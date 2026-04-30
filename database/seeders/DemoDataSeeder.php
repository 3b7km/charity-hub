<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'donor@example.com'],
            ['name' => 'John Donor', 'password' => bcrypt('password')]
        );

        $campaigns = [
            [
                'title' => 'Clean Water Initiative',
                'description' => 'Providing sustainable clean water access to 5 remote villages in the northern Rift Valley.',
                'goal_amount' => 2000000,
                'category' => 'Environment',
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addDays(30),
            ],
            [
                'title' => 'Education for All',
                'description' => 'Empowering the next generation through education. We are raising funds to build a new school.',
                'goal_amount' => 5000000,
                'category' => 'Education',
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addDays(45),
            ],
        ];

        foreach ($campaigns as $data) {
            $campaign = \App\Models\Campaign::firstOrCreate(['title' => $data['title']], array_merge($data, ['created_by' => $user->id]));

            // Add some donations
            for ($i = 0; $i < 5; $i++) {
                $amount = rand(1000, 50000); // £10 - £500
                $donation = \App\Models\Donation::create([
                    'campaign_id' => $campaign->id,
                    'donor_id' => $user->id,
                    'amount' => $amount,
                    'status' => 'confirmed',
                    'currency' => 'GBP',
                    'donated_at' => now()->subHours(rand(1, 100)),
                ]);

                // Add Ledger entry
                \App\Models\LedgerEntry::create([
                    'donation_id' => $donation->id,
                    'type' => 'credit',
                    'amount' => $amount,
                    'balance_after' => $amount, // Simplified for demo
                    'notes' => 'Donation via Stripe',
                ]);
            }
        }
    }
}
