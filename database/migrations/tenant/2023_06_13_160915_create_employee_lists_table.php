<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Dealer\Store::class)->constrained();
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
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_lists');
    }
};
