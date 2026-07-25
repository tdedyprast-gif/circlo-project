<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table Courses
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grant_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_low_bandwidth_optimized')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Table Cohorts (Kelompok Pendampingan)
        Schema::create('cohorts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('facilitator_id')->constrained('users');
            $table->string('cohort_name');
            $table->integer('max_capacity')->default(30);
            $table->timestamps();
        });

        // Table Enrollments
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cohort_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['ENROLLED', 'IN_PROGRESS', 'COMPLETED', 'DROPPED'])->default('ENROLLED');
            $table->timestamp('enrolled_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
            $table->index(['status', 'cohort_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('cohorts');
        Schema::dropIfExists('courses');
    }
};
