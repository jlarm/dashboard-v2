<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Settings;

use App\Enums\ComplianceSummaryFrequency;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Settings\SendComplianceSummaryRequest;
use App\Http\Requests\Tenant\Settings\UpdateAutomatedReportsRequest;
use App\Jobs\SendComplianceSummaryJob;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Throwable;

class AutomatedReportsController extends Controller
{
    private const array RECIPIENT_ROLES = [
        Role::Owner->value,
        Role::CFO->value,
        Role::GM->value,
        Role::GSM->value,
        Role::QualifiedIndividual->value,
    ];

    public function index(): InertiaResponse
    {
        $this->authorize('manageReports', GlobalSetting::class);

        $settings = GlobalSetting::query()->first();

        $availableRecipients = User::query()
            ->whereHas('roles', fn (Builder $query) => $query->whereIn('name', self::RECIPIENT_ROLES))
            ->orderBy('name')
            ->get(['id', 'name', 'email'])
            ->map(fn (User $user): array => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ])
            ->all();

        return Inertia::render('tenant/settings/AutomatedReports', [
            'settings' => [
                'compliance_summary_active' => (bool) ($settings->compliance_summary_active ?? false),
                'compliance_summary_frequency' => $settings?->compliance_summary_frequency->value
                    ?? ComplianceSummaryFrequency::Monthly->value,
                'compliance_summary_recipients' => $settings->compliance_summary_recipients ?? [],
            ],
            'availableRecipients' => $availableRecipients,
            'frequencies' => array_map(
                static fn (ComplianceSummaryFrequency $f): array => ['value' => $f->value, 'label' => $f->label()],
                ComplianceSummaryFrequency::cases(),
            ),
        ]);
    }

    public function update(UpdateAutomatedReportsRequest $request): RedirectResponse
    {
        try {
            GlobalSetting::query()->updateOrCreate([], [
                'compliance_summary_active' => $request->boolean('compliance_summary_active'),
                'compliance_summary_frequency' => $request->validated('compliance_summary_frequency'),
                'compliance_summary_recipients' => $request->validated('compliance_summary_recipients', []),
            ]);
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('flash.error', 'We could not save the compliance summary settings. Please try again.');
        }

        return back()->with('flash.success', 'Compliance Summary settings saved.');
    }

    public function sendNow(SendComplianceSummaryRequest $request): RedirectResponse
    {
        $recipientIds = $request->recipientIds();

        if ($recipientIds === []) {
            return back()->with('flash.error', 'Select at least one recipient before sending.');
        }

        $recipientEmails = User::query()
            ->whereIn('id', $recipientIds)
            ->pluck('email')
            ->all();

        if ($recipientEmails === []) {
            return back()->with('flash.error', 'No valid recipients found.');
        }

        try {
            dispatch(new SendComplianceSummaryJob(
                Store::query()->pluck('id')->all(),
                $recipientEmails,
                $request->frequency()->periodLabel(),
            ));
        } catch (Throwable $e) {
            report($e);

            return back()->with('flash.error', 'We could not queue the compliance summary. Please try again.');
        }

        return back()->with('flash.success', 'Compliance summary queued — reports will be emailed shortly.');
    }
}
