<?php

namespace App\Http\Controllers;

use App\Infastructures\Response;
use App\Applications\UserTypeApplication;
use App\Repositories\UserTypeRepository;
use App\Validations\UserTypeValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTypeController extends Controller
{
    protected $userTypeApplication;
    protected $userTypeRepository;
    protected $response;

    public function __construct(
        UserTypeApplication $userTypeApplication,
        UserTypeRepository $userTypeRepository,
        Response $response)
    {
        $this->userTypeApplication = $userTypeApplication;
        $this->userTypeRepository = $userTypeRepository;
        $this->response = $response;
    }

    public function add(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), UserTypeValidation::userTypeRule);

        //if validation fails
        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        //create user type
        $userType = $this->userTypeApplication
            ->preparation($request)
            ->create()
            ->execute();

        //return response JSON user is created
        if($userType->original['status']) {
            return $this->response->successResponse("Successfully add user type data", $userType->original['data']);
        }

        //return JSON process insert failed 
        return $this->response->errorResponse("Failed add user type data");
    }

    public function index()
    {
        $userTypes = $this->userTypeRepository->index();
        return $this->response->successResponse("Successfully get user types data", $userTypes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($userId)
    {
        $users = $this->userTypeRepository->findById($userId);
        return $this->response->successResponse("Successfully get user type data", $users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $userTypeId)
    {
        //set validation
        $validator = Validator::make($request->all(), UserTypeValidation::userTypeRule);

        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        $update = $this->userTypeApplication
            ->preparation($request, $userTypeId)
            ->update()
            ->execute();

        if ($update->original['status'])
        {
            return $this->response->successResponse("Successfully update user type data", $update->original['data']); 
        }
        
        return $this->response->errorResponse("Failed update user type data"); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($userId)
    {
        $delete = $this->userTypeApplication
            ->preparation(null, $userId)
            ->delete()
            ->execute();

        if ($delete->original['status'])
        {
            return $this->response->successResponse("Successfully delete user type data", $delete->original['data']); 
        }
        
        return $this->response->errorResponse("Failed delete user type data"); 
    }
}