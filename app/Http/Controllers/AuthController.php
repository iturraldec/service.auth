<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Custom\ResponseDataRequest;

class AuthController extends Controller
{
    private $_response;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->_response = new ResponseDataRequest();
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        $token = auth()->claims(['roles' => 'operador de tf'])->attempt($credentials);
        if (! $token) {
            $this->_response->setResponse('0', 'No esta autorizado.');

            return response($this->_response->getJson(), 401);
        }

        $this->_response->setResponse('1', 'Token de autorización.', $this->respondWithToken($token));

        return response($this->_response->getJson(), 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token object structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $response = new \stdClass();
        
        $response->access_token = $token;
        $response->token_type   = 'bearer';
        $response->expires_in   = auth()->factory()->getTTL() * 60;

        return $response;
    }
}