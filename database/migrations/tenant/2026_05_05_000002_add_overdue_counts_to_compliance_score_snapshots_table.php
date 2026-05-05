<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('compliance_score_snapshots', function (Blueprint $table): void {
            $table->unsignedInteger('overdue_count')->nullable()->after('weights');
            $table->unsignedInteger('overdue_high_severity_count')->nullable()->after('overdue_count');
        });
    }

    public function down(): void
    {
        Schema::table('compliance_score_snapshots', function (Blueprint $table): void {
            $table->dropColumn(['overdue_count', 'overdue_high_severity_count']);
        });
    }
};
