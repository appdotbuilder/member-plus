<?php

namespace Database\Factories;

use App\Models\InsurancePolicy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InsurancePolicy>
 */
class InsurancePolicyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\InsurancePolicy>
     */
    protected $model = InsurancePolicy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['car', 'health', 'home', 'dental', 'life', 'travel'];
        $type = $this->faker->randomElement($types);
        
        $policyNames = [
            'car' => ['Premium Auto Protection', 'Comprehensive Car Insurance', 'Third Party Plus', 'Full Coverage Auto'],
            'health' => ['Complete Health Cover', 'Family Health Plus', 'Individual Health Plan', 'Premium Medical'],
            'home' => ['Home & Contents', 'Property Protection Plus', 'Comprehensive Home Cover', 'Building Insurance'],
            'dental' => ['Dental Wellness Plan', 'Complete Dental Cover', 'Family Dental Care', 'Preventive Dental'],
            'life' => ['Term Life Insurance', 'Whole Life Protection', 'Family Life Cover', 'Income Protection'],
            'travel' => ['International Travel', 'Domestic Travel Cover', 'Adventure Travel Plus', 'Business Travel'],
        ];

        $startDate = $this->faker->dateTimeBetween('-2 years', '-6 months');
        $endDate = (clone $startDate)->modify('+1 year');

        return [
            'user_id' => User::factory(),
            'policy_number' => 'POL-' . $this->faker->year . '-' . $this->faker->unique()->numberBetween(100000, 999999),
            'type' => $type,
            'name' => $this->faker->randomElement($policyNames[$type]),
            'description' => $this->faker->paragraph(2),
            'premium_amount' => $this->faker->randomFloat(2, 200, 2000),
            'coverage_amount' => $this->faker->randomFloat(2, 10000, 500000),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(['active', 'pending', 'expired']),
            'details' => [
                'deductible' => $this->faker->randomFloat(2, 500, 5000),
                'provider_network' => $this->faker->company,
                'policy_terms' => $this->faker->paragraph,
            ],
        ];
    }

    /**
     * Indicate that the policy is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'start_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
        ]);
    }
}