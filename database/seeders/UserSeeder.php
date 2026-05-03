<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
   public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin Gudang Podgasm',
            'email' => 'admin@podgasm.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);
    }
}
