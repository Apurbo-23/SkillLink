<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the database with an admin user.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@admin.io'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // Change this in production!
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'support@admin.io'],
            [
                'name' => 'Support',
                'password' => Hash::make('support123'), // Change this in production!
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
