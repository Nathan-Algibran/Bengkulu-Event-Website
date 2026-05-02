<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Admin Event Bengkulu',
            'email'    => 'admin@eventbengkulu.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name'     => 'User Demo',
            'email'    => 'user@eventbengkulu.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $user->assignRole('user');
    }
}