<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{

    public function getRoleLibelleById($id)
    {
        $role = Role::find($id);
        return $role ? $role->libelle : null;
    }
    public function getRoleIdByLibelle($libelle)
    {
        $role = Role::where('libelle', $libelle)->first();
        return $role ? $role->id : null;
    }
    public function getRoleByLibelle($libelle)
    {
        return Role::where('libelle', $libelle)->first();
    }
}
