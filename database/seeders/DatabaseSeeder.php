<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MemberProfile;
use App\Models\InsurancePolicy;
use App\Models\InsuranceClaim;
use App\Models\LoyaltyPoint;
use App\Models\LifestyleProduct;
use App\Models\DentalAppointment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo user
        $demoUser = User::factory()->create([
            'name' => 'Demo Member',
            'email' => 'demo@example.com',
        ]);

        // Create member profile for demo user
        $memberProfile = MemberProfile::factory()->create([
            'user_id' => $demoUser->id,
            'first_name' => 'Demo',
            'last_name' => 'Member',
            'membership_tier' => 'gold',
        ]);

        // Create insurance policies for demo user
        $policies = InsurancePolicy::factory(4)->create([
            'user_id' => $demoUser->id,
        ]);

        // Ensure at least 2 policies are active
        $policies->take(2)->each(function ($policy) {
            $policy->update([
                'status' => 'active',
                'start_date' => now()->subMonths(6),
                'end_date' => now()->addMonths(6),
            ]);
        });

        // Create claims for some policies
        foreach ($policies->take(2) as $policy) {
            InsuranceClaim::factory(2)->create([
                'user_id' => $demoUser->id,
                'insurance_policy_id' => $policy->id,
            ]);
        }

        // Create loyalty points transactions
        $pointsTransactions = [
            ['type' => 'earned', 'description' => 'New policy purchase bonus', 'amount' => 500],
            ['type' => 'earned', 'description' => 'Monthly loyalty bonus', 'amount' => 100],
            ['type' => 'earned', 'description' => 'Referral bonus', 'amount' => 250],
            ['type' => 'redeemed', 'description' => 'Dental service discount', 'amount' => -150],
            ['type' => 'earned', 'description' => 'Policy renewal bonus', 'amount' => 200],
        ];

        $totalPoints = 0;
        foreach ($pointsTransactions as $transaction) {
            $totalPoints += $transaction['amount'];
            LoyaltyPoint::create([
                'user_id' => $demoUser->id,
                'points' => $totalPoints,
                'transaction_type' => $transaction['type'],
                'description' => $transaction['description'],
                'amount' => $transaction['amount'],
                'reference_type' => 'system',
                'reference_id' => null,
            ]);
        }

        // Create dental appointments
        DentalAppointment::factory(3)->create([
            'user_id' => $demoUser->id,
            'appointment_datetime' => now()->addDays(random_int(1, 30)),
            'status' => 'scheduled',
        ]);

        // Create additional test users
        $users = User::factory(10)->create();
        
        foreach ($users as $user) {
            // Create member profile
            MemberProfile::factory()->create(['user_id' => $user->id]);
            
            // Create some policies
            $userPolicies = InsurancePolicy::factory(random_int(1, 3))->create(['user_id' => $user->id]);
            
            // Create some claims
            if ($userPolicies->count() > 0) {
                InsuranceClaim::factory(random_int(0, 2))->create([
                    'user_id' => $user->id,
                    'insurance_policy_id' => $userPolicies->random()->id,
                ]);
            }
            
            // Create loyalty points
            $points = random_int(0, 1000);
            LoyaltyPoint::create([
                'user_id' => $user->id,
                'points' => $points,
                'transaction_type' => 'earned',
                'description' => 'Welcome bonus',
                'amount' => $points,
            ]);
        }

        // Create lifestyle products
        LifestyleProduct::factory(20)->active()->create();
        
        // Create specific featured products
        $featuredProducts = [
            [
                'name' => 'Premium Car Insurance Package',
                'category' => 'car_insurance',
                'description' => 'Comprehensive coverage for your vehicle with 24/7 roadside assistance, rental car coverage, and accident forgiveness.',
                'features' => "Collision Coverage\nComprehensive Coverage\n24/7 Roadside Assistance\nRental Car Coverage\nAccident Forgiveness",
                'price' => 299.99,
                'member_price' => 239.99,
                'points_reward' => 150,
            ],
            [
                'name' => 'Complete Dental Care Package',
                'category' => 'dental_care',
                'description' => 'Full dental coverage including cleanings, fillings, crowns, and emergency procedures with preferred provider network.',
                'features' => "Preventive Care\nRestorative Procedures\nEmergency Services\nPreferred Provider Network\nNo Waiting Periods",
                'price' => 159.99,
                'member_price' => 127.99,
                'points_reward' => 100,
            ],
            [
                'name' => 'Executive Health Screening',
                'category' => 'health',
                'description' => 'Comprehensive health screening package designed for busy professionals, including full blood panel and lifestyle assessment.',
                'features' => "Full Blood Panel\nCardiac Assessment\nLifestyle Consultation\nNutritional Analysis\nPrevention Planning",
                'price' => 499.99,
                'member_price' => 399.99,
                'points_reward' => 250,
            ],
            [
                'name' => 'Wellness & Fitness Program',
                'category' => 'wellness',
                'description' => 'Complete wellness program including gym membership, personal training, nutrition coaching, and mental health support.',
                'features' => "Gym Membership\nPersonal Training Sessions\nNutrition Coaching\nMental Health Support\nWellness Tracking App",
                'price' => 199.99,
                'member_price' => 159.99,
                'points_reward' => 200,
            ],
        ];

        foreach ($featuredProducts as $product) {
            LifestyleProduct::create([
                ...$product,
                'is_active' => true,
                'eligibility_criteria' => ['min_tier' => 'bronze'],
            ]);
        }
    }
}