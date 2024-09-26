<?php

namespace App\Factories;

use InvalidArgumentException;

class RepoFactory
{
    
    public static function make($driver)
    {
        $config = config("db_service.{$driver}.auth");
        // dd($config);
        if (!isset($config['class'])) {
            throw new InvalidArgumentException("Le driver d'authentification [{$driver}] n'est pas correctement configuré.");
        }

        $authServiceClass = $config['class'];

        if (!class_exists($authServiceClass)) {
            throw new InvalidArgumentException("La classe de service d'authentification [{$authServiceClass}] n'existe pas.");
        }
        return new $authServiceClass($config['config'] ?? []);
    }
}
