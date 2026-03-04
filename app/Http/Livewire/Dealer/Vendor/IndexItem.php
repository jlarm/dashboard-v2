<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Livewire\Component;

class IndexItem extends Component
{
    public Vendor $vendor;
    public $noCount;
    public $totalQuestions = 0;
    public $array = [];
    private ?object $latestForm = null;
    private bool $latestFormLoaded = false;

    public function mount(): void
    {
        foreach ($this->vendor->getAttributes() as $key => $value) {
            if (str_starts_with($key, 'q') && str_ends_with($key, 'a')) {
                if ($value === 'no') {
                    $this->array[] = $value;
                }
                $this->totalQuestions++;
            }
        }
        $this->noCount = count($this->array);
    }

    public function download()
    {
        $vendor = Vendor::query()->where('id', $this->vendor->id)->first();
        $pdf = PDF::loadView('dealer.vendor.pdf.form-submission', ['vendor' => $vendor]);

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

    public function render()
    {
        return view('livewire.dealer.vendor.index-item');
    }

    private function getLatestForm(): ?object
    {
        if (! $this->latestFormLoaded) {
            $this->latestForm = $this->vendor->forms()->latest()->first();
            $this->latestFormLoaded = true;
        }

        return $this->latestForm;
    }
}
