<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Settings;

use App\Enums\ComplianceSummaryFrequency;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Settings\UpdateAutomatedReportsRequest;
use App\Jobs\SendComplianceSummaryJob;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

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
            ->whereHas('roles', fn ($query) => $query->whereIn('name', self::RECIPIENT_ROLES))
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
                'compliance_summary_active' => (bool) ($settings?->compliance_summary_active ?? false),
                'compliance_summary_frequency' => $settings?->compliance_summary_frequency?->value
                    ?? ComplianceSummaryFrequency::Monthly->value,
                'compliance_summary_recipients' => $settings?->compliance_summary_recipients ?? [],
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
        GlobalSetting::query()->updateOrCreate([], [
            'compliance_summary_active' => $request->boolean('compliance_summary_active'),
            'compliance_summary_frequency' => $request->validated('compliance_summary_frequency'),
            'compliance_summary_recipients' => $request->validated('compliance_summary_recipients', []),
        ]);

        return back()->with('flash.success', 'Compliance Summary settings saved.');
    }

    public function sendNow(Request $request): RedirectResponse
    {
        $this->authorize('manageReports', GlobalSetting::class);

        $validated = $request->validate([
            'compliance_summary_frequency' => ['required', 'string'],
            'compliance_summary_recipients' => ['array'],
            'compliance_summary_recipients.*' => ['integer'],
        ]);

        $recipientIds = $validated['compliance_summary_recipients'] ?? [];

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

        $frequency = ComplianceSummaryFrequency::tryFrom($validated['compliance_summary_frequency'])
            ?? ComplianceSummaryFrequency::Monthly;

        dispatch(new SendComplianceSummaryJob(
            Store::query()->pluck('id')->all(),
            $recipientEmails,
            $frequency->periodLabel(),
        ));

        return back()->with('flash.success', 'Compliance summary queued — reports will be emailed shortly.');
    }
}
