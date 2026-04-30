<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin Role & User
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@charityhub.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);

        // 2. Create Sample Campaigns
        $campaigns = [
            [
                'title' => 'Clean Water Initiative',
                'description' => '<p>Help us provide clean, accessible drinking water to remote villages. Every drop counts in our mission to eradicate waterborne diseases and improve overall health.</p><h3>The Impact</h3><ul><li>Build 5 new wells</li><li>Train local maintenance crews</li><li>Provide water filters for 100 families</li></ul>',
                'goal_amount' => 5000000, // £50,000.00
                'raised_amount' => 1250000, // £12,500.00
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
                'status' => 'active',
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Education for All',
                'description' => '<p>Empowering the next generation through education. We are raising funds to build a new school and provide essential learning materials for children in underserved communities.</p><h3>Goals</h3><ol><li>Construct 4 classrooms</li><li>Hire 5 full-time teachers</li><li>Provide 500 textbooks</li></ol>',
                'goal_amount' => 2500000, // £25,000.00
                'raised_amount' => 2000000, // £20,000.00
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(5),
                'status' => 'active',
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Emergency Disaster Relief',
                'description' => '<p>Immediate assistance required for communities affected by the recent natural disaster. Funds will go directly towards food, shelter, and medical supplies.</p>',
                'goal_amount' => 10000000, // £100,000.00
                'raised_amount' => 0, // £0.00
                'start_date' => now(),
                'end_date' => now()->addDays(60),
                'status' => 'active',
                'created_by' => $admin->id,
            ]
        ];

        foreach ($campaigns as $data) {
            Campaign::create($data);
        }
    }
}
