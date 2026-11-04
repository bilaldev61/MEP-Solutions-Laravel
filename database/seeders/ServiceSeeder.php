<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Seed the trades shown on the website (hero chips + services grid).
     */
    public function run(): void
    {
        $services = [
            ['icon' => '🔧', 'name' => 'Plumbing',  'description' => 'Leaks, burst pipes, taps, fittings and drainage fixed fast and done right.'],
            ['icon' => '🔥', 'name' => 'Welding',   'description' => 'On-site and workshop MIG/TIG welding, gates, railings and metal fabrication.'],
            ['icon' => '🧴', 'name' => 'Cleaning',  'description' => 'Deep residential and commercial cleaning that leaves every space spotless.'],
            ['icon' => '⚡', 'name' => 'Wiring',    'description' => 'Certified electrical wiring, lighting, panels and power troubleshooting.'],
            ['icon' => '❄️', 'name' => 'AC Maintenance', 'description' => 'Installation, servicing and gas top-up for split and window AC units.'],
            ['icon' => '🎨', 'name' => 'Painting',   'description' => 'Interior and exterior painting with a smooth, long-lasting professional finish.'],
            ['icon' => '🪚', 'name' => 'Carpentry',  'description' => 'Custom furniture, doors, shelving and on-site woodwork by skilled carpenters.'],
            ['icon' => '🧱', 'name' => 'Tiling',     'description' => 'Floor and wall tiling, grouting and waterproofing for kitchens and bathrooms.'],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name']],
                $service + ['active' => true]
            );
        }
    }
}
