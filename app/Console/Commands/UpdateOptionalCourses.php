<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class UpdateOptionalCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:update-optional {--tenants=* : The tenant(s) to run the command for. Default all.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function ($tenant): void {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            Course::query()
                ->where('slug', function ($query): void {
                    $query->select('slug')
                        ->where('slug', '6h-national-emission-standards')
                        ->orWhere('slug', 'tractor-safety')
                        ->orWhere('slug', 'dot-hazardous-materials-transportation')
                        ->orWhere('slug', 'dot-hazardous-materials-transportation-identifying-hazardous-materials')
                        ->orWhere('slug', 'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment')
                        ->orWhere('slug', 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')
                        ->orWhere('slug', 'diversity-equality-and-inclusion-training')
                        ->orWhere('slug', 'powered-industrial-trucks');
                })
                ->update(['optional' => true]);

        });
    }
}
