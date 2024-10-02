<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\Interfaces\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{

    public function __construct(protected RoleRepositoryInterface $roleRepository) {}
    
    public function getLibelle($id)
    {
        return $this->roleRepository->getRoleLibelleById($id);
    }

    public function getId($libelle)
    {
        return $this->roleRepository->getRoleIdByLibelle($libelle);
    }

    public function getRoleByLibelle($libelle){
        return $this->roleRepository->getRoleByLibelle($libelle);
    }
}
