<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Dealership;

use App\Models\User;
use App\Services\DealershipCreator;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Create extends Modal
{
    public string $name = '';

    /** @var array<string, string> */
    protected array $rules = [
        'name' => 'required|string|max:255|unique:tenants,name|regex:/^[a-zA-Z0-9 ]+$/',
    ];

    public function mount(): void
    {
        abort_unless(auth()->user()?->hasAnyRole('super-admin|Consultant') ?? false, 403);
    }

    public function createDealership(DealershipCreator $dealershipCreator): void
    {
        $validated = $this->validate();
        $user = auth()->user();

        abort_unless($user instanceof User, 403);

        $dealershipCreator->create($user, $validated['name']);

        $this->emit('refreshDealerships');
        $this->close();

        Notification::make()
            ->title('Dealership Created')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.central.dealership.create');
    }
}
