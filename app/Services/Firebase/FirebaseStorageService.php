<?php

namespace App\Services\Firebase;
use Kreait\Laravel\Firebase\Facades\Firebase;
class FirebaseStorageService
{
    protected $firestore;
    protected $credentials;

    public function __construct()
    {
        $this->firestore = Firebase::storage();
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
