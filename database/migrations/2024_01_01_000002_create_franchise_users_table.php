<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('franchise_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('franchise_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['owner', 'manager', 'staff'])->default('staff');
            $table->date('joined_date');
            $table->timestamps();
            
            $table->unique(['franchise_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('franchise_users');
    }
};
