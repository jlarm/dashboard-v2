<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('user_id');
            $table->date('agreement_date');
            $table->string('dealer_name');
            $table->json('services');
            $table->date('commence_date');
            $table->integer('yearly_inspection_total');
            $table->integer('initial_fee');
            $table->integer('monthly_fee');
            $table->string('armp_signature')->nullable();
            $table->string('armp_printed_name')->nullable();
            $table->date('armp_date_signed')->nullable();
            $table->string('dealer_signature')->nullable();
            $table->string('dealer_printed_name')->nullable();
            $table->date('dealer_date_signed')->nullable();
            $table->string('dealer_physical_address')->nullable();
            $table->string('dealer_physical_city')->nullable();
            $table->string('dealer_physical_state')->nullable();
            $table->string('dealer_physical_zip')->nullable();
            $table->string('dealer_phone')->nullable();
            $table->string('dealer_qi_name')->nullable();
            $table->string('dealer_qi_email')->nullable();
            $table->string('dealer_billing_address')->nullable();
            $table->string('dealer_billing_city')->nullable();
            $table->string('dealer_billing_state')->nullable();
            $table->string('dealer_billing_zip')->nullable();
            $table->string('dealer_billing_fax')->nullable();
            $table->string('dealer_billing_contact_name')->nullable();
            $table->string('dealer_billing_contact_title')->nullable();
            $table->string('dealer_billing_contact_email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
