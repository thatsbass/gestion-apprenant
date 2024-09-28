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

    public function update($id, array $data): bool
    {
        return Referentiel::update($id, $data);
    }

    public function delete($id): bool
    {
        return Referentiel::destroy($id);
    }

    public function addCompetenceToReferentiel($referentielId, array $competenceData)
    {
        $referentiel = $this->find($referentielId);
        if (!$referentiel) {
            return false;
        }
        return Referentiel::create($competenceData, $competenceData['nom'], "referentiels/{$referentielId}/competences");
    }

    public function addModuleToCompetence($referentielId, $competenceName, array $moduleData)
    {
        $referentiel = $this->find($referentielId);
        if (!$referentiel) {
            return false;
        }

        return Referentiel::create($moduleData, $moduleData['nom'] ,"referentiels/{$referentielId}/competences/{$competenceName}/modules");
    }
}