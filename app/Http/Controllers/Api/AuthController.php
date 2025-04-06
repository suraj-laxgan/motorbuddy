<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
      
        try {
                $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);
                $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = JWTAuth::fromUser($user);

            $this->response['success'] = true;
            $this->response['message'] = 'User successfully registered !';
            $this->response['data'] = $user;
            return response()->json($this->response);
        } catch (\Exception $e) {
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response);
        }
    }

    // Login the user and return a JWT token
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if ($token = Auth::attempt($credentials)) {
            // return response()->json(['token' => $token]);
            return $this->createNewToken($token);

        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Get the authenticated user
    public function me()
    {
        return response()->json(Auth::user());
    }

    // Logout the user (invalidate token)
    public function logout()
    {
        try {
            Auth::logout();
            $this->response['success'] = true;
            $this->response['message'] = 'Logged out successfully';
            return response()->json($this->response);
        } catch (\Exception $e) {
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response);
        }
    }

     /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            return $this->createNewToken(auth()->refresh());
        } catch (\Exception $e) {
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
