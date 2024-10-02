<?php

namespace App\Http\Requests;

use App\Rules\UniqueFirebase;
use Illuminate\Foundation\Http\FormRequest;

class StoreReferentielRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => ['required', 'string', new UniqueFirebase('referentiels', 'code')],
            'libelle' => ['required', 'string', new UniqueFirebase('referentiels', 'libelle')],
            'description' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'statut' => 'required|in:actif,inactif,archiver',
            'competences' => 'required|array',
            'competences.*.nom' => ['required', 'string', new UniqueFirebase('referentiels/'.$this->libelle.'/competences', 'nom')],
            'competences.*.description' => 'nullable|string',
            'competences.*.duree_aquisition' => 'required|string',
            'competences.*.type' => 'required|in:Back-End,Front-End',
            'competences.*.modules' => 'required|array',
            'competences.*.modules.*.nom' => ['required', 'string', new UniqueFirebase('referentiels/'.$this->libelle.'/competences/'.$this->competence_nom.'/modules', 'nom')],
            'competences.*.modules.*.description' => 'nullable|string',
            'competences.*.modules.*.duree' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            // Messages pour le Référentiel
            'code.required' => 'Le code du référentiel est obligatoire.',
            'code.unique' => 'Ce code de référentiel existe déjà.',
            'libelle.required' => 'Le libellé du référentiel est obligatoire.',
            'libelle.unique' => 'Ce libellé de référentiel existe déjà.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'photo.image' => 'La photo de couverture doit être une image.',
            'photo.required' => 'La photo de couverture est obligatoire.',
            'statut.required' => 'Le statut du référentiel est obligatoire.',
            'statut.in' => 'Le statut doit être soit actif, inactif ou archiver.',

            // Messages pour les compétences
            'competences.required' => 'Vous devez ajouter au moins une compétence.',
            'competences.*.nom.required' => 'Le nom de la compétence est obligatoire.',
            'competences.*.nom.unique' => 'Le nom de cette compétence existe déjà dans ce référentiel.',
            'competences.*.description.string' => 'La description de la compétence doit être une chaîne de caractères.',
            'competences.*.duree_aquisition.required' => 'La durée d\'acquisition de la compétence est obligatoire.',
            // 'competences.*.duree_aquisition.integer' => 'La durée d\'acquisition de la compétence doit être un nombre entier.',
            'competences.*.type.required' => 'Le type de compétence est obligatoire.',
            'competences.*.type.in' => 'Le type de compétence doit être soit Back-End ou Front-End.',

            // Messages pour les modules
            'competences.*.modules.required' => 'Chaque compétence doit avoir au moins un module.',
            'competences.*.modules.*.nom.required' => 'Le nom du module est obligatoire.',
            'competences.*.modules.*.nom.unique' => 'Le nom de ce module existe déjà pour cette compétence.',
            'competences.*.modules.*.description.string' => 'La description du module doit être une chaîne de caractères.',
            'competences.*.modules.*.duree.required' => 'La durée d\'acquisition du module est obligatoire.',
            // 'competences.*.modules.*.duree.integer' => 'La durée d\'acquisition du module doit être un nombre entier.',
        ];
    }

}