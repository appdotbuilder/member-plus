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
        Schema::create('loyalty_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('points')->default(0);
            $table->string('transaction_type'); // earned, redeemed, expired
            $table->string('description');
            $table->integer('amount'); // positive for earned, negative for redeemed
            $table->string('reference_type')->nullable(); // policy_purchase, claim_processed, etc.
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('transaction_type');
            $table->index(['reference_type', 'reference_id']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_points');
    }
};