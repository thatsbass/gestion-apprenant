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

    // public function getCompetencesForReferentiel($referentielId);

    // public function updateCompetence($referentielId, $competenceId, array $data);

    // public function deleteCompetence($referentielId, $competenceId);

}