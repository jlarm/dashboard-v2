<?php

namespace App\Http\Livewire\Dealer\Settings;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class SendComplianceEmailLink extends Component
{
    public Store $store;
    public $email;

    public function sendEmail()
    {
        $signedUrl = \URL::temporarySignedRoute('dealer.dealer.settings.form', now()->addDays(4), ['store' => $this->store->id]);

        Mail::to($this->email)->send(new \App\Mail\ComplianceFormMail($signedUrl, $this->store->name));

        $this->reset(['email']);

        Notification::make()
            ->title('Email Sent Successfully')
            ->success()
            ->send();
    }
    public function render()
    {
        return view('livewire.dealer.settings.send-compliance-email-link');
    }
}
