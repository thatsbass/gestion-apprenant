<?php

namespace App\Services\Authentification;

use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Factory;
use App\Contracts\AuthServiceInterface;
use App\Facade\UserFirebaseFacade as User;

class FirebaseAuthService implements AuthServiceInterface
{
    protected $firebaseAuth;
    protected $credentials;

    public function __construct()
    {
        $this->credentials = env('FIREBASE_CREDENTIALS');
        $this->firebaseAuth = (new Factory)
        ->withServiceAccount($this->credentials)
        ->withProjectId(env('FIREBASE_PROJECT_ID'))
        ->createAuth();
    }

   
    public function login($email, $password)
    {
        try {
            // Sign in using Firebase Auth
            $signInResult = $this->firebaseAuth->signInWithEmailAndPassword($email, $password);

            $idToken = $signInResult->idToken();
            $user = User::find($signInResult->firebaseUserId());

            if (!$user) {
                return response()->json(['error' => 'User not found in local database'], 404);
            }

            return response()->json([
                'token' => $idToken,
                'user' => $user->toArray(),
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
