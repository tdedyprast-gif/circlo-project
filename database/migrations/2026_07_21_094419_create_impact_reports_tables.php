<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Indikator Dampak Program Donatur
        Schema::create('impact_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grant_id')->constrained()->cascadeOnDelete();
            $table->string('metric_name'); // ex: "Peningkatan Pendapatan Bulanan"
            $table->enum('metric_type', ['PERCENTAGE', 'CURRENCY', 'NUMERIC', 'BOOLEAN']);
            $table->decimal('target_value', 12, 2);
            $table->timestamps();
        });

        // Log Dampak per Peserta (Pre/Post Baseline)
        Schema::create('impact_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('impact_indicator_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('verified_by_facilitator_id')->nullable()->constrained('users');

            $table->decimal('pre_program_value', 12, 2)->default(0);  // Baseline
            $table->decimal('post_program_value', 12, 2)->default(0); // Outcome

            $table->text('evidence_file_path')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index(['impact_indicator_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impact_logs');
        Schema::dropIfExists('impact_indicators');
    }
};
