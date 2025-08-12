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
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code', 20)->unique();
            $table->string('asset_name');
            $table->enum('asset_category', [
                'building', 'equipment', 'vehicle', 'furniture', 'computer', 'other'
            ]);
            $table->date('acquisition_date');
            $table->decimal('acquisition_cost', 15, 2);
            $table->decimal('accumulated_depreciation', 15, 2)->default(0);
            $table->decimal('book_value', 15, 2)->default(0);
            $table->integer('useful_life_years');
            $table->integer('remaining_life_months')->nullable();
            $table->enum('depreciation_method', ['straight_line', 'declining_balance', 'sum_of_years']);
            $table->decimal('annual_depreciation', 15, 2)->default(0);
            $table->decimal('monthly_depreciation', 15, 2)->default(0);
            $table->string('location')->nullable();
            $table->string('responsible_person')->nullable();
            $table->enum('condition', ['excellent', 'good', 'fair', 'poor', 'damaged'])->default('good');
            $table->enum('status', ['active', 'disposed', 'sold', 'donated', 'stolen', 'damaged'])->default('active');
            $table->date('disposal_date')->nullable();
            $table->decimal('disposal_value', 15, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('asset_code');
            $table->index(['asset_category', 'status']);
            $table->index(['acquisition_date', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_assets');
    }
};