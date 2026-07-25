<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER']);
            $table->date('birth_date')->nullable();

            // Lokasi Geografis
            $table->string('province_id', 10);
            $table->string('regency_id', 10);
            $table->string('district_id', 10);
            $table->text('address_detail')->nullable();

            // Indikator Sosio-Ekonomi & Kelompok Rentan
            $table->enum('economic_status', ['LOW_INCOME', 'MIDDLE_BELOW', 'MIDDLE_ABOVE']);
            $table->string('primary_occupation')->nullable();
            $table->boolean('is_disabled')->default(false);
            $table->string('disability_type')->nullable();

            $table->timestamps();

            $table->index(['province_id', 'regency_id', 'economic_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
