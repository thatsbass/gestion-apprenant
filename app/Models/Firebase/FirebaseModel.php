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

    // Init Firebase connection
    protected function initializeFirebase()
    {
        $this->database = Firebase::database();
    }

    public function create($path = null, array $data, string $uid = null)
    {
        $referencePath = $this->table;
        if ($path) {
            $referencePath .= "/" . $path;
        }
        if ($uid) {
            $this->database
                ->getReference($referencePath . "/" . $uid)
                ->set($data);
            $data["uid"] = $uid;
            return $data;
        }
        $newRef = $this->database->getReference($referencePath)->push($data);
        $data["id"] = $newRef->getKey();
        return $data;
    }

    public function all()
    {
        $snapshot = $this->database->getReference($this->table)->getSnapshot();
        return $snapshot->getValue();
    }

    public function update(string $uid, array $data)
    {
        $this->database->getReference($this->table . "/" . $uid)->update($data);
    }

    public function delete(string $uid)
    {
        $this->database->getReference($this->table . "/" . $uid)->remove();
    }

    public function find(string $uid)
    {
        $snapshot = $this->database
            ->getReference($this->table . "/" . $uid)
            ->getSnapshot();
        return $snapshot->getValue();
    }

    public function where(string $key, $value)
    {
        $query = $this->database
            ->getReference($this->table)
            ->orderByChild($key)
            ->equalTo($value);

        $snapshot = $query->getSnapshot();
        return $snapshot->getValue();
    }

    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
