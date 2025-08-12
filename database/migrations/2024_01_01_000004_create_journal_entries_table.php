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
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('journal_number', 20)->unique();
            $table->date('transaction_date');
            $table->date('posting_date')->nullable();
            $table->string('reference_number')->nullable();
            $table->enum('transaction_type', [
                'general', 'revenue', 'expense', 'asset', 'liability', 
                'budget_realization', 'adjustment', 'closing'
            ]);
            $table->string('description');
            $table->decimal('total_debit', 15, 2)->default(0);
            $table->decimal('total_credit', 15, 2)->default(0);
            $table->enum('status', ['draft', 'posted', 'approved', 'cancelled'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('posted_by')->nullable()->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['transaction_date', 'status']);
            $table->index(['transaction_type', 'status']);
            $table->index('journal_number');
            $table->index('reference_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};