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
        Schema::table('individual_audits', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('individual_audits', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
};
