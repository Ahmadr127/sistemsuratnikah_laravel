<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user (username: admin, password: 123)
        User::updateOrCreate(
            ['email' => 'admin@bukunikahdigital.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('123'),
                'role' => 'admin',
            ]
        );

        // Create regular user for testing (username: user, password: 123)
        User::updateOrCreate(
            ['email' => 'user@bukunikahdigital.com'],
            [
                'name' => 'User Test',
                'password' => Hash::make('123'),
                'role' => 'user',
            ]
        );

        // Create additional admin user with username 'admin' and password '123'
        User::updateOrCreate(
            ['email' => 'admin'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123'),
                'role' => 'admin',
            ]
        );
    }
}
