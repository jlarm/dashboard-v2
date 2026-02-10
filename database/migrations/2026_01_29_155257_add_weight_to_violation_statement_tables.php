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
        Schema::table('osha_violation_statements', function (Blueprint $table): void {
            $table->unsignedTinyInteger('weight')->default(1)->after('keywords');
        });

        Schema::table('body_shop_violation_statements', function (Blueprint $table): void {
            $table->unsignedTinyInteger('weight')->default(1)->after('keywords');
        });

        Schema::table('glba_violation_statements', function (Blueprint $table): void {
            $table->unsignedTinyInteger('weight')->default(1)->after('keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('osha_violation_statements', function (Blueprint $table): void {
            $table->dropColumn('weight');
        });

        Schema::table('body_shop_violation_statements', function (Blueprint $table): void {
            $table->dropColumn('weight');
        });

        Schema::table('glba_violation_statements', function (Blueprint $table): void {
            $table->dropColumn('weight');
        });
    }
};
