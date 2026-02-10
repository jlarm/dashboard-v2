<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table): void {
            $table->decimal('standard_dpp_rate', 5, 2)->nullable()->after('fi_password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table): void {
            if (Schema::hasColumn('stores', 'standard_dpp_rate')) {
                $table->dropColumn('standard_dpp_rate');
            }
        });
    }
};
