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
            'commune_id' => 'required|integer',
            'description' => 'required|string',
            'objectif' => 'required|string',
            'attente' => 'required|string',
            'cible' => 'required|string|max:255',
            'categorie' => 'required|in:education,assainissement,jeunesse,sport,divertissement',
            'statut' => 'required|boolean', // ou 'required|integer' si vous utilisez 0 ou 1
            'etat' => 'required|boolean', // ou 'required|integer' si vous utilisez 0 ou 1
            'budget' => 'required|numeric', // ou 'required|string|max:255' si vous utilisez des chaînes
            'image' => 'nullable|string|max:255',
        ];
    }
}
