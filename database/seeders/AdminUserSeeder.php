<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama'     => 'Administrator',
            'email'    => 'admin@ukk2026.com',
            'password' => Hash::make('123456'),
            'role'     => 'admin',
        ]);
    }
}