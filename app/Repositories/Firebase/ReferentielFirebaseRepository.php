<?php

namespace App\Repositories\Firebase;

use App\Facade\ReferentielFacade as Referentiel;
use App\Repositories\Interfaces\ReferentielRepositoryInterface;
use Illuminate\Support\Collection;

class ReferentielFirebaseRepository implements ReferentielRepositoryInterface
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

    public function create(array $data)
    {
        return Referentiel::create(null ,$data, strtoupper($data["libelle"]));
    }

    public function update($id, array $data)
    {
        Referentiel::update($id, $data);
    }

    public function delete($id): bool
    {
        return Referentiel::destroy($id);
    }

    public function addCompetenceToReferentiel($referentielId, array $competenceData)
    {
        $referentiel = Referentiel::find($referentielId);
        if (!$referentiel) {
            return false;
        }
        // referentiels/{$referentielId}/competences
        return Referentiel::create("{$referentielId}/competences", $competenceData, $competenceData['nom']);
    }

    public function addModuleToCompetence($referentielId, $competenceId, array $moduleData)
    {
        $referentiel = $this->find($referentielId);
        if (!$referentiel) {
            return false;
        }

        return Referentiel::create("{$referentielId}/competences/{$competenceId}/modules", $moduleData, $moduleData['nom']);
    }
}
