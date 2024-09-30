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

    public function delete($id)
    {
        return Referentiel::delete($id);
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

    public function getCompetencesForReferentiel($referentielId) {
        $referentiel = Referentiel::find($referentielId);
        if (!$referentiel) {
            return false;
        }
        return Referentiel::find("{$referentielId}/competences");
    }

    public function getReferentielByIdWithModules($referentielId) {
        $referentiel = Referentiel::find($referentielId);
        if (!$referentiel) {
            return false;
        }
        $competences = $referentiel['competences'];
        $modules = [];
        foreach ($competences as $competenceId => $competence) {
            $modules[$competenceId] = $this->getModulesForCompetence($referentielId, $competenceId);
        }
        return $modules;
    }

    public function getModulesForCompetence($referentielId, $competenceId) {
        $competence = Referentiel::find("{$referentielId}/competences/{$competenceId}");
        if (!$competence) {
            return false;
        }
        return $competence['modules'];
    }

    public function deleteCompetence($referentielId, $competenceId) {
        return Referentiel::softDelete("{$referentielId}/competences/{$competenceId}");
    }

    public function deleteModuleToCompetence($referentielId, $competenceId, $moduleId) {
        return Referentiel::softDelete("{$referentielId}/competences/{$competenceId}/modules/{$moduleId}");
    }
}