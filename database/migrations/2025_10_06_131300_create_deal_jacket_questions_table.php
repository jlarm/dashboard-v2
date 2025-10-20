<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deal_jacket_questions', static function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('statement')->nullable();
            $table->json('categories');
            $table->unsignedTinyInteger('weight')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_jacket_questions');
    }
};
