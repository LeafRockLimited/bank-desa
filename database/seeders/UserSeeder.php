<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create admin user
         $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('admin');

        // Create teller user
        $teller = User::create([
            'name' => 'Teller User',
            'email' => 'teller@example.com',
            'password' => Hash::make('password')
        ]);
        $teller->assignRole('teller');

        // Create nasabah user
        $nasabah = User::create([
            'name' => 'Nasabah User',
            'email' => 'nasabah@example.com',
            'password' => Hash::make('password')
        ]);
        $nasabah->assignRole('nasabah');
    }
}
