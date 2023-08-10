<?php

namespace App\Http\Controllers;

use App\Applications\UserApplication;
use App\Constants\UserRoleConstant;
use App\Infastructures\Response;
use App\Repositories\UserRepository;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $userApplication;
    protected $userRepository;
    protected $response;
    public function __construct(
        UserApplication $userApplication,
        UserRepository $userRepository,
        Response $response)
    {
        $this->userApplication = $userApplication;
        $this->userRepository = $userRepository;
        $this->response = $response;
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $request=(object)[
            "name" => $googleUser->name,
            "email" => $googleUser->email,
            "user_type" => "customer",
            "password" => $googleUser->id.$googleUser->email,
        ];        

        if (!isset($this->userRepository->findByEmail($googleUser->email)->email))
        {
            $this->userApplication
                ->preparation($request)
                ->create()
                ->execute();
        }

        $credentials = [
            "email" => $googleUser->email,
            "password" => $googleUser->id.$googleUser->email,
        ];        
        
        //if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return $this->response->errorResponse("Failed login using google account");
        }
        
        //if auth success
        return response()->json([
            'success' => true,
            'data'    => auth()->guard('api')->user(),    
            'token'   => $token   
        ], 200);
    }
}
