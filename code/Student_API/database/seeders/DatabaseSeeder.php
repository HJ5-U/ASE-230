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
        // Create initial admin user
        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('Admin@123!Secure'), // Make sure to note this password
            'role' => 'admin'
        ]);

        // Create a regular test user
        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        // Run the StudentSeeder to populate students table
        $this->call(StudentSeeder::class);
    }
}
