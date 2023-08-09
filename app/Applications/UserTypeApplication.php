<?php

namespace App\Applications;

use App\Infastructures\Response;
use App\Repositories\UserTypeRepository;
use App\Models\UserType;

class UserTypeApplication
{
    // Repository
    protected $userRepository;

    // Infrastructure
    protected $response;

    // Variables
    private $userType;
    private $request;
    private $session;

    public function __construct(UserTypeRepository $userTypeRepository, Response $response)
    {
        $this->userRepository = $userTypeRepository;
        $this->response = $response;
    }

    public function preparation($request, $userId = null)
    {
        if ($userId != null)
        {
            $this->userType = $this->userRepository->findById($userId);
        }
        else
        {
            $this->userType = new UserType;
        }

        $this->request = $request;
        return $this;
    }

    public function create()
    {
        $this->userType->name = $this->request->name;
        return $this;
    }

    public function update()
    {
        $this->userType->name = $this->request->name;
        return $this;
    }

    public function delete()
    {
       $this->userType->delete();
       return $this;
    }

    public function execute()
    {   
        if ($this->request == null)
        {
            return $this->response->responseObject(true, $this->userType);
        }

        $execute = $this->userType->save();
        
        if ($execute) {
            return $this->response->responseObject(true, $this->userType);
        }
        return $this->response->responseObject(false, $this->userType);
    }
}

?>