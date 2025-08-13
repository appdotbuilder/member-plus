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
        Schema::create('dental_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('appointment_number')->unique();
            $table->string('service_type'); // cleaning, checkup, treatment, emergency
            $table->text('notes')->nullable();
            $table->datetime('appointment_datetime');
            $table->integer('duration_minutes')->default(60);
            $table->string('dentist_name')->nullable();
            $table->string('clinic_name');
            $table->text('clinic_address');
            $table->string('clinic_phone');
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->decimal('estimated_cost', 8, 2)->nullable();
            $table->text('preparation_instructions')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('appointment_number');
            $table->index('appointment_datetime');
            $table->index('status');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dental_appointments');
    }
};