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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('budget_code', 20)->unique();
            $table->string('budget_name');
            $table->foreignId('financial_period_id')->constrained()->onDelete('cascade');
            $table->enum('budget_type', ['revenue', 'expense']);
            $table->enum('budget_category', [
                'apbd_revenue', 'blud_revenue', 'other_revenue',
                'personnel_expense', 'goods_services', 'capital_expense'
            ]);
            $table->decimal('planned_amount', 15, 2)->default(0);
            $table->decimal('revised_amount', 15, 2)->default(0);
            $table->decimal('realized_amount', 15, 2)->default(0);
            $table->decimal('remaining_amount', 15, 2)->default(0);
            $table->enum('status', ['draft', 'approved', 'active', 'closed'])->default('draft');
            $table->date('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index(['financial_period_id', 'budget_type']);
            $table->index(['budget_category', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};