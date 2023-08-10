<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    public function run()
    {
        // Insert sample banks
        Bank::create(['name' => 'Bank BCA']);
        Bank::create(['name' => 'Bank Mandiri']);
        Bank::create(['name' => 'Bank Danamon']);

        // You can add more banks as needed
    }
}
