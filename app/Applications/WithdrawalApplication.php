<?php

namespace App\Applications;

use App\Infastructures\Response;
use App\Repositories\WalletRepository;
use App\Repositories\WithdrawalRepository;
use App\Models\Withdrawal;

class WithdrawalApplication
{
    // Repository
    protected $withdrawalRepository;
    protected $walletRepository;

    // Infrastructure
    protected $response;

    // Variables
    private $withdrawal;
    private $bankAccount;
    private $wallet;
    private $request;
    private $session;

    public function __construct(
        WithdrawalRepository $withdrawalRepository, 
        WalletRepository $walletRepository,
        Response $response)
    {
        $this->withdrawalRepository = $withdrawalRepository;
        $this->walletRepository = $walletRepository;
        $this->response = $response;
    }

    public function preparation($request, $withdrawalId = null)
    {
        if ($withdrawalId != null)
        {
            $this->withdrawal = $this->withdrawalRepository->findById($withdrawalId);
        }
        else
        {
            $this->withdrawal = new Withdrawal;
        }

        $this->request = $request;
        return $this;
    }

    public function create()
    {
        $this->withdrawal->bank_account_id = $this->request->bank_account_id;
        $this->withdrawal->user_id = auth()->guard('api')->user()->id;
        $this->withdrawal->value = $this->request->value;
        $this->withdrawal->status = "on progress";
        return $this;
    }

    public function decreaseWalletBalance()
    {
        $this->wallet = $this->walletRepository->findByUserId(auth()->guard('api')->user()->id);
        $this->wallet->balance = $this->wallet->balance - $this->request->value;
        return $this;
    }

    public function update()
    {
        $this->withdrawal->status = "success";
        return $this;
    }

    public function delete()
    {
       $this->withdrawal->delete();
       return $this;
    }

    public function execute()
    {   
        if ($this->request == null)
        {
            return $this->response->responseObject(true, $this->withdrawal);
        }

        $execute = $this->withdrawal->save();
        if (isset($this->wallet)) {
            $this->wallet->save();
        }
        if ($execute) {
            return $this->response->responseObject(true, $this->withdrawal);
        }
        return $this->response->responseObject(false, $this->withdrawal);
    }
}

?>