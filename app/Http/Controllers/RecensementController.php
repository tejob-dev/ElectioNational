<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\Commune;
use App\Models\Parrain;
use App\Models\Section;
use App\Models\LieuVote;
use App\Models\Quartier;
use App\Models\SousSection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\AgentDeSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecensementController extends Controller
{
 
    public function getLVList(Request $request, $single){
        if ($request->ajax()) {

            $totalCount = LieuVote::count();
            $lieus = LieuVote::userlimit()
                ->skip($request->start)
                ->take($request->length);
            // dd($lieus);
                
            // $parrains = Parrain::all();
            return DataTables::of($lieus)
                ->addColumn('regionm', function ($lieu) {
                    return optional($lieu->quartier->section->section->commune)->libel ?? '-';
                })
                ->addColumn('departm', function ($lieu) {
                    return optional($lieu->quartier->section->section)->libel ?? '-';
                })
                ->addColumn('communem', function ($lieu) {
                    return optional($lieu->quartier->section)->libel ?? '-';
                })
                ->addColumn('sectionm', function ($lieu) {
                    return optional($lieu->quartier)->libel ?? '-';
                })
                ->addColumn('parrainm', function ($lieu) {
                    // $parrainCount = Parrain::where('code_lv', 'like', '%'.$lieu->libel.'%')->count();
                    $lieuId = $lieu->id;
                    $parrainCount = Parrain::whereIn('code_lv', function ($query) use ($lieuId) {
                        $query->select('lieu_votes.libel')
                            ->from('agent_terrains')
                            ->join('quartiers', 'agent_terrains.section_id', '=', 'quartiers.id')
                            ->join('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                            ->where('lieu_votes.id', $lieuId);
                    })->count();  
                    return $parrainCount;
                })
                ->rawColumns(['regionm','departm','communem', 'sectionm', 'parrainm'])
                ->setTotalRecords($totalCount)
                ->setFilteredRecords(intval($request->length))
                ->toJson();

            // dd($dataJson->getContent());

            
                // ->make(true);

        }
    }
    
    public function getQuartierList(Request $request, $single){
        if ($request->ajax()) {
            
            $quartiers = Quartier::userlimit()->with('section.section.commune', 'lieuVotes')->latest()->get();
            // $parrains = Parrain::get();
            // $lieuVotesList = LieuVote::get();
            // $parrainCounts = [];

            // dd($quartiers, $parrains);
            
            // foreach ($quartiers as $quartier) {
            //     $parrainCount = 0;
            //     $lvIds = $quartier->lieuVotes->pluck('id')->toArray();
                
            //     $lieuVotes = $lieuVotesList->filter(function ($lieuVote) use($lvIds) {
            //         return in_array($lieuVote->id, $lvIds);
            //     });
            
            //     foreach ($lieuVotes as $lieuVote) {
            //         $filteredParrains = $parrains->filter(function ($parrain) use ($lieuVote) {
            //             return $parrain->code_lv == $lieuVote->libel;
            //         });
            //         $parrainCount += $filteredParrains->count();
            //     }
            
            //     $parrainCounts[$quartier->id] = $parrainCount;
            // }

            // dd($parrainCounts);
            
            return DataTables::of($quartiers)
                ->addColumn('regionm', function ($quartier) {
                    return ($quartier->section?->section?->commune)->libel ?? '-';
                })
                ->addColumn('departm', function ($quartier) {
                    return optional($quartier->section?->section)->libel ?? '-';
                })
                ->addColumn('communem', function ($quartier) {
                    return optional($quartier->section)->libel ?? '-';
                })
                ->addColumn('sectionm', function ($quartier) {
                    return optional($quartier)->libel ?? '-';
                })
                ->addColumn('parrainm', function ($quartier)  {
                    $parrainCount = 0;
                    $quartierId = $quartier->id;
                    $parrainCount = Parrain::whereIn('code_lv', function ($query) use ($quartierId) {
                        $query->select('lieu_votes.libel')
                            ->from('agent_terrains')
                            ->join('quartiers', 'agent_terrains.section_id', '=', 'quartiers.id')
                            ->join('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                            ->where('quartiers.id', $quartierId)
                            ->where('lieu_votes.imported', false);
                    })->count();                    

                    // foreach ($quartier->lieuVotes->where("imported", "=", false) as $lieuVote){
                    //     $parrainCount += Parrain::where('code_lv', 'like', '%'.$lieuVote->libel.'%')->count();;
                    // }
                    // foreach ($quartier->section->agentTerrains as $terrain) {
                    //     $parrainCount += $terrain->parrains->count();
                    // }
                    return $parrainCount.'';
                })
                ->rawColumns(['regionm', 'departm', 'communem', 'sectionm', 'parrainm'])
                
                ->make(true);
        }
    }
    
    public function getParrainList(Request $request, $single){
        if ($request->ajax()) {
            
            $parrains = Parrain::userlimit()->where("imported", "=", false)->with('agentterrain.sousSection')->latest()->get();
    
            return DataTables::of($parrains)
                ->addColumn('agent', function ($parrain) {
                    return (optional($parrain->agentterrain)->nom ?? $parrain->nom_pren_par)." ".(optional($parrain->agentterrain)->prenom ?? '');
                })
                ->addColumn('telephoneag', function ($parrain) {
                    return (optional($parrain->agentterrain)->telephone ?? $parrain->telephone_par);
                })
                ->addColumn('section', function ($parrain) {
                    return (optional($parrain->agentterrain)->section->libel ?? '-');
                })
                // ->addColumn('soussection', function ($parrain) {
                //     return (optional($parrain->agentterrain)->sousSection->libel ?? "-");
                // })
                ->addColumn('date_naissp', function ($parrain) {
                    return $parrain->date_naiss ? Carbon::createFromFormat('Y-m-d H:i:s', $parrain->date_naiss)->format('d/m/Y'): '-';
                })
                ->addColumn('createdat', function ($parrain) {
                    return $parrain->created_at ? Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('d/m/Y')." à ".Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('H:i'): '-';
                })
                ->addColumn('pphoto', function($parrain) {
                    $listofpv = "";
                    if($parrain->photo){
                        $miicon = '<i class="ion ion-md-camera"></i>';
                        if(Str::contains($parrain->photo, "parraineer.png") == false){
                            $miicon = '<img src=\''.(Storage::url($parrain->photo)).'\' style=\'width: 30px; height: 30px; margin: 0 auto;\'>';
                        }
                        
                        $listofpv .= '<div class="KBmodal" data-content-url="<div style=\'position:relative;\'> <h3 style=\'background-color:white;color:black;font-weight:bold;position:absolute;left:0;top:0;\'>'.(optional($parrain)->nom??"-".' '.optional($parrain)->nom??"-").'</h3> <img src=\''.(Storage::url($parrain->photo)).'\' style=\'max-width: 1550px; max-height: 670px;\'></div>" data-content-type="html">'.$miicon.'</div>&nbsp;';
                    }
                    // foreach($bureauvote->procesverbals as $pverb){
                    // }
                    return $listofpv;
                })
                ->rawColumns(['agent', 'telephoneag', 'section', 'createdat', 'pphoto'])
                ->make(true);
        }
    }
    
    public function listCommune(Request $request){
        $curr_user = Auth::user();
        $commune = $curr_user->commune;
        $agent_Section = null;
        $isOperateur = false;
        $communeModel = new Commune;
        $query = $communeModel->newQuery();

        if($request->search) $query->where("libel", "like", "%".$request->search."%");

        if($curr_user->hasRole("super-admin") || $curr_user->hasRole("Admin") || $curr_user->hasRole("Invité") || $curr_user->hasPermissionTo("can-open-all")){
            $communes = $query->latest()->paginate(12)
            ->withQueryString();
        }

        if($curr_user->hasPermissionTo("can-open-section-only")){
            $isOperateur = true;
            $name = $curr_user->name;
            $prenom = $curr_user->prenom;
            $agent_Section = AgentDeSection::where([
                ["nom","like", $name],
                ["prenom","like", $prenom],
            ])->with("section.commune")->first();
            $communeId = $agent_Section->section->commune->id;
            
            $communes = $query->where("id", $communeId)->paginate(12)
            ->withQueryString();
        }
        //dd($parrainCount);
        return view("app.recens.index-commune", compact("communes", "agent_Section", "isOperateur"));
    }

    public function listSection(Request $request){

        $curr_user = Auth::user();
        $agent_Section = null;
        $isOperateur = false;
        $sectionModel = new Quartier;
        $query = $sectionModel->newQuery();
        $query->userlimit();
        if($request->search){
            $sear = $request->search;
            $query->with("commune")
            ->where("libel", "like", "%".$request->search."%")
            ->orWhereHas("commune", function($q) use($sear){
                $q->where("libel", "like", "%".$sear."%");
            });
        }

        if($curr_user->hasRole("super-admin") || $curr_user->hasRole("Admin") || $curr_user->hasRole("Invité") || $curr_user->hasPermissionTo("can-open-all")){
            $sections = $query->latest()->paginate(12)
            ->withQueryString();
        }

        if($curr_user->hasPermissionTo("can-open-section-only")){
            $isOperateur = true;
            $name = $curr_user->name;
            $prenom = $curr_user->prenom;
            $agent_Section = AgentDeSection::where([
                ["nom","like", $name],
                ["prenom","like", $prenom],
            ])->with("section.commune")->first();
            $sectionId = $agent_Section->section->id;
            
            $sections = $query->where("id", $sectionId)->paginate(12)
            ->withQueryString();
        }

        return view("app.recens.index-section", compact("sections", "isOperateur"));
    }
    
    public function listSousSection(Request $request){

        $curr_user = Auth::user();
        $agent_Section = null;
        $isOperateur = false;
        $sectionModel = new SousSection;
        $query = $sectionModel->newQuery();
        $query->userlimit();
        if($request->search){
            $sear = $request->search;
            $query
            ->where("libel", "like", "%".$request->search."%");
        }

        if($curr_user->hasRole("super-admin") || $curr_user->hasRole("Admin") || $curr_user->hasRole("Invité") || $curr_user->hasPermissionTo("can-open-all")){
            $soussections = $query->latest()->paginate(12)
            ->withQueryString();
        }

        if($curr_user->hasPermissionTo("can-open-soussection-only")){
            $isOperateur = true;
            // $name = $curr_user->name;
            // $prenom = $curr_user->prenom;
            // $agent_Section = AgentDeSection::where([
            //     ["nom","like", $name],
            //     ["prenom","like", $prenom],
            // ])->with("section.commune")->first();
            // $sectionId = $agent_Section->section->id;
            
            $soussections = $query->latest()->paginate(12)
            ->withQueryString();
        }

        return view("app.recens.index-soussection", compact("soussections", "isOperateur"));
    }

    public function listRCommune(Request $request){

        $curr_user = Auth::user();
        $agent_Section = null;
        $isOperateur = false;
        $sectionModel = new Quartier;
        $query = $sectionModel->newQuery();

        if($request->search){
            $sear = $request->search;
            $query->with(["commune","quartiers"])
            ->where("libel", "like", "%".$request->search."%")
            ->orWhereHas("commune", function($q) use($sear){
                $q->where("libel", "like", "%".$sear."%");
            })
            ->orWhereHas("quartiers", function($q) use($sear){
                $q->where("libel", "like", "%".$sear."%");
            });
        }

        if($curr_user->hasRole("super-admin") || $curr_user->hasRole("Admin") || $curr_user->hasRole("Invité") || $curr_user->hasPermissionTo("can-open-all")){
            $sections = $query->latest()->paginate(12)
            ->withQueryString();
        }

        if($curr_user->hasPermissionTo("can-open-section-only")){
            $isOperateur = true;
            $name = $curr_user->name;
            $prenom = $curr_user->prenom;
            $agent_Section = AgentDeSection::where([
                ["nom","like", $name],
                ["prenom","like", $prenom],
            ])->with("section.section.section.commune")->first();
            $sectionId = $agent_Section->section->id;
            
            $sections = $query->where("id", $sectionId)->paginate(12)
            ->withQueryString();
        }

        return view("app.recens.index-rcommune", compact("sections", "isOperateur"));
    }
    
    public function listQuartier(Request $request){

        $curr_user = Auth::user();
        $agent_Section = null;
        $isOperateur = false;
        $sectionModel = new Quartier;
        $query = $sectionModel->newQuery();

        if($request->search){
            $sear = $request->search;
            $query->with(["commune","quartiers"])
            ->where("libel", "like", "%".$request->search."%")
            ->orWhereHas("commune", function($q) use($sear){
                $q->where("libel", "like", "%".$sear."%");
            })
            ->orWhereHas("quartiers", function($q) use($sear){
                $q->where("libel", "like", "%".$sear."%");
            });
        }

        if($curr_user->hasRole("super-admin") || $curr_user->hasRole("Admin") || $curr_user->hasRole("Invité") || $curr_user->hasPermissionTo("can-open-all")){
            $sections = $query->latest()->paginate(12)
            ->withQueryString();
        }

        if($curr_user->hasPermissionTo("can-open-section-only")){
            $isOperateur = true;
            $name = $curr_user->name;
            $prenom = $curr_user->prenom;
            $agent_Section = AgentDeSection::where([
                ["nom","like", $name],
                ["prenom","like", $prenom],
            ])->with("section.commune")->first();
            $sectionId = $agent_Section->section->id;
            
            $sections = $query->where("id", $sectionId)->paginate(12)
            ->withQueryString();
        }

        return view("app.recens.index-quartier", compact("sections", "isOperateur"));
    }

    public function listLieuvote(Request $request){

        $curr_user = Auth::user();
        $agent_Section = null;
        $isOperateur = false;
        $sectionModel = new Quartier;
        $query = $sectionModel->newQuery();

        if($request->search){
            $sear = $request->search;
            if($request->items == 0){
                $query->with("commune")
                ->where("libel", "like", "%".$request->search."%")
                ->orWhereHas("commune", function($q) use($sear){
                    $q->where("libel", "like", "%".$sear."%");
                });
            }
            if($request->items == 1){
                $query->where("libel", "like", "%".$request->search."%");
            }
            
            if($request->items == 2){
                $query->orWhereHas("quartiers", function($q) use($sear){
                    $q->where("libel", "like", "%".$sear."%");
                })
                ->with(['quartiers' => function ($query) use ($sear) {
                    $query->where('libel', "like", "%".$sear."%");
                }]);
            }
            
            if($request->items == 3){
                $query->orWhereHas("quartiers.lieuvotes", function($q) use($sear){
                    $q->where("libel", "like", "%".$sear."%");;
                })
                ->with(['quartiers.lieuvotes' => function ($query) use ($sear) {
                    $query->where('libel', "like", "%".$sear."%");
                }]);
            }
            
            
        }

        if($curr_user->hasRole("super-admin") || $curr_user->hasRole("Admin") || $curr_user->hasRole("Invité") || $curr_user->hasPermissionTo("can-open-all")){
            $sections = $query->latest()->paginate(4)
            ->withQueryString();
        }

        if($curr_user->hasPermissionTo("can-open-section-only")){
            $isOperateur = true;
            $name = $curr_user->name;
            $prenom = $curr_user->prenom;
            $agent_Section = AgentDeSection::where([
                ["nom","like", $name],
                ["prenom","like", $prenom],
            ])->with("section.commune")->first();
            $sectionId = $agent_Section->section->id;
            
            $sections = $query->where("id", $sectionId)->paginate(4)
            ->withQueryString();
        }
        

        return view("app.recens.index-lieuvote", compact("sections", "isOperateur"));
    }

    public function listParrain(Request $request){

        return view("app.recens.index-parrain");
    }
    // public function listParrain(Request $request){

    //     $curr_user = Auth::user();
    //     $agent_Section = null;
    //     $breakSearch = null;
    //     $isOperateur = false;
    //     $sectionModel = new Section;
    //     $query = $sectionModel->newQuery();
    //     $searchType = 0;

    //     if($request->search){
    //         $sear = $request->search;
    //         if($request->items == 0){
    //             $query->with("commune")
    //             ->where("libel", "like", "%".$request->search."%")
    //             ->orWhereHas("commune", function($q) use($sear){
    //                 $q->where("libel", "like", "%".$sear."%");
    //             });
    //         }
    //         if($request->items == 1){
    //             $query->where("libel", "like", "%".$request->search."%");
    //             $searchType = 1;
    //         }
            
    //         if($request->items == 2){
    //             $searchType = 2;
    //             $breakSearch = $sear;
    //             $query->whereHas("quartiers", function($q) use($sear){
    //                 $list = [
    //                     'libel',
    //                 ];
    //                 foreach ($list as $column) {
    //                     $q->orWhere($column, "like", "%".$sear."%");
    //                 }
    //             })
    //             ->with(['agentterrains.parrains' => function ($query) {
    //                     $query->orderBy('created_at');
    //                 }
    //             ,'quartiers' => function ($query) use ($sear) {
    //                 $list = [
    //                     'libel',
    //                 ];
    //                 foreach ($list as $column) {
    //                     $query->orWhere($column, "like", "%".$sear."%");
    //                 }
    //             }]);
    //             //dd($query->get());
    //         }
            
    //         if($request->items == 3){
    //             $searchType = 3;
    //             $breakSearch = $sear;
    //             $query->orWhereHas("quartiers.lieuvotes", function($q) use($sear){
    //                 $q->where("libel", "like", "%".$sear."%");
    //             })
    //             ->with(['agentterrains.parrains' => function ($query) {
    //                 $query->orderBy('created_at');
    //             }
    //             , 'quartiers.lieuvotes' => function ($query) use ($sear) {
    //                 $query->where('libel', "like", "%".$sear."%");
    //             }]);
    //             //dd($query->get());
    //         }
            
    //         if($request->items == 4){
    //             $searchType = 4;
    //             $breakSearch = $sear;
    //             $query->orWhereHas("agentterrains.parrains", function($q) use($sear){
    //                 $list = [
    //                     'nom',
    //                     'prenom',
    //                     'telephone',
    //                 ];
    //                 foreach ($list as $column) {
    //                     $q->orWhere($column, "like", "%".$sear."%")
    //                     ->orderBy('created_at');
    //                 }
    //             })
    //             ->with(['agentterrains.parrains' => function ($query) use ($sear) {
    //                 $list = [
    //                     'nom',
    //                     'prenom',
    //                     'telephone',
    //                 ];
    //                 foreach ($list as $column) {
    //                     $query->orWhere($column, "like", "%".$sear."%")
    //                     ->orderBy('created_at');
    //                 }
    //             }]);
    //         }
            
            
    //     }

    //     if($curr_user->hasRole("super-admin") || $curr_user->hasRole("Admin") || $curr_user->hasRole("Invité") || $curr_user->hasPermissionTo("can-open-all")){
    //         if($searchType == 0 || $searchType == 1){
    //             $sections = $query->with(['agentterrains.parrains' => function ($query) {
    //                 $query->orderBy('created_at');
    //             }])->orderBy( "id", "desc")->get();
    //         }else{
    //             $sections = $query->orderBy( "id", "desc")->get();
    //         }
    //         //->withQueryString();
            
    //     }

    //     if($curr_user->hasPermissionTo("can-open-section-only")){
    //         $isOperateur = true;
    //         $name = $curr_user->name;
    //         $prenom = $curr_user->prenom;
    //         $agent_Section = AgentDeSection::where([
    //             ["nom","like", $name],
    //             ["prenom","like", $prenom],
    //         ])->with("section.commune")->first();
            
    //         if($agent_Section){
    //             $sectionId = $agent_Section->section->id;
    //             if($searchType == 0 || $searchType == 1){
    //                 $sections = $query->where("id", $sectionId)->with(['agentterrains.parrains' => function ($query) {
    //                     $query->orderBy('created_at');
    //                 }])->orderBy("id", "desc")->paginate(2)->withQueryString();
    //             }else{
    //                 $sections = $query->where("id", $sectionId)->orderBy("id", "desc")->paginate(2)->withQueryString();
    //             }
    //         }else{
    //             $sections = $query->where("id", -1)->paginate(2)->withQueryString();
    //         }
    //     }
        
    //     //dd($sections);

    //     return view("app.recens.index-parrain", compact("sections", "isOperateur", "breakSearch", "searchType"));
    // }

}
