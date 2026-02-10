<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Event;

use App\Models\Event;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Create extends Modal
{
    public string $name = '';
    public ?string $startDate = null;
    public ?string $endDate = null;
    public ?string $locationName = '';
    public ?string $address = '';
    public ?string $city = '';
    public ?string $state = '';
    public ?string $zipCode = '';
    public ?string $link = '';

    /** @var array<string, string> */
    protected array $rules = [
        'name' => 'required|string|max:255',
        'startDate' => 'required|date:Y-m-d',
        'endDate' => 'required|date:Y-m-d|after_or_equal:startDate',
        'locationName' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'zipCode' => 'nullable|string|max:255',
        'link' => 'nullable|string|max:255',
    ];

    public function create(): void
    {
        $validated = $this->validate();

        Event::query()->create([
            'name' => $validated['name'],
            'start_date' => $validated['startDate'],
            'end_date' => $validated['endDate'],
            'location_name' => $validated['locationName'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zipCode'],
            'link' => $validated['link'],
        ]);

        $this->emit('eventAdded');

        $this->close();

        Notification::make()
            ->title('Event Successfully Created!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.central.event.create');
    }
}
