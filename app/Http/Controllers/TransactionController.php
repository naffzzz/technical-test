<?php

namespace App\Http\Controllers;

use App\Applications\TransactionApplication;
use App\Infastructures\Response;
use App\Repositories\TransactionRepository;
use App\Validations\TransactionValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionController extends Controller
{
    protected $transactionApplication;
    protected $transactionRepository;
    protected $response;

    public function __construct(
        TransactionApplication $transactionApplication,
        TransactionRepository $transactionRepository,
        Response $response)
    {
        $this->transactionApplication = $transactionApplication;
        $this->transactionRepository = $transactionRepository;
        $this->response = $response;
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), TransactionValidation::transactionRule);

        //if validation fails
        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        //create user type
        $userType = $this->transactionApplication
            ->preparation($request)
            ->create()
            ->execute();

        //return response JSON user is created
        if($userType->original['status']) {
            return $this->response->successResponse("Successfully add transaction data", $userType->original['data']);
        }

        //return JSON process insert failed 
        return $this->response->errorResponse("Failed add transaction data");
    }

    public function index()
    {
        $transactions = $this->transactionRepository->index();
        return $this->response->successResponse("Successfully get transactions data", $transactions);
    }

    public function userIndex()
    {
        $transactions = $this->transactionRepository->findByBuyerId(auth()->guard('api')->user()->id);
        return $this->response->successResponse("Successfully get transactions data", $transactions);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($transactionId)
    {
        $transaction = $this->transactionRepository->findById($transactionId);
        return $this->response->successResponse("Successfully get transaction data", $transaction);
    }

    public function payTransaction(Request $request, $transactionId)
    {
        $update = $this->transactionApplication
            ->preparation($request, $transactionId)
            ->pay()
            ->topUpWallet()
            ->generateQrCode()
            ->execute();

        if ($update->original['status'])
        {
            return $this->response->successResponse("Successfully pay transaction data", $update->original['data']); 
        }
        
        return $this->response->errorResponse("Failed pay transaction data"); 
        
    }

    public function returnTransaction(Request $request, $transactionId)
    {
        //set validation
        $validator = Validator::make($request->all(), TransactionValidation::transactionRule);

        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        $update = $this->transactionApplication
            ->preparation($request, $transactionId)
            ->return()
            ->execute();

        if ($update->original['status'])
        {
            return $this->response->successResponse("Successfully return transaction data", $update->original['data']); 
        }
        
        return $this->response->errorResponse("Failed return transaction data"); 
        
    }
}