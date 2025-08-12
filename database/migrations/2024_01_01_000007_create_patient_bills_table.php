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
        Schema::create('patient_bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number', 20)->unique();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->date('service_date');
            $table->date('bill_date');
            $table->date('due_date');
            $table->enum('service_type', [
                'outpatient', 'inpatient', 'emergency', 'surgery', 
                'laboratory', 'radiology', 'pharmacy', 'other'
            ]);
            $table->decimal('gross_amount', 15, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('insurance_coverage', 15, 2)->default(0);
            $table->decimal('patient_responsibility', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('outstanding_amount', 15, 2)->default(0);
            $table->enum('payment_status', ['unpaid', 'partial', 'paid', 'overdue', 'cancelled'])->default('unpaid');
            $table->enum('insurance_claim_status', ['pending', 'submitted', 'approved', 'rejected', 'paid'])->nullable();
            $table->string('insurance_claim_number')->nullable();
            $table->date('insurance_claim_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['patient_id', 'service_date']);
            $table->index(['bill_date', 'payment_status']);
            $table->index(['due_date', 'payment_status']);
            $table->index('service_type');
            $table->index('insurance_claim_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_bills');
    }
};