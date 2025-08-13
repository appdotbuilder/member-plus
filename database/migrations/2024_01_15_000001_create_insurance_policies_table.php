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
        Schema::create('insurance_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('policy_number')->unique();
            $table->string('type'); // car, health, home, dental, etc.
            $table->string('name');
            $table->text('description');
            $table->decimal('premium_amount', 10, 2);
            $table->decimal('coverage_amount', 12, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'expired', 'cancelled', 'pending'])->default('pending');
            $table->json('details')->nullable(); // Store additional policy-specific details
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('policy_number');
            $table->index('type');
            $table->index('status');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_policies');
    }
};