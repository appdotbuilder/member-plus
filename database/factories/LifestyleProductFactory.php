<?php

namespace Database\Factories;

use App\Models\LifestyleProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LifestyleProduct>
 */
class LifestyleProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\LifestyleProduct>
     */
    protected $model = LifestyleProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['car_insurance', 'dental_care', 'health', 'wellness'];
        $category = $this->faker->randomElement($categories);
        
        $productsByCategory = [
            'car_insurance' => [
                'Premium Car Protection Plan',
                'Comprehensive Auto Coverage',
                'Young Driver Special Package',
                'Classic Car Insurance',
                'Commercial Vehicle Cover'
            ],
            'dental_care' => [
                'Complete Dental Wellness Package',
                'Family Dental Care Plan',
                'Cosmetic Dental Cover',
                'Emergency Dental Service',
                'Preventive Care Package'
            ],
            'health' => [
                'Executive Health Package',
                'Family Health Plus',
                'Mental Health Support Plan',
                'Chronic Care Management',
                'Preventive Health Screening'
            ],
            'wellness' => [
                'Fitness & Wellness Program',
                'Nutrition Consultation Package',
                'Stress Management Program',
                'Sleep Wellness Package',
                'Mindfulness & Meditation'
            ]
        ];

        $name = $this->faker->randomElement($productsByCategory[$category]);
        $price = $this->faker->randomFloat(2, 50, 1000);
        $memberPrice = $price * 0.8; // 20% discount for members

        return [
            'name' => $name,
            'category' => $category,
            'description' => $this->faker->paragraphs(3, true),
            'features' => implode("\n", $this->faker->sentences(5)),
            'price' => $price,
            'member_price' => $memberPrice,
            'image_url' => $this->faker->optional()->imageUrl(400, 300, 'health'),
            'is_active' => $this->faker->boolean(90),
            'eligibility_criteria' => [
                'min_tier' => $this->faker->randomElement(['bronze', 'silver', 'gold']),
                'age_restriction' => $this->faker->optional()->numberBetween(18, 65),
                'location_restriction' => $this->faker->optional(0.3)->city,
            ],
            'points_reward' => $this->faker->numberBetween(50, 500),
        ];
    }

    /**
     * Indicate that the product is for a specific category.
     */
    public function category(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }

    /**
     * Indicate that the product is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }
}