<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_manuals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class);
            $table->foreignIdFor(App\Models\Dealer\Store::class);
            $table->string('qi_name');
            $table->decimal('standard_dpp_rate', 5, 2);
            $table->string('adoption_approval_name_one')->nullable();
            $table->string('adoption_approval_signature_one')->nullable();
            $table->string('adoption_approval_name_two')->nullable();
            $table->string('adoption_approval_signature_two')->nullable();
            $table->string('adoption_approval_name_three')->nullable();
            $table->string('adoption_approval_signature_three')->nullable();
            $table->string('dealer_participation_program_name')->nullable();
            $table->string('dealer_participation_program_signature')->nullable();
            $table->string('appointment_program_name_one')->nullable();
            $table->string('appointment_program_signature_one')->nullable();
            $table->string('appointment_program_name_two')->nullable();
            $table->string('appointment_program_signature_two')->nullable();
            $table->string('appointment_program_name_three')->nullable();
            $table->string('appointment_program_signature_three')->nullable();
            $table->string('acknowledgement_name');
            $table->string('acknowledgement_signature');
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_manuals');
    }
};
