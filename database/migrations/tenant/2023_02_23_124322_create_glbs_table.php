<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('glbs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();

            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('website');
            $table->string('qi');
            $table->json('receptacles')->nullable();

            $table->json('managers')->nullable();

            $table->string('assessment_company');
            $table->string('assessment_name');
            $table->date('assessment_date');

            $table->boolean('q1a');
            $table->text('q1c')->nullable();
            $table->boolean('q2a');
            $table->text('q2c')->nullable();
            $table->boolean('q3a');
            $table->text('q3c')->nullable();
            $table->boolean('q4a');
            $table->text('q4c')->nullable();
            $table->boolean('q5a');
            $table->text('q5c')->nullable();
            $table->boolean('q6a');
            $table->text('q6c')->nullable();
            $table->boolean('q7a');
            $table->text('q7c')->nullable();
            $table->boolean('q8a');
            $table->text('q8c')->nullable();
            $table->boolean('q9a');
            $table->text('q9c')->nullable();
            $table->boolean('q10a');
            $table->text('q10c')->nullable();
            $table->boolean('q11a');
            $table->text('q11c')->nullable();
            $table->boolean('q12a');
            $table->text('q12c')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('glbs');
    }
};
