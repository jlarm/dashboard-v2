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
        if (! Schema::hasTable('vendor_forms') || Schema::hasColumn('vendor_forms', 'document_path')) {
            return;
        }

        Schema::table('vendor_forms', function (Blueprint $table): void {
            $table->string('document_path')->nullable()->after('data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('vendor_forms') || ! Schema::hasColumn('vendor_forms', 'document_path')) {
            return;
        }

        Schema::table('vendor_forms', function (Blueprint $table): void {
            $table->dropColumn('document_path');
        });
    }
};
