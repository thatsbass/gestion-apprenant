<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueFirebase;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:500',
            'fonction' => 'required|string|max:255',
            'email' => ['required', 'email', new UniqueFirebase('users', 'email')],
            'telephone' => ['required','numeric', new UniqueFirebase('users', 'telephone')],
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'statut' => 'required|in:active,inactive',
            'role' => 'required|string|max:50',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'fonction.required' => 'La fonction est obligatoire.',
            'role.required' => 'Le role est obligatoire.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'photo.required' => 'La photo est obligatoire.',
            'telephone.required' => 'Le telephone est obligatoire.',
            'telephone.unique' => 'Ce numero de telephone est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'statut.in' => 'Le statut doit être soit active, soit inactive.',
        ];
    }

}