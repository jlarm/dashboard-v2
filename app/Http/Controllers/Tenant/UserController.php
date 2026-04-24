<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\User\Actions\BuildEmployeesCsv;
use App\Domain\Tenant\User\Actions\GenerateDotCertificate;
use App\Domain\Tenant\User\Actions\ImportEmployees;
use App\Domain\Tenant\User\Actions\InviteEmployee;
use App\Domain\Tenant\User\Actions\RecordEmployeeCourseResult;
use App\Domain\Tenant\User\Actions\SendEmployeesReport;
use App\Domain\Tenant\User\Actions\SetCourseOverride;
use App\Domain\Tenant\User\Actions\UpdateEmployee;
use App\Domain\Tenant\User\Data\EmployeeData;
use App\Domain\Tenant\User\Data\TrainingCountsData;
use App\Domain\Tenant\User\Data\TrainingSummaryData;
use App\Domain\Tenant\User\Queries\GetEmployeeCertificates;
use App\Domain\Tenant\User\Queries\GetEmployeeCourses;
use App\Domain\Tenant\User\Queries\GetEmployeeFilterOptions;
use App\Domain\Tenant\User\Queries\GetEmployees;
use App\Domain\Tenant\User\Queries\GetInviteEmployeeOptions;
use App\Domain\Tenant\User\Queries\GetManageCoursesOptions;
use App\Enums\AuditTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\User\EmailEmployeesReportRequest;
use App\Http\Requests\Tenant\User\ExportEmployeesRequest;
use App\Http\Requests\Tenant\User\ImportEmployeesRequest;
use App\Http\Requests\Tenant\User\IndexEmployeesRequest;
use App\Http\Requests\Tenant\User\InviteEmployeeRequest;
use App\Http\Requests\Tenant\User\RecordCourseResultRequest;
use App\Http\Requests\Tenant\User\SetCourseOverrideRequest;
use App\Http\Requests\Tenant\User\UpdateEmployeeRequest;
use App\Http\Resources\Tenant\EmployeeResource;
use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Services\TrainingComplianceService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Sentry;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class UserController extends Controller
{
    public function index(
        IndexEmployeesRequest $request,
        GetEmployees $getEmployees,
        GetEmployeeFilterOptions $getFilterOptions,
    ): Response {
        /** @var User $viewer */
        $viewer = $request->user();
        $filters = $request->filters();

        logger()->info('employees.index filters', [
            'query' => $request->query(),
            'filters' => $filters->toArray(),
        ]);

        $result = $getEmployees->handle($viewer, $filters, $request->page());

        return Inertia::render('tenant/user/Index', [
            'employees' => EmployeeResource::collection($result['paginator']),
            'trainingCounts' => TrainingCountsData::fromSummaries($result['summaries'])->toArray(),
            'filters' => $filters->toArray(),
            'filterOptions' => $getFilterOptions->handle(),
            'permissions' => [
                'manage_filters' => $viewer->can('create-stores'),
                'email_report' => $viewer->can('create-dealerships'),
                'send_message' => ! $viewer->hasAnyRole(['Manager', 'Employee', 'Porter/Driver']),
            ],
            'storeContext' => [
                'multiple_stores' => app()->bound('multipleStoresExist') && resolve('multipleStoresExist'),
                'current_store_name' => app()->bound('currentStoreModel')
                    ? (string) resolve('currentStoreModel')->name
                    : (string) tenant('name'),
            ],
        ]);
    }

    public function invite(Request $request, GetInviteEmployeeOptions $optionsQuery): Response
    {
        /** @var User $viewer */
        $viewer = $request->user();

        abort_unless(
            $viewer->hasAnyRole([
                'super-admin',
                'Consultant',
                'Owner',
                'CFO',
                'GM',
                'GSM',
                'Qualified Individual',
                'Manager',
            ]),
            403,
        );

        return Inertia::render('tenant/user/Invite', [
            'options' => $optionsQuery->handle($viewer),
            'defaults' => [
                'department_id' => $viewer->department_id,
                'role' => $viewer->can('create-stores') ? null : 'Employee',
            ],
        ]);
    }

    public function storeInvite(InviteEmployeeRequest $request, InviteEmployee $action): RedirectResponse
    {
        /** @var User $inviter */
        $inviter = $request->user();

        $invite = $action->handle(
            inviter: $inviter,
            name: $request->name(),
            email: $request->email(),
            departmentId: $request->departmentId(),
            role: $request->role(),
            qualifiedIndividual: $request->qualifiedIndividual(),
            storeIds: $request->storeIds(),
            primaryStoreId: $request->primaryStoreId(),
            courses: $request->courses(),
        );

        return redirect()
            ->route('employees.index')
            ->with('success', "{$invite->name} has been invited.");
    }

    public function import(ImportEmployeesRequest $request, ImportEmployees $action): RedirectResponse
    {
        try {
            $result = $action->handle(
                importer: $request->user(),
                jsonContent: (string) $request->spreadsheet()->get(),
            );
        } catch (Throwable $e) {
            return back()->withErrors(['spreadsheet' => $e->getMessage()]);
        }

        if ($result->errors !== []) {
            return back()
                ->withErrors(['spreadsheet' => 'Import failed due to validation errors.'])
                ->with('import_errors', $result->errors);
        }

        $message = "{$result->successCount} invite(s) imported successfully.";
        if ($result->skippedCount > 0) {
            $message .= " {$result->skippedCount} row(s) skipped (already invited or registered).";
        }

        return back()->with('success', $message);
    }

    public function export(
        ExportEmployeesRequest $request,
        GetEmployees $getEmployees,
        BuildEmployeesCsv $buildCsv,
    ): StreamedResponse {
        if ($request->selectAll()) {
            /** @var User $viewer */
            $viewer = $request->user();

            /** @var EloquentCollection<int, User> $users */
            $users = $getEmployees
                ->buildScopedQuery($viewer, $request->filters())
                ->get();
        } else {
            $users = User::query()
                ->with([
                    'roles:id,name',
                    'department:id,name',
                    'stores:id,name,state',
                    'courseOverrides:user_id,course_id,type',
                ])
                ->whereIn('id', $request->userIds())
                ->get();
        }

        $csv = $buildCsv->forSelection($users);

        $slug = app()->bound('currentStoreModel')
            ? str(resolve('currentStoreModel')->name)->slug()->value()
            : str((string) tenant('name'))->slug()->value();
        $filename = "incomplete-employee-courses-report-{$slug}-".date('m-d-Y').'.csv';

        return response()->streamDownload(static function () use ($csv): void {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    public function show(
        Request $request,
        User $user,
        GetEmployees $getEmployees,
        TrainingComplianceService $complianceService,
    ): Response {
        return Inertia::render(
            'tenant/user/Show',
            $this->sharedProps($request, $user, $getEmployees, $complianceService),
        );
    }

    public function courses(
        Request $request,
        User $user,
        GetEmployees $getEmployees,
        TrainingComplianceService $complianceService,
        GetEmployeeCourses $getEmployeeCourses,
    ): Response {
        /** @var User $viewer */
        $viewer = $request->user();

        $props = $this->sharedProps($request, $user, $getEmployees, $complianceService);
        $props['courses'] = $getEmployeeCourses->handle($user);
        $props['canRecordCourseResult'] = $viewer->can('recordCourseResult', $user);

        return Inertia::render('tenant/user/Courses', $props);
    }

    public function recordCourseResult(
        RecordCourseResultRequest $request,
        User $user,
        Course $course,
        RecordEmployeeCourseResult $action,
    ): RedirectResponse {
        $action->handle($user, $course, $request->takenOn());

        return back()->with('success', "Recorded {$course->name} for {$user->name}.");
    }

    public function manageCourses(
        Request $request,
        User $user,
        GetEmployees $getEmployees,
        TrainingComplianceService $complianceService,
        GetManageCoursesOptions $getManageCoursesOptions,
    ): Response {
        $props = $this->sharedProps($request, $user, $getEmployees, $complianceService);
        $props['manageableCourses'] = $getManageCoursesOptions->handle($user);

        return Inertia::render('tenant/user/ManageCourses', $props);
    }

    public function updateCourseOverride(
        SetCourseOverrideRequest $request,
        User $user,
        Course $course,
        SetCourseOverride $action,
    ): RedirectResponse {
        /** @var User $actor */
        $actor = $request->user();

        $action->handle($actor, $user, $course, $request->state());

        return back()->with('success', "{$course->name} updated for {$user->name}.");
    }

    public function dotCertificates(
        Request $request,
        User $user,
        GetEmployees $getEmployees,
        TrainingComplianceService $complianceService,
        GetEmployeeCertificates $certificatesQuery,
    ): Response {
        /** @var User $viewer */
        $viewer = $request->user();

        $props = $this->sharedProps($request, $user, $getEmployees, $complianceService);
        $props['certificates'] = $certificatesQuery->certificates($user);
        $props['canGenerateDotCert'] = $viewer->can('generateDotCertificate', $user)
            && $certificatesQuery->canGenerateDotCertificate($user);

        return Inertia::render('tenant/user/DotCertificates', $props);
    }

    public function generateDotCertificate(
        Request $request,
        User $user,
        GenerateDotCertificate $action,
    ): RedirectResponse {
        $this->authorize('generateDotCertificate', $user);

        $storeName = app()->bound('currentStoreModel')
            ? (string) resolve('currentStoreModel')->name
            : (string) tenant('name');

        $url = $action->handle($user, $storeName);

        return back()->with('success', 'DOT certificate generated.')->with('dot_certificate_url', $url);
    }

    public function update(UpdateEmployeeRequest $request, User $user, UpdateEmployee $action): RedirectResponse
    {
        $action->handle(
            user: $user,
            departmentId: $request->departmentId(),
            roleId: $request->roleId(),
            qualifiedIndividual: $request->qualifiedIndividual(),
            storeIds: $request->storeIds(),
            auditTypes: $request->auditTypes(),
        );

        return back()->with('success', "{$user->name} updated.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', "{$user->name} removed.");
    }

    public function impersonate(Request $request, User $user): RedirectResponse
    {
        $this->authorize('impersonate', $user);

        /** @phpstan-ignore-next-line -- macro provided by stancl/tenancy UserImpersonation feature */
        $token = tenancy()->impersonate(
            tenant(),
            $user->id,
            '/dashboard',
            'web',
        );

        return redirect("https://{$request->getHost()}/impersonate/{$token->token}");
    }

    public function emailReport(
        EmailEmployeesReportRequest $request,
        GetEmployees $getEmployees,
        BuildEmployeesCsv $buildCsv,
        SendEmployeesReport $sendReport,
    ): RedirectResponse {
        /** @var User $viewer */
        $viewer = $request->user();

        try {
            $users = $getEmployees
                ->buildScopedQuery($viewer, $request->filters())
                ->get();

            $csv = $buildCsv->forReport($users);
            $sendReport->handle($request->email(), $csv);

            return back()->with('success', 'User report sent successfully.');
        } catch (Throwable $e) {
            Sentry::captureException($e);

            return back()->with('error', 'Error trying to send the User Report. Please check the email address.');
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function sharedProps(
        Request $request,
        User $user,
        GetEmployees $getEmployees,
        TrainingComplianceService $complianceService,
    ): array {
        /** @var User $viewer */
        $viewer = $request->user();

        abort_if($viewer->id === $user->id, 403);
        abort_unless($getEmployees->isVisibleTo($viewer, $user), 403);

        $user->load([
            'roles:id,name',
            'department:id,name',
            'stores:id,name,state',
            'courseOverrides:user_id,course_id,type',
            'remediationReminderPreferences:id,user_id,audit_type',
        ]);

        $training = TrainingSummaryData::fromArray($complianceService->summarizeUser($user));
        $employee = EmployeeData::fromModel(user: $user, training: $training, canView: true);

        $canUpdate = $viewer->can('update', $user);

        return [
            'employee' => $employee->toArray(),
            'remediationReminders' => $user->remediationReminderPreferences
                ->pluck('audit_type')
                ->map(static fn ($type): string => $type instanceof AuditTypes ? $type->value : (string) $type)
                ->values()
                ->all(),
            'permissions' => [
                'update' => $canUpdate,
                'delete' => $viewer->can('delete', $user),
                'impersonate' => $viewer->can('impersonate', $user),
                'manage_courses' => $viewer->hasAnyRole(['super-admin', 'Consultant', 'Qualified Individual']),
            ],
            'editOptions' => $canUpdate ? $this->editOptions() : null,
        ];
    }

    /**
     * @return array{
     *     departments: list<array{id: int, name: string}>,
     *     roles: list<array{id: int, name: string}>,
     *     stores: list<array{id: int, name: string}>|null,
     *     audit_types: list<array{value: string, label: string}>
     * }
     */
    private function editOptions(): array
    {
        $departments = Department::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(static fn (Department $department): array => [
                'id' => (int) $department->id,
                'name' => (string) $department->name,
            ])
            ->values()
            ->all();

        $roles = Role::query()
            ->whereNotIn('name', ['super-admin', 'Consultant', 'Qualified Individual'])
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(static fn (Role $role): array => [
                'id' => (int) $role->id,
                'name' => (string) $role->name,
            ])
            ->values()
            ->all();

        $stores = Store::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $storeOptions = $stores->count() > 1
            ? $stores
                ->map(static fn (Store $store): array => [
                    'id' => (int) $store->id,
                    'name' => (string) $store->name,
                ])
                ->values()
                ->all()
            : null;

        $auditTypes = array_map(
            static fn (AuditTypes $type): array => ['value' => $type->value, 'label' => $type->label()],
            AuditTypes::cases(),
        );

        return [
            'departments' => $departments,
            'roles' => $roles,
            'stores' => $storeOptions,
            'audit_types' => $auditTypes,
        ];
    }
}
