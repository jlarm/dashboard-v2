<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sds', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('product_identifier')->nullable();
            $table->json('product_identification_numbers')->nullable();
            $table->string('manufacturer')->nullable();
            $table->json('cas_nos')->nullable();
            $table->string('common_name')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sds');
    }
};
