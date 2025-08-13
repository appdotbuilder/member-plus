<?php

namespace Database\Factories;

use App\Models\InsuranceClaim;
use App\Models\User;
use App\Models\InsurancePolicy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InsuranceClaim>
 */
class InsuranceClaimFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\InsuranceClaim>
     */
    protected $model = InsuranceClaim::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $claimDate = $this->faker->dateTimeBetween('-6 months', 'now');
        $incidentDate = $this->faker->dateTimeBetween('-1 year', $claimDate);
        
        $claimTitles = [
            'Vehicle collision damage',
            'Windshield replacement',
            'Theft of personal items',
            'Water damage to property',
            'Medical expenses claim',
            'Fire damage restoration',
            'Storm damage repair',
            'Burglary claim',
            'Accidental damage',
            'Emergency medical treatment'
        ];

        $claimedAmount = $this->faker->randomFloat(2, 100, 10000);
        $approvedAmount = $this->faker->optional(0.7)->randomFloat(2, $claimedAmount * 0.5, $claimedAmount);

        return [
            'user_id' => User::factory(),
            'insurance_policy_id' => InsurancePolicy::factory(),
            'claim_number' => 'CLM-' . $claimDate->format('Ymd') . '-' . str_pad((string)$this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'title' => $this->faker->randomElement($claimTitles),
            'description' => $this->faker->paragraphs(2, true),
            'claimed_amount' => $claimedAmount,
            'approved_amount' => $approvedAmount,
            'status' => $this->faker->randomElement(['pending', 'under_review', 'approved', 'rejected', 'paid']),
            'incident_date' => $incidentDate,
            'documents' => $this->faker->optional(0.6)->randomElements([
                'receipt_001.pdf',
                'photo_damage.jpg',
                'police_report.pdf',
                'medical_report.pdf'
            ], $this->faker->numberBetween(1, 3)),
            'admin_notes' => $this->faker->optional(0.4)->paragraph,
            'submitted_at' => $claimDate,
            'processed_at' => $approvedAmount ? $this->faker->dateTimeBetween($claimDate, 'now') : null,
        ];
    }

    /**
     * Indicate that the claim is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'approved_amount' => null,
            'processed_at' => null,
        ]);
    }

    /**
     * Indicate that the claim is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'approved_amount' => $this->faker->randomFloat(2, $attributes['claimed_amount'] * 0.7, $attributes['claimed_amount']),
            'processed_at' => $this->faker->dateTimeBetween($attributes['submitted_at'], 'now'),
        ]);
    }
}