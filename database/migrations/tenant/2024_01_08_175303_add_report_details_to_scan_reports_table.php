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
        Schema::table('scan_reports', function (Blueprint $table) {
            $table->string('grade')->nullable();
            $table->integer('exploits_high')->nullable();
            $table->integer('exploits_medium')->nullable();
            $table->integer('exploits_low')->nullable();
            $table->integer('cves_high')->nullable();
            $table->integer('cves_medium')->nullable();
            $table->integer('cves_low')->nullable();
            $table->integer('assets')->nullable();
            $table->date('last_scan')->nullable();
            $table->date('next_scan')->nullable();
            $table->string('last_scan_status')->nullable();
            $table->integer('last_scan_progress')->nullable();
            $table->integer('last_scan_errors')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scan_reports', function (Blueprint $table) {
            $table->dropColumn('grade');
            $table->dropColumn('exploits_high');
            $table->dropColumn('exploits_medium');
            $table->dropColumn('exploits_low');
            $table->dropColumn('cves_high');
            $table->dropColumn('cves_medium');
            $table->dropColumn('cves_low');
            $table->dropColumn('assets');
            $table->dropColumn('last_scan');
            $table->dropColumn('next_scan');
            $table->dropColumn('last_scan_status');
            $table->dropColumn('last_scan_progress');
            $table->dropColumn('last_scan_errors');
        });
    }
};
