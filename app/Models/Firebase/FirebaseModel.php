<?php

namespace App\Models\Firebase;

use Kreait\Laravel\Firebase\Facades\Firebase; 
use Illuminate\Support\Collection;

abstract class FirebaseModel
{
    protected $database;
    protected $table;

    public function __construct()
    {
        $this->initializeFirebase();
    }

    // Initialisation de Firebase
    protected function initializeFirebase()
    {
        $this->database = Firebase::database(); 
    }


    public function create($path = null, array $data, string $uid = null)
    {
        // Si un chemin est fourni, on l'ajoute au chemin de la table
        $referencePath = $this->table;
        if ($path) {
            $referencePath .= '/' . $path;
        }
    
        // Si un UID est fourni, enregistrez les données sous cet UID
        if ($uid) {
            $this->database->getReference($referencePath . '/' . $uid)->set($data);
            $data['uid'] = $uid; // Ajouter l'UID aux données retournées
            return $data;
        }
    
        // Si aucun UID n'est fourni, créer une nouvelle entrée avec une clé générée automatiquement
        $newRef = $this->database->getReference($referencePath)->push($data);
        $data['id'] = $newRef->getKey(); 
        return $data;
    }
    
    
    // Récupérer toutes les entrées
    public function all()
    {
        $snapshot = $this->database->getReference($this->table)->getSnapshot();
        return $snapshot->getValue(); // Retourner toutes les valeurs
    }

    // Mettre à jour une entrée existante
    public function update(string $uid, array $data)
    {

        $this->database->getReference($this->table . '/' . $uid)->update($data);
    }

    // Supprimer une entrée
    public function delete(string $uid)
    {
        $this->database->getReference($this->table . '/' . $uid)->remove();
    }

    // Trouver une entrée par UID
    public function find(string $uid)
    {
        $snapshot = $this->database->getReference($this->table . '/' . $uid)->getSnapshot();
        return $snapshot->getValue(); // Retourner la valeur trouvée
    }

    // Filtrer les entrées
    public function where(string $key, $value)
    {
        $query = $this->database->getReference($this->table)
            ->orderByChild($key)
            ->equalTo($value);

        $snapshot = $query->getSnapshot();
        return $snapshot->getValue(); 
    }

    // Convertir l'objet en tableau
    public function toArray()
    {
        return json_decode(json_encode($this), true); // Conversion en tableau
    }

    // Convertir l'objet en JSON
    public function toJson()
    {
        return json_encode($this->toArray()); // Conversion en JSON
    }
}
