<?php

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

            $table->foreignId('store_id')
                ->nullable()
                ->constrained('stores')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('q1a');
            $table->text('q1c')->nullable();
            $table->string('q2a');
            $table->text('q2c')->nullable();
            $table->string('q3a');
            $table->text('q3c')->nullable();
            $table->string('q4a');
            $table->text('q4c')->nullable();
            $table->string('q5a');
            $table->text('q5c')->nullable();
            $table->string('q6a');
            $table->text('q6c')->nullable();
            $table->string('q7a');
            $table->text('q7c')->nullable();
            $table->string('q8a');
            $table->text('q8c')->nullable();
            $table->string('q9a');
            $table->text('q9c')->nullable();
            $table->string('q10a');
            $table->text('q10c')->nullable();
            $table->string('q11a');
            $table->text('q11c')->nullable();
            $table->string('q12a');
            $table->text('q12c')->nullable();
            $table->string('q13a');
            $table->text('q13c')->nullable();
            $table->string('q14a');
            $table->text('q14c')->nullable();
            $table->string('q15a');
            $table->text('q15c')->nullable();
            $table->string('q16a');
            $table->text('q16c')->nullable();
            $table->string('q17a');
            $table->text('q17c')->nullable();
            $table->string('q18a');
            $table->text('q18c')->nullable();
            $table->string('q19a');
            $table->text('q19c')->nullable();
            $table->string('q20a');
            $table->text('q20c')->nullable();
            $table->string('q21a');
            $table->text('q21c')->nullable();
            $table->string('q22a');
            $table->text('q22c')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
