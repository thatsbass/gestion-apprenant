<?php

namespace App\Services\Interfaces;

interface FirebaseStorageInterface
{
    public function uploadFile($localFilePath, $firebaseFolder, $fileName);
    public function getFileUrl($firebaseStoragePath);
}
