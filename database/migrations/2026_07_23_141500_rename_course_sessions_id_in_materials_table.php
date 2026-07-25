<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            // Hapus foreign key lama terlebih dahulu
            $table->dropForeign('materials_course_sessions_id_foreign');

            // Ubah nama kolom dari course_sessions_id menjadi course_session_id
            $table->renameColumn('course_sessions_id', 'course_session_id');

            // Pasang kembali foreign key dengan nama yang baru
            $table->foreign('course_session_id')->references('id')->on('course_sessions')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign(['course_session_id']);
            $table->renameColumn('course_session_id', 'course_sessions_id');
            $table->foreign('course_sessions_id')->references('id')->on('course_sessions')->cascadeOnDelete();
        });
    }
};