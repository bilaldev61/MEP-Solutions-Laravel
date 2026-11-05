<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Demo admin account (role is not mass assignable — set explicitly)
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Test User', 'password' => 'password']
        );
        $admin->role = 'admin';
        $admin->save();

        // Demo manager account — limited access
        $manager = User::updateOrCreate(
            ['email' => 'manager@example.com'],
            ['name' => 'Site Manager', 'password' => 'password']
        );
        $manager->role = 'manager';
        $manager->save();

        // Seed all demo data (all seeders are idempotent)
        $this->call([
            SiteSettingsSeeder::class,
            ServiceSeeder::class,
            EmployeeSeeder::class,
            AttendanceSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
