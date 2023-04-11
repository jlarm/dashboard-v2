<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\StoreSettings;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\Component;

class SingleStoreDetails extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $dealer;

    public function mount(): void
    {
        $this->dealer = StoreSettings::first();
        $this->form->fill([
            'name' => $this->dealer->name,
            'address' => $this->dealer->address,
            'city' => $this->dealer->city,
            'state' => $this->dealer->state,
            'postal_code' => $this->dealer->postal_code,
            'phone' => $this->dealer->phone,
            'url' => $this->dealer->website,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')->required()->label('Dealership Name'),
            Forms\Components\TextInput::make('address')->required()->label('Address'),
            Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\TextInput::make('city')->required()->label('City'),
                    Forms\Components\TextInput::make('state')->required()->label('State'),
                    Forms\Components\TextInput::make('postal_code')->required()->label('Zip Code'),
                ]),
            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\TextInput::make('phone')->required()->label('Phone Number'),
                    Forms\Components\TextInput::make('url')->required()->label('Website URL'),
                ]),
        ];
    }

    public function update(): void
    {
        $this->dealer->update($this->form->getState());

        Notification::make()
            ->title('Settings Updated Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.store.single-store-details');
    }
}
