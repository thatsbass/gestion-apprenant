<?php

namespace App\Services\Interfaces;

interface ReferentielServiceInterface
{
    public function createReferentiel(array $data);

    public function getAllReferentiels($statut = "actif");

    public function getReferentielById($id);

    public function updateReferentiel($id, array $data);

    public function deleteReferentiel($id);

    public function addCompetenceToReferentiel($referentielId, array $competenceData);

    public function addModuleToCompetence($referentielId, $competenceName, array $competenceData);
}
