<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invites', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->json('stores')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('roles');
            $table->string('invitation_token', 32)->unique()->nullable();
            $table->timestamp('registered_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invites');
    }
};
