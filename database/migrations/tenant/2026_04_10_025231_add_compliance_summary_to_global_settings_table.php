<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('global_settings', function (Blueprint $table): void {
            $table->boolean('compliance_summary_active')->default(false)->after('phishing_ip');
            $table->string('compliance_summary_frequency')->nullable()->after('compliance_summary_active');
            $table->json('compliance_summary_recipients')->nullable()->after('compliance_summary_frequency');
        });
    }

    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table): void {
            $table->dropColumn(['compliance_summary_active', 'compliance_summary_frequency', 'compliance_summary_recipients']);
        });
    }
};
