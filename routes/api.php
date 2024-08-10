<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentaireController;



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

// routes pour gerer les commentaires
Route::apiResource('commentaires', CommentaireController::class);
// route pour vote
 Route::apiResource('votes', VoteController::class);


 //Route pour la commune



Route::get('communes', [CommuneController::class, 'index'])->name('communes.index');
Route::get('details/commune/{commune}', [CommuneController::class, 'show'])->name('communes.show');
Route::put('update/commune/{commune}', [CommuneController::class, 'update'])->name('communes.update');
Route::post('add/communes', [CommuneController::class, 'store'])->name('communes.store');
Route::delete('delete/commune/{commune}', [CommuneController::class, 'destroy'])->name('communes.destroy');
