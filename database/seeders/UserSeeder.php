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
        User::create([
            'nom' => "Serigne Fallou Niang",
            'email' => "serignefallou@gmail.com",
            'date_naissance' => "1990/01/01",
            'adresse' => "Touba",
            'lieu_naissance' => "Touba",
            'genre' => "masculin",
            'telephone' => "766149938",
            'situation_matrimoniale' => "marie",  // Correction ici
            'commune_id' => 2,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ],
    [
       'nom' => "Ndeye Mbombe Cisse",
            'email' => "nmc@gmail.com",
            'date_naissance' => "1990/01/01",
            'adresse' => "Touba",
            'lieu_naissance' => "Touba",
            'genre' => "masculin",
            'telephone' => "784055367",
            'situation_matrimoniale' => "marie",  // Correction ici
            'commune_id' => 2,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10), 
    ]);
    }
}
