<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository
{
    public function index()
    {
        return Wallet::get();
    }

    public function findByUserId($userId)
    {
        return Wallet::where('user_id', $userId)->first();
    }
}

?>