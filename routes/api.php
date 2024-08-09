<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\VoteController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// routes pour gerer les commentaires
Route::apiResource('commentaires', CommentaireController::class);
// route pour vote
 Route::apiResource('votes', VoteController::class);
