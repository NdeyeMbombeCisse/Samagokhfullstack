<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Seeder;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ville::insert([
            [
                'libelle' => 'Dakar',
                'description' => 'La capitale du Sénégal, située sur la côte atlantique.'
            ],
            [
                'libelle' => 'Touba',
                'description' => 'Une ville religieuse majeure, siège de la confrérie mouride.'
            ],
            [
                'libelle' => 'Thiès',
                'description' => 'Ville industrielle et commerciale, située à l’est de Dakar.'
            ],
            [
                'libelle' => 'Saint-Louis',
                'description' => 'Ancienne capitale du Sénégal, située dans le nord du pays.'
            ],
            [
                'libelle' => 'Kaolack',
                'description' => 'Ville commerçante située sur la rive nord du fleuve Saloum.'
            ],
            [
                'libelle' => 'Ziguinchor',
                'description' => 'Ville principale de la région de Casamance, au sud du Sénégal.'
            ],
            [
                'libelle' => 'Louga',
                'description' => 'Ville située dans le nord-ouest du Sénégal, connue pour son agriculture.'
            ],
            [
                'libelle' => 'Kolda',
                'description' => 'Ville du sud du Sénégal, connue pour ses productions agricoles.'
            ],
            [
                'libelle' => 'Fatick',
                'description' => 'Ville du centre-ouest du Sénégal, au cœur du pays Sereer.'
            ],
            [
                'libelle' => 'Tambacounda',
                'description' => 'Ville située dans l’est du Sénégal, connue pour ses parcs nationaux.'
            ],
        ]);
    }
}
