<?php

namespace App\Applications;

use App\Infastructures\Response;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;

class TransactionApplication
{
    // Repository
    protected $transactionRepository;

    // Infrastructure
    protected $response;

    // Variables
    private $transaction;
    private $request;
    private $session;

    public function __construct(TransactionRepository $transactionRepository, Response $response)
    {
        $this->transactionRepository = $transactionRepository;
        $this->response = $response;
    }

    public function preparation($request, $userId = null)
    {
        if ($userId != null)
        {
            $this->transaction = $this->transactionRepository->findById($userId);
        }
        else
        {
            $this->transaction = new Transaction;
        }

        $this->request = $request;
        return $this;
    }

    public function create()
    {
        $this->transaction->event_id = $this->request->event_id;
        $this->transaction->buyer_id = auth()->guard('api')->user()->id;
        $this->transaction->is_paid = false;
        return $this;
    }

    public function pay()
    {
        $this->transaction->is_paid = true;
        return $this;
    }

    public function execute()
    {   
        if ($this->request == null)
        {
            return $this->response->responseObject(true, $this->transaction);
        }

        $execute = $this->transaction->save();
        
        if ($execute) {
            return $this->response->responseObject(true, $this->transaction);
        }
        return $this->response->responseObject(false, $this->transaction);
    }
}

?>