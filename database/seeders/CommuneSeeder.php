<?php

namespace Database\Seeders;

use App\Models\Commune;
use Illuminate\Database\Seeder;

class CommuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Commune::insert([
            [
                'libelle' => 'Commune de Dakar Plateau',
                'description' => 'Située au cœur de la capitale sénégalaise, cette commune est le centre administratif et commercial de Dakar.',
                'ville_id' => 1, // Remplacez par l'ID réel de la ville de Dakar dans la table `villes`
            ],
            [
                'libelle' => 'Commune de Médina',
                'description' => 'Une commune historique et culturelle de Dakar, connue pour son marché et ses activités culturelles.',
                'ville_id' => 1, // ID de Dakar
            ],
            [
                'libelle' => 'Commune de Thiès Est',
                'description' => 'Une des principales communes de la ville de Thiès, avec de nombreuses industries.',
                'ville_id' => 2, // Remplacez par l'ID réel de la ville de Thiès
            ],
            [
                'libelle' => 'Commune de Saint-Louis Nord',
                'description' => 'Commune située dans la ville historique de Saint-Louis, ancienne capitale du Sénégal.',
                'ville_id' => 3, // Remplacez par l'ID réel de la ville de Saint-Louis
            ],
            [
                'libelle' => 'Commune de Kaolack',
                'description' => 'Commune principale de la ville de Kaolack, située sur les rives du fleuve Saloum.',
                'ville_id' => 4, // Remplacez par l'ID réel de la ville de Kaolack
            ],

        ]);
    }
}
