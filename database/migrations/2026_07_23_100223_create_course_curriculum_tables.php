<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Table Sessions / Pertemuan
        Schema::create('course_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('order')->default(1); // Urutan Pertemuan (1, 2, 3...)
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['course_id', 'order']);
        });

        // 2. Table Materials / Materi Belajar
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_sessions_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('content_type', ['VIDEO', 'PDF', 'TEXT', 'AUDIO']); 
            $table->text('content_url')->nullable(); // URL CDN / Path File lokal
            $table->text('body_text')->nullable();   // Teks ringkas (Ramah Low-Bandwidth)
            $table->boolean('is_required')->default(true);
            $table->unsignedInteger('order')->default(1);
            $table->timestamps();

            $table->index(['course_sessions_id', 'order']);
        });

        // 3. Table Assignments / Tugas & Evaluasi
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_sessions_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->dateTime('due_date')->nullable();
            $table->unsignedSmallInteger('max_score')->default(100);
            $table->boolean('allow_offline_submission')->default(true); // Opsi setor langsung ke Fasilitator
            $table->timestamps();

            $table->index('course_sessions_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('course_sessions');
    }
};