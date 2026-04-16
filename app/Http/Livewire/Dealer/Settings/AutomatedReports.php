<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Settings;

use App\Enums\ComplianceSummaryFrequency;
use App\Jobs\SendComplianceSummaryJob;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use Closure;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class AutomatedReports extends Component
{
    private const AUTHORIZED_ROLES = [
        'super-admin',
        'Consultant',
        'Owner',
        'GM',
        'CFO',
        'GSM',
        'Qualified Individual',
    ];

    private const RECIPIENT_ROLES = ['Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual'];

    public bool $compliance_summary_active = false;
    public string $compliance_summary_frequency = '';

    /** @var array<int> */
    public array $compliance_summary_recipients = [];

    /** @var Collection<int, User> */
    public Collection $availableRecipients;

    public function mount(): void
    {
        $this->ensureAuthorized();

        $settings = GlobalSetting::query()->first();

        $this->compliance_summary_active = $settings?->compliance_summary_active ?? false;
        $this->compliance_summary_frequency = $settings?->compliance_summary_frequency?->value
            ?? ComplianceSummaryFrequency::Monthly->value;
        $this->compliance_summary_recipients = $settings?->compliance_summary_recipients ?? [];

        $this->loadAvailableRecipients();
    }

    public function saveComplianceSummary(): void
    {
        $this->ensureAuthorized();

        $this->validate([
            'compliance_summary_frequency' => ['required', 'in:monthly,quarterly'],
            'compliance_summary_recipients' => [
                'array',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->compliance_summary_active && empty($value)) {
                        $fail('At least one recipient is required when the compliance summary is enabled.');
                    }
                },
            ],
        ]);

        GlobalSetting::query()->updateOrCreate([], [
            'compliance_summary_active' => $this->compliance_summary_active,
            'compliance_summary_frequency' => $this->compliance_summary_frequency,
            'compliance_summary_recipients' => $this->compliance_summary_recipients,
        ]);

        Notification::make()
            ->title('Compliance Summary Settings Saved!')
            ->success()
            ->send();
    }

    public function sendNow(): void
    {
        $this->ensureAuthorized();

        if ($this->compliance_summary_recipients === []) {
            Notification::make()
                ->title('No recipients selected.')
                ->body('Select at least one recipient before sending.')
                ->danger()
                ->send();

            return;
        }

        $recipientEmails = User::query()
            ->whereIn('id', $this->compliance_summary_recipients)
            ->pluck('email')
            ->all();

        if ($recipientEmails === []) {
            Notification::make()
                ->title('No valid recipients found.')
                ->danger()
                ->send();

            return;
        }

        $frequency = ComplianceSummaryFrequency::tryFrom($this->compliance_summary_frequency)
            ?? ComplianceSummaryFrequency::Monthly;

        SendComplianceSummaryJob::dispatch(
            Store::query()->pluck('id')->all(),
            $recipientEmails,
            $frequency->periodLabel(),
        );

        Notification::make()
            ->title('Compliance summary queued!')
            ->body('Reports are being generated and will be emailed shortly.')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.settings.automated-reports')
            ->layout('components.dealer-app');
    }

    private function ensureAuthorized(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(self::AUTHORIZED_ROLES), 403);
    }

    private function loadAvailableRecipients(): void
    {
        $this->availableRecipients = User::query()
            ->whereHas('roles', fn ($q) => $q->whereIn('name', self::RECIPIENT_ROLES))
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    }
}
