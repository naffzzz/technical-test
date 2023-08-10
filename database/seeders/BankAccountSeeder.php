<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BankAccount::create([
            'full_name' => "Admin Digital Cellar", 
            'account_number' => "1234567890",
            'bank_id' => 1,
            'user_id' => 1,
            'balance' => 100.00
        ]);

        BankAccount::create([
            'full_name' => "Customer Digital Cellar", 
            'account_number' => "1234567891",
            'bank_id' => 2,
            'user_id' => 2,
            'balance' => 100.00
        ]);

        BankAccount::create([
            'full_name' => "Promoter Digital Cellar", 
            'account_number' => "1234567892",
            'bank_id' => 3,
            'user_id' => 3,
            'balance' => 100.00
        ]);
    }
}
