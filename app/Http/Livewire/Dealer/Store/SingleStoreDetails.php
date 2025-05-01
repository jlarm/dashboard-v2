<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Enums\Frequency;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
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

    public ?Store $store;

    public $name;
    public $address;
    public $city;
    public $state;
    public $postal_code;
    public $phone;
    public $website;

    public $mediaComponentNames = ['logo'];
    public $logo = null;

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
    public array $selectedManagerIds = [];

    public function mount(): void
    {
        $this->settings = GlobalSetting::first();

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
        $this->selectedManagerIds = [];

        if ($this->remediationNotifications) {
            $this->selectedManagerIds = collect($this->store->remediationSettings->managers)
                ->map(function ($managers, $audit) {
                    return collect($managers)->map(function ($manager) use ($audit) {
                        return $audit . '_' . $manager;
                    });
                })
                ->flatten()
                ->toArray();
        }
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

    public function departmentManagers(): Collection
    {
        $audits = $this->audits();

        $allManagers = collect();

        foreach($audits as $name => $departmentIds) {
            $allManagers[$name] = collect();
            foreach($departmentIds as $id) {
                $allManagers[$name] = $allManagers[$name]->merge(
                    $this->getUsers()
                        ->role('Manager')
                        ->where('department_id', $id)
                        ->select(['id', 'name', 'department_id'])
                        ->get()
                        ->toArray()
                );
            }
        }

        return $allManagers;
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
            'selectedManagerIds' => ['required_if:remediationNotifications,true'],
        ];
    }

    private function validationMessages(): array
    {
        return [
            'frequency.required_if' => 'The frequency field is required when remediation notifications are enabled.',
            'selectedManagerIds.required_if' => 'At least one manager must be selected.',
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
        ]);
    }

    private function updateRemediationSettings(): Void
    {
        $this->store->remediationSettings()->updateOrCreate([], [
            'active' => $this->remediations,
            'notifications' => $this->remediationNotifications,
            'frequency' => $this->frequency,
            'managers' => $this->saveManagers(),
        ]);
    }

    private function updateGlobalSettings(): void
    {
        if (is_null($this->settings)) {
            GlobalSetting::create([
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

    private function audits(): array
    {
        return [
            'Osha' => [3,4],
            'Body Shop' => [5],
            'Glba' => [1,6],
        ];
    }

    private function saveManagers(): array
    {
        return collect($this->selectedManagerIds)
            ->map(function ($managerId) {
                [$audit, $userId] = explode('_', $managerId);
                return [$audit => $userId];
            })
            ->groupBy(function ($item) {
                return key($item);
            })
            ->map(function ($group) {
                // Extract user IDs for this audit type
                return collect($group)->map(function ($item) {
                    return reset($item);
                })->values()->toArray();
            })
            ->toArray();
    }

    private function getUsers()
    {
        if (tenant('locations')) {
            return $this->store->users()->withoutSuperAdminsAndConsultants();
        }

        return User::query()->withoutSuperAdminsAndConsultants();
    }
}
