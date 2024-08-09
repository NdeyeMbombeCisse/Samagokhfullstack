<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjetController;

Route::get('projets', [ProjetController::class, 'index'])->name('projets.index');          
