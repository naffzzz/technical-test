<?php

namespace App\Repositories;

use App\Models\UserType;

class UserTypeRepository
{
    public function index()
    {
        return UserType::get();
    }

    public function findById($userId)
    {
        return UserType::find($userId);
    }

    public function findByName($name)
    {
        return UserType::where('name',$name)->first();
    }
}

?>