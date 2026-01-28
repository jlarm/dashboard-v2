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
        Schema::table('stores', function (Blueprint $table) {
            $table->string('police_emergency_phone')->nullable()->after('logo');
            $table->string('police_non_emergency_phone')->nullable()->after('logo');
            $table->string('fire_emergency_phone')->nullable()->after('logo');
            $table->string('fire_non_emergency_phone')->nullable()->after('logo');
            $table->string('fire_alarm_type')->nullable()->after('logo');
            $table->string('burglar_alarm_type')->nullable()->after('logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            //
        });
    }
};
