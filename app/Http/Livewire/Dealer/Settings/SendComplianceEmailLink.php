<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Settings;

use App\Mail\ComplianceFormMail;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class SendComplianceEmailLink extends Component
{
    public Store $store;
    public $email;

    public function sendEmail(): void
    {
        $signedUrl = URL::temporarySignedRoute('dealer.dealer.settings.form', now()->addDays(4), ['store' => $this->store->id]);

        Mail::to($this->email)->send(new ComplianceFormMail($signedUrl, $this->store->name));

        $this->reset(['email']);

        Notification::make()
            ->title('Email Sent Successfully')
            ->success()
            ->send();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.settings.send-compliance-email-link');
    }
}
