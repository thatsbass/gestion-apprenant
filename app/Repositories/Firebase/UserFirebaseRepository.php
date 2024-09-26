<?php

namespace App\Repositories\Firebase;
use App\Facade\UserFirebaseFacade as User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class UserFirebaseRepository implements UserRepositoryInterface
{
    protected $firestore;
    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firestore = $firebaseAuth;
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
        $user = $this->firestore->createUserWithEmailAndPassword($data['email'], $data['password']);
        
        $uid = $user->uid;
        $data['password'] = $user->passwordHash;
        User::create($data, $uid);
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