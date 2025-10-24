<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('royalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('franchise_id')->constrained()->onDelete('cascade');
            $table->string('period'); // e.g., "2024-01", "Q1-2024"
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('gross_sales', 15, 2);
            $table->decimal('royalty_percentage', 5, 2);
            $table->decimal('royalty_amount', 15, 2);
            $table->enum('status', ['pending', 'calculated', 'invoiced', 'paid', 'overdue'])->default('pending');
            $table->date('due_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('profit_sharing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('franchise_id')->constrained()->onDelete('cascade');
            $table->string('period');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('total_revenue', 15, 2);
            $table->decimal('total_expenses', 15, 2);
            $table->decimal('net_profit', 15, 2);
            $table->decimal('franchisor_share_percentage', 5, 2);
            $table->decimal('franchisor_share_amount', 15, 2);
            $table->decimal('franchisee_share_percentage', 5, 2);
            $table->decimal('franchisee_share_amount', 15, 2);
            $table->enum('status', ['pending', 'calculated', 'approved', 'distributed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profit_sharing');
        Schema::dropIfExists('royalties');
    }
};
