<?php

namespace App\Facade;

use App\Models\Firebase\PromotionFirebase;
use Illuminate\Support\Facades\Facade;

class PromotionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PromotionFirebase::class;
    }
}