<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deal_jackets', static function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('deal_jacket_group_id')->constrained('deal_jacket_groups')->cascadeOnDelete();
            $table->date('audit_date');
            $table->date('date_of_deal_jacket');
            $table->text('customer_name');
            $table->text('customer_deal_number');
            $table->foreignId('user_id')->constrained('users');
            $table->string('mileage');
            $table->string('purchase_type');
            $table->string('vehicle_type');
            $table->text('responses');
            $table->unsignedTinyInteger('total_passed');
            $table->unsignedTinyInteger('total_failed');
            $table->unsignedTinyInteger('total_high_risk');
            $table->unsignedTinyInteger('percentage');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_jackets');
    }
};
