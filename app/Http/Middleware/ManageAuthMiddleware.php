<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class ManageAuthMiddleware
// {
//     protected $firebaseAuth;

//     public function __construct()
//     {
//         $this->firebaseAuth = app('AuthService');
//     }

//     public function handle(Request $request, Closure $next)
//     {
//         $authMethod = env('AUTH_DRIVER','');

//         if ($authMethod === 'firebase') {
//             return $this->handleFirebaseAuth($request, $next);
//         } elseif ($authMethod === 'passport') {
//             return $this->handlePassportAuth($request, $next);
//         }

//         return response()->json(['error' => 'Invalid authentication method'], 500);
//     }

//     protected function handleFirebaseAuth(Request $request, Closure $next)
//     {
//         $idTokenString = $request->bearerToken();
//         if (!$idTokenString) {
//             return response()->json(['error' => 'No token provided'], 401);
//         }

//         try {
//             $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idTokenString);
//             $firebaseUid = $verifiedIdToken->claims()->get('sub');
//             $user = $this->firebaseAuth->getUser($firebaseUid);
//             $request->attributes->set('firebaseUser', $user);
//             $request->attributes->set('firebaseToken', $idTokenString);
//         } catch (\Exception $e) {
//             return response()->json(['error' => 'Invalid Firebase token: ' . $e->getMessage()], 401);
//         }

//         return $next($request);
//     }

//     protected function handlePassportAuth(Request $request, Closure $next)
//     {
//         if (!Auth::guard('api')->check()) {
//             return response()->json(['error' => 'Invalid Passport token'], 401);
//         }

//         return $next($request);
//     }
// }
