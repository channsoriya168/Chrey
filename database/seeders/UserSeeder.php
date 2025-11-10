<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles are created by RolesSeeder; assume they exist

        // Create or fetch an admin user
        $admin = User::firstOrCreate(
            ['email' => 'soriya@gmail.com'],
            [
                'name' => 'soriya',
                'password' => '12345678', // Will be auto-hashed by User model
            ]
        );
        // Assign admin role if not already assigned
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
