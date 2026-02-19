<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CertIndex extends Component
{
    public User $user;
    public bool $isLoaded = false;
    protected $listeners = [
        'employeeTabChanged' => 'handleTabChanged',
        'certificateGenerated' => 'reloadCertificates',
    ];

    public function handleTabChanged(string $tab): void
    {
        if ($tab !== 'certificates' || $this->isLoaded) {
            return;
        }

        $this->isLoaded = true;
    }

    public function reloadCertificates(): void
    {
        $this->isLoaded = true;
    }

    public function render()
    {
        $certs = $this->isLoaded
            ? $this->user->certificates()->latest()->get()
            : collect();

        return view('livewire.dealer.employee.cert-index', [
            'certs' => $certs,
        ]);
    }

    public function temporaryUrl(string $fileName): string
    {
        return Storage::disk('armp-certs')->temporaryUrl(
            tenant('id').'/'.$this->user->id.'/'.$fileName,
            now()->addMinutes(2)
        );
    }
}
