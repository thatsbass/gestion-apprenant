<?php

namespace App\Services\Authentification;

use App\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;

class PassportAuthService implements AuthServiceInterface
{
    public function login($email, $password)
    {
    //   dd($email, $password);
        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $user = Auth::user();
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        }
        return response()->json(['error' => 'Email or password is incorrect'], 401);
    }

    public function logout($token)
    {
        // Revoke the token
        if ($user = Auth::guard('api')->user()) {
            $user->token()->revoke(); 

            return response()->json(['message' => 'Logged out from Passport'], 200);
        }

        return response()->json(['error' => 'Unable to logout'], 500);
    }
}
