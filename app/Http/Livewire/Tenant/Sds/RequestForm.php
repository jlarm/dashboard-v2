<?php

namespace App\Http\Livewire\Tenant\Sds;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class RequestForm extends Modal
{
    public string $name = '';
    public string $manufacturer = '';
    protected array $rules = [
        'name' => 'required|string|max:255',
        'manufacturer' => 'nullable|string|max:255',
    ];

    public function send(): void
    {
        $this->validate();

        $user = auth()->user();
        $tenantName = tenant('name');

        $superAdmins = User::role('super-admin')->pluck('email')->toArray();

        foreach ($superAdmins as $superAdmin) {
            Mail::raw($this->buildEmailContent($user, $tenantName), static function ($message) use ($superAdmin) {
                $message->to($superAdmin)
                    ->subject('New SDS Sheet Request - '.tenant('name'))
                    ->from('noreply@armp.app');
            });
        }

        $this->reset(['name', 'manufacturer']);

        $this->close();

        Notification::make()
            ->title('Request successfully sent')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.tenant.sds.request-form');
    }

    private function buildEmailContent($user, $tenantName): string
    {
        return "Chemical Name: {$this->name}\n".
            'Manufacturer: '.($this->manufacturer ?: 'Not specified')."\n\n".
            "Requested by: {$user->name} - {$user->email}\n".
            "Store Name: {$tenantName}\n";
    }
}
