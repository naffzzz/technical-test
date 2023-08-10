<?php

namespace App\Http\Controllers;

use App\Applications\CreditCardApplication;
use App\Infastructures\Response;
use App\Repositories\CreditCardRepository;
use App\Validations\CreditCardValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreditCardController extends Controller
{
    protected $creditCardApplication;
    protected $creditCardRepository;
    protected $response;

    public function __construct(
        CreditCardApplication $creditCardApplication,
        CreditCardRepository $creditCardRepository,
        Response $response)
    {
        $this->creditCardApplication = $creditCardApplication;
        $this->creditCardRepository = $creditCardRepository;
        $this->response = $response;
    }

    public function add(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), CreditCardValidation::creditCardRule);
        
        //if validation fails
        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        //create credit card
        $creditCard = $this->creditCardApplication
            ->preparation($request)
            ->create()
            ->execute();

        //return response JSON credit card is created
        if($creditCard->original['status']) {
            return $this->response->successResponse("Successfully add credit card data", $creditCard->original['data']);
        }

        //return JSON process insert failed 
        return $this->response->errorResponse("Failed add credit card data");
    }

    public function index()
    {
        $creditCards = $this->creditCardRepository->index();
        return $this->response->successResponse("Successfully get credit cards data", $creditCards);
    }

    public function userIndex()
    {
        $creditCards = $this->creditCardRepository->findByUserId(auth()->guard('api')->user()->id);
        return $this->response->successResponse("Successfully get credit cards data", $creditCards);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($creditCardId)
    {
        $creditCards = $this->creditCardRepository->findById($creditCardId);
        return $this->response->successResponse("Successfully get credit card data", $creditCards);
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
        $validator = Validator::make($request->all(), CreditCardValidation::creditCardRule);

        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        $update = $this->creditCardApplication
            ->preparation($request, $bankAccountId)
            ->update()
            ->execute();

        if ($update->original['status'])
        {
            return $this->response->successResponse("Successfully update credit card data", $update->original['data']); 
        }
        
        return $this->response->errorResponse("Failed update credit card data"); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($bankAccountId)
    {
        $delete = $this->creditCardApplication
            ->preparation(null, $bankAccountId)
            ->delete()
            ->execute();

        if ($delete->original['status'])
        {
            return $this->response->successResponse("Successfully delete credit card data", $delete->original['data']); 
        }
        
        return $this->response->errorResponse("Failed delete credit card data"); 
    }
}