<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_number', 20)->unique();
            $table->string('nik', 16)->nullable(); // NIK Indonesia
            $table->string('bpjs_number', 20)->nullable();
            $table->string('name');
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->text('address');
            $table->string('phone', 20)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            $table->enum('insurance_type', ['bpjs', 'private', 'corporate', 'cash'])->default('cash');
            $table->string('insurance_number')->nullable();
            $table->string('insurance_class')->nullable(); // For BPJS classes 1, 2, 3
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('patient_number');
            $table->index('nik');
            $table->index('bpjs_number');
            $table->index(['name', 'birth_date']);
            $table->index('insurance_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};