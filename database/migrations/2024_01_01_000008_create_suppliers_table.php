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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code', 20)->unique();
            $table->string('supplier_name');
            $table->string('tax_number', 20)->nullable(); // NPWP
            $table->text('address');
            $table->string('city');
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->enum('supplier_type', ['goods', 'services', 'both'])->default('both');
            $table->enum('payment_terms', ['cash', 'credit_7', 'credit_14', 'credit_30', 'credit_60', 'credit_90']);
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('supplier_code');
            $table->index('supplier_name');
            $table->index('tax_number');
            $table->index(['supplier_type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};