<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->all($request);
        
        return response()->json($users);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        // dd($data);
        $data['photo'] = $request->file('photo')->store('photos/users', 'public');
        $user = $this->userService->create($data);
        return response()->json($user, 201);
    }


}