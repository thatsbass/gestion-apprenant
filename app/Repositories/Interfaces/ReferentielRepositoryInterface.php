<?php

namespace App\Repositories\Interfaces;

interface ReferentielRepositoryInterface
{

    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function addCompetenceToReferentiel($referentielId, array $competenceData);

    public function getCompetencesForReferentiel($referentielId);

    public function deleteCompetence($referentielId, $competenceId);

    public function addModuleToCompetence($referentielId, $competenceId, array $moduleData);

    public function getReferentielByIdWithModules($referentielId);

    public function getModulesForCompetence($referentielId, $competenceId);

    public function deleteModuleToCompetence($referentielId, $competenceId, $moduleiD);

}