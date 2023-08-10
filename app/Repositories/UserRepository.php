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

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }
    
}

?>