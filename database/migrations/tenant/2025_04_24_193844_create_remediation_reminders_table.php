<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('remediation_reminders', function (Blueprint $table) {
            $table->id();
            $table->morphs('remindable');
            $table->date('send_date');
            $table->unsignedInteger('store_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('remediation_reminders');
    }
};
