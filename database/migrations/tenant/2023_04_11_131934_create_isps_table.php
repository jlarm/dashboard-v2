<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('isps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Dealer\Store::class)->nullable();

            $table->integer('logged_in_user')->nullable();
            $table->string('qualified_individual_name')->nullable();
            $table->string('qualified_individual_phone')->nullable();
            $table->string('service_manager_name')->nullable();
            $table->string('service_manager_phone')->nullable();
            $table->string('parts_manager_name')->nullable();
            $table->string('parts_manager_phone')->nullable();
            $table->string('body_shop_manager_name')->nullable();
            $table->string('body_shop_manager_phone')->nullable();
            $table->string('general_manager_name')->nullable();
            $table->string('general_manager_phone')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('police_emergency_phone')->nullable();
            $table->string('police_non_emergency_phone')->nullable();
            $table->string('fire_emergency_phone')->nullable();
            $table->string('fire_non_emergency_phone')->nullable();
            $table->string('fire_alarm_type')->nullable();
            $table->string('burglar_alarm_type')->nullable();
            $table->string('signature')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('isps');
    }
};
