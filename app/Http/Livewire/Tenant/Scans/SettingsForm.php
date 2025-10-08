<?php

namespace App\Http\Livewire\Tenant\Scans;

use App\Models\Dealer\Cyrisma;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;

class SettingsForm extends Component
{
    public ?Store $store = null;
    public ?string $shortName = '';
    public bool $isLoading = false;
    public ?string $errorMessage = null;
    public ?string $successMessage = null;
    protected array $rules = [
        'shortName' => ['required', 'string', 'min:3', 'max:255'],
    ];

    public function mount(): void
    {
        $this->store = Store::find(app('currentStore'));
        $this->shortName = $this->store->cyrisma->short_name ?? null;
    }

    public function updated($propertyName): void
    {
        if ($propertyName === 'shortName') {
            $this->errorMessage = null;
            $this->successMessage = null;
        }
    }

    public function save(): void
    {
        $this->validate();

        $this->isLoading = true;
        $this->errorMessage = null;
        $this->successMessage = null;

        try {
            $cyrisma = app(CyrismaService::class);

            $instance = $cyrisma->findInstanceByShortName($this->shortName);

            if (! $instance) {
                $this->errorMessage = 'No instance found with that short name.';
                $this->isLoading = false;

                return;
            }

            Cyrisma::updateOrCreate(
                ['store_id' => $this->store->id],
                [
                    'short_name' => $this->shortName,
                    'instance_id' => $instance['instance_id'],
                    'instance_url' => $instance['url'],
                ]
            );

            $this->store->refresh()->load('cyrisma');

            Notification::make()
                ->title('Instance configuration saved successfully')
                ->success()
                ->send();

        } catch (Exception $e) {
            Log::error('Failed to save configuraiton', [
                'message' => $e->getMessage(),
                'store_id' => $this->store->id,
            ]);

            $this->errorMessage = 'An error occurred while saving. Please try again.';
        } finally {
            $this->isLoading = false;
        }
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.settings-form');
    }
}
