<?php

namespace App\Facade;

use App\Models\Firebase\ReferentielFirebase;
use Illuminate\Support\Facades\Facade;

class ReferentielFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ReferentielFirebase::class;
    }
}