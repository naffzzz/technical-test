<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\BankSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\UserTypeSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(WalletSeeder::class);
    }
}
