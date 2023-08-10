<?php

namespace App\Http\Controllers;

use App\Applications\BankApplication;
use App\Infastructures\Response;
use App\Repositories\BankRepository;
use App\Validations\BankValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class BankController extends Controller
{
    protected $bankApplication;
    protected $bankRepository;
    protected $response;

    public function __construct(
        BankApplication $bankApplication,
        BankRepository $bankRepository,
        Response $response)
    {
        $this->bankApplication = $bankApplication;
        $this->bankRepository = $bankRepository;
        $this->response = $response;
    }

    public function add(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), BankValidation::bankRule);

        //if validation fails
        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        //create bank
        $bank = $this->bankApplication
            ->preparation($request)
            ->create()
            ->execute();

        //return response JSON user is created
        if($bank->original['status']) {
            return $this->response->successResponse("Successfully add bank data", $bank->original['data']);
        }

        //return JSON process insert failed 
        return $this->response->errorResponse("Failed add bank data");
    }

    public function index()
    {
        $banks = $this->bankRepository->index();
        return $this->response->successResponse("Successfully get banks data", $banks);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($bankId)
    {
        $banks = $this->bankRepository->findById($bankId);
        return $this->response->successResponse("Successfully get bank data", $banks);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $bankId)
    {
        //set validation
        $validator = Validator::make($request->all(), BankValidation::bankRule);

        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        $update = $this->bankApplication
            ->preparation($request, $bankId)
            ->update()
            ->execute();

        if ($update->original['status'])
        {
            return $this->response->successResponse("Successfully update bank data", $update->original['data']); 
        }
        
        return $this->response->successResponse("Failed update bank data", $update->original['data']); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($bankId)
    {
        $delete = $this->bankApplication
            ->preparation(null, $bankId)
            ->delete()
            ->execute();

        if ($delete->original['status'])
        {
            return $this->response->successResponse("Successfully delete bank data", $delete->original['data']); 
        }
        
        return $this->response->successResponse("Failed delete bank data", $delete->original['data']); 
    }
}