<?php

namespace Database\Factories;

use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberProfile>
 */
class MemberProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\MemberProfile>
     */
    protected $model = MemberProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-2 years', 'now');
        
        return [
            'user_id' => User::factory(),
            'member_number' => 'MEM-' . date('Y') . '-' . $this->faker->unique()->numberBetween(10000, 99999),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->dateTimeBetween('-70 years', '-18 years'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other', 'prefer_not_to_say']),
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->optional()->city,
            'postal_code' => $this->faker->postcode,
            'country' => 'Australia',
            'emergency_contact_name' => $this->faker->name,
            'emergency_contact_phone' => $this->faker->phoneNumber,
            'membership_tier' => $this->faker->randomElement(['bronze', 'silver', 'gold', 'platinum']),
            'membership_start_date' => $startDate,
            'membership_end_date' => $this->faker->optional(0.3)->dateTimeBetween('now', '+2 years'),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the member has a specific tier.
     */
    public function tier(string $tier): static
    {
        return $this->state(fn (array $attributes) => [
            'membership_tier' => $tier,
        ]);
    }
}