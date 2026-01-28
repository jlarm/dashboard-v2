<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('body_shop_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Store::class)->nullable();

            $table->boolean('draft')->default(true);

            $table->date('audit_date')->nullable();

            $table->string('pdf_path')->nullable();

            $table->tinyInteger('body_shop_q1_answer')->nullable();
            $table->mediumText('body_shop_q1_comment')->nullable();
            $table->boolean('body_shop_q1_danger')->default(false);
            $table->tinyInteger('body_shop_q2_answer')->nullable();
            $table->mediumText('body_shop_q2_comment')->nullable();
            $table->boolean('body_shop_q2_danger')->default(false);
            $table->tinyInteger('body_shop_q3_answer')->nullable();
            $table->mediumText('body_shop_q3_comment')->nullable();
            $table->boolean('body_shop_q3_danger')->default(false);
            $table->tinyInteger('body_shop_q4_answer')->nullable();
            $table->mediumText('body_shop_q4_comment')->nullable();
            $table->boolean('body_shop_q4_danger')->default(false);
            $table->tinyInteger('body_shop_q5_answer')->nullable();
            $table->mediumText('body_shop_q5_comment')->nullable();
            $table->boolean('body_shop_q5_danger')->default(false);
            $table->tinyInteger('body_shop_q6_answer')->nullable();
            $table->mediumText('body_shop_q6_comment')->nullable();
            $table->boolean('body_shop_q6_danger')->default(false);
            $table->tinyInteger('body_shop_q7_answer')->nullable();
            $table->mediumText('body_shop_q7_comment')->nullable();
            $table->boolean('body_shop_q7_danger')->default(false);
            $table->tinyInteger('body_shop_q8_answer')->nullable();
            $table->mediumText('body_shop_q8_comment')->nullable();
            $table->boolean('body_shop_q8_danger')->default(false);
            $table->tinyInteger('body_shop_q9_answer')->nullable();
            $table->mediumText('body_shop_q9_comment')->nullable();
            $table->boolean('body_shop_q9_danger')->default(false);
            $table->tinyInteger('body_shop_q10_answer')->nullable();
            $table->mediumText('body_shop_q10_comment')->nullable();
            $table->boolean('body_shop_q10_danger')->default(false);
            $table->tinyInteger('body_shop_q11_answer')->nullable();
            $table->mediumText('body_shop_q11_comment')->nullable();
            $table->boolean('body_shop_q11_danger')->default(false);
            $table->tinyInteger('body_shop_q12_answer')->nullable();
            $table->mediumText('body_shop_q12_comment')->nullable();
            $table->boolean('body_shop_q12_danger')->default(false);
            $table->tinyInteger('body_shop_q13_answer')->nullable();
            $table->mediumText('body_shop_q13_comment')->nullable();
            $table->boolean('body_shop_q13_danger')->default(false);
            $table->tinyInteger('body_shop_q14_answer')->nullable();
            $table->mediumText('body_shop_q14_comment')->nullable();
            $table->boolean('body_shop_q14_danger')->default(false);
            $table->tinyInteger('body_shop_q15_answer')->nullable();
            $table->mediumText('body_shop_q15_comment')->nullable();
            $table->boolean('body_shop_q15_danger')->default(false);
            $table->tinyInteger('body_shop_q16_answer')->nullable();
            $table->date('body_shop_q16_inspection_date')->nullable();
            $table->mediumText('body_shop_q16_comment')->nullable();
            $table->boolean('body_shop_q16_danger')->default(false);
            $table->tinyInteger('body_shop_q17_answer')->nullable();
            $table->mediumText('body_shop_q17_comment')->nullable();
            $table->boolean('body_shop_q17_danger')->default(false);
            $table->tinyInteger('body_shop_q18_answer')->nullable();
            $table->mediumText('body_shop_q18_comment')->nullable();
            $table->boolean('body_shop_q18_danger')->default(false);
            $table->tinyInteger('body_shop_q19_answer')->nullable();
            $table->mediumText('body_shop_q19_comment')->nullable();
            $table->boolean('body_shop_q19_danger')->default(false);
            $table->tinyInteger('body_shop_q20_answer')->nullable();
            $table->mediumText('body_shop_q20_comment')->nullable();
            $table->boolean('body_shop_q20_danger')->default(false);
            $table->tinyInteger('body_shop_q21_answer')->nullable();
            $table->mediumText('body_shop_q21_comment')->nullable();
            $table->boolean('body_shop_q21_danger')->default(false);
            $table->tinyInteger('body_shop_q22_answer')->nullable();
            $table->mediumText('body_shop_q22_comment')->nullable();
            $table->boolean('body_shop_q22_danger')->default(false);
            $table->tinyInteger('body_shop_q23_answer')->nullable();
            $table->mediumText('body_shop_q23_comment')->nullable();
            $table->boolean('body_shop_q23_danger')->default(false);
            $table->tinyInteger('body_shop_q24_answer')->nullable();
            $table->mediumText('body_shop_q24_comment')->nullable();
            $table->boolean('body_shop_q24_danger')->default(false);
            $table->tinyInteger('body_shop_q25_answer')->nullable();
            $table->mediumText('body_shop_q25_comment')->nullable();
            $table->boolean('body_shop_q25_danger')->default(false);
            $table->tinyInteger('body_shop_q26_answer')->nullable();
            $table->mediumText('body_shop_q26_comment')->nullable();
            $table->boolean('body_shop_q26_danger')->default(false);
            $table->tinyInteger('body_shop_q27_answer')->nullable();
            $table->mediumText('body_shop_q27_comment')->nullable();
            $table->boolean('body_shop_q27_danger')->default(false);
            $table->tinyInteger('body_shop_q28_answer')->nullable();
            $table->mediumText('body_shop_q28_comment')->nullable();
            $table->boolean('body_shop_q28_danger')->default(false);
            $table->tinyInteger('body_shop_q29_answer')->nullable();
            $table->mediumText('body_shop_q29_comment')->nullable();
            $table->boolean('body_shop_q29_danger')->default(false);
            $table->tinyInteger('body_shop_q30_answer')->nullable();
            $table->mediumText('body_shop_q30_comment')->nullable();
            $table->boolean('body_shop_q30_danger')->default(false);
            $table->tinyInteger('body_shop_q31_answer')->nullable();
            $table->mediumText('body_shop_q31_comment')->nullable();
            $table->boolean('body_shop_q31_danger')->default(false);
            $table->tinyInteger('body_shop_q32_answer')->nullable();
            $table->mediumText('body_shop_q32_comment')->nullable();
            $table->boolean('body_shop_q32_danger')->default(false);
            $table->tinyInteger('body_shop_q33_answer')->nullable();
            $table->mediumText('body_shop_q33_comment')->nullable();
            $table->boolean('body_shop_q33_danger')->default(false);
            $table->tinyInteger('body_shop_q34_answer')->nullable();
            $table->mediumText('body_shop_q34_comment')->nullable();
            $table->boolean('body_shop_q34_danger')->default(false);
            $table->tinyInteger('body_shop_q35_answer')->nullable();
            $table->mediumText('body_shop_q35_comment')->nullable();
            $table->boolean('body_shop_q35_danger')->default(false);
            $table->tinyInteger('body_shop_q36_answer')->nullable();
            $table->mediumText('body_shop_q36_comment')->nullable();
            $table->boolean('body_shop_q36_danger')->default(false);
            $table->tinyInteger('body_shop_q37_answer')->nullable();
            $table->mediumText('body_shop_q37_comment')->nullable();
            $table->boolean('body_shop_q37_danger')->default(false);
            $table->tinyInteger('body_shop_q38_answer')->nullable();
            $table->mediumText('body_shop_q38_comment')->nullable();
            $table->boolean('body_shop_q38_danger')->default(false);
            $table->tinyInteger('body_shop_q39_answer')->nullable();
            $table->mediumText('body_shop_q39_comment')->nullable();
            $table->boolean('body_shop_q39_danger')->default(false);
            $table->tinyInteger('body_shop_q40_answer')->nullable();
            $table->mediumText('body_shop_q40_comment')->nullable();
            $table->boolean('body_shop_q40_danger')->default(false);
            $table->tinyInteger('body_shop_q41_answer')->nullable();
            $table->mediumText('body_shop_q41_comment')->nullable();
            $table->boolean('body_shop_q41_danger')->default(false);
            $table->tinyInteger('body_shop_q42_answer')->nullable();
            $table->mediumText('body_shop_q42_comment')->nullable();
            $table->boolean('body_shop_q42_danger')->default(false);
            $table->tinyInteger('body_shop_q43_answer')->nullable();
            $table->mediumText('body_shop_q43_comment')->nullable();
            $table->boolean('body_shop_q43_danger')->default(false);
            $table->tinyInteger('body_shop_q44_answer')->nullable();
            $table->mediumText('body_shop_q44_comment')->nullable();
            $table->boolean('body_shop_q44_danger')->default(false);
            $table->tinyInteger('body_shop_q45_answer')->nullable();
            $table->mediumText('body_shop_q45_comment')->nullable();
            $table->boolean('body_shop_q45_danger')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('body_shop_audits');
    }
};
