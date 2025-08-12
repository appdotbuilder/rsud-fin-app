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
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_code', 20)->unique();
            $table->string('account_name');
            $table->enum('account_type', ['asset', 'liability', 'equity', 'revenue', 'expense']);
            $table->enum('account_category', [
                'current_asset', 'fixed_asset', 'current_liability', 'long_term_liability',
                'equity', 'operating_revenue', 'non_operating_revenue', 'operating_expense', 
                'non_operating_expense', 'depreciation'
            ])->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('level')->default(1);
            $table->string('path')->nullable(); // For hierarchical queries
            $table->enum('normal_balance', ['debit', 'credit']);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_header')->default(false); // Header accounts cannot have transactions
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->foreign('parent_id')->references('id')->on('chart_of_accounts')->onDelete('cascade');
            $table->index(['account_type', 'is_active']);
            $table->index(['parent_id', 'level']);
            $table->index('path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};