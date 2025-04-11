<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Restaurant::create([
            'name' => 'TableReady Demo Restaurant',
            'slug' => 'tableready-demo',
            'address' => '123 Main Street',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
            'phone' => '+1234567890',
            'email' => 'demo@tableready.io',
            'website' => 'https://tableready.io',
            'description' => 'Demo restaurant for TableReady waitlist platform',
            'active' => true,
            'average_wait_time' => 15,
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
