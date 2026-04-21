<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('contracts')
            ->whereNotNull('services')
            ->orderBy('id')
            ->each(function (object $row): void {
                $outer = json_decode((string) $row->services);

                if (! is_string($outer)) {
                    return;
                }

                $decoded = json_decode($outer, true);

                if (! is_array($decoded)) {
                    return;
                }

                DB::table('contracts')
                    ->where('id', $row->id)
                    ->update(['services' => json_encode($decoded)]);
            });
    }

    public function down(): void
    {
        //
    }
};
