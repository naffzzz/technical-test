<?php

namespace App\Repositories;

use App\Models\CreditCard;

class CreditCardRepository
{
    public function index()
    {
        return CreditCard::get();
    }

    public function findByUserId($userId)
    {
        return CreditCard::where('user_id', $userId)->get();
    }

    public function findById($creditCardId)
    {
        return CreditCard::find($creditCardId);
    }
}

?>