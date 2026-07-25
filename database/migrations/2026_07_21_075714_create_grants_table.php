<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained()->cascadeOnDelete();
            $table->string('grant_name');
            $table->string('code')->unique(); // e.g. GRANT-2026-UMKM
            $table->decimal('total_funding_amount', 15, 2);
            $table->decimal('cost_per_beneficiary_target', 10, 2)->default(0);
            $table->integer('target_beneficiaries_count');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['DRAFT', 'ACTIVE', 'COMPLETED', 'AUDITED'])->default('DRAFT');
            $table->timestamps();

            $table->index(['status', 'start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grants');
    }
};
