<?php

namespace App\Facade;

use App\Services\Interfaces\RoleServiceInterface;
use Illuminate\Support\Facades\Facade;

class RoleFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return RoleServiceInterface::class;
    }
}
