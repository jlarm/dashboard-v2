<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->morphs('violationable');
            $table->uuid()->unique();
            $table->unsignedInteger('statement_id');
            $table->string('statement');
            $table->text('comment')->nullable();
            $table->date('violation_date')->nullable();
            $table->boolean('risk')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
