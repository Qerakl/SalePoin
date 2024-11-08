<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['message' => 'Login successful'])
            ->cookie('token', $token, 60 * 24, '/', null, true, true);
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
        $newToken = auth()->refresh();
        return response()->json([
            'status' => 'success',
            'message' => 'Token refreshed successfully',
            'token' => $newToken
        ])->cookie('token', $newToken, 60 * 24, '/', null, true, true);
    }


}
