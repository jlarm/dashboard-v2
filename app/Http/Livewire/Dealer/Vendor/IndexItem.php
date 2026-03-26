<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public Vendor $vendor;
    public int $noCount = 0;
    public int $totalQuestions = 0;
    public array $vendorAnswers = [];

    public function mount(): void
    {
        foreach ($this->vendor->getAttributes() as $key => $value) {
            if (str_starts_with($key, 'q') && str_ends_with($key, 'a')) {
                if ($value === 'no') {
                    $this->vendorAnswers[] = $value;
                }
                $this->totalQuestions++;
            }
        }
        $this->noCount = count($this->vendorAnswers);
    }

    public function download()
    {
        $pdf = PDF::loadView('dealer.vendor.pdf.form-submission', ['vendor' => $this->vendor]);

        return response()->streamDownload(function () use ($pdf): void {
            echo $pdf->output();
        }, $this->vendor->name.now()->format('Ymd').'.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function isCompleted(): bool
    {
        $form = $this->getLatestForm();

        if (! $form) {
            return false;
        }

        return $form->signature || $form->document_path;
    }

    public function render(): View
    {
        return view('livewire.dealer.vendor.index-item');
    }

    private function getLatestForm(): ?object
    {
        return $this->vendor->latestForm;
    }
}
