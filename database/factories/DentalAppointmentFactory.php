<?php

namespace Database\Factories;

use App\Models\DentalAppointment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DentalAppointment>
 */
class DentalAppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\DentalAppointment>
     */
    protected $model = DentalAppointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $appointmentDate = $this->faker->dateTimeBetween('now', '+3 months');
        
        return [
            'user_id' => User::factory(),
            'appointment_number' => 'DENT-' . $appointmentDate->format('Ymd') . '-' . str_pad((string)$this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'service_type' => $this->faker->randomElement(['cleaning', 'checkup', 'treatment', 'emergency']),
            'notes' => $this->faker->optional(0.7)->paragraph,
            'appointment_datetime' => $appointmentDate,
            'duration_minutes' => $this->faker->randomElement([30, 45, 60, 90, 120]),
            'dentist_name' => $this->faker->optional(0.8)->name,
            'clinic_name' => $this->faker->company . ' Dental',
            'clinic_address' => $this->faker->address,
            'clinic_phone' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(['scheduled', 'confirmed', 'completed', 'cancelled']),
            'estimated_cost' => $this->faker->optional(0.6)->randomFloat(2, 50, 500),
            'preparation_instructions' => $this->faker->optional(0.3)->paragraph,
        ];
    }

    /**
     * Indicate that the appointment is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'appointment_datetime' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['scheduled', 'confirmed']),
        ]);
    }
}