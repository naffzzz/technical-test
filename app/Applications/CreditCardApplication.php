<?php

namespace App\Applications;

use App\Infastructures\Response;
use App\Models\CreditCard;
use App\Repositories\CreditCardRepository;

class CreditCardApplication
{
    // Repository
    protected $creditCardRepository;

    // Infrastructure
    protected $response;

    // Variables
    private $creditCard;
    private $request;
    private $session;

    public function __construct(
        CreditCardRepository $creditCardRepository,
        Response $response)
    {
        $this->creditCardRepository = $creditCardRepository;
        $this->response = $response;
    }

    public function preparation($request, $creditCardId = null)
    {
        if ($creditCardId != null)
        {
            $this->creditCard = $this->creditCardRepository->findById($creditCardId);
        }
        else
        {
            $this->creditCard = new CreditCard;
        }

        $this->request = $request;
        return $this;
    }

    public function create()
    {
        $this->creditCard->card_number = $this->request->card_number;
        $this->creditCard->cvv = $this->request->cvv;
        $this->creditCard->month = $this->request->month;
        $this->creditCard->year = $this->request->year;
        $this->creditCard->user_id = auth()->guard('api')->user()->id;
        return $this;
    }

    public function update()
    {
        $this->creditCard->card_number = $this->request->card_number;
        $this->creditCard->cvv = $this->request->cvv;
        $this->creditCard->month = $this->request->month;
        $this->creditCard->year = $this->request->year;
        return $this;
    }

    public function delete()
    {
       $this->creditCard->delete();
       return $this;
    }

    public function execute()
    {   
        if ($this->request == null)
        {
            return $this->response->responseObject(true, $this->creditCard);
        }

        $execute = $this->creditCard->save();
        
        if ($execute) {
            return $this->response->responseObject(true, $this->creditCard);
        }
        return $this->response->responseObject(false, $this->creditCard);
    }
}

?>