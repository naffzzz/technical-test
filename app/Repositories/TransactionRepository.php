<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function index()
    {
        return Transaction::get();
    }

    public function findById($transactionId)
    {
        return Transaction::find($transactionId);
    }
}

?>