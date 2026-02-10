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
        Schema::table('vendor_email_logs', function (Blueprint $table): void {
            $table->string('status')->default('sent')->after('sent_at');
            $table->timestamp('delivered_at')->nullable()->after('status');
            $table->text('delivery_message')->nullable()->after('delivered_at');
            $table->string('event_type')->nullable()->after('delivery_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_email_logs', function (Blueprint $table): void {
            $table->dropColumn(['status', 'delivered_at', 'delivery_message', 'event_type']);
        });
    }
};
