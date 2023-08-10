<?php

namespace App\Applications;

use App\Infastructures\Response;
use App\Models\BankAccount;
use App\Repositories\BankRepository;
use App\Repositories\BankAccountRepository;
use App\Models\Bank;

class BankAccountApplication
{
    // Repository
    protected $bankRepository;
    protected $bankAccountRepository;

    // Infrastructure
    protected $response;

    // Variables
    private $bank;
    private $bankAccount;
    private $request;
    private $session;

    public function __construct(
        BankRepository $bankRepository, 
        BankAccountRepository $bankAccountRepository,
        Response $response)
    {
        $this->bankRepository = $bankRepository;
        $this->bankAccountRepository = $bankAccountRepository;
        $this->response = $response;
    }

    public function preparation($request, $bankAccountId = null)
    {
        if ($bankAccountId != null)
        {
            $this->bankAccount = $this->bankAccountRepository->findById($bankAccountId);
        }
        else
        {
            $this->bankAccount = new BankAccount;
        }

        $this->request = $request;
        return $this;
    }

    public function create()
    {
        $this->bankAccount->full_name = $this->request->full_name;
        $this->bankAccount->account_number = $this->request->account_number;
        $this->bankAccount->bank_id = $this->request->bank_id;
        $this->bankAccount->user_id = auth()->guard('api')->user()->id;
        $this->bankAccount->balance = 0;
        return $this;
    }

    public function update()
    {
        $this->bankAccount->full_name = $this->request->full_name;
        $this->bankAccount->account_number = $this->request->account_number;
        $this->bankAccount->bank_id = $this->request->bank_id;
        return $this;
    }

    public function delete()
    {
       $this->bankAccount->delete();
       return $this;
    }

    public function execute()
    {   
        if ($this->request == null)
        {
            return $this->response->responseObject(true, $this->bankAccount);
        }

        $execute = $this->bankAccount->save();
        
        if ($execute) {
            return $this->response->responseObject(true, $this->bankAccount);
        }
        return $this->response->responseObject(false, $this->bankAccount);
    }
}

?>