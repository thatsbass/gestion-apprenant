<?php

namespace App\Contracts;

interface AuthServiceInterface
{
    public function login($email, $password);
    public function logout($token);
}
