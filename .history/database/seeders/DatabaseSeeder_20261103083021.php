<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kandang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /* ===== 1. AKUN ADMIN ===== */
        User::updateOrCreate(
            ['email' => 'admin@peternakan.com'],
            [
                'name'     => 'Administrator',
                'role'     => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        /* ===== 2. AKUN MAN POWER (beberapa kandang) ===== */
        $kandangs = ['Kandang A', 'Kandang B', 'Kandang C'];
        foreach ($kandangs as $index => $namaKandang) {
            // Buat kandang dulu (biar manpower bisa pilih kandang di laporan)
            $kandang = Kandang::updateOrCreate(
                ['nama' => $namaKandang],
                ['lokasi' => 'Blok ' . chr(65 + $index)]
            );

            User::updateOrCreate(
                ['email' => 'manpower' . ($index + 1) . '@peternakan.com'],
                [
                    'name'     => 'Man Power ' . $namaKandang,
                    'role'     => 'manpower',
                    'password' => Hash::make('manpower123'),
                ]
            );
        }

        /* ===== 3. AKUN UMUM (MODE BACA / READ-ONLY) ===== */
        User::updateOrCreate(
            ['email' => 'umum@peternakan.com'],
            [
                'name'     => 'User Umum',
                'role'     => 'umum',
                'password' => Hash::make('umum123'),
            ]
        );
    }
}
