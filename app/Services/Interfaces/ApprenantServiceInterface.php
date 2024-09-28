<?php

namespace App\Services\Interfaces;

interface ApprenantServiceInterface
{
    public function all();

    public function find($id);

    public function createApprenant(array $data);

    public function update($id, array $data);

    public function delete($id);
}
