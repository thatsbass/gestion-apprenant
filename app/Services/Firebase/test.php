<?php

// namespace App\Models\Firebase;

// use Kreait\Laravel\Firebase\Facades\Firebase; // Importez la façade
// use Illuminate\Support\Collection;

// abstract class FirebaseModel
// {
//     protected string $collection;
//     protected array $attributes = [];

//     public function __construct()
//     {
//         // Vous n'avez plus besoin de FirebaseService
//     }

//     public function __get($property)
//     {
//         return $this->attributes[$property] ?? null;
//     }

//     public function __set($property, $value): void
//     {
//         $this->attributes[$property] = $value;
//     }

//     public function setAttrs(array $values, $id = null): void
//     {
//         $this->attributes = $values;
//         $this->attributes['id'] = $id;
//     }

//     public function all(): Collection
//     {
//         $collection = new Collection();
//         $results = Firebase::database()->getReference($this->collection)->getValue(); // Utilisation de la façade

//         foreach ($results as $id => $value) {
//             $model = new static();
//             $model->setAttrs($value, $id);
//             $collection->push($model);
//         }

//         return $collection;
//     }

//     public function find($id): ?self
//     {
//         $result = Firebase::database()->getReference("{$this->collection}/{$id}")->getValue(); // Utilisation de la façade

//         if (empty($result)) {
//             return null;
//         }

//         $model = new static();
//         $model->setAttrs($result, $id);

//         return $model;
//     }

//     public function where(string $key, $value): Collection
//     {
//         $collection = new Collection();
//         $results = $this->all(); // Récupérer tous les enregistrements pour filtrer

//         foreach ($results as $model) {
//             if ($model->{$key} == $value) {
//                 $collection->push($model);
//             }
//         }

//         return $collection;
//     }

//     public function create(array $data, $path = null): ?self
//     {
//         if ($path) {
//             $this->collection = $path;
//         }
        
//         // Utilisez la méthode push() pour créer un nouvel enregistrement
//         $newReference = Firebase::database()->getReference($this->collection)->push($data);
//         $model = new static();
//         $model->setAttrs($data, $newReference->getKey());
//         return $model;
//     }

//     public function update($id, array $data): bool
//     {
//         try {
//             Firebase::database()->getReference("{$this->collection}/{$id}")->update($data); // Utilisation de la façade
//             return true;
//         } catch (\Exception $e) {
//             return false;
//         }
//     }

//     public function destroy($id): bool
//     {
//         try {
//             Firebase::database()->getReference("{$this->collection}/{$id}")->remove(); // Utilisation de la façade
//             return true;
//         } catch (\Exception $e) {
//             return false;
//         }
//     }

//     public function save(): bool
//     {
//         $id = $this->attributes['id'] ?? null;

//         if ($id === null) {
//             $newReference = Firebase::database()->getReference($this->collection)->push($this->attributes); // Utilisation de la façade
//             $this->attributes['id'] = $newReference->getKey();
//         } else {
//             $this->update($id, $this->attributes);
//         }

//         return true;
//     }

//     public function delete(): bool
//     {
//         $id = $this->attributes['id'];
//         return $this->destroy($id);
//     }

//     public function toArray(): array
//     {
//         return $this->attributes;
//     }

//     public function toJson(): string
//     {
//         return json_encode($this->attributes);
//     }

//     public function belongsToOne(string $modelClass, string $relatedKey)
//     {
//         $relatedId = $this->attributes[$relatedKey] ?? null;

//         if ($relatedId === null) {
//             return null;
//         }

//         $relatedModel = new $modelClass();
//         $result = Firebase::database()->getReference("{$relatedModel->collection}/{$relatedId}")->getValue(); // Utilisation de la façade

//         if (empty($result)) {
//             return null;
//         }

//         $relatedModel->setAttrs($result, $relatedId);
//         return $relatedModel;
//     }

//     public function hasMany(string $modelClass, string $foreignKey): Collection
//     {
//         $relatedModel = new $modelClass();
//         $results = Firebase::database()->getReference($relatedModel->collection)->getValue(); // Récupérer tous les enregistrements pour filtrer

//         $collection = new Collection();
//         foreach ($results as $id => $value) {
//             if (isset($value[$foreignKey]) && $value[$foreignKey] == $this->attributes['id']) {
//                 $relatedInstance = new $modelClass();
//                 $relatedInstance->setAttrs($value, $id);
//                 $collection->push($relatedInstance);
//             }
//         }

//         return $collection;
//     }
// }
