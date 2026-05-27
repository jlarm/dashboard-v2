<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\Dealership;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Override;

class UpdateOptionalCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    #[Override]
    protected $signature = 'courses:update-optional {--tenants=* : The tenant(s) to run the command for. Default all.}';

    /**
     * The console command description.
     *
     * @var string
     */
    #[Override]
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

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function (Dealership $tenant): void {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            Course::query()
                ->whereIn('slug', [
                    '6h-national-emission-standards',
                    'tractor-safety',
                    'dot-hazardous-materials-transportation',
                    'dot-hazardous-materials-transportation-identifying-hazardous-materials',
                    'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment',
                    'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding',
                    'diversity-equality-and-inclusion-training',
                    'powered-industrial-trucks',
                ])
                ->update(['optional' => true]);

        });
    }
}
