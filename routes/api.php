<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\AuthController;


//spaties congiguration
  
//Route of the middleware Spaties  
Route::group(['middleware' => ['auth']], function() {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users', AdminController::class);

    //refrech Token
    Route::get("refreshToken", [AuthController::class, "refreshToken"]);
    //Restaurer un utilisateur
    Route::post('etudiants/{id}/restore', [AuthController::class, 'restore']);
     });



//Login , register and logout
//register
Route::post("register", [AuthController::class, "register"]);
//route of login
Route::post("login", [AuthController::class, "login"]);
//route of logout
Route::get("logout", [AuthController::class, "logout"]);
//route of refresh
Route::get("refreshToken", [AuthController::class, "refreshToken"]);
//route update profil
Route::put('update-profile/{id}', [AuthController::class, 'update']);

//softDelete
Route::delete('delete-account/{id}', [AuthController::class, 'softDelete']);



//gestion projet
Route::get('projets', [ProjetController::class, 'index'])->name('projets.index');          
Route::get('details/projet/{projet}', [ProjetController::class, 'show'])->name('projets.show');   
Route::put('update/projet/{projet}', [ProjetController::class, 'update'])->name('projets.update'); 
Route::post('add/projets', [ProjetController::class, 'store'])->name('projets.store');         
Route::delete('delete/projets/{projet}', [ProjetController::class, 'destroy'])->name('projets.destroy'); 

