<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Course;
use App\Models\Dealership;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Override;

class CourseYearsExpireCommand extends Command
{
    #[Override]
    protected $signature = 'courses:years-expire {--tenants=* : The tenant(s) to run the command for. Default all.}';

    #[Override]
    protected $description = 'Add the years before course expires';

    /**
     * @var array<string, int>
     */
    protected array $custom = [
        'dot-hazardous-materials-transportation' => 3,
        'dot-hazardous-materials-transportation-identifying-hazardous-materials' => 3,
        'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment' => 3,
        'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding' => 3,
    ];

    public function handle(): void
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function (Dealership $tenant): void {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            foreach (Course::all() as $course) {
                $course->update([
                    'years_expires' => array_key_exists((string) $course->slug, $this->custom) ? $this->custom[$course->slug] : 1,
                ]);
            }
        });
    }
}
