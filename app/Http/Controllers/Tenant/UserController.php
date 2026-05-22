<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\User\Actions\BuildEmployeesCsv;
use App\Domain\Tenant\User\Actions\GenerateDotCertificate;
use App\Domain\Tenant\User\Actions\InviteEmployee;
use App\Domain\Tenant\User\Actions\RecordEmployeeCourseResult;
use App\Domain\Tenant\User\Actions\ResendInvite;
use App\Domain\Tenant\User\Actions\RestoreEmployee;
use App\Domain\Tenant\User\Actions\SendCustomEmployeeMessage;
use App\Domain\Tenant\User\Actions\SendEmployeesReport;
use App\Domain\Tenant\User\Actions\SetCourseOverride;
use App\Domain\Tenant\User\Actions\UpdateEmployee;
use App\Domain\Tenant\User\Data\EmployeeData;
use App\Domain\Tenant\User\Data\EmployeeIndexPermissionsData;
use App\Domain\Tenant\User\Data\TrainingSummaryData;
use App\Domain\Tenant\User\Queries\GetDeletedEmployees;
use App\Domain\Tenant\User\Queries\GetEmployeeCertificates;
use App\Domain\Tenant\User\Queries\GetEmployeeCourses;
use App\Domain\Tenant\User\Queries\GetEmployeeEditOptions;
use App\Domain\Tenant\User\Queries\GetEmployeeFilterOptions;
use App\Domain\Tenant\User\Queries\GetEmployees;
use App\Domain\Tenant\User\Queries\GetInviteEmployeeOptions;
use App\Domain\Tenant\User\Queries\GetManageCoursesOptions;
use App\Domain\Tenant\User\Queries\GetOpenInvites;
use App\Enums\AuditTypes;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\User\EmailEmployeesReportRequest;
use App\Http\Requests\Tenant\User\ExportEmployeesRequest;
use App\Http\Requests\Tenant\User\ImportEmployeesRequest;
use App\Http\Requests\Tenant\User\IndexDeletedEmployeesRequest;
use App\Http\Requests\Tenant\User\IndexEmployeesRequest;
use App\Http\Requests\Tenant\User\IndexOpenInvitesRequest;
use App\Http\Requests\Tenant\User\InviteEmployeeRequest;
use App\Http\Requests\Tenant\User\RecordCourseResultRequest;
use App\Http\Requests\Tenant\User\ResendInvitesRequest;
use App\Http\Requests\Tenant\User\SendCustomMessageRequest;
use App\Http\Requests\Tenant\User\SetCourseOverrideRequest;
use App\Http\Requests\Tenant\User\UpdateEmployeeRequest;
use App\Http\Resources\Tenant\DeletedEmployeeResource;
use App\Http\Resources\Tenant\EmployeeResource;
use App\Http\Resources\Tenant\OpenInviteResource;
use App\Jobs\ImportEmployeesJob;
use App\Models\Dealer\Course;
use App\Models\Dealer\Invite;
use App\Models\User;
use App\Services\TrainingComplianceService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
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

        $paginator = $getEmployees->handle($viewer, $filters, $request->page());

        return Inertia::render('tenant/user/Index', [
            'employees' => EmployeeResource::collection($paginator),
            'trainingCounts' => Inertia::defer(
                fn (): array => $getEmployees->trainingCounts($viewer, $filters)->toArray(),
            ),
            'filters' => $filters->toArray(),
            'filterOptions' => $getFilterOptions->handle(),
            'permissions' => EmployeeIndexPermissionsData::forViewer($viewer)->toArray(),
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

        abort_unless($viewer->hasAnyRole(Role::values(Role::employeeSectionViewers())), 403);

        $isManagerOnly = $viewer->hasRole(Role::Manager->value)
            && ! $viewer->hasAnyRole(Role::values(Role::employeeAdminRoles()));

        return Inertia::render('tenant/user/Invite', [
            'options' => $optionsQuery->handle($viewer),
            'defaults' => [
                'department_id' => $viewer->department_id,
                'role' => $viewer->can('create-stores') ? null : Role::Employee->value,
                'store_ids' => $viewer->current_store_id !== null ? [(int) $viewer->current_store_id] : [],
            ],
            'permissions' => [
                'mark_qualified_individual' => ! $isManagerOnly,
                'add_completed_courses' => $viewer->hasAnyRole([Role::SuperAdmin->value, Role::Consultant->value]),
            ],
        ]);
    }

    public function storeInvite(InviteEmployeeRequest $request, InviteEmployee $action): RedirectResponse
    {
        /** @var User $inviter */
        $inviter = $request->user();

        try {
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
        } catch (Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'We could not send the invite. Please try again.');
        }

        return to_route('employees.index')
            ->with('success', "{$invite->name} has been invited.");
    }

    public function openInvites(IndexOpenInvitesRequest $request, GetOpenInvites $query): Response
    {
        /** @var User $viewer */
        $viewer = $request->user();

        $result = $query->handle($viewer, $request->filters(), $request->page());

        return Inertia::render('tenant/user/OpenInvites', [
            'invites' => OpenInviteResource::collection($result['paginator']),
            'filters' => $request->filters(),
            'departments' => $result['departments'],
            'multipleStores' => $result['multiple_stores'],
        ]);
    }

    public function resendInvite(Request $request, Invite $invite, GetOpenInvites $query, ResendInvite $action): RedirectResponse
    {
        /** @var User $viewer */
        $viewer = $request->user();

        abort_unless($query->buildScopedQuery($viewer)->whereKey($invite->id)->exists(), 403);

        try {
            $action->handle($invite);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', "We could not resend the invite to {$invite->name}. Please try again.");
        }

        return back()->with('success', "Invite to {$invite->name} resent.");
    }

    public function resendInvites(ResendInvitesRequest $request, GetOpenInvites $query, ResendInvite $action): RedirectResponse
    {
        /** @var User $viewer */
        $viewer = $request->user();

        $requestedIds = $request->inviteIds();
        /** @var EloquentCollection<int, Invite> $invites */
        $invites = $query->buildScopedQuery($viewer)
            ->whereIn('id', $requestedIds)
            ->get();

        $skipped = count($requestedIds) - $invites->count();
        $failed = 0;

        foreach ($invites as $invite) {
            try {
                $action->handle($invite);
            } catch (Throwable $e) {
                $failed++;
                report($e);
            }
        }

        $resent = $invites->count() - $failed;

        if ($resent === 0 && $invites->count() > 0) {
            return back()->with('error', 'We could not resend any of the invites. Please try again.');
        }

        $message = "{$resent} invite(s) resent.";
        if ($skipped > 0) {
            $message .= " {$skipped} were skipped because they're outside your scope.";
        }
        if ($failed > 0) {
            $message .= " {$failed} could not be resent.";
        }

        return back()->with('success', $message);
    }

    public function destroyInvite(Request $request, Invite $invite, GetOpenInvites $query): RedirectResponse
    {
        /** @var User $viewer */
        $viewer = $request->user();

        abort_unless($query->buildScopedQuery($viewer)->whereKey($invite->id)->exists(), 403);

        $name = $invite->name;

        try {
            $invite->delete();
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', "We could not delete the invite to {$name}. Please try again.");
        }

        return back()->with('success', "Invite to {$name} deleted.");
    }

    public function deleted(IndexDeletedEmployeesRequest $request, GetDeletedEmployees $query): Response
    {
        /** @var User $viewer */
        $viewer = $request->user();

        $paginator = $query->handle($viewer, $request->filters(), $request->page());

        return Inertia::render('tenant/user/Deleted', [
            'employees' => DeletedEmployeeResource::collection($paginator),
            'filters' => $request->filters(),
        ]);
    }

    public function restoreEmployee(Request $request, User $user, RestoreEmployee $action): RedirectResponse
    {
        abort_unless(
            (bool) $request->user()?->hasAnyRole(Role::values(Role::employeeAdminRoles())),
            403,
        );

        abort_unless($user->trashed(), 404);

        try {
            $action->handle($user);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', "We could not restore {$user->name}. Please try again.");
        }

        return back()->with('success', "{$user->name} restored.");
    }

    public function import(ImportEmployeesRequest $request): RedirectResponse
    {
        /** @var User $importer */
        $importer = $request->user();

        $tenantId = (string) (tenant('id') ?? 'central');
        $payloadPath = "imports/employees/{$tenantId}/".str()->ulid().'.json';

        try {
            $request->spreadsheet()->storeAs(
                dirname($payloadPath),
                basename($payloadPath),
                ['disk' => 'local'],
            );

            dispatch(new ImportEmployeesJob($importer, $payloadPath));
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'We could not start the import. Please try again.');
        }

        return back()->with('success', 'Import started — you will receive an email when it completes.');
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
        GetEmployeeEditOptions $editOptions,
    ): Response {
        return Inertia::render(
            'tenant/user/Show',
            $this->sharedProps($request, $user, $getEmployees, $complianceService, $editOptions),
        );
    }

    public function courses(
        Request $request,
        User $user,
        GetEmployees $getEmployees,
        TrainingComplianceService $complianceService,
        GetEmployeeCourses $getEmployeeCourses,
        GetEmployeeEditOptions $editOptions,
    ): Response {
        /** @var User $viewer */
        $viewer = $request->user();

        $props = $this->sharedProps($request, $user, $getEmployees, $complianceService, $editOptions);
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
        try {
            $action->handle($user, $course, $request->takenOn());
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', "We could not record {$course->name} for {$user->name}. Please try again.");
        }

        return back()->with('success', "Recorded {$course->name} for {$user->name}.");
    }

    public function manageCourses(
        Request $request,
        User $user,
        GetEmployees $getEmployees,
        TrainingComplianceService $complianceService,
        GetManageCoursesOptions $getManageCoursesOptions,
        GetEmployeeEditOptions $editOptions,
    ): Response {
        $props = $this->sharedProps($request, $user, $getEmployees, $complianceService, $editOptions);
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

        try {
            $action->handle($actor, $user, $course, $request->state());
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', "We could not update {$course->name} for {$user->name}. Please try again.");
        }

        return back()->with('success', "{$course->name} updated for {$user->name}.");
    }

    public function dotCertificates(
        Request $request,
        User $user,
        GetEmployees $getEmployees,
        TrainingComplianceService $complianceService,
        GetEmployeeCertificates $certificatesQuery,
        GetEmployeeEditOptions $editOptions,
    ): Response {
        /** @var User $viewer */
        $viewer = $request->user();

        $props = $this->sharedProps($request, $user, $getEmployees, $complianceService, $editOptions);
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

        try {
            $url = $action->handle($user);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'We could not generate the DOT certificate. Please try again.');
        }

        return back()->with('success', 'DOT certificate generated.')->with('dot_certificate_url', $url);
    }

    public function update(UpdateEmployeeRequest $request, User $user, UpdateEmployee $action): RedirectResponse
    {
        try {
            $action->handle(
                user: $user,
                departmentId: $request->departmentId(),
                roleId: $request->roleId(),
                qualifiedIndividual: $request->qualifiedIndividual(),
                storeIds: $request->storeIds(),
                auditTypes: $request->auditTypes(),
            );
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', "We could not update {$user->name}. Please try again.");
        }

        return back()->with('success', "{$user->name} updated.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        try {
            $user->delete();
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', "We could not remove {$user->name}. Please try again.");
        }

        return to_route('employees.index')
            ->with('success', "{$user->name} removed.");
    }

    public function impersonate(Request $request, User $user): RedirectResponse
    {
        $this->authorize('impersonate', $user);

        try {
            /** @phpstan-ignore-next-line -- macro provided by stancl/tenancy UserImpersonation feature */
            $token = tenancy()->impersonate(
                tenant(),
                $user->id,
                '/dashboard',
                'web',
            );
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', "We could not start an impersonation session for {$user->name}.");
        }

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
            /** @var EloquentCollection<int, User> $users */
            $users = $getEmployees
                ->buildScopedQuery($viewer, $request->filters())
                ->get();

            $csv = $buildCsv->forReport($users);
            $sendReport->handle($request->email(), $csv);

            return back()->with('success', 'User report sent successfully.');
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Error trying to send the User Report. Please check the email address.');
        }
    }

    public function sendMessage(
        SendCustomMessageRequest $request,
        GetEmployees $getEmployees,
        SendCustomEmployeeMessage $sendMessage,
    ): RedirectResponse {
        /** @var User $viewer */
        $viewer = $request->user();

        $scopedQuery = $getEmployees->buildScopedQuery($viewer, $request->filters());

        if (! $request->selectAll()) {
            $scopedQuery->whereIn('users.id', $request->userIds());
        }

        /** @var EloquentCollection<int, User> $users */
        $users = $scopedQuery->get(['users.id', 'users.name', 'users.email']);

        try {
            $sent = $sendMessage->handle(
                users: $users,
                subject: $request->subjectLine(),
                messageBody: $request->messageBody(),
            );
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'We could not send the message. Please try again.');
        }

        if ($sent === 0) {
            return back()->with('error', 'No employees with valid email addresses were selected.');
        }

        return back()->with('success', "Message sent to {$sent} ".str('employee')->plural($sent).'.');
    }

    /**
     * @return array<string, mixed>
     */
    private function sharedProps(
        Request $request,
        User $user,
        GetEmployees $getEmployees,
        TrainingComplianceService $complianceService,
        GetEmployeeEditOptions $editOptions,
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
                ->map(static fn (mixed $type): string => $type instanceof AuditTypes ? $type->value : (string) $type)
                ->values()
                ->all(),
            'permissions' => [
                'update' => $canUpdate,
                'delete' => $viewer->can('delete', $user),
                'impersonate' => $viewer->can('impersonate', $user),
                'manage_courses' => $viewer->hasAnyRole([
                    Role::SuperAdmin->value,
                    Role::Consultant->value,
                    Role::QualifiedIndividual->value,
                ]),
            ],
            'editOptions' => $canUpdate ? $editOptions->handle() : null,
        ];
    }
}
