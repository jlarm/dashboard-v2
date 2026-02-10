<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dealer_docs', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->foreignIdFor(Store::class)->constrained();
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dealer_docs');
    }
};
