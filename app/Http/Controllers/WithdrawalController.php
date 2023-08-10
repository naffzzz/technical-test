<?php

namespace App\Http\Controllers;

use App\Applications\WithdrawalApplication;
use App\Infastructures\Response;
use App\Repositories\WithdrawalRepository;
use App\Validations\WithdrawalValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class WithdrawalController extends Controller
{
    protected $withdrawalApplication;
    protected $withdrawalRepository;
    protected $response;

    public function __construct(
        WithdrawalApplication $withdrawalApplication,
        WithdrawalRepository $withdrawalRepository,
        Response $response)
    {
        $this->withdrawalApplication = $withdrawalApplication;
        $this->withdrawalRepository = $withdrawalRepository;
        $this->response = $response;
    }

    public function add(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), WithdrawalValidation::withdrawalRule);

        //if validation fails
        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        //create bank account
        $withdrawal = $this->withdrawalApplication
            ->preparation($request)
            ->create()
            ->decreaseWalletBalance()
            ->execute();

        //return response JSON bank account is created
        if($withdrawal->original['status']) {
            return $this->response->successResponse("Successfully add withdrawal data", $withdrawal->original['data']);
        }

        //return JSON process insert failed 
        return $this->response->errorResponse("Failed add withdrawal data");
    }

    public function index()
    {
        $withdrawals = $this->withdrawalRepository->index();
        return $this->response->successResponse("Successfully get withdrawals data", $withdrawals);
    }

    public function userIndex()
    {
        $withdrawals = $this->withdrawalRepository->findByUserId(auth()->guard('api')->user()->id);
        return $this->response->successResponse("Successfully get withdrawals data", $withdrawals);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($withdrawalId)
    {
        $withdrawals = $this->withdrawalRepository->findById($withdrawalId);
        return $this->response->successResponse("Successfully get withdrawal data", $withdrawals);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $withdrawalId)
    {
        $update = $this->withdrawalApplication
            ->preparation($request, $withdrawalId)
            ->update()
            ->execute();

        if ($update->original['status'])
        {
            return $this->response->successResponse("Successfully update bank account data", $update->original['data']); 
        }
        
        return $this->response->errorResponse("Failed update bank account data"); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($withdrawalId)
    {
        $delete = $this->withdrawalApplication
            ->preparation(null, $withdrawalId)
            ->delete()
            ->execute();

        if ($delete->original['status'])
        {
            return $this->response->successResponse("Successfully delete bank account data", $delete->original['data']); 
        }
        
        return $this->response->errorResponse("Failed delete bank account data"); 
    }
}