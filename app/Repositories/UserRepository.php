<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function index()
    {
        return User::get();
    }

    public function findById($userId)
    {
        return User::find($userId);
    }
}

?>