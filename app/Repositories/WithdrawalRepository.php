<?php

namespace App\Repositories;

use App\Models\Withdrawal;

class WithdrawalRepository
{
    public function index()
    {
        return Withdrawal::get();
    }

    public function findByUserId($userId)
    {
        return Withdrawal::where('user_id', $userId)->get();
    }

    public function findById($withdrawalId)
    {
        return Withdrawal::find($withdrawalId);
    }
}

?>