<?php

namespace App\Services\Authentification;

use App\Services\Authentification\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;

class PassportAuthService implements AuthServiceInterface
{
    public function login($email, $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response()->json(['token' => $token, 'user local' => $user], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout($token)
    {
        if ($user = Auth::guard('api')->user()) {
            $user->token()->revoke();
            return response()->json(['message' => 'Logged out from Passport'], 200);
        } else {
            return response()->json(['error' => 'Unable to logout'], 500);
        }
    }

    public function refresh($token){

    }
}
