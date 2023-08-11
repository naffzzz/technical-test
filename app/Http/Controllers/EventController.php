<?php

namespace App\Http\Controllers;

use App\Applications\EventApplication;
use App\Infastructures\Response;
use App\Repositories\EventRepository;
use App\Validations\EventValidation;
use App\Validations\UserValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class EventController extends Controller
{
    protected $eventApplication;
    protected $eventRepository;
    protected $response;

    public function __construct(
        EventApplication $eventApplication,
        EventRepository $eventRepository,
        Response $response)
    {
        $this->eventApplication = $eventApplication;
        $this->eventRepository = $eventRepository;
        $this->response = $response;
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), EventValidation::eventRule);

        //if validation fails
        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        //create user
        $user = $this->eventApplication
            ->preparation($request)
            ->create()
            ->execute();

        //return response JSON user is created
        if($user->original['status']) {
            return $this->response->successResponse("Successfully add event data", $user->original['data']);
        }

        //return JSON process insert failed 
        return $this->response->errorResponse("Failed add event data");
    }

    public function index(Request $request)
    {
        $events = $this->eventRepository->index($request);
        return $this->response->successResponse("Successfully get events data", $events);
    }

    public function userIndex(Request $request)
    {
        $events = $this->eventRepository->findByCreatorId(auth()->guard('api')->user()->id);
        return $this->response->successResponse("Successfully get events data", $events);
    }

    public function sellEvent(Request $request)
    {
        $sellEvents = (object)["total sell " => $this->eventRepository->findByCreatorId(auth()->guard('api')->user()->id)->sum('sell')];

        return $this->response->successResponse("Successfully get events data", $sellEvents);
    }

    public function returnEvent(Request $request)
    {
        $returnEvents = (object)["total return " => $this->eventRepository->findByCreatorId(auth()->guard('api')->user()->id)->sum('return')];
        return $this->response->successResponse("Successfully get events data", $returnEvents);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($eventId)
    {
        $events = $this->eventRepository->findById($eventId);
        return $this->response->successResponse("Successfully get event data", $events);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $eventId)
    {
        //set validation
        $validator = Validator::make($request->all(), EventValidation::eventRule);

        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        $update = $this->eventApplication
            ->preparation($request, $eventId)
            ->update()
            ->execute();

        if ($update->original['status'])
        {
            return $this->response->successResponse("Successfully update event data", $update->original['data']); 
        }
        
        return $this->response->errorResponse("Failed update event data"); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($eventId)
    {
        $delete = $this->eventApplication
            ->preparation(null, $eventId)
            ->delete()
            ->execute();

        if ($delete->original['status'])
        {
            return $this->response->successResponse("Successfully delete event data", $delete->original['data']); 
        }
        
        return $this->response->errorResponse("Failed delete event data"); 
    }
}