<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface ApprenantRepositoryInterface
{
    public function all(): Collection;

    public function find($id);

    public function findByStatut($statut);

    public function createApprenant(array $data);

    public function update($id, array $data): bool;

    public function delete($id): bool;

    public function addCompetenceToReferentiel($referentielId, array $competenceData);

    public function addModuleToCompetence($referentielId, $competenceName, array $moduleData);
}
