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
            $table->longText('fi_products_sold')->nullable()->after('compliance_issues');
            $table->json('service_contracts')->nullable()->after('fi_products_sold');
            $table->json('tire_wheel')->nullable()->after('service_contracts');
            $table->json('other_fi')->nullable()->after('tire_wheel');
            $table->text('fi_system')->nullable()->after('other_fi');
            $table->text('appearance_protection_sold')->nullable()->after('fi_system');
            $table->boolean('reinsurance')->nullable()->after('appearance_protection_sold');
            $table->text('admin_name')->nullable()->after('reinsurance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'fi_products_sold',
                'service_contracts',
                'tire_wheel',
                'other_fi',
                'fi_system',
                'appearance_protection_sold',
                'reinsurance',
                'admin_name',
            ]);
        });
    }
};
