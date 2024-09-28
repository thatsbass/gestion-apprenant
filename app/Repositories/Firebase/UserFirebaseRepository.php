<?php

namespace App\Repositories\Firebase;
use App\Facade\UserFirebaseFacade as User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Kreait\Laravel\Firebase\Facades\Firebase;

class UserFirebaseRepository implements UserRepositoryInterface
{
    protected $auth;
    public function __construct()
    {
        $this->auth = Firebase::auth();
    }

 
    public function all()
    {
        return User::all();
    }
    public function find($id)
    {
        return User::find($id);
    }
    public function create(array $data)
    {
        $user = $this->auth->createUserWithEmailAndPassword($data['email'], $data['password']);
        $data['password'] = $user->passwordHash;
        User::create(null, $data, $user->uid);
        return $user;
    }
    public function update( array $data)
    {
        return User::update($data['id'], $data);
    }

    public function delete($id)
    {
        return User::destroy($id);
    }
}