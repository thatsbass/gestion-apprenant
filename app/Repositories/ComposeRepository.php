<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ComposeRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Firebase\UserFirebaseRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;

class ComposeRepository implements ComposeRepositoryInterface
{
    protected $repoFirebase;
    protected $repoPgsql;
    protected $activeRepository;

    public function __construct(UserFirebaseRepository $repoFirebase, UserRepository $repoPgsql) {
        $this->repoFirebase = $repoFirebase;
        $this->repoPgsql = $repoPgsql;

        $this->activeRepository = app(UserFirebaseRepository::class);
    }


  

    public function all()
    {
        return $this->activeRepository->all();
    }

    public function find($id)
    {
        return $this->activeRepository->find($id);
    }

    public function create(array $data)
    {
        $firebaseUser = $this->repoFirebase->create($data);
        $postgresqlUser = $this->repoPgsql->create($data);

        return ['firebase' => $firebaseUser, 'postgresql' => $postgresqlUser];
    }

    public function update(array $data)
    {
        // $this->repoFirebase->update($id, $data);
        // return $this->repoPgsql->update($id, $data);
    }

    public function delete($id)
    {
        $this->repoFirebase->delete($id);
        return $this->repoPgsql->delete($id);
    }
}
