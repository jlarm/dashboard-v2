<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compliance_score_snapshots', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->date('scored_on');
            $table->decimal('score', 5, 2);
            $table->json('pillars');
            $table->json('weights');
            $table->timestamps();

            $table->unique(['store_id', 'scored_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compliance_score_snapshots');
    }
};
