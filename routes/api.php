<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjetController;

Route::get('projets', [ProjetController::class, 'index'])->name('projets.index');          
Route::get('details/projet/{projet}', [ProjetController::class, 'show'])->name('projets.show');   
Route::put('update/projet/{projet}', [ProjetController::class, 'update'])->name('projets.update'); 
Route::post('add/projets', [ProjetController::class, 'store'])->name('projets.store');         
