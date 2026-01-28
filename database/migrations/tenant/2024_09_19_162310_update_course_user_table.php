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
        Schema::table('course_user', function (Blueprint $table) {
            // Remove the 'pass' column
            $table->dropColumn('pass');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');

            // Drop existing foreign keys
            $table->dropForeign(['course_id']);
            $table->dropForeign(['user_id']);

            // Ensure columns exist before modifying them
            if (! Schema::hasColumn('course_user', 'course_id')) {
                $table->foreignId('course_id')->constrained()->cascadeOnDelete()->change();
            } else {
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            }

            if (! Schema::hasColumn('course_user', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete()->change();
            } else {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_user', function (Blueprint $table) {
            // Add the 'pass' column back
            $table->boolean('pass')->default(0);

            // Drop updated foreign keys
            $table->dropForeign(['course_id']);
            $table->dropForeign(['user_id']);

            // Recreate original foreign keys
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
