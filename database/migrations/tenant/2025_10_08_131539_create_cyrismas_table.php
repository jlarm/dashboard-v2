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
        Schema::create('cyrismas', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Store::class)->constrained()->cascadeOnDelete();
            $table->string('short_name');
            $table->text('instance_id');
            $table->text('instance_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cyrismas');
    }
};
