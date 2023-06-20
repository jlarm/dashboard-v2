<?php

namespace App\Http\Livewire\Dealer\Settings;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;

class EmployeeList extends Component
{
    public Store $store;

    public $dealer;
    public $qualified_individual_name;
    public $qualified_individual_phone;
    public $service_manager_name;
    public $service_manager_phone;
    public $parts_manager_name;
    public $parts_manager_phone;
    public $body_shop_manager_name;
    public $body_shop_manager_phone;
    public $general_manager_name;
    public $general_manager_phone;
    public $owner_name;
    public $owner_phone;

    protected $rules = [
        'qualified_individual_name' => ['nullable', 'string', 'max:255'],
        'qualified_individual_phone' => ['nullable', 'string', 'max:255'],
        'service_manager_name' => ['nullable', 'string', 'max:255'],
        'service_manager_phone' => ['nullable', 'string', 'max:255'],
        'parts_manager_name' => ['nullable', 'string', 'max:255'],
        'parts_manager_phone' => ['nullable', 'string', 'max:255'],
        'body_shop_manager_name' => ['nullable', 'string', 'max:255'],
        'body_shop_manager_phone' => ['nullable', 'string', 'max:255'],
        'general_manager_name' => ['nullable', 'string', 'max:255'],
        'general_manager_phone' => ['nullable', 'string', 'max:255'],
        'owner_name' => ['nullable', 'string', 'max:255'],
        'owner_phone' => ['nullable', 'string', 'max:255'],
    ];

    public function mount(\App\Models\Dealer\Settings\EmployeeList $employeeList)
    {
        $this->dealer = $employeeList->where('store_id', $this->store->id)->first();

        $this->qualified_individual_name = $this->dealer->qualified_individual_name ?? '';
        $this->qualified_individual_phone = $this->dealer->qualified_individual_phone ?? '';
        $this->service_manager_name = $this->dealer->service_manager_name ?? '';
        $this->service_manager_phone = $this->dealer->service_manager_phone ?? '';
        $this->parts_manager_name = $this->dealer->parts_manager_name ?? '';
        $this->parts_manager_phone = $this->dealer->parts_manager_phone ?? '';
        $this->body_shop_manager_name = $this->dealer->body_shop_manager_name ?? '';
        $this->body_shop_manager_phone = $this->dealer->body_shop_manager_phone ?? '';
        $this->general_manager_name = $this->dealer->general_manager_name ?? '';
        $this->general_manager_phone = $this->dealer->general_manager_phone ?? '';
        $this->owner_name = $this->dealer->owner_name ?? '';
        $this->owner_phone = $this->dealer->owner_phone ?? '';
    }

    public function update()
    {
        $this->validate();

        $this->dealer->update([
            'qualified_individual_name' => $this->qualified_individual_name,
            'qualified_individual_phone' => $this->qualified_individual_phone,
            'service_manager_name' => $this->service_manager_name,
            'service_manager_phone' => $this->service_manager_phone,
            'parts_manager_name' => $this->parts_manager_name,
            'parts_manager_phone' => $this->parts_manager_phone,
            'body_shop_manager_name' => $this->body_shop_manager_name,
            'body_shop_manager_phone' => $this->body_shop_manager_phone,
            'general_manager_name' => $this->general_manager_name,
            'general_manager_phone' => $this->general_manager_phone,
            'owner_name' => $this->owner_name,
            'owner_phone' => $this->owner_phone,
        ]);

        Notification::make()
            ->title('Employee List Updated Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.settings.employee-list');
    }
}
