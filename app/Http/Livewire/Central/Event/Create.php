<?php

namespace App\Http\Livewire\Central\Event;

use App\Models\Event;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Create extends Modal
{
    public $name;
    public $startDate;
    public $endDate;
    public $locationName;
    public $address;
    public $city;
    public $state;
    public $zipCode;
    public $link;
    protected $rules = [
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

    public function create()
    {
        $validated = $this->validate();

        Event::create([
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

    public function render()
    {
        return view('livewire.central.event.create');
    }
}
