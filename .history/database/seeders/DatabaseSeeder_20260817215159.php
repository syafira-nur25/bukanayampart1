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
            ['email' => 'admin@peternakan.com'],
            ['name' => 'Administrator', 'role' => 'admin', 'password' => Hash::make('admin123')]
        );

        User::updateOrCreate(
            ['email' => 'admin@peternakan.com'],
            ['name' => 'Administrator', 'role' => 'admin', 'password' => Hash::make('admin123')]
        );


        User::updateOrCreate(
            ['email' => 'manpower@peternakan.com'],
            ['name' => 'Anak Kandang 1', 'role' => 'manpower', 'password' => Hash::make('manpower123')]
        );
    }
}
