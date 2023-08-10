<?php

namespace App\Http\Controllers;

use App\Applications\BankAccountApplication;
use App\Infastructures\Response;
use App\Repositories\BankAccountRepository;
use App\Validations\BankAccountValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class BankAccountController extends Controller
{
    protected $bankAccountApplication;
    protected $bankAccountRepository;
    protected $response;

    public function __construct(
        BankAccountApplication $bankAccountApplication,
        BankAccountRepository $bankAccountRepository,
        Response $response)
    {
        $this->bankAccountApplication = $bankAccountApplication;
        $this->bankAccountRepository = $bankAccountRepository;
        $this->response = $response;
    }

    public function add(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), BankAccountValidation::bankAccountRule);

        //if validation fails
        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        //create bank account
        $bankAccount = $this->bankAccountApplication
            ->preparation($request)
            ->create()
            ->execute();

        //return response JSON bank account is created
        if($bankAccount->original['status']) {
            return $this->response->successResponse("Successfully add bank account data", $bankAccount->original['data']);
        }

        //return JSON process insert failed 
        return $this->response->errorResponse("Failed add bank account data");
    }

    public function index()
    {
        $bankAccounts = $this->bankAccountRepository->index();
        return $this->response->successResponse("Successfully get bank accounts data", $bankAccounts);
    }

    public function userIndex()
    {
        $banks = $this->bankAccountRepository->findByUserId(auth()->guard('api')->user()->id);
        return $this->response->successResponse("Successfully get bank accounts data", $banks);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($bankAccountId)
    {
        $banks = $this->bankAccountRepository->findById($bankAccountId);
        return $this->response->successResponse("Successfully get bank account data", $banks);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $bankAccountId)
    {
        //set validation
        $validator = Validator::make($request->all(), BankAccountValidation::bankAccountRule);

        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        $update = $this->bankAccountApplication
            ->preparation($request, $bankAccountId)
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
    public function destroy($bankAccountId)
    {
        $delete = $this->bankAccountApplication
            ->preparation(null, $bankAccountId)
            ->delete()
            ->execute();

        if ($delete->original['status'])
        {
            return $this->response->successResponse("Successfully delete bank account data", $delete->original['data']); 
        }
        
        return $this->response->errorResponse("Failed delete bank account data"); 
    }
}