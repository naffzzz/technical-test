<?php

namespace App\Repositories;

use App\Models\Bank;

class BankRepository
{
    public function index()
    {
        return Bank::get();
    }

    public function findById($bankId)
    {
        return Bank::find($bankId);
    }

    public function findByName($name)
    {
        return Bank::where('name',$name)->first();
    }
}

?>