<?php

namespace App\Facade;
use Illuminate\Support\Facades\Facade;
use App\Models\Firebase\UserFirebase;

class UserFirebaseFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return UserFirebase::class;
    }
}
