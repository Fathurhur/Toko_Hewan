<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menanam akun Admin
        User::updateOrCreate(
            ['email' => 'adminutama@pasarhewan.com'],
            [
                'name'              => 'Admin', // <--- UBAH DI SINI
                'whatsapp_number'   => '089631221745', // <--- UBAH DI SINI
                'role'              => 'admin',
                'password'          => Hash::make('rahasia123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
