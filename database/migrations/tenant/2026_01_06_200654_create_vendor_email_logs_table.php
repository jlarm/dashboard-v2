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
        if (Schema::hasTable('vendor_email_logs')) {
            return;
        }

        Schema::create('vendor_email_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('vendor_form_id')->constrained()->cascadeOnDelete();
            $table->string('to');
            $table->string('subject');
            $table->string('mailgun_id')->nullable();
            $table->string('mailgun_message')->nullable();
            $table->string('message_id')->nullable();
            $table->timestamp('sent_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_email_logs');
    }
};
