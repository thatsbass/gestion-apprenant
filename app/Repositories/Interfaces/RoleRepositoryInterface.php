<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface
{

    public function getRoleLibelleById($id);

    public function getRoleIdByLibelle($libelle);

    public function getRoleByLibelle($libelle);

}
