<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use App\Enums\Frequency;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\RemediationReminderPreference;
use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class SingleStoreDetails extends Component
{
    use WithFileUploads, WithMedia;

    public ?Store $store = null;
    public $name;
    public $address;
    public $city;
    public $state;
    public $postal_code;
    public $phone;
    public $website;
    public $mediaComponentNames = ['logo'];
    public $logo;
    public $active_monitoring = false;
    public $phishing_active = false;
    public $phishing_token;
    public $phishing_ip;
    public $monitoring_start_date;
    public $settings;
    public $notifications;
    public bool $remediations;
    public bool $remediationNotifications;
    public $frequency;
    public $selectedRemediationReminderUsers = [];
    public bool $videos;

    public function mount(): void
    {
        $this->store = Store::query()->find(app('currentStore'));

        $this->settings = GlobalSetting::query()->first();

        $this->name = $this->store->name;
        $this->address = $this->store->address;
        $this->city = $this->store->city;
        $this->state = $this->store->state;
        $this->postal_code = $this->store->postal_code;
        $this->phone = $this->store->phone;
        $this->website = $this->store->website;
        $this->active_monitoring = $this->store->active_monitoring;
        $this->monitoring_start_date = $this->store->monitoring_start_date?->format('Y-m-d');
        $this->phishing_active = $this->settings->phishing_active ?? false;
        $this->phishing_token = $this->settings->phishing_token ?? null;
        $this->phishing_ip = $this->settings->phishing_ip ?? null;

        $this->notifications = $this->store->courses_not_taken_notification;
        $this->remediations = $this->store->remediationSettings->active ?? false;
        $this->remediationNotifications = $this->store->remediationSettings->notifications ?? false;
        $this->frequency = $this->store->remediationSettings->frequency ?? null;

        $this->selectedRemediationReminderUsers = $this->getRemediationReminderUsers();

        $this->videos = $this->store->videos;
    }

    public function update(): void
    {
        $this->validate($this->validationRules(), $this->validationMessages());

        try {
            $this->updateStore();
            $this->updateRemediationSettings();
            $this->updateGlobalSettings();
            $this->syncLogo();

            Notification::make()
                ->title('Settings Updated Successfully!')
                ->success()
                ->send();

        } catch (Exception $e) {
            Log::error($e->getMessage());
            Notification::make()
                ->title('Something went wrong!')
                ->danger()
                ->send();
        }
    }

    public function deleteLogo(): RedirectResponse
    {
        if ($this->store->logo) {
            Storage::delete($this->store->logo);
        }

        $this->store->update([
            'logo' => null,
        ]);

        return redirect()->route('dealer.dealer.settings');
    }

    public function render(): View
    {
        return view('livewire.dealer.store.single-store-details');
    }

    public function updatedLogo(): void
    {
        $this->validate([
            'logo' => 'sometimes|image|max:1024',
        ]);
    }

    private function validationRules(): array
    {
        return [
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'postal_code' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'website' => ['nullable', 'string'],
            'active_monitoring' => ['required', 'boolean'],
            'monitoring_start_date' => ['date', 'nullable'],
            'phishing_active' => ['required', 'boolean'],
            'phishing_token' => ['nullable', 'string'],
            'phishing_ip' => ['nullable', 'string'],
            'notifications' => ['nullable', 'boolean'],
            'remediations' => ['nullable', 'boolean'],
            'remediationNotifications' => ['nullable', 'boolean'],
            'frequency' => ['nullable', Rule::enum(Frequency::class), 'required_if:remediationNotifications,true'],
            'videos' => ['nullable', 'boolean'],
        ];
    }

    private function validationMessages(): array
    {
        return [
            'frequency.required_if' => 'The frequency field is required when remediation notifications are enabled.',
        ];
    }

    private function updateStore(): void
    {
        $this->store->update([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'website' => $this->website,
            'active_monitoring' => $this->active_monitoring,
            'monitoring_start_date' => $this->monitoring_start_date,
            'courses_not_taken_notification' => $this->notifications,
            'videos' => $this->videos,
        ]);
    }

    private function updateRemediationSettings(): void
    {
        $this->store->remediationSettings()->updateOrCreate([], [
            'active' => $this->remediations,
            'notifications' => $this->remediationNotifications,
            'frequency' => $this->frequency,
        ]);
    }

    private function updateGlobalSettings(): void
    {
        if (is_null($this->settings)) {
            GlobalSetting::query()->create([
                'phishing_active' => $this->phishing_active,
                'phishing_token' => $this->phishing_token,
                'phishing_ip' => $this->phishing_ip,
            ]);
        } else {
            $this->settings->update([
                'phishing_active' => $this->phishing_active,
                'phishing_token' => $this->phishing_token,
                'phishing_ip' => $this->phishing_ip,
            ]);
        }
    }

    private function syncLogo(): void
    {
        $this->store->syncFromMediaLibraryRequest($this->logo)
            ->toMediaCollection('logo', 'digitalocean');
    }

    private function getRemediationReminderUsers(): array
    {
        if (tenant('locations')) {
            $relevantUsersCollection = $this->store->users()->permission('create-users')->get(['id', 'name', 'slug'])->keyBy('id');
        } else {
            $relevantUsersCollection = User::permission('create-users')->get(['id', 'name', 'slug'])->keyBy('id');
        }

        $userIdsForQuery = $relevantUsersCollection->keys()->all();

        return RemediationReminderPreference::query()->whereIn('user_id', $userIdsForQuery)
            ->where('enabled', true)
            ->get()
            ->groupBy(fn ($preference) => $preference->audit_type->value)
            ->map(fn($preferencesInGroup) => $preferencesInGroup->map(function ($preference) use ($relevantUsersCollection): ?array {
                $user = $relevantUsersCollection->get($preference->user_id);
                if ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'slug' => $user->slug,
                    ];
                }

                return null;
            })->filter()->values()->toArray())
            ->toArray();
    }
}
