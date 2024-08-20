<?php

namespace App\Http\Requests;
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'objectif' => 'required|string',
            'attente' => 'required|string',
            'cible' => 'required|string|max:255',
            'categorie' => 'required|in:education,assainissement,jeunesse,sport,divertissement',
            'statut' => 'required|boolean',
            'etat' => 'required|boolean',
            'budget' => 'required|string|max:255',
            'user_id' => 'required|numeric',
        ];
    }
}
