<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remediation_reminders', function (Blueprint $table): void {
            $table->id();
            $table->morphs('remindable');
            $table->date('send_date');
            $table->unsignedInteger('store_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remediation_reminders');
    }
};
