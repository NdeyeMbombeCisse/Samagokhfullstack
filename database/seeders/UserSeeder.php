<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            "commune_id"=> 4,
            "prenom"=> "Bouna",
            "nom"=> "Drame",
            "CNI"=>"1793201800042",
            "date_naissance"=> "1990-01-01",
            "adresse"=> "123 Main St",
            "lieu_naissance"=> "Cityville",
            "fonction"=> "etudiant",
            "genre"=> "masculin",
            "telephone"=> "771860200",
            "situation_matrimoniale"=> "celibataire",
            "date_integration"=> "2024-01-01",
            "date_sortie"=> "2024-12-31",
            "photo"=> null,
            "email"=> "test61345@gmail.com",
            "password" => Hash::make('password'),
            "remember_token" => Str::random(10),
        ]);

        $user->assignRole('admin');

    }

}
