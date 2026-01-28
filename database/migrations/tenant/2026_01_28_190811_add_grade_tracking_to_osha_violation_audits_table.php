<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('osha_violation_audits', function (Blueprint $table) {
            $table->foreignId('grade_updated_by')->nullable()->constrained('users');
            $table->timestamp('grade_updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('osha_violation_audits', function (Blueprint $table) {
            $table->dropConstrainedForeignId('grade_updated_by');
            $table->dropColumn('grade_updated_at');
        });
    }
};
