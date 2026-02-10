<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Dealer\Store;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scan_reports', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Store::class);
            $table->string('path');
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scan_reports');
    }
};
