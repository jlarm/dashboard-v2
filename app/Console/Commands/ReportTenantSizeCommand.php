<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealership;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReportTenantSizeCommand extends Command
{
    protected $signature = 'tenant:report-sizes';
    protected $description = 'Command description';

    public function handle(): void
    {
        $this->info('Tenant Database Size Report');

        Dealership::all()->each(function ($tenant) {
            $dbName = $tenant->tenancy_db_name;
            $size = DB::connection('mysql')
                ->selectOne('
                    SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb
                    FROM information_schema.TABLES
                    WHERE table_schema = ?
                ', [$dbName])->size_mb;

            $this->line(" - {$dbName}: {$size} MB");
        });
    }
}
