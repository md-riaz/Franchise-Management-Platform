<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compliance_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('category'); // e.g., "legal", "operational", "safety", "quality"
            $table->enum('frequency', ['once', 'monthly', 'quarterly', 'annually'])->default('once');
            $table->boolean('is_mandatory')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('compliance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('franchise_id')->constrained()->onDelete('cascade');
            $table->foreignId('compliance_requirement_id')->constrained()->onDelete('cascade');
            $table->date('due_date');
            $table->date('completion_date')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'overdue', 'non_compliant'])->default('pending');
            $table->foreignId('completed_by')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compliance_records');
        Schema::dropIfExists('compliance_requirements');
    }
};
