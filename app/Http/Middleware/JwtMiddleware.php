<?php

namespace App\Http\Middleware;

use Closure;
use App\Infastructures\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    private $response;

    public function __construct(
        Response $response)
    {
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
            return $next($request);
        }
        catch (\Exception $e)
        {
            return $this->response->errorResponse('Token has expired');
        }
    }
}
