<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('signature')->nullable();

            $table->foreignId('store_id')
                ->nullable()
                ->constrained('stores')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('q1a')->nullable();
            $table->text('q1c')->nullable();
            $table->string('q2a')->nullable();
            $table->text('q2c')->nullable();
            $table->string('q3a')->nullable();
            $table->text('q3c')->nullable();
            $table->string('q4a')->nullable();
            $table->text('q4c')->nullable();
            $table->string('q5a')->nullable();
            $table->text('q5c')->nullable();
            $table->string('q6a')->nullable();
            $table->text('q6c')->nullable();
            $table->string('q7a')->nullable();
            $table->text('q7c')->nullable();
            $table->string('q8a')->nullable();
            $table->text('q8c')->nullable();
            $table->string('q9a')->nullable();
            $table->text('q9c')->nullable();
            $table->string('q10a')->nullable();
            $table->text('q10c')->nullable();
            $table->string('q11a')->nullable();
            $table->text('q11c')->nullable();
            $table->string('q12a')->nullable();
            $table->text('q12c')->nullable();
            $table->string('q13a')->nullable();
            $table->text('q13c')->nullable();
            $table->string('q14a')->nullable();
            $table->text('q14c')->nullable();
            $table->string('q15a')->nullable();
            $table->text('q15c')->nullable();
            $table->string('q16a')->nullable();
            $table->text('q16c')->nullable();
            $table->string('q17a')->nullable();
            $table->text('q17c')->nullable();
            $table->string('q18a')->nullable();
            $table->text('q18c')->nullable();
            $table->string('q19a')->nullable();
            $table->text('q19c')->nullable();
            $table->string('q20a')->nullable();
            $table->text('q20c')->nullable();
            $table->string('q21a')->nullable();
            $table->text('q21c')->nullable();
            $table->string('q22a')->nullable();
            $table->text('q22c')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
