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


    protected function initializeFirebase()
    {
        $this->database = Firebase::database(); 
    }


    public function create($path = null, array $data, string $uid = null)
    {
       
        $referencePath = $this->table;
        if ($path) {
            $referencePath .= '/' . $path;
        }
    
        
        if ($uid) {
            $this->database->getReference($referencePath . '/' . $uid)->set($data);
            $data['uid'] = $uid; 
            return $data;
        }
    
        $newRef = $this->database->getReference($referencePath)->push($data);
        $data['id'] = $newRef->getKey(); 
        return $data;
    }
    
    
   
    public function all()
    {
        $snapshot = $this->database->getReference($this->table)->getSnapshot();
        $allEntries = $snapshot->getValue();
    
        $activeEntries = array_filter($allEntries, function($entry) {
            return empty($entry['deleted_at']);
        });
    
        return $activeEntries;
    }    

    public function update(string $uid, array $data)
    {

        $this->database->getReference($this->table . '/' . $uid)->update($data);
    }

   
    public function delete(string $uid)
    {
        $this->database->getReference($this->table . '/' . $uid)->remove();
    }

    public function softDelete(string $uid)
    {
        $this->database->getReference($this->table . '/' . $uid)
            ->update(['deleted_at' => now()->timestamp]);
    }

    public function restore(string $uid)
    {
        $this->database->getReference($this->table . '/' . $uid)
            ->update(['deleted_at' => null]);
    }

    public function find(string $uid)
    {
        $snapshot = $this->database->getReference($this->table . '/' . $uid)->getSnapshot();
        $entry = $snapshot->getValue();

        if (!empty($entry['deleted_at'])) {
            return null;
        }

        return $entry;
    }

    public function where(string $key, $value)
    {
        $query = $this->database->getReference($this->table)
            ->orderByChild($key)
            ->equalTo($value);

        $snapshot = $query->getSnapshot();
        return $snapshot->getValue(); 
    }

    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }

    // Convertir l'objet en JSON
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}