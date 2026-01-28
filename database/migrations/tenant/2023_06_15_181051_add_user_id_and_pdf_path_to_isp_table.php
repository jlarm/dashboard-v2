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
        Schema::table('isps', function (Blueprint $table) {
            $table->foreignIdFor(App\Models\User::class)->nullable()->after('id');
            $table->string('pdf_path')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('isps', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('pdf_path');
        });
    }
};
