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
        Schema::table('scan_settings', function (Blueprint $table) {
            $table->bigInteger('external_id')->nullable();
            $table->bigInteger('internal_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scan_settings', function (Blueprint $table) {
            $table->dropColumn('external_id');
            $table->dropColumn('internal_id');
        });
    }
};
