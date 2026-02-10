<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Course;
use Illuminate\Console\Command;

class CourseYearsExpireCommand extends Command
{
    protected $signature = 'course:years-expire {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Add the years before course expires';
    protected array $custom = [
        'dot-hazardous-materials-transportation' => 3,
        'dot-hazardous-materials-transportation-identifying-hazardous-materials' => 3,
        'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment' => 3,
        'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding' => 3,
    ];

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant): void {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            foreach (Course::all() as $course) {
                $course->update([
                    'years_expires' => array_key_exists($course->slug, $this->custom) ? $this->custom[$course->slug] : 1,
                ]);
            }
        });
    }
}
