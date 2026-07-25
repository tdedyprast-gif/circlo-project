<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Table Material Progress (Jejak Baca/Tonton)
        Schema::create('material_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Memastikan 1 peserta hanya memiliki 1 record progress per materi
            $table->unique(['enrollment_id', 'material_id']);
        });

        // 2. Table Assignment Submissions (Pengumpulan & Penilaian Tugas)
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            
            // Pengumpulan & Bukti
            $table->text('file_path')->nullable(); 
            $table->text('notes')->nullable(); // Catatan jawaban peserta
            $table->timestamp('submitted_at')->nullable();

            // Penilaian oleh Fasilitator / Instrukur
            $table->unsignedSmallInteger('grade')->nullable();
            $table->text('feedback')->nullable();
            $table->foreignId('graded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('graded_at')->nullable();
            
            $table->timestamps();

            $table->unique(['enrollment_id', 'assignment_id']);
            $table->index(['enrollment_id', 'grade']);
        });

        // 3. Table Session Completions (Rekap Progres Pertemuan)
        Schema::create('session_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_sessions_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['IN_PROGRESS', 'COMPLETED'])->default('IN_PROGRESS');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['enrollment_id', 'course_sessions_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_completions');
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('material_progress');
    }
};