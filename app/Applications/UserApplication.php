<?php

namespace App\Applications;

use App\Infastructures\Response;
use App\Repositories\UserRepository;
use App\Models\User;
use App\Repositories\UserTypeRepository;

class UserApplication
{
    // Repository
    protected $userRepository;
    protected $userTypeRepository;

    // Infrastructure
    protected $response;

    // Variables
    private $user;
    private $request;
    private $session;
    private $isError;

    public function __construct(
        UserRepository $userRepository, 
        UserTypeRepository $userTypeRepository,
        Response $response)
    {
        $this->isError = false;
        $this->userRepository = $userRepository;
        $this->userTypeRepository = $userTypeRepository;
        $this->response = $response;
    }

    public function preparation($request, $userId = null)
    {
        if ($userId != null)
        {
            $this->user = $this->userRepository->findById($userId);
        }
        else
        {
            $this->user = new User;
        }

        $this->request = $request;
        return $this;
    }

    public function create()
    {
        $this->user->name = $this->request->name;
        $this->user->email = $this->request->email;
        $this->user->password = bcrypt($this->request->password);

        $userType = $this->userTypeRepository->findByName($this->request->user_type);
        if ($userType == null)
        {
            $this->isError = true;
            return $this;
        }
        $this->user->type_id = $userType->id;
        return $this;
    }

    public function update()
    {
        $this->user->name = $this->request->name;
        $this->user->email = $this->request->email;
        if (isset($this->request->user_type))
        {
            $userType = $this->userTypeRepository->findByName($this->request->user_type);
            if ($userType == null)
            {
                $this->isError = true;
                return $this;
            }
            $this->user->type_id = $userType->id;
            return $this;
        }
        return $this;
    }

    public function delete()
    {
       $this->user->delete();
       return $this;
    }

    public function execute()
    {   
        if ($this->isError)
        {
            return $this->response->responseObject(false, $this->user);
        }

        if ($this->request == null)
        {
            return $this->response->responseObject(true, $this->user);
        }

        $execute = $this->user->save();
        
        if ($execute) {
            return $this->response->responseObject(true, $this->user);
        }
        return $this->response->responseObject(false, $this->user);
    }
}

?>