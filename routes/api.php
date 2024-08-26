<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CommentaireController;


//spaties congiguration

Route::patch('/projets-statut/{projet}/', [ProjetController::class, 'updateStatut']);


//Route of the middleware Spaties
Route::group(['middleware' => ['auth']], function() {
    Route::apiResource('users', AdminController::class);

    //refrech Token
    Route::get("refreshToken", [AuthController::class, "refreshToken"]);
    //Restaurer un utilisateur
    Route::post('users/{id}/restore', [AuthController::class, 'restore']);
    //route update profil
    Route::put('update-profile', [AuthController::class, 'update']);
    //permissions
    // Route::get('/permissions', [PermissionController::class, 'getPermissions']);
    //récupération des permissions par rapport aux roles
    // Route::get('/roles/{roleId}/permissions', [RoleController::class, 'getRolePermissions']);
    // nombre d'utilisateurs
    Route::get('compteUser', [AdminController::class, 'getTotalUsers']);
    Route::get('compteCommune', [CommuneController::class, 'getTotalCommunes']);

 });


Route::middleware('auth:api')->group(function () {
    // Route::get('permissions', [PermissionController::class, 'getPermissions'])->middleware('can:view-any,' . Spatie\Permission\Models\Permission::class);
    // Route::get('/roles/{roleId}/permissions', [RoleController::class, 'getRolePermissions'])->middleware('can:view-any,' . Spatie\Permission\Models\Permission::class);
    // Route::apiResource('roles', RoleController::class)->middleware('can:view-any,' . Spatie\Permission\Models\Permission::class);
    Route::apiResource('users', AdminController::class);
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



// routes pour gerer les commentaires
Route::apiResource('commentaires', CommentaireController::class);
// route pour vote
 Route::apiResource('votes', VoteController::class);

 // route pour ville
 Route::apiResource('villes', VilleController::class);



 //Route pour la commune
Route::get('communes', [CommuneController::class, 'index'])->name('communes.index');
Route::get('details/commune/{commune}', [CommuneController::class, 'show'])->name('communes.show');
Route::put('update/commune/{commune}', [CommuneController::class, 'update'])->name('communes.update');
Route::post('add/communes', [CommuneController::class, 'store'])->name('communes.store');
Route::delete('delete/commune/{commune}', [CommuneController::class, 'destroy'])->name('communes.destroy');



//Route pour notification
Route::get('notifications', function () {
    $user = Auth::user();
    return response()->json($user->notifications, 200);
});


// mis a jour du statut

// recuperation des projtes publies et non publies
 Route::get('/projets/publies', [ProjetController::class, 'getProjetsPublies']);
Route::get('/projets/non-publies', [ProjetController::class, 'getProjetsNonPublies']);

// les projets soumis
Route::get('projets/publies/{userId}', [ProjetController::class, 'getPublishedProjectsByUser']);

// routes qui affiche le nombre de projets
// Exemple pour Laravel
Route::get('/projets/count', [ProjetController::class, 'countTotalProjets']);
Route::get('/projets/publies/count', [ProjetController::class, 'countProjetsPublies']);
// publication







Route::middleware(['auth'])->group(function () {
    Route::get('/projets/statistics', [ProjetController::class, 'statistics'])->name('projets.statistics');
});

Route::put('users/{id}/roles', [AdminController::class, 'updateRoles'])
->middleware('permission:admin-edit');



//gestion projet
Route::get('projets', [ProjetController::class, 'index'])->name('projets.index');
Route::get('details/projet/{projet}', [ProjetController::class, 'show'])->name('projets.show');
Route::patch('update/projet/{projet}', [ProjetController::class, 'update'])->name('projets.update');
Route::post('add/projets', [ProjetController::class, 'store'])->name('projets.store');
Route::delete('delete/projets/{projet}', [ProjetController::class, 'destroy'])->name('projets.destroy');


route::get('/projets/{projet}/votes', [ProjetController::class, 'getVoteStatistics']);
