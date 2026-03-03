<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 5 Admin
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Admin Ke-$i",
                'email' => "admin$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        // 5 Customers
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Customer Ke-$i",
                'email' => "customer$i@example.com",
                'password' => Hash::make('password'), // Password default: password
                'email_verified_at' => now(),
            ]);
        }
    }
}