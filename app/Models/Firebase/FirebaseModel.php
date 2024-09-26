<?php

namespace App\Models\Firebase;

use App\Services\Firebase\FirebaseService;
use Illuminate\Support\Collection;

abstract class FirebaseModel
{
    protected FirebaseService $firebaseService;
    protected string $collection;
    protected array $attributes = [];

    public function __construct(FirebaseService $firebaseService = null)
    {
        $this->firebaseService = $firebaseService ?? new FirebaseService();
    }

    public function __get($property)
    {
        return $this->attributes[$property] ?? null;
    }

    public function __set($property, $value): void
    {
        $this->attributes[$property] = $value;
    }

    public function setAttrs(array $values, $id = null): void
    {
        $this->attributes = $values;
        $this->attributes['id'] = $id;
    }

    public function all(): Collection
    {
        $collection = new Collection();
        $results = $this->firebaseService->fetchAllRecords($this->collection);

        foreach ($results as $id => $value) {
            $model = new static($this->firebaseService);
            $model->setAttrs($value, $id);
            $collection->push($model);
        }

        return $collection;
    }

    public function find($id): ?self
    {
        $result = $this->firebaseService->fetchRecord($this->collection, $id);

        if (empty($result)) {
            return null;
        }

        $model = new static($this->firebaseService);
        $model->setAttrs($result, $id);

        return $model;
    }

    public function where(string $key, $value): Collection
    {
        $collection = new Collection();
        $results = $this->firebaseService->fetchAllRecordsByQuery($this->collection, $key, $value);

        foreach ($results as $id => $value) {
            $model = new static($this->firebaseService);
            $model->setAttrs($value, $id);
            $collection->push($model);
        }

        return $collection;
    }

    public function create(array $data, $id = null, $path = null): ?self
    {
        if ($path) {
            $this->collection = $path;
        }
        $id = $this->firebaseService->createRecord($this->collection, $data, $id);
        $model = new static($this->firebaseService);
        $model->setAttrs($data, $id);
        return $model;
    }

    public function update($id, array $data): bool
    {
        try {
            $this->firebaseService->updateRecord($this->collection, $id, $data);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function destroy($id): bool
    {
        try {
            $this->firebaseService->deleteRecord($this->collection, $id);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function save(): bool
    {
        $id = $this->attributes['id'] ?? null;

        if ($id === null) {
            $id = $this->firebaseService->createRecord($this->collection, $this->attributes);
            $this->attributes['id'] = $id;
        } else {
            $this->firebaseService->updateRecord($this->collection, $id, $this->attributes);
        }

        return true;
    }

    public function delete(): bool
    {
        $id = $this->attributes['id'];
        return $this->destroy($id);
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function toJson(): string
    {
        return json_encode($this->attributes);
    }

    public function belongsToOne(string $modelClass, string $relatedKey)
    {
        $relatedId = $this->attributes[$relatedKey] ?? null;

        if ($relatedId === null) {
            return null;
        }

        $relatedModel = new $modelClass();
        $result = $this->firebaseService->fetchRecord($relatedModel->collection, $relatedId);

        if (empty($result)) {
            return null;
        }

        $relatedModel->setAttrs($result, $relatedId);
        return $relatedModel;
    }

    public function hasMany(string $modelClass, string $foreignKey): Collection
    {
        $relatedModel = new $modelClass();
        $results = $this->firebaseService->fetchAllRecordsByQuery($relatedModel->collection, $foreignKey, $this->attributes['id']);

        $collection = new Collection();
        foreach ($results as $id => $value) {
            $relatedInstance = new $modelClass();
            $relatedInstance->setAttrs($value, $id);
            $collection->push($relatedInstance);
        }

        return $collection;
    }
}
