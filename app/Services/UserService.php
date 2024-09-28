<?php

namespace App\Services;

use App\Repositories\Interfaces\ComposeRepositoryInterface;
use App\Services\Firebase\FirebaseStorageService;
use App\Services\ExportPdfService;


class UserService
{
    protected $repository;
    protected $storageService;

    public function __construct(ComposeRepositoryInterface $repository, FirebaseStorageService $storageService)
    {
        $this->repository = $repository;
        $this->storageService = $storageService;
    }


    public function all($request)
    {
        $data = $this->repository->all()->toArray();

        if ($request['format'] === 'pdf') {
            $url = app(ExportPdfService::class)->export(['users' => $data], 'users/index', 'Liste_users');
        } 
        elseif ($request['format'] === 'excel') {
            $formattedData = array_map(function($item) {
                return [
                    'Nom' => $item->nom,
                    'Prenom' => $item->prenom,
                    'Telephone' => $item->telephone,
                    'Email' => $item->email,
                    'Fonction' => $item->fonction,
                    'Adresse' => $item->adresse,
                    'Rôle' => $item->role,
                    'Statut' => $item->statut,
                ];
            }, $data);

            $headers = ['Nom', 'Prenom', 'Telephone', 'Email', 'Fonction', 'Adresse', 'Rôle', 'Statut'];
            $url = app(ExcelService::class)->exportExcelFile($formattedData, $headers, 'Liste_users');
        }
        else {
            $url =  $this->repository->all()->map->toArray();
        }
        return $url;
    }


    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        $firebaseFolder = 'users/photos';
        $fileName = $data['telephone'].'.png';
        $data['photo'] = $this->storageService->uploadFile(storage_path('app/public/' . $data['photo']), $firebaseFolder, $fileName);

        return $this->repository->create($data);
    }

    public function update( array $data)
    {
        return $this->repository->update($data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}