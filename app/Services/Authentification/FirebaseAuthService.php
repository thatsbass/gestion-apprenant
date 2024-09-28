<?php

namespace App\Services\Authentification;

// use Kreait\Firebase\Auth as FirebaseAuth;
// use Kreait\Firebase\Factory;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Contracts\AuthServiceInterface;
use App\Facade\UserFirebaseFacade as User;

class FirebaseAuthService implements AuthServiceInterface
{
    protected $auth;

    public function __construct()
    {
        // $this->credentials = env('FIREBASE_CREDENTIALS');
        $this->auth = Firebase::auth();
    }

   
    public function login($email, $password)
    {
        try {
            // Sign in using Firebase Auth
            $signInResult = $this->auth->signInWithEmailAndPassword($email, $password);
            $idToken = $signInResult->idToken(); // Get the generated ID token
            $uid = $signInResult->firebaseUserId(); // Use the correct method to get the UID
            $user = User::find($uid);
            // dd($user);
            if (!$user) {
                return response()->json(['error' => 'User not found in local database'], 404);
            }

            return response()->json([
                'token' => $idToken,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Firebase login failed: ' . $e->getMessage()], 401);
        }
    }

 
    public function logout($token)
    {
        try {
            $verifiedToken = $this->firebaseAuth->verifyIdToken($token);
            $uid = $verifiedToken->claims()->get('sub');
            $this->firebaseAuth->revokeRefreshTokens($uid);

            return response()->json(['message' => 'Logged out from Firebase'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Firebase logout failed: ' . $e->getMessage()], 500);
        }
    }
}
