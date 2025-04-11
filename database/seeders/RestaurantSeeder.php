<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@tableready.io',
                'password' => bcrypt('tableready123'),
                'email_verified_at' => now(),
            ]);
        }

        Restaurant::create([
            'name' => 'TableReady Demo Restaurant',
            'slug' => 'tableready-demo',
            'address' => '123 Main Street',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
            'country' => 'US',
            'phone' => '+1234567890',
            'email' => 'demo@tableready.io',
            'website' => 'https://tableready.io',
            'timezone' => 'America/New_York',
            'active' => true,
            'average_wait_time' => 15,
            'user_id' => $user->id,
            'settings' => json_encode([
                'theme' => [
                    'primary_color' => '#28a745',
                    'secondary_color' => '#ff7f00',
                    'accent_color' => '#ffcc00'
                ]
            ])
        ]);
    }
}
