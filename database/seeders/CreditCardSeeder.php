<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CreditCard::create([
            'user_id' => 1, 
            'card_number' => "1234567891",
            'cvv' => "123",
            'month' => "12",
            'year' => "2024"
        ]);

        CreditCard::create([
            'user_id' => 2, 
            'card_number' => "1234567892",
            'cvv' => "124",
            'month' => "12",
            'year' => "2025"
        ]);

        CreditCard::create([
            'user_id' => 3, 
            'card_number' => "1234567893",
            'cvv' => "123",
            'month' => "12",
            'year' => "2026"
        ]);
    }
}
