<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface ApprenantRepositoryInterface
{
    public function all(): Collection;
    public function find($id);

    public function createApprenant(array $data);

    public function update($id, array $data);
}
