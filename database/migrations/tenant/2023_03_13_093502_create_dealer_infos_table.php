<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dealer_infos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('store_id')->nullable()->constrained('stores')->cascadeOnDelete();

            $table->string('firewall_company')->nullable();
            $table->json('ip_addresses')->nullable();
            $table->boolean('mfa')->nullable();
            $table->boolean('vulnerability')->nullable();
            $table->boolean('currently_monitoring')->nullable();
            $table->string('antivirus_software')->nullable();
            $table->string('antivirus_computers')->nullable();
            $table->string('antivirus_minutes')->nullable();
            $table->string('screensaver_minutes')->nullable();
            $table->string('dms_provider')->nullable();
            $table->json('website_urls')->nullable();
            $table->string('backups')->nullable();
            $table->string('designated_red_flag_coordinator')->nullable();
            $table->boolean('document_shredding')->nullable();
            $table->boolean('service_provider_agreements')->nullable();
            $table->boolean('offsite_storage')->nullable();
            $table->boolean('other_business')->nullable();
            $table->boolean('vendor_access')->nullable();
            $table->boolean('personal_devices')->nullable();
            $table->boolean('compliance_issues')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dealer_infos');
    }
};
