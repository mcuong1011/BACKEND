<?php

namespace App\Http\Controllers;


use App\Exceptions\ApiException;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends APIController
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(RegisterRequest $request)
    {
        $credentials = $request->only(["email", "password"]);
        $user = User::create([
            "uuid" => Str::uuid(),
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "is_admin" => false,
        ]);
        return $this->respondWithToken(Auth::attempt($credentials));
    }

    /**
     * @throws ApiException
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            throw new ApiException("Unauthorized", 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user'=> auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
