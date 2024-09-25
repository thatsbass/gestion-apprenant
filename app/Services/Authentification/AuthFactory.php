<?php

namespace App\Services\Authentification;

use InvalidArgumentException;

class AuthFactory
{
    /**
     * Créer une instance du service d'authentification en fonction du driver sélectionné.
     *
     * @param string $driver
     * @return mixed
     */
    public static function make($driver)
    {
        $config = config("auth.{$driver}.auth");

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
