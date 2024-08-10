<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;


//spaties congiguration
  
// Route::get('/home', [HomeController::class, 'index'])->name('home');
  
// Route::group(['middleware' => ['auth']], function() {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users', AdminController::class);
    // });



//Login , register and logout
Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);
Route::get("logout", [AuthController::class, "logout"]);
Route::get("refreshToken", [AuthController::class, "refreshToken"]);
Route::put('update-profile/{id}', [AuthController::class, 'update']);

//softDelete
Route::delete('delete-account/{id}', [AuthController::class, 'softDelete']);



//gestion projet
Route::get('projets', [ProjetController::class, 'index'])->name('projets.index');          
Route::get('details/projet/{projet}', [ProjetController::class, 'show'])->name('projets.show');   
Route::put('update/projet/{projet}', [ProjetController::class, 'update'])->name('projets.update'); 
Route::post('add/projets', [ProjetController::class, 'store'])->name('projets.store');         
Route::delete('delete/projets/{projet}', [ProjetController::class, 'destroy'])->name('projets.destroy'); 

