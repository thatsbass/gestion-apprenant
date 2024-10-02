<?php

namespace App\Repositories\Interfaces;

interface ComposeRepositoryInterface
{
    public function create(array $data);
    public function update(array $data);
    public function delete($id);

    // repo active
    public function all($request);
    public function find($id);

}