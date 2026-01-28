<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fit_test_docs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id');
            $table->foreignId('user_id');
            $table->string('employee_name');
            $table->date('date');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fit_test_docs');
    }
};
