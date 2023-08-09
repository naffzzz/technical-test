<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    public function index()
    {
        return Event::get();
    }

    public function findById($userId)
    {
        return Event::find($userId);
    }
}

?>