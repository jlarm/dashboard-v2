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
        Schema::table('osha_violation_audits', function (Blueprint $table) {
            $table->string('remediation_pdf_path')->nullable()->after('pdf_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('osha_violation_audits', function (Blueprint $table) {
            $table->dropColumn('remediation_pdf_path');
        });
    }
};
