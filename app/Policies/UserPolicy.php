<?php

namespace App\Policies;

use App\Facade\RoleFacade;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    use HandlesAuthorization;

       public function viewAny(User $user): bool
    {
       
        return true;
    }

  
    public function view(User $user, User $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return true;
    }
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager() || $user->isCME();
    }

    public function canCreate(User $user, Role $role): bool{
       if($user->isManager() && $role->id === RoleFacade::getId('Admin')){
        return false;
       }
       if($user->isCME() && ($role->id === RoleFacade::getId('Admin') || $role->id === RoleFacade::getId('Manager'))){
        return false;
       }
       return true;
    }
    
}