<?php

namespace App\Services\Firebase;

use Kreait\Firebase\Factory;
class FirebaseStorageService
{
    protected $firestore;
    protected $credentials;

    public function __construct()
    {
        // Initialiser Firebase avec les credentials
        $this->credentials = config("db_service.firebase.auth.config");

        $this->firestore = (new Factory)
            ->withServiceAccount($this->credentials["firebase_credentials"])
            ->createStorage();
    }

    public function uploadFile($localFilePath, $firebaseFolder, $fileName)
    {
        
        $firebaseStoragePath = $firebaseFolder . '/' . $fileName;
        $bucket = $this->firestore->getBucket();
        $bucket->upload(
            fopen($localFilePath, 'r'),
            ['name' => $firebaseStoragePath]
        );
        return $this->getFileUrl($firebaseStoragePath);
    }

    public function getFileUrl($firebaseStoragePath)
    {
        $bucket = $this->firestore->getBucket();
        $object = $bucket->object($firebaseStoragePath);

        return $object->signedUrl(new \DateTime('+1 hour'));
    }
}
