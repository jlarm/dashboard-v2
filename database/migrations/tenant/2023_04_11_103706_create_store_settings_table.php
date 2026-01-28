<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(App\Models\Dealer\Store::class)->nullable();

            $table->string('name');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();

            $table->string('police_emergency_phone')->nullable();
            $table->string('police_non_emergency_phone')->nullable();
            $table->string('fire_emergency_phone')->nullable();
            $table->string('fire_non_emergency_phone')->nullable();
            $table->string('fire_alarm_type')->nullable();
            $table->string('burglar_alarm_type')->nullable();

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
        Schema::dropIfExists('store_settings');
    }
};
