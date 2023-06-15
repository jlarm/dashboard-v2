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
            $table->date('deal_jacket_date')->nullable()->after('audit_date');
            $table->foreignIdFor(\App\Models\User::class, 'manager_id')->nullable()->after('deal_jacket_date');
            $table->integer('mileage')->nullable()->after('manager_id');
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
            //
        });
    }
};
