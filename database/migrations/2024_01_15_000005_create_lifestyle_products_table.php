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
        Schema::create('lifestyle_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // car_insurance, dental_care, health, wellness
            $table->text('description');
            $table->text('features'); // JSON or serialized array of features
            $table->decimal('price', 10, 2);
            $table->decimal('member_price', 10, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('eligibility_criteria')->nullable(); // Membership tier requirements, etc.
            $table->integer('points_reward')->default(0); // Points earned when purchased
            $table->timestamps();
            
            // Indexes for performance
            $table->index('category');
            $table->index('is_active');
            $table->index(['category', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lifestyle_products');
    }
};