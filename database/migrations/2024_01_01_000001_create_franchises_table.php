<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('franchises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('location');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country')->default('USA');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('franchisor_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['active', 'pending', 'suspended', 'closed'])->default('pending');
            $table->date('opening_date')->nullable();
            $table->decimal('initial_investment', 15, 2)->nullable();
            $table->decimal('franchise_fee', 15, 2)->nullable();
            $table->decimal('royalty_percentage', 5, 2)->default(5.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('franchises');
    }
};
