<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('SecurePassword123'),
            'photo' => null,
            'role' => 'superAdmin',
            'gender' => 'male',
            'address' => '123 Admin Street',
            'phone_number' => '+1234567890',
            'status' => 'active',
            'registration_date' => now(),
            'email_verified_at' => now(),
        ]);
    }
}