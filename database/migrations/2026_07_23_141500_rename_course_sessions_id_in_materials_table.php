<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            if (! Schema::hasColumn('materials', 'course_session_id') && Schema::hasColumn('materials', 'course_sessions_id')) {
                DB::statement('ALTER TABLE materials RENAME COLUMN course_sessions_id TO course_session_id');
            }

            return;
        }

        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign('materials_course_sessions_id_foreign');
            $table->renameColumn('course_sessions_id', 'course_session_id');
            $table->foreign('course_session_id')->references('id')->on('course_sessions')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            if (! Schema::hasColumn('materials', 'course_sessions_id') && Schema::hasColumn('materials', 'course_session_id')) {
                DB::statement('ALTER TABLE materials RENAME COLUMN course_session_id TO course_sessions_id');
            }

            return;
        }

        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign(['course_session_id']);
            $table->renameColumn('course_session_id', 'course_sessions_id');
            $table->foreign('course_sessions_id')->references('id')->on('course_sessions')->cascadeOnDelete();
        });
    }
};