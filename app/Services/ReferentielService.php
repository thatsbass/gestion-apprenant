<?php

namespace App\Services;

use App\Repositories\Firebase\ReferentielFirebaseRepository;
use App\Services\Firebase\FirebaseStorageService;
use App\Services\Interfaces\ReferentielServiceInterface;

class ReferentielService implements ReferentielServiceInterface
{
    protected $storageService;
    protected $referentielRepository;
    
    public function __construct(ReferentielFirebaseRepository $referentielRepository, FirebaseStorageService $storageService)
    {
        $this->referentielRepository = $referentielRepository;
        $this->storageService = $storageService;
    }

    public function createReferentiel(array $data)
{
    $firebaseFolder = 'referentiels/photos';
    $fileName = $data['code'] . '.png';
    $data['photo'] = $this->storageService->uploadFile(storage_path('app/public/' . $data['photo']), $firebaseFolder, $fileName);
    $referentiel = $this->referentielRepository->create([
        'code'=> $data['code'],
        'libelle'=> $data['libelle'],
        'description'=> $data['description'],
        'statut'=> $data['statut'],
        'photo'=> $data['photo'],
    ]);

    if (isset($data['competences'])) {
        foreach ($data['competences'] as $competence) {
                $this->addCompetenceToReferentiel($referentiel["uid"], $competence);
        }
    }
    return $referentiel;
}


    public function getAllReferentiels($statut = "actif", $format = null)
    {
        $data = $this->referentielRepository->findByStatut($statut ?? "actif");

        $time = time();
        if ($format === 'pdf') {
            $data = app(ExportPdfService::class)->export(['referentiels' => $data], 'referentiels/index', 'Liste_referentiels'.$time);
        } 
        elseif ($format === 'excel') {
            $formattedData = array_map(function($item) {
                return [
                    'Code' => $item['code'],
                    'Libelle' => $item['libelle'],
                    'Statut' => $item['statut'],
                    'Description' => $item['description'],
                ];
            }, $data);

            $firstKey = array_key_first($formattedData);
            $headers = !empty($formattedData) ? array_keys($formattedData[$firstKey]) : [];
            $data = app(ExcelService::class)->exportExcelFile($formattedData, $headers, 'Liste_referentiels'.$time);
        }

       return $data;
    }

    public function getReferentielById($id, $filtre)
    {
        if ($filtre === "competences") {
            return [
                "Competences" => $this->referentielRepository->getCompetencesForReferentiel($id) ];
        }
        elseif ($filtre === "modules") {
            return [
                "Modules" => $this->referentielRepository->getReferentielByIdWithModules($id) ];
        }
        return [
            "Referentiels" => $this->referentielRepository->find($id) ];
    }

    public function updateReferentiel($id, array $data)
    {
        return $this->referentielRepository->update($id, $data);
    }

    public function deleteReferentiel($id)
    {
        $this->referentielRepository->update($id, ['statut' => 'archiver']);
        return $this->referentielRepository->delete($id);
    }

    public function addCompetenceToReferentiel($referentielId, array $data)
    {

        $competenceData = [
            'nom' => $data['nom'],
            'description'=> $data['description'],
            'duree_aquisition'=> $data['duree_aquisition'],
            'type'=> $data['type'],
        ];
        $competence = $this->referentielRepository->addCompetenceToReferentiel($referentielId, $competenceData);
    
        if (isset($data['modules'])) {
            foreach ($data['modules'] as $dataModule) {
                $this->addModuleToCompetence($referentielId, $competence["uid"], $dataModule);
            }
        }
        return $competence;
    }

    public function addModuleToCompetence($referentielId, $competenceId, array $competenceData)
    {
        $competence = $this->referentielRepository->addModuleToCompetence($referentielId, $competenceId, $competenceData);
        return $competence;
    }

    public function getArchivedReferentiels() {
        return $this->referentielRepository->findByStatut("archiver");
    }
}

