<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    public function run()
    {
        // Insert sample wallets
        Wallet::create(['user_id' => 1, 'balance' => 100.00]);
        Wallet::create(['user_id' => 2, 'balance' => 50.00]);
        Wallet::create(['user_id' => 3, 'balance' => 200.00]);

        // You can add more wallets as needed
    }
}
