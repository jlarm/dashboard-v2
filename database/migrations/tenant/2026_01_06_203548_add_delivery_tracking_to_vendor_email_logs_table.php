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
        if (! Schema::hasTable('vendor_email_logs')) {
            return;
        }

        Schema::table('vendor_email_logs', function (Blueprint $table): void {
            if (! Schema::hasColumn('vendor_email_logs', 'status')) {
                $table->string('status')->default('sent')->after('sent_at');
            }

            if (! Schema::hasColumn('vendor_email_logs', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('status');
            }

            if (! Schema::hasColumn('vendor_email_logs', 'delivery_message')) {
                $table->text('delivery_message')->nullable()->after('delivered_at');
            }

            if (! Schema::hasColumn('vendor_email_logs', 'event_type')) {
                $table->string('event_type')->nullable()->after('delivery_message');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('vendor_email_logs')) {
            return;
        }

        Schema::table('vendor_email_logs', function (Blueprint $table): void {
            $columnsToDrop = array_values(array_filter([
                Schema::hasColumn('vendor_email_logs', 'status') ? 'status' : null,
                Schema::hasColumn('vendor_email_logs', 'delivered_at') ? 'delivered_at' : null,
                Schema::hasColumn('vendor_email_logs', 'delivery_message') ? 'delivery_message' : null,
                Schema::hasColumn('vendor_email_logs', 'event_type') ? 'event_type' : null,
            ]));

            if ($columnsToDrop !== []) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
