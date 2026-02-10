<?php

declare(strict_types=1);

namespace App\Jobs\Contracts;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Contract $contract) {}

    public function handle(): void
    {
        $path = storage_path('app/contracts');

        if (! File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $services = json_decode($this->contract->services);
        $reviewedServices = [];

        foreach ($services as $service) {
            $reviewedServices[] = $this->reviewLabel($service);
        }

        $html = view('central.contract.pdf', [
            'contract' => $this->contract,
            'services' => $reviewedServices,
        ])->render();

        Browsershot::html($html)
            ->showBrowserHeaderAndFooter()
            ->headerHtml('.')
            ->footerHtml(View::make('pdf.contract.footer'))
            ->format('A4')
            ->margins(5, 20, 20, 20)
            ->scale(0.75)
            ->save(storage_path('app/contracts/'.$this->createFileName()));

        $this->contract->update([
            'pdf_path' => $this->createFileName(),
        ]);
    }

    protected function reviewLabel($service): string
    {
        return match ($service) {
            'glba' => 'GLBA - Safeguards Rule, Sales & Finance',
            'osha' => 'OSHA',
            'it' => 'IT Security',
            'ces' => 'Cyber Enhanced Security',
        };
    }

    private function createFileName(): string
    {
        return mb_strtolower(str_replace(' ', '-', $this->contract->dealer_name)).'-armp-contract-'.$this->contract->created_at->format('Y-m-d').'.pdf';
    }
}
