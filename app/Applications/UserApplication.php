<?php

namespace App\Applications;

use App\Infastructures\Response;
use App\Repositories\UserRepository;
use App\Models\User;

class UserApplication
{
    // Repository
    protected $userRepository;

    // Infrastructure
    protected $response;

    // Variables
    private $user;
    private $request;
    private $session;

    public function __construct(UserRepository $userRepository, Response $response)
    {
        $this->userRepository = $userRepository;
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
        $this->user->role = $this->request->role;
        return $this;
    }

    public function update()
    {
        $this->user->name = $this->request->name;
        $this->user->email = $this->request->email;
        if (isset($this->request->role))
        {
            $this->user->role = $this->request->role;
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