<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@localmarket.com'],
            [
                'name'     => 'Admin LocalMarket',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'status'   => 'activo',
            ]
        );
    }
}
