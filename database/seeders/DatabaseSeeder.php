<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@trinistay.com',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
        ]);

        // Create Owner Test User
        User::factory()->create([
            'name' => 'Pemilik Kos Demo',
            'email' => 'owner@trinistay.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'phone_number' => '081234567890',
        ]);

        // Create Renter Test User
        User::factory()->create([
            'name' => 'Penyewa Demo',
            'email' => 'renter@trinistay.com',
            'password' => bcrypt('password'),
            'role' => 'renter',
            'phone_number' => '081987654321',
            'age' => 25,
            'gender' => 'Male',
        ]);
    }
}
