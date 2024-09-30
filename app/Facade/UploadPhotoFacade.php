<?php

namespace App\Facade;

use App\Services\Interfaces\FirebaseStorageInterface;
use Illuminate\Support\Facades\Facade;

class UploadPhotoFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return FirebaseStorageInterface::class;
    }
}
