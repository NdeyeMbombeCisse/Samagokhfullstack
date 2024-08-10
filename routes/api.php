<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProjetController;



//Login , register and logout
Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);
Route::get("logout", [AuthController::class, "logout"]);
Route::get("refreshToken", [AuthController::class, "refreshToken"]);
Route::put('update-profile', [AuthController::class, 'update']);



//gestion projet
Route::get('projets', [ProjetController::class, 'index'])->name('projets.index');          
Route::get('details/projet/{projet}', [ProjetController::class, 'show'])->name('projets.show');   
Route::put('update/projet/{projet}', [ProjetController::class, 'update'])->name('projets.update'); 
Route::post('add/projets', [ProjetController::class, 'store'])->name('projets.store');         
Route::delete('delete/projets/{projet}', [ProjetController::class, 'destroy'])->name('projets.destroy'); 

