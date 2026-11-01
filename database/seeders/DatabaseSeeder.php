<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pilkades.local'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'panitia@pilkades.local'],
            [
                'name' => 'Panitia',
                'password' => Hash::make('password'),
                'role' => 'committee',
            ]
        );

        User::updateOrCreate(
            ['email' => 'officer@pilkades.local'],
            [
                'name' => 'Petugas TPS',
                'password' => Hash::make('password'),
                'role' => 'officer',
            ]
        );
    }
}