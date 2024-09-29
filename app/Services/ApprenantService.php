<?php

namespace App\Services;

use App\Repositories\Interfaces\ApprenantRepositoryInterface;
use App\Services\Firebase\FirebaseStorageService;
use App\Services\Interfaces\ApprenantServiceInterface;


class ApprenantService implements ApprenantServiceInterface
{
    protected $repository;
    protected $dualRepository;
    protected $storageService;

    public function __construct(ApprenantRepositoryInterface $repository, FirebaseStorageService $storageService)
    {
        $this->repository = $repository;
        $this->storageService = $storageService;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function createApprenant(array $data)
    {
        $firebaseFolder = 'Apprenants/photos';
        $fileName = $data['telephone'].'.png';
        $data['photo'] = $this->storageService->uploadFile(storage_path('app/public/' . $data['photo']), $firebaseFolder, $fileName);

        return $this->repository->createApprenant($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

}