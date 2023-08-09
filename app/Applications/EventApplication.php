<?php

namespace App\Applications;

use App\Infastructures\Response;
use App\Models\Event;
use App\Repositories\EventRepository;

class EventApplication
{
    // Repository
    protected $eventRepository;

    // Infrastructure
    protected $response;

    // Variables
    private $event;
    private $request;
    private $session;
    private $isError;

    public function __construct(
        EventRepository $eventRepository,
        Response $response)
    {
        $this->isError = false;
        $this->eventRepository = $eventRepository;
        $this->response = $response;
    }

    public function preparation($request, $userId = null)
    {
        if ($userId != null)
        {
            $this->event = $this->eventRepository->findById($userId);
        }
        else
        {
            $this->event = new Event;
        }

        $this->request = $request;
        return $this;
    }

    public function create()
    {
        $this->event->name = $this->request->name;
        $this->event->price = $this->request->price;
        $this->event->event_date = $this->request->event_date;
        $this->event->is_open = $this->request->is_open;
        $this->event->status = $this->request->status;
        $this->event->open_order_date = $this->request->open_order_date;
        $this->event->creator_id = auth()->guard('api')->user()->id;
        return $this;
    }

    public function update()
    {
        $this->event->name = $this->request->name;
        $this->event->price = $this->request->price;
        $this->event->event_date = $this->request->event_date;
        $this->event->is_open = $this->request->is_open;
        $this->event->status = $this->request->status;
        $this->event->open_order_date = $this->request->open_order_date;
        return $this;
    }

    public function delete()
    {
       $this->event->delete();
       return $this;
    }

    public function execute()
    {   
        if ($this->isError)
        {
            return $this->response->responseObject(false, $this->event);
        }

        if ($this->request == null)
        {
            return $this->response->responseObject(true, $this->event);
        }

        $execute = $this->event->save();
        
        if ($execute) {
            return $this->response->responseObject(true, $this->event);
        }
        return $this->response->responseObject(false, $this->event);
    }
}

?>