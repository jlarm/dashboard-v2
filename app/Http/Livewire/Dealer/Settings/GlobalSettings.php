<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Settings;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;

class GlobalSettings extends Component
{
    private const SECTION_GENERAL = 'general';

    private const SECTION_COURSE_MANAGEMENT = 'course-management';

    private const SECTION_RESET_COURSES = 'reset-courses';

    private const SECTION_PHISHING = 'phishing';

    public $settings;
    public $phishing_active;
    public $phishing_token;
    public $phishing_ip;
    public $stores = [];
    public string $section = self::SECTION_GENERAL;

    public function mount(string $section = self::SECTION_GENERAL): void
    {
        abort_unless(in_array($section, $this->sections(), true), 404);

        $this->section = $section;
        $this->settings = GlobalSetting::query()->first();

        $this->phishing_active = $this->settings->phishing_active ?? false;
        $this->phishing_token = $this->settings->phishing_token ?? null;
        $this->phishing_ip = $this->settings->phishing_ip ?? null;

        $this->stores = Store::query()
            ->with('remediationSettings')
            ->orderBy('name')
            ->select(['id', 'name', 'courses_not_taken_notification'])
            ->get();
    }

    public function toggleStoreNotifications($storeId): void
    {
        $store = Store::with('remediationSettings')->find($storeId);

        if ($store) {
            $store->update([
                'courses_not_taken_notification' => ! $store->courses_not_taken_notification,
            ]);

            $this->stores = Store::query()
                ->with('remediationSettings')
                ->orderBy('name')
                ->select(['id', 'name', 'courses_not_taken_notification'])
                ->get();
        }
    }

    public function toggleRemediations($storeId): void
    {
        $store = Store::with('remediationSettings')->find($storeId);

        if ($store) {
            $store->remediationSettings()->updateOrCreate([], [
                'active' => ! ($store->remediationSettings->active ?? false),
            ]);

            $this->stores = Store::query()
                ->with('remediationSettings')
                ->orderBy('name')
                ->select(['id', 'name', 'courses_not_taken_notification'])
                ->get();
        }
    }

    public function update(): void
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

        Notification::make()
            ->title('Settings Updated Successfully!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.settings.global-settings')
            ->layout('components.dealer-app');
    }

    private function sections(): array
    {
        return [
            self::SECTION_GENERAL,
            self::SECTION_COURSE_MANAGEMENT,
            self::SECTION_RESET_COURSES,
            self::SECTION_PHISHING,
        ];
    }
}
