<?php

namespace App\Applications;

use App\Infastructures\Response;
use App\Repositories\BankRepository;
use App\Models\Bank;

class BankApplication
{
    // Repository
    protected $bankRepository;

    // Infrastructure
    protected $response;

    // Variables
    private $bank;
    private $request;
    private $session;

    public function __construct(BankRepository $bankRepository, Response $response)
    {
        $this->bankRepository = $bankRepository;
        $this->response = $response;
    }

    public function preparation($request, $bankId = null)
    {
        if ($bankId != null)
        {
            $this->bank = $this->bankRepository->findById($bankId);
        }
        else
        {
            $this->bank = new Bank;
        }

        $this->request = $request;
        return $this;
    }

    public function create()
    {
        $this->bank->name = $this->request->name;
        return $this;
    }

    public function update()
    {
        $this->bank->name = $this->request->name;
        return $this;
    }

    public function delete()
    {
       $this->bank->delete();
       return $this;
    }

    public function execute()
    {   
        if ($this->request == null)
        {
            return $this->response->responseObject(true, $this->bank);
        }

        $execute = $this->bank->save();
        
        if ($execute) {
            return $this->response->responseObject(true, $this->bank);
        }
        return $this->response->responseObject(false, $this->bank);
    }
}

?>