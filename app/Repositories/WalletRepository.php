<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository
{
    public function index()
    {
        return Wallet::get();
    }

    public function findById($userId)
    {
        return Wallet::find($userId);
    }
}

?>