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
        Schema::create('insurance_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('insurance_policy_id')->constrained()->onDelete('cascade');
            $table->string('claim_number')->unique();
            $table->string('title');
            $table->text('description');
            $table->decimal('claimed_amount', 10, 2);
            $table->decimal('approved_amount', 10, 2)->nullable();
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected', 'paid'])->default('pending');
            $table->date('incident_date');
            $table->json('documents')->nullable(); // Store uploaded document paths
            $table->text('admin_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('insurance_policy_id');
            $table->index('claim_number');
            $table->index('status');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_claims');
    }
};