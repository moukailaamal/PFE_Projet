<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create a test user with your actual schema
        User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'photo' => null,
            'role' => 'client',
            'gender' => 'other',
            'address' => '123 Test Street',
            'phone_number' => '+1234567890',
            'status' => 'active',
            'registration_date' => Carbon::now(),
            'email_verified_at' => Carbon::now(),
        ]);

        // Call the category services seeder
        $this->call([
            CategoryServiceSeeder::class,
        ]);
    }
}