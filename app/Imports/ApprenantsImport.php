<?php

namespace App\Imports;

use App\Services\Firebase\FirebaseStorageService;
use App\Services\ApprenantService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ApprenantsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $firebaseStorage;
    protected $apprenantService;

    public function __construct(FirebaseStorageService $firebaseStorage, ApprenantService $apprenantService)
    {
        $this->firebaseStorage = $firebaseStorage;
        $this->apprenantService = $apprenantService;
    }

    public function model(array $row)
    {
  
        $data = [
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'date_naissance' => $row['date_naissance'],
            'genre' => $row['genre'],
            'adresse' => $row['adresse'],
            'telephone' => $row['telephone'],
            'email' => $row['email'],
            'photo' => $row['photo'],
            'tuteur_nom' => $row['tuteur_nom'],
            'tuteur_prenom' => $row['tuteur_prenom'],
            'tuteur_contact' => $row['tuteur_contact'],
            'cni' => $row['cni'],
            'extrait_de_naissance' => $row['extrait_de_naissance'],
            'casier_judiciaire' => $row['casier_judiciaire'],
            'diplome' => $row['diplome'],
            'visite_medicale' => $row['visite_medicale'],
            'referentiel' => $row['referentiel'],
        ];

        $this->apprenantService->createApprenant($data);
    }

    public function rules(): array
    {
        return [
            
        ];
    }
}