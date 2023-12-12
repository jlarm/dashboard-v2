<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('fi_username')->after('user_submitted')->nullable();
            $table->string('fi_password')->after('fi_username')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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
