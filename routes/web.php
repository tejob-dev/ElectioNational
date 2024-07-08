<?php

use App\Models\MessageAgent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuiviController;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\ParrainController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\LieuVoteController;
use App\Http\Controllers\QuartierController;
use App\Http\Controllers\RCommuneController;
use App\Http\Controllers\ResultatController;
use App\Http\Controllers\RabatteurController;
use App\Http\Controllers\BureauVoteController;
use App\Http\Controllers\CorParrainController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\RecensementController;
use App\Http\Controllers\SousSectionController;
use App\Http\Controllers\AgentTerrainController;
use App\Http\Controllers\MessageAgentController;
use App\Http\Controllers\ProcesVerbalController;
use App\Http\Controllers\SupLieuDeVoteController;
use App\Http\Controllers\AgentDeSectionController;
use App\Http\Controllers\ElectorParrainController;
use App\Http\Controllers\OperateurSuiviController;
use App\Http\Controllers\AgentDuBureauVoteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->to('/dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');
    
Route::get("/recens/parrains/{single}/data", [RecensementController::class, "getParrainList"])->name("recens.parrains.list");
Route::get("/recens/quartiers/{single}/data", [RecensementController::class, "getQuartierList"])->name("recens.quartiers.list");
Route::get("/recens/lvotes/{single}/data", [RecensementController::class, "getLVList"])->name("recens.lvotes.list");
Route::get("/recens/districts/{single}/data", [RecensementController::class, "getDistrictList"])->name("recens.districts.list");
Route::get("/recens/communes/{single}/data", [RecensementController::class, "getCommuneList"])->name("recens.communes.list");
Route::get("/recens/regions/{single}/data", [RecensementController::class, "getRegionList"])->name("recens.regions.list");
Route::get("/recens/departements/{single}/data", [RecensementController::class, "getDepartementList"])->name("recens.departements.list");

Route::get("/agentterrains/{single}/data", [AgentTerrainController::class, "getAgentList"])->name("agentterrains.list");

Route::get("/suivis/communes/{single}/data", [SuiviController::class, "getListCommune"])->name("suivi.communes.list");
Route::get("/suivi/sections/{single}/data", [SuiviController::class, "getListSection"])->name("suivi.sections.list");
Route::get("/suivi/rcommunes/{single}/data", [SuiviController::class, "getListRCommune"])->name("suivi.rcommunes.list");
Route::get("/suivi/quartiers/{single}/data", [SuiviController::class, "getListQuartier"])->name("suivi.quartiers.list");
Route::get("/suivis/lieuvotes/{single}/data", [SuiviController::class, "getListLieuvote"])->name("suivi.lieuvotes.list");
Route::get("/suivis/bureauvotes/{single}/data", [SuiviController::class, "getListBureauvote"])->name("suivi.bureauvotes.list");
Route::get("/suivis/agentterrains/{single}/data", [SuiviController::class, "getListAgentterrain"])->name("suivi.agentterrains.list");

Route::get("/resultats/communes/{single}/data", [ResultatController::class, "getListCommune"])->name("resultats.communes.list");
Route::get("/resultats/sections/{single}/data", [ResultatController::class, "getListSection"])->name("resultats.sections.list");
Route::get("/resultats/rcommunes/{single}/data", [ResultatController::class, "getListRCommune"])->name("resultats.rcommunes.list");
Route::get("/resultats/quartiers/{single}/data", [ResultatController::class, "getListQuartier"])->name("resultats.quartiers.list");
Route::get("/resultats/lieuvotes/{single}/data", [ResultatController::class, "getListLieuvote"])->name("resultats.lieuvotes.list");
Route::get("/resultats/bureauvotes/{single}/data", [ResultatController::class, "getListBureauvote"])->name("resultats.bureauvotes.list");

