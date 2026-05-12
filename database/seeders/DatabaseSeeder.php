<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\ImpactReport;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\VolunteerSchedule;
use App\Models\BeneficiaryLocation;
use App\Models\CharitySubscription;
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
        // 1. Create Roles & Admin User
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $donorRole = Role::firstOrCreate(['name' => 'donor']);
        
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@charityhub.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);

        // Youssef's personal account
        $youssef = User::factory()->create([
            'name' => 'Youssef Abdelhakam',
            'email' => 'youssefabdelhakam99@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $youssef->assignRole($donorRole);

        // Create volunteer users
        $volunteerUsers = [];
        $volunteerNames = [
            ['name' => 'Sara Ahmed',    'email' => 'sara@charityhub.com'],
            ['name' => 'Mohamed Ali',   'email' => 'mohamed@charityhub.com'],
            ['name' => 'Fatma Hassan',  'email' => 'fatma@charityhub.com'],
            ['name' => 'Omar Youssef',  'email' => 'omar@charityhub.com'],
        ];

        foreach ($volunteerNames as $vData) {
            $user = User::factory()->create([
                'name' => $vData['name'],
                'email' => $vData['email'],
                'password' => bcrypt('password'),
            ]);
            $user->assignRole($donorRole);
            $volunteerUsers[] = $user;
        }

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

        $createdCampaigns = [];
        foreach ($campaigns as $data) {
            $createdCampaigns[] = Campaign::create($data);
        }

        // 3. Create Volunteers & Volunteer Schedules
        $volunteers = [];
        $skillSets = [
            ['Teaching', 'First Aid', 'Arabic Translation'],
            ['Driving', 'Logistics', 'Heavy Lifting'],
            ['Medical', 'Nursing', 'Counseling'],
            ['IT Support', 'Data Entry', 'Social Media'],
        ];

        foreach ($volunteerUsers as $i => $user) {
            $volunteer = Volunteer::create([
                'user_id' => $user->id,
                'skills' => $skillSets[$i],
                'availability' => ['weekdays' => true, 'weekends' => true],
                'total_hours' => rand(10, 80),
                'verified_at' => now()->subDays(rand(5, 30)),
                'emergency_contact' => 'Contact: +20 10' . rand(10000000, 99999999),
            ]);
            $volunteers[] = $volunteer;
        }

        // Assign shifts across campaigns
        $statuses = ['scheduled', 'confirmed', 'completed', 'completed'];
        foreach ($createdCampaigns as $campaign) {
            foreach ($volunteers as $j => $volunteer) {
                $shiftStart = now()->addDays(rand(-5, 15))->setHour(rand(8, 14));
                $shiftEnd = (clone $shiftStart)->addHours(rand(3, 6));
                $status = $statuses[array_rand($statuses)];

                VolunteerSchedule::create([
                    'volunteer_id' => $volunteer->id,
                    'campaign_id' => $campaign->id,
                    'shift_start' => $shiftStart,
                    'shift_end' => $shiftEnd,
                    'hours_logged' => $status === 'completed' ? $shiftStart->diffInHours($shiftEnd) : null,
                    'status' => $status,
                    'conflict_checked_at' => now(),
                ]);
            }
        }

        // 4. Create Impact Reports with geodata
        $impactData = [
            [
                'campaign_index' => 0, // Clean Water
                'beneficiary_count' => 320,
                'summary' => '<h3>Clean Water Initiative — Phase 1 Report</h3><p>Successfully installed 3 wells across 10th of Ramadan and surrounding areas. Over 320 families now have daily access to clean water. Local technicians have been trained for ongoing maintenance.</p><ul><li>3 wells operational</li><li>Water quality tested and certified</li><li>Maintenance crew of 6 trained</li></ul>',
                'locations' => [
                    ['lat' => 30.2976, 'lng' => 31.7500, 'label' => '10th of Ramadan City — Well #1'],
                    ['lat' => 30.0444, 'lng' => 31.2357, 'label' => 'Cairo — Distribution Center'],
                    ['lat' => 30.5965, 'lng' => 32.2715, 'label' => 'Ismailia — Well #2'],
                ],
            ],
            [
                'campaign_index' => 1, // Education
                'beneficiary_count' => 150,
                'summary' => '<h3>Education for All — Mid-Term Report</h3><p>Two classrooms have been constructed in 10th of Ramadan industrial zone community. 150 children enrolled in the first semester. Teachers recruited and trained.</p><ul><li>2 of 4 classrooms complete</li><li>150 students enrolled</li><li>250 textbooks distributed</li></ul>',
                'locations' => [
                    ['lat' => 30.2976, 'lng' => 31.7500, 'label' => '10th of Ramadan — New School Site'],
                    ['lat' => 30.0131, 'lng' => 31.2089, 'label' => 'Helwan — Partner School'],
                ],
            ],
            [
                'campaign_index' => 2, // Disaster Relief
                'beneficiary_count' => 0,
                'summary' => '<h3>Emergency Disaster Relief — Initial Assessment</h3><p>Field teams have been deployed to assess affected areas. Supply routes mapped and logistics partners identified. Awaiting full funding to begin distribution.</p>',
                'locations' => [
                    ['lat' => 31.2001, 'lng' => 29.9187, 'label' => 'Alexandria — Assessment Zone'],
                    ['lat' => 24.0889, 'lng' => 32.8998, 'label' => 'Aswan — Staging Area'],
                ],
            ],
        ];

        foreach ($impactData as $data) {
            ImpactReport::create([
                'campaign_id' => $createdCampaigns[$data['campaign_index']]->id,
                'beneficiary_count' => $data['beneficiary_count'],
                'locations' => $data['locations'],
                'summary' => $data['summary'],
                'published_at' => $data['beneficiary_count'] > 0 ? now()->subDays(rand(1, 7)) : null,
            ]);
        }

        // 5. Add 10th of Ramadan as a beneficiary location for campaigns
        foreach ($createdCampaigns as $campaign) {
            BeneficiaryLocation::create([
                'campaign_id' => $campaign->id,
                'location_name' => '10th of Ramadan City, Egypt',
                'latitude' => 30.2976,
                'longitude' => 31.7500,
                'beneficiary_count' => rand(50, 200),
            ]);
        }

        // 6. Create Charity Subscriptions
        $plans = ['monthly', 'quarterly', 'annually'];
        foreach ($volunteerUsers as $donor) {
            foreach (array_slice($createdCampaigns, 0, 2) as $campaign) {
                $plan = $plans[array_rand($plans)];
                CharitySubscription::create([
                    'donor_id' => $donor->id,
                    'campaign_id' => $campaign->id,
                    'stripe_subscription_id' => 'sub_demo_' . Str::random(14),
                    'stripe_customer_id' => 'cus_demo_' . Str::random(14),
                    'plan' => $plan,
                    'status' => 'active',
                    'current_period_end' => now()->addDays($plan === 'monthly' ? 30 : ($plan === 'quarterly' ? 90 : 365)),
                ]);
            }
        }

        $this->call([
            BeneficiaryLocationSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
