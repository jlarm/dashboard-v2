<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class IssueCounts extends Component
{
    public array $details = [];

    protected CyrismaService $cyrisma;

    public function mount(CyrismaService $cyrisma): void
    {
        $this->cyrisma = $cyrisma;
        $scanData = $this->cyrisma->getVulnerabilityScans();
        $this->details = $scanData['vulnerability_scans'][0] ?? [];
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.components.issue-counts');
    }
}
