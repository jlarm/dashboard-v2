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
        Schema::create('dealership_roles', function (Blueprint $table) {
            $table->id();

            //            $table->string('tenant_id');
            //            $table->string('global_role_id');
            //
            //            $table->unique(['tenant_id', 'global_role_id']);
            //
            //            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
            //            $table->foreign('global_role_id')->references('global_id')->on('roles')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealership_roles');
    }
};
