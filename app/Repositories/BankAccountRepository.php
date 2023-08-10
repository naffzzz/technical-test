<?php

namespace App\Repositories;

use App\Models\BankAccount;

class BankAccountRepository
{
    public function index()
    {
        return BankAccount::get();
    }

    public function findByUserId($userId)
    {
        return BankAccount::where('user_id', $userId)->get();
    }

    public function findById($bankAccountId)
    {
        return BankAccount::find($bankAccountId);
    }

    public function findByName($name)
    {
        return BankAccount::where('full_name',$name)->first();
    }
}

?>