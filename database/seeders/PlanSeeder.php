<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Gold Plan',
                'slug' => 'gold-plan',
                'stripe_plan' => 'price_1NnIyGAm4cVATBbnwGXts3f4',
                'price' => 80,
                'description' => '15 000 words/monthWrite in 10 languagesImage generation (40/month)25+ languagesUnlimited projectsUnlimited Marvel ChatNew experimental features'
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'stripe_plan' => 'price_1NnbHCAm4cVATBbn0OYne5Va',
                'price' => 120,
                'description' => '15 000 words/month Write in 10 languages Image generation (40/month) 25+ languages Unlimited projects Unlimited Marvel Chat New experimental features'
            ]
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
