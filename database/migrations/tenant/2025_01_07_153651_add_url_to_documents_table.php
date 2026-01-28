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
        Schema::table('dealer_docs', function (Blueprint $table) {
            $table->string('url')->nullable()->after('title');
            $table->string('file_name')->nullable()->change();
            $table->string('file_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dealer_docs', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
};
