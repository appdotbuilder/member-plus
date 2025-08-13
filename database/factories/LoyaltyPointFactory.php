<?php

namespace Database\Factories;

use App\Models\LoyaltyPoint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoyaltyPoint>
 */
class LoyaltyPointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\LoyaltyPoint>
     */
    protected $model = LoyaltyPoint::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transactionType = $this->faker->randomElement(['earned', 'redeemed', 'expired']);
        
        $descriptions = [
            'earned' => [
                'New policy purchase bonus',
                'Monthly loyalty reward',
                'Referral bonus',
                'Policy renewal bonus',
                'Birthday reward',
                'Review submission reward',
                'Social media engagement'
            ],
            'redeemed' => [
                'Dental service discount',
                'Product purchase discount',
                'Gift card redemption',
                'Cashback redemption',
                'Service upgrade'
            ],
            'expired' => [
                'Points expired after 2 years',
                'Account inactivity expiration',
                'Promotional points expired'
            ]
        ];

        $amount = match($transactionType) {
            'earned' => $this->faker->numberBetween(50, 1000),
            'redeemed' => -$this->faker->numberBetween(100, 500),
            'expired' => -$this->faker->numberBetween(50, 200),
            default => 0,
        };

        return [
            'user_id' => User::factory(),
            'points' => 0, // This will be calculated in the seeder
            'transaction_type' => $transactionType,
            'description' => $this->faker->randomElement($descriptions[$transactionType]),
            'amount' => $amount,
            'reference_type' => $this->faker->optional(0.6)->randomElement(['policy_purchase', 'claim_processed', 'referral', 'system']),
            'reference_id' => $this->faker->optional(0.6)->numberBetween(1, 1000),
        ];
    }

    /**
     * Indicate that points were earned.
     */
    public function earned(): static
    {
        return $this->state(fn (array $attributes) => [
            'transaction_type' => 'earned',
            'amount' => $this->faker->numberBetween(50, 1000),
            'description' => $this->faker->randomElement([
                'New policy purchase bonus',
                'Monthly loyalty reward',
                'Referral bonus',
                'Policy renewal bonus'
            ]),
        ]);
    }

    /**
     * Indicate that points were redeemed.
     */
    public function redeemed(): static
    {
        return $this->state(fn (array $attributes) => [
            'transaction_type' => 'redeemed',
            'amount' => -$this->faker->numberBetween(100, 500),
            'description' => $this->faker->randomElement([
                'Dental service discount',
                'Product purchase discount',
                'Gift card redemption'
            ]),
        ]);
    }
}