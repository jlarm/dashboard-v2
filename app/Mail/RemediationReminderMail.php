<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RemediationReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $modelType;
    public bool $locations;
    public string $storeSlug;

    public function __construct($modelType, $locations, $storeSlug)
    {
        $this->locations = $locations;
        $this->storeSlug = $storeSlug;
        $this->modelType = $modelType;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@armp.app'),
            subject: $this->getLabel().' Remediation Reminder',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.remediation-reminder',
            with: [
                'label' => $this->getLabel(),
                'link' => $this->link(),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }

    private function getLabel(): string
    {
        return match ($this->modelType) {
            'Osha' => 'OSHA',
            'BodyShop' => 'Body Shop',
            'Glba' => 'GLBA',
        };
    }

    private function getLinkSlug(): string
    {
        return match ($this->modelType) {
            'Osha' => 'osha',
            'BodyShop' => 'body-shop',
            'Glba' => 'finance',
        };
    }

    private function link(): string
    {
        if ($this->locations) {
            return 'https://'.tenant('domain').'/stores/'.$this->storeSlug.'/audits/'.$this->getLinkSlug();
        }

        return 'https://'.tenant('domain').'/audits/'.$this->getLinkSlug();
    }
}
