<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    public function index($request)
    {
        $status = $request->query('status');
        $type = $request->query('type');
        $eventDate = $request->query('event_date');
    
        $query = Event::query();
    
        if ($status) {
            $query->where('status', $status);
        }
    
        if ($type) {
            $query->where('type', $type);
        }

        if ($eventDate) {
            $query->where('event_date', $eventDate);
        }
    
        $results = $query->get();
        return $results;
    }

    public function findById($userId)
    {
        return Event::find($userId);
    }
}

?>