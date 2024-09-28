<?php

namespace App\Policies;

use App\Facade\RoleFacade;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Only admins can view any user
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Check if the authenticated user is an admin
        if ($user->isAdmin()) {
            return true;
        }

        // Check if the authenticated user is the user themselves
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Assuming only admins can create users
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
    /** 
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Only admins or the user themselves can update the user model
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Only admins can delete a user
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        // Only admins can restore a user
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Only admins can permanently delete a user
        return $user->isAdmin();
    }
}