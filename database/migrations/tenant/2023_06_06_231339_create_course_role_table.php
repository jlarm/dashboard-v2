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
        Schema::create('course_role', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->index();
            $table->unsignedBigInteger('role_id')->index();

            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_role');
    }
};
