<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phishing_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_id')->nullable();
            $table->foreignId('store_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('status')->nullable();
            $table->json('results')->nullable();
            $table->dateTime('launched_at')->nullable();
            $table->dateTime('campaign_created_at');
            $table->integer('emails_sent')->default(0);
            $table->integer('emails_opened')->default(0);
            $table->integer('links_clicked')->default(0);
            $table->integer('data_submitted')->default(0);
            $table->integer('emails_reported')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phishing_campaigns');
    }
};
