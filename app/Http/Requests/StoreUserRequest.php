<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Vous pouvez ajuster cela selon vos besoins d'autorisation
    }

    public function rules()
    {
        return [
            'commune_id' => 'nullable|exists:communes,id',
            'prenom' => 'required|string',
            'nom' => 'required|string',
            'date_naissance' => 'required|date',
            'CNI' => 'required|string|size:13',
            'adresse' => 'required|string',
            'lieu_naissance' => 'required|string',
            'fonction' => 'nullable|in:eleve,bachelier,etudiant,diplome,mentor_certifie,profetionnel_reconvertit,retraite,chomeur',
            'genre' => 'required|in:masculin,feminin',
            'telephone' => 'required|string|unique:users',
            'situation_matrimoniale' => 'required|in:marie,divorce,celibataire,veuve',
            'date_integration' => 'nullable|date',
            'date_sortie' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422));
    }
}
