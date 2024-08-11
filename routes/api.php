<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\VilleController;



//Login , register and logout
Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);
Route::get("logout", [AuthController::class, "logout"]);
Route::get("refreshToken", [AuthController::class, "refreshToken"]);


//gestion projet
Route::get('projets', [ProjetController::class, 'index'])->name('projets.index');          
Route::get('details/projet/{projet}', [ProjetController::class, 'show'])->name('projets.show');   
Route::put('update/projet/{projet}', [ProjetController::class, 'update'])->name('projets.update'); 
Route::post('add/projets', [ProjetController::class, 'store'])->name('projets.store');         
Route::delete('delete/projets/{projet}', [ProjetController::class, 'destroy'])->name('projets.destroy'); 




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// routes pour gerer les commentaires
Route::apiResource('commentaires', CommentaireController::class);
// route pour vote
 Route::apiResource('votes', VoteController::class);

 // route pour ville
 Route::apiResource('villes', VilleController::class);

