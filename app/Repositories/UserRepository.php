<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function login($credentials)
    {
        
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
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = Role::where('libelle', $data['role'])->first()->id;
        return User::create($data);
    }

    public function update(array $data)
    {
        $user = User::find($data['id']);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function delete($id)
    {
        return User::destroy($id);
    }
}