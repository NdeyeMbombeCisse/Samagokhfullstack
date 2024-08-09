<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'objectif' => 'sometimes|required|string',
            'attente' => 'sometimes|required|string',
            'cible' => 'sometimes|required|string|max:255',
            'categorie' => 'sometimes|required|in:education,assainissement,jeunesse,sport,divertissement',
            'statut' => 'sometimes|required|boolean',
            'etat' => 'sometimes|required|boolean',
            'budget' => 'sometimes|required|string|max:255',
        ];
    }
}
