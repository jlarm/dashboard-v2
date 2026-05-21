<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timelines', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('phishing_campaign_id')->constrained('phishing_campaigns')->cascadeOnDelete();
            $table->string('email');
            $table->dateTime('time');
            $table->string('message');
            $table->json('details')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timelines');
    }
};
