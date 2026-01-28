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
        Schema::table('stores', function (Blueprint $table) {
            $table->string('fi_username')->after('user_submitted')->nullable();
            $table->string('fi_password')->after('fi_username')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            if (Schema::hasColumn('stores', 'fi_username')) {
                $table->dropColumn('fi_username');
            }
            if (Schema::hasColumn('stores', 'fi_password')) {
                $table->dropColumn('fi_password');
            }
        });
    }
};
