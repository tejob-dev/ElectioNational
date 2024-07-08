<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommuneController;
use App\Http\Controllers\Api\ParrainController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\CandidatController;
use App\Http\Controllers\Api\LieuVoteController;
use App\Http\Controllers\Api\QuartierController;
use App\Http\Controllers\Api\RabatteurController;
use App\Http\Controllers\Api\BureauVoteController;
use App\Http\Controllers\Api\CommonItemController;
use App\Http\Controllers\Api\CorParrainController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\DepartementController;
use App\Http\Controllers\Api\AgentTerrainController;
use App\Http\Controllers\Api\CommuneUsersController;
use App\Http\Controllers\Api\ProcesVerbalController;
use App\Http\Controllers\Api\SupLieuDeVoteController;
use App\Http\Controllers\Api\AgentDeSectionController;
use App\Http\Controllers\Api\OperateurSuiviController;
use App\Http\Controllers\Api\CommuneSectionsController;
use App\Http\Controllers\Api\CommonItemMobileController;
use App\Http\Controllers\Api\CommuneLieuVotesController;
use App\Http\Controllers\Api\DepartementUsersController;
use App\Http\Controllers\Api\LieuVoteCommunesController;
use App\Http\Controllers\Api\SectionQuartiersController;
use App\Http\Controllers\Api\AgentDuBureauVoteController;
use App\Http\Controllers\Api\QuartierLieuVotesController;
use App\Http\Controllers\Api\LieuVoteRabatteursController;
use App\Http\Controllers\Api\RabatteurLieuVotesController;
use App\Http\Controllers\Api\CommuneDepartementsController;
use App\Http\Controllers\Api\DepartementCommunesController;
use App\Http\Controllers\Api\LieuVoteBureauVotesController;
use App\Http\Controllers\Api\LieuVoteAgentTerrainsController;
use App\Http\Controllers\Api\LieuVoteSupLieuDeVotesController;
use App\Http\Controllers\Api\SectionAgentDeSectionsController;
use App\Http\Controllers\Api\BureauVoteProcesVerbalsController;
use App\Http\Controllers\Api\LieuVoteOperateurSuivisController;
use App\Http\Controllers\Api\OperateurSuiviLieuVotesController;
use App\Http\Controllers\Api\BureauVoteAgentDuBureauVotesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource(
            'agent-de-sections',
            AgentDeSectionController::class
        );

        Route::apiResource('cor-parrains', CorParrainController::class);

        Route::apiResource(
            'agent-du-bureau-votes',
            AgentDuBureauVoteController::class
        );

        Route::apiResource('agent-terrains', AgentTerrainController::class);

        Route::apiResource('bureau-votes', BureauVoteController::class);

        // BureauVote Agent Du Bureau Votes
        Route::get('/bureau-votes/{bureauVote}/agent-du-bureau-votes', [
            BureauVoteAgentDuBureauVotesController::class,
            'index',
        ])->name('bureau-votes.agent-du-bureau-votes.index');
        Route::post('/bureau-votes/{bureauVote}/agent-du-bureau-votes', [
            BureauVoteAgentDuBureauVotesController::class,
            'store',
        ])->name('bureau-votes.agent-du-bureau-votes.store');

        // BureauVote Proces Verbals
        Route::get('/bureau-votes/{bureauVote}/proces-verbals', [
            BureauVoteProcesVerbalsController::class,
            'index',
        ])->name('bureau-votes.proces-verbals.index');
        Route::post('/bureau-votes/{bureauVote}/proces-verbals', [
            BureauVoteProcesVerbalsController::class,
            'store',
        ])->name('bureau-votes.proces-verbals.store');

        Route::apiResource('candidats', CandidatController::class);

        Route::apiResource('communes', CommuneController::class);

        // Commune Users
        Route::get('/communes/{commune}/users', [
            CommuneUsersController::class,
            'index',
        ])->name('communes.users.index');
        Route::post('/communes/{commune}/users', [
            CommuneUsersController::class,
            'store',
        ])->name('communes.users.store');

        // Commune Sections
        Route::get('/communes/{commune}/sections', [
            CommuneSectionsController::class,
            'index',
        ])->name('communes.sections.index');
        Route::post('/communes/{commune}/sections', [
            CommuneSectionsController::class,
            'store',
        ])->name('communes.sections.store');

        // Commune Lieu Votes
        Route::get('/communes/{commune}/lieu-votes', [
            CommuneLieuVotesController::class,
            'index',
        ])->name('communes.lieu-votes.index');
        Route::post('/communes/{commune}/lieu-votes/{lieuVote}', [
            CommuneLieuVotesController::class,
            'store',
        ])->name('communes.lieu-votes.store');
        Route::delete('/communes/{commune}/lieu-votes/{lieuVote}', [
            CommuneLieuVotesController::class,
            'destroy',
        ])->name('communes.lieu-votes.destroy');

        // Commune Departements
        Route::get('/communes/{commune}/departements', [
            CommuneDepartementsController::class,
            'index',
        ])->name('communes.departements.index');
        Route::post('/communes/{commune}/departements/{departement}', [
            CommuneDepartementsController::class,
            'store',
        ])->name('communes.departements.store');
        Route::delete('/communes/{commune}/departements/{departement}', [
            CommuneDepartementsController::class,
            'destroy',
        ])->name('communes.departements.destroy');

        Route::apiResource('lieu-votes', LieuVoteController::class);

        // LieuVote Bureau Votes
        Route::get('/lieu-votes/{lieuVote}/bureau-votes', [
            LieuVoteBureauVotesController::class,
            'index',
        ])->name('lieu-votes.bureau-votes.index');
        Route::post('/lieu-votes/{lieuVote}/bureau-votes', [
            LieuVoteBureauVotesController::class,
            'store',
        ])->name('lieu-votes.bureau-votes.store');

        // LieuVote Sup Lieu De Votes
        Route::get('/lieu-votes/{lieuVote}/sup-lieu-de-votes', [
            LieuVoteSupLieuDeVotesController::class,
            'index',
        ])->name('lieu-votes.sup-lieu-de-votes.index');
        Route::post('/lieu-votes/{lieuVote}/sup-lieu-de-votes', [
            LieuVoteSupLieuDeVotesController::class,
            'store',
        ])->name('lieu-votes.sup-lieu-de-votes.store');

        // LieuVote Agent Terrains
        Route::get('/lieu-votes/{lieuVote}/agent-terrains', [
            LieuVoteAgentTerrainsController::class,
            'index',
        ])->name('lieu-votes.agent-terrains.index');
        Route::post('/lieu-votes/{lieuVote}/agent-terrains', [
            LieuVoteAgentTerrainsController::class,
            'store',
        ])->name('lieu-votes.agent-terrains.store');

        // LieuVote Communes
        Route::get('/lieu-votes/{lieuVote}/communes', [
            LieuVoteCommunesController::class,
            'index',
        ])->name('lieu-votes.communes.index');
        Route::post('/lieu-votes/{lieuVote}/communes/{commune}', [
            LieuVoteCommunesController::class,
            'store',
        ])->name('lieu-votes.communes.store');
        Route::delete('/lieu-votes/{lieuVote}/communes/{commune}', [
            LieuVoteCommunesController::class,
            'destroy',
        ])->name('lieu-votes.communes.destroy');

        Route::apiResource('parrains', ParrainController::class);

        Route::apiResource('proces-verbals', ProcesVerbalController::class);

        Route::apiResource('quartiers', QuartierController::class);

        // Quartier Lieu Votes
        Route::get('/quartiers/{quartier}/lieu-votes', [
            QuartierLieuVotesController::class,
            'index',
        ])->name('quartiers.lieu-votes.index');
        Route::post('/quartiers/{quartier}/lieu-votes', [
            QuartierLieuVotesController::class,
            'store',
        ])->name('quartiers.lieu-votes.store');

        Route::apiResource('sections', SectionController::class);

        // Section Quartiers
        Route::get('/sections/{section}/quartiers', [
            SectionQuartiersController::class,
            'index',
        ])->name('sections.quartiers.index');
        Route::post('/sections/{section}/quartiers', [
            SectionQuartiersController::class,
            'store',
        ])->name('sections.quartiers.store');

        // Section Agent De Sections
        Route::get('/sections/{section}/agent-de-sections', [
            SectionAgentDeSectionsController::class,
            'index',
        ])->name('sections.agent-de-sections.index');
        Route::post('/sections/{section}/agent-de-sections', [
            SectionAgentDeSectionsController::class,
            'store',
        ])->name('sections.agent-de-sections.store');

        Route::apiResource('sup-lieu-de-votes', SupLieuDeVoteController::class);

        Route::apiResource('users', UserController::class);

        Route::apiResource('departements', DepartementController::class);

        // Departement Users
        Route::get('/departements/{departement}/users', [
            DepartementUsersController::class,
            'index',
        ])->name('departements.users.index');
        Route::post('/departements/{departement}/users', [
            DepartementUsersController::class,
            'store',
        ])->name('departements.users.store');

        // Departement Communes
        Route::get('/departements/{departement}/communes', [
            DepartementCommunesController::class,
            'index',
        ])->name('departements.communes.index');
        Route::post('/departements/{departement}/communes/{commune}', [
            DepartementCommunesController::class,
            'store',
        ])->name('departements.communes.store');
        Route::delete('/departements/{departement}/communes/{commune}', [
            DepartementCommunesController::class,
            'destroy',
        ])->name('departements.communes.destroy');

        Route::get('/lieu-votes/{lieuVote}/rabatteurs', [
            LieuVoteRabatteursController::class,
            'index',
        ])->name('lieu-votes.rabatteurs.index');
        Route::post('/lieu-votes/{lieuVote}/rabatteurs/{rabatteur}', [
            LieuVoteRabatteursController::class,
            'store',
        ])->name('lieu-votes.rabatteurs.store');
        Route::delete('/lieu-votes/{lieuVote}/rabatteurs/{rabatteur}', [
            LieuVoteRabatteursController::class,
            'destroy',
        ])->name('lieu-votes.rabatteurs.destroy');

        // LieuVote Operateur Suivis
        Route::get('/lieu-votes/{lieuVote}/operateur-suivis', [
            LieuVoteOperateurSuivisController::class,
            'index',
        ])->name('lieu-votes.operateur-suivis.index');
        Route::post(
            '/lieu-votes/{lieuVote}/operateur-suivis/{operateurSuivi}',
            [LieuVoteOperateurSuivisController::class, 'store']
        )->name('lieu-votes.operateur-suivis.store');
        Route::delete(
            '/lieu-votes/{lieuVote}/operateur-suivis/{operateurSuivi}',
            [LieuVoteOperateurSuivisController::class, 'destroy']
        )->name('lieu-votes.operateur-suivis.destroy');

        Route::apiResource('operateur-suivis', OperateurSuiviController::class);

        // OperateurSuivi Lieu Votes
        Route::get('/operateur-suivis/{operateurSuivi}/lieu-votes', [
            OperateurSuiviLieuVotesController::class,
            'index',
        ])->name('operateur-suivis.lieu-votes.index');
        Route::post(
            '/operateur-suivis/{operateurSuivi}/lieu-votes/{lieuVote}',
            [OperateurSuiviLieuVotesController::class, 'store']
        )->name('operateur-suivis.lieu-votes.store');
        Route::delete(
            '/operateur-suivis/{operateurSuivi}/lieu-votes/{lieuVote}',
            [OperateurSuiviLieuVotesController::class, 'destroy']
        )->name('operateur-suivis.lieu-votes.destroy');

        Route::apiResource('rabatteurs', RabatteurController::class);

        // Rabatteur Lieu Votes
        Route::get('/rabatteurs/{rabatteur}/lieu-votes', [
            RabatteurLieuVotesController::class,
            'index',
        ])->name('rabatteurs.lieu-votes.index');
        Route::post('/rabatteurs/{rabatteur}/lieu-votes/{lieuVote}', [
            RabatteurLieuVotesController::class,
            'store',
        ])->name('rabatteurs.lieu-votes.store');
        Route::delete('/rabatteurs/{rabatteur}/lieu-votes/{lieuVote}', [
            RabatteurLieuVotesController::class,
            'destroy',
        ])->name('rabatteurs.lieu-votes.destroy');
        
    });
    
    Route::post("/poste/alerte/agent", [AlerteController::class, "store"]);
    
    Route::post("/common/apis/all/items", [CommonItemController::class, "checker"])->name("common.api.all.items");
    Route::post("/common/apis/nmd/items", [CommonItemController::class, "checkernmd"])->name("common.api.nmd.items");
    //Route::post("/common/apis/mobile/items", [CommonItemMobileController::class, "checker"])->name("common.api.mobille.items");
