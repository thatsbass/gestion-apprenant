<?php

namespace App\Services\Firebase;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $firestore;
    protected $credentials;

    public function __construct()
    {

        $this->credentials = config("db_service.firebase.auth.config");

        $this->firestore = (new Factory)
            ->withServiceAccount($this->credentials["firebase_credentials"])
            ->createFirestore()
            ->database();
    }

    public function fetchRecord(string $collection, string $id): array
    {
        $document = $this->firestore->collection($collection)->document($id)->snapshot();
        return $document->exists() ? $document->data() : [];
    }

    public function fetchAllRecords(string $collection): array
    {
        $documents = $this->firestore->collection($collection)->documents();
        $results = [];

        foreach ($documents as $document) {
            $results[$document->id()] = $document->data();
        }

        return $results;
    }

    public function fetchAllRecordsByQuery(string $collection, string $key, $value): array
    {
        $documents = $this->firestore->collection($collection)->where($key, '=', $value)->documents();
        $results = [];

        foreach ($documents as $document) {
            $results[$document->id()] = $document->data();
        }

        return $results;
    }

    public function createRecord(string $collection, array $data, string $id = null): string
    {
        if ($id) {
            $this->firestore->collection($collection)->document($id)->set($data);
        } else {
            $document = $this->firestore->collection($collection)->add($data);
            return $document->id();
        }
        return $id;
    }

    public function updateRecord(string $collection, string $id, array $data): void
    {
        $this->firestore->collection($collection)->document($id)->set($data, ['merge' => true]);
    }

    public function deleteRecord(string $collection, string $id): void
    {
        $this->firestore->collection($collection)->document($id)->delete();
    }
}
