<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserType::create(['name' => 'admin']);
        UserType::create(['name' => 'customer']);
        UserType::create(['name' => 'promoter']);
    }
}
