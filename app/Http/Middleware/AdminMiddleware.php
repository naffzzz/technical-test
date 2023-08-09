<?php

namespace App\Http\Middleware;

use App\Constants\UserRoleConstant;
use App\Repositories\UserTypeRepository;
use Closure;
use App\Infastructures\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
{
    private $response;
    private $userTypeRepository;

    public function __construct(
        UserTypeRepository $userTypeRepository,
        Response $response)
    {
        $this->userTypeRepository = $userTypeRepository;
        $this->response = $response;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            $token = JWTAuth::parseToken();
            $payload = $token->getPayload();
    
            if (isset($token) && $payload->get('exp') < time()) {
                return $this->response->errorResponse('Token has expired');
            }
            
            $userType = $this->userTypeRepository->findById(auth()->guard('api')->user()->type_id);
            if (isset($userType) && $userType->name == UserRoleConstant::Admin)
            {
                return $next($request);
            }

            return $this->response->errorResponse('You are not eligible to do this');
        }
        catch (\Exception $e)
        {
            return $this->response->errorResponse('You are not eligible to do this');
        }
    }
}