Route::get("/downimage/{image}", function ($image){
    $filePath = public_path('storage/' . decrypt($image));
    //dd($filePath);
    // if (!Storage::exists($filePath)) {
    //     abort(404);
    // }

    return response()->download($filePath);
});

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('agent-de-sections', AgentDeSectionController::class);
        Route::resource(
            'agent-du-bureau-votes',
            AgentDuBureauVoteController::class
        );
        Route::resource('agent-terrains', AgentTerrainController::class);
        Route::resource('bureau-votes', BureauVoteController::class);
        Route::resource('candidats', CandidatController::class);
        Route::resource('communes', CommuneController::class);
        Route::resource('rcommunes', RCommuneController::class);
        Route::resource('lieu-votes', LieuVoteController::class);
        Route::resource('parrains', ParrainController::class);
        Route::resource('proces-verbals', ProcesVerbalController::class);
        Route::resource('quartiers', QuartierController::class);
        Route::resource('sections', SectionController::class);
        Route::resource('sup-lieu-de-votes', SupLieuDeVoteController::class);
        Route::resource('users', UserController::class);
        Route::resource('departements', DepartementController::class);
        Route::resource('sous-sections', SousSectionController::class);
        Route::resource('agentmessages', MessageAgentController::class);

        Route::get('/import/rabatteur', [RabatteurController::class, 'showImportRabat'])->name("import.rabatteurs");
        Route::post('/import/rabatteur/validate', [RabatteurController::class, 'importRabat'])->name("import.rabatteurs.validated");
        
        Route::get('/agentmessages/create/{type}', [MessageAgentController::class, 'create'])->name("agentmessages.make");

        Route::get("/alerte/agent/list", [AlerteController::class, "index"])->name("alerte.agentlist.index");
        Route::get("/alerte/agent/edit/{alerte}", [AlerteController::class, "edit"])->name("alerte.agentlist.edit");
        Route::post("/alerte/agent/update/{alerte}", [AlerteController::class, "update"])->name("alerte.agentlist.update");
        
        Route::get("/recens/sous-sections", [RecensementController::class, "listSousSection"])->name("recens.soussections.index");
        Route::get("/recens/districts", [RecensementController::class, "listDistrict"])->name("recens.districts.index");
        Route::get("/recens/regions", [RecensementController::class, "listRegion"])->name("recens.regions.index");
        Route::get("/recens/departements", [RecensementController::class, "listDepartement"])->name("recens.departements.index");
        Route::get("/recens/communes", [RecensementController::class, "listCommune"])->name("recens.communes.index");
        Route::get("/recens/rcommunes", [RecensementController::class, "listRCommune"])->name("recens.rcommunes.index");
        Route::get("/recens/sections", [RecensementController::class, "listSection"])->name("recens.sections.index");
        Route::get("/recens/quartiers", [RecensementController::class, "listQuartier"])->name("recens.quartiers.index");
        Route::get("/recens/lieuvotes", [RecensementController::class, "listLieuvote"])->name("recens.lieuvotes.index");
        Route::get("/recens/parrains", [RecensementController::class, "listParrain"])->name("recens.parrains.index");
        Route::get("/recens/search/all", [RecensementController::class, "searchs"])->name("recens.search.all");

        Route::get("/suivis/communes", [SuiviController::class, "listCommune"])->name("suivi.communes.index");
        Route::get("/suivis/sections", [SuiviController::class, "listSection"])->name("suivi.sections.index");
        Route::get("/suivis/rcommunes", [SuiviController::class, "listRcommune"])->name("suivi.rcommunes.index");
        Route::get("/suivis/quartiers", [SuiviController::class, "listQuartier"])->name("suivi.quartiers.index");
        Route::get("/suivis/lieuvotes", [SuiviController::class, "listLieuvote"])->name("suivi.lieuvotes.index");
        Route::get("/suivis/bureauvotes", [SuiviController::class, "listBureauvote"])->name("suivi.bureauvotes.index");
        Route::get("/suivis/agentterrains", [SuiviController::class, "listAgentterrain"])->name("suivi.agentterrains.index");

        Route::get("/resultats/communes", [ResultatController::class, "listCommune"])->name("resultats.communes.index");
        Route::get("/resultats/sections", [ResultatController::class, "listSection"])->name("resultats.sections.index");
        Route::get("/resultats/rcommunes", [ResultatController::class, "listRcommune"])->name("resultats.rcommunes.index");
        Route::get("/resultats/quartiers", [ResultatController::class, "listQuartier"])->name("resultats.quartiers.index");
        Route::get("/resultats/lieuvotes", [ResultatController::class, "listLieuvote"])->name("resultats.lieuvotes.index");
        Route::get("/resultats/bureauvotes", [ResultatController::class, "listBureauvote"])->name("resultats.bureauvotes.index");

        Route::get("/operateurs/index", [UserController::class, "operateurs"])->name("operateurs.index");
        
        Route::get("/export/all/parrains", [ParrainController::class, "exportParrains"])->name("parrains.export");
        Route::get("/export/parrain/only", [ParrainController::class, "exportParrainsOnly"]);

        Route::get('/elector-parrains/2024', [ElectorParrainController::class, 'elector2024'])->name("elector-parrains.index2");
        Route::resource('elector-parrains', ElectorParrainController::class);
        Route::resource('cor-parrains', CorParrainController::class);
        Route::resource('operateur-suivis', OperateurSuiviController::class);
        Route::resource('rabatteurs', RabatteurController::class);

        Route::resource('regions', RegionController::class);
        Route::resource('districts', DistrictController::class);

    });
