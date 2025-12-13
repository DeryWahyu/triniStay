<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@trinistay.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@trinistay.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'phone_number' => '081234567890',
            ]
        );
    }
}
