<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Insert sample users
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1q2w3e4r'),
            'type_id' => 1,
        ]);

        User::create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('1q2w3e4r'),
            'type_id' => 2,
        ]);

        User::create([
            'name' => 'Promoter',
            'email' => 'promoter@gmail.com',
            'password' => Hash::make('1q2w3e4r'),
            'type_id' => 3,
        ]);

    }
}

