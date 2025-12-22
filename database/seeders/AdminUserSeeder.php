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
            ['email' => 'spasi0123123@gmail.com'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'gender' => 'L',
            ]
        );

        // Create regular user for testing (username: user, password: 123)
        User::updateOrCreate(
            ['email' => 'user@bukunikahdigital.com'],
            [
                'name' => 'User Test',
                'username' => 'user',
                'password' => Hash::make('123'),
                'role' => 'user',
                'gender' => 'L',
            ]
        );
    }
}
