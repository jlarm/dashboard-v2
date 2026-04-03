<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('osha_violation_statements')
            ->whereNotNull('keywords')
            ->orderBy('id')
            ->each(function (object $row): void {
                $step1 = json_decode($row->keywords);

                if (! is_string($step1)) {
                    return;
                }

                $decoded = json_decode($step1, true);

                if (! is_array($decoded)) {
                    return;
                }

                DB::table('osha_violation_statements')
                    ->where('id', $row->id)
                    ->update(['keywords' => json_encode($decoded)]);
            });
    }

    public function down(): void
    {
        //
    }
};
