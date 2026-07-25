<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name');
            $table->enum('type', ['CSR_CORPORATE', 'INTERNATIONAL_NGO', 'GOVERNMENT', 'INDIVIDUAL']);
            $table->string('contact_person_name');
            $table->string('contact_email')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
