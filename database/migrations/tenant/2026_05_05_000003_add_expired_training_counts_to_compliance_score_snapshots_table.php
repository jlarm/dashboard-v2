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
            $table->unsignedInteger('expired_training_count')->nullable()->after('overdue_high_severity_count');
            $table->unsignedInteger('expiring_soon_training_count')->nullable()->after('expired_training_count');
        });
    }

    public function down(): void
    {
        Schema::table('compliance_score_snapshots', function (Blueprint $table): void {
            $table->dropColumn(['expired_training_count', 'expiring_soon_training_count']);
        });
    }
};
