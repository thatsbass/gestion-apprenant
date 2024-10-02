<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Kreait\Laravel\Firebase\Facades\Firebase;

class UniqueFirebase implements ValidationRule
{
    protected $path;
    protected $attributeName;

    /**
     * UniqueFirebase constructor.
     *
     * @param string $path Le chemin dans la base de données Firebase (ex: 'users')
     * @param string $attributeName Le nom de l'attribut à vérifier (ex: 'email')
     */
    public function __construct(string $path, string $attributeName)
    {
        $this->path = $path;
        $this->attributeName = $attributeName;
    }

    /**
     * Vérifie si la règle de validation passe.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $database = Firebase::database();
        $reference = $database->getReference($this->path);

        
        $snapshot = $reference->orderByChild($this->attributeName)->equalTo($value)->getSnapshot();

        if ($snapshot->hasChildren()) {
            $fail("Le {$attribute} existe déjà.");
        }
    }
}