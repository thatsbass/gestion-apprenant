<?php

namespace App\Repositories\Firebase;

use App\Facade\ReferentielFacade as Referentiel;
use App\Repositories\Interfaces\ApprenantRepositoryInterface;
use Illuminate\Support\Collection;

class ApprenantRepository implements ApprenantRepositoryInterface
{
    public function all(): Collection
    {
        return Referentiel::all();
    }

    public function find($id)
    {
        return Referentiel::find($id);
    }

    public function findByStatut($statut){
        return Referentiel::where('statut', $statut);
    }

    public function createApprenant(array $data)
    {
        return Referentiel::create($data);
    }

    public function update($id, array $data)
    {
        $referentiel = $this->find($id);
        if (!$referentiel) {
            return false;
        }
        Referentiel::update($id, $data);
    }

    public function delete($id): bool
    {
        return Referentiel::destroy($id);
    }

    
}