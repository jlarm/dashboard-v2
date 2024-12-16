<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;

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
    public function handle()
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            Course::query()
                ->where('slug', function ($query) {
                    $query->select('slug')
                        ->where('slug', '6h-national-emission-standards')
                        ->orWhere('slug', 'tractor-safety')
                        ->orWhere('slug', 'dot-hazardous-materials-transportation')
                        ->orWhere('slug', 'dot-hazardous-materials-transportation-identifying-hazardous-materials')
                        ->orWhere('slug', 'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment')
                        ->OrWhere('slug', 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')
                        ->OrWhere('slug', 'powered-industrial-trucks');
                })
                ->update(['optional' => true]);

        });
    }
}
