<?php

namespace App\Services\Firebase;

// use Kreait\Firebase\Facades\Firebase; // Importez la façade
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseService
{
    protected $database;

    public function __construct()
    {
        // Récupérez l'instance de la base de données via la façade
        $this->database = Firebase::database();
    }

    public function fetchRecord(string $path): array
    {
        // Obtenez le document par son chemin
        $snapshot = $this->database->getReference($path)->getValue();
        return $snapshot ?? [];
    }

    public function fetchAllRecords(string $path): array
    {
        // Obtenez tous les documents du chemin donné
        $snapshot = $this->database->getReference($path)->getValue();
        return $snapshot ?? [];
    }

    public function fetchAllRecordsByQuery(string $path, string $key, $value): array
    {
        // Requêtes personnalisées ne sont pas directement supportées en Realtime DB
        // Vous pourriez avoir besoin d'implémenter une logique de filtrage après récupération
        $records = $this->fetchAllRecords($path);
        return array_filter($records, function ($record) use ($key, $value) {
            return isset($record[$key]) && $record[$key] == $value;
        });
    }

    public function createRecord(string $path, array $data): string
    {
        // Ajoutez un nouvel enregistrement à la Realtime Database
        $newReference = $this->database->getReference($path)->push($data);
        return $newReference->getKey(); // Retourne la clé de l'enregistrement ajouté
    }

    public function updateRecord(string $path, array $data): void
    {
        // Mettez à jour l'enregistrement à l'emplacement spécifié
        $this->database->getReference($path)->update($data);
    }

    public function deleteRecord(string $path): void
    {
        // Supprimez l'enregistrement à l'emplacement spécifié
        $this->database->getReference($path)->remove();
    }
}
