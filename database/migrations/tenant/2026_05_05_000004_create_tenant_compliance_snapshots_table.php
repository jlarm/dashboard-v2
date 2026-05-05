<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_compliance_snapshots', function (Blueprint $table): void {
            $table->id();
            $table->date('scored_on')->unique();
            $table->unsignedInteger('expired_training_count')->nullable();
            $table->unsignedInteger('expiring_soon_training_count')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_compliance_snapshots');
    }
};
