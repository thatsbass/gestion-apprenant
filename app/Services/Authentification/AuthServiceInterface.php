<?php

namespace App\Services\Authentification;

interface AuthServiceInterface
{
    public function login($credentials);
    public function logout($user);
    public function refresh($token);
}
