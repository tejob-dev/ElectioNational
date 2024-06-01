<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Parrain;
use App\Models\Section;
use App\Models\LieuVote;
use App\Models\Quartier;
use App\Models\RCommune;
use App\Models\Rabatteur;
use App\Models\BureauVote;
use App\Models\CorParrain;
use App\Models\AgentTerrain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SuiviController extends Controller
{
    //
    public function getListCommune(Request $request, $single){
        if ($request->ajax()) {
            
            // $agents = null;//Rabatteur::with('parrains')->latest()->get();
            // $corparrains = CorParrain::userlimit()->latest()->get();
            // // $lvlist = LieuVote::userlimit()->latest()->get();
            $sections = Quartier::userlimit()->with('agentterrains', 'lieuVotes')->latest();
            $communes = Commune::userlimit()->oldest()->get();
            // dd($communes);
            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune) use($sections) {
                    return optional($commune)->libel ?? '-';
                })
                ->addColumn('lieuvote', function ($commune) {
                    // $lieuVoteCount = DB::table('sections')->count();
                    $communeId = $commune->id;
                    $counter = LieuVote::whereIn('quartier_id', function ($query) use ($communeId) {
                        $query->select('quartiers.id')
                            ->from('quartiers')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.commune_id', $communeId);
                    })->count();
                    return $counter??"0";
                })
                ->addColumn('bureauvote', function ($commune) {
                    $communeId = $commune->id;
                    $bureauVoteCount = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.commune_id', $communeId);
                    })->count();
                    // dd($bureauVoteCount);
                    return $bureauVoteCount;
                })
                ->addColumn('votant', function ($commune) {
                    $communeId = $commune->id;
                    $votantCount = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.commune_id', $communeId);
                        })->sum('votant_suivi');
                        return $votantCount??"0";
                    })
                ->addColumn('recense', function ($commune) {
                        // $recenseCount = DB::table('corparrains')->count();
                    $communeId = $commune->id;
                    $recenseCount = CorParrain::whereIn('nom_lv', function ($query) use ($communeId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.commune_id', $communeId);
                    })->count();
                    return $recenseCount??"0";
                })
                ->addColumn('avote', function ($commune) {
                    // $voteCount = DB::table('corparrains')
                    //     ->whereIn('nom_lv', function ($query) {
                    //         $query->select('libel')
                    //             ->from('lieu_votes');
                    //     })
                    //     ->sum('a_vote');
                    $communeId = $commune->id;
                    $voteCount = CorParrain::whereIn('nom_lv', function ($query) use ($communeId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.commune_id', $communeId);
                    })->sum("a_vote");
                    return $voteCount??"0";
                })
                ->addColumn('participation', function ($commune) {
                    $communeId = $commune->id;
                    $participationRate = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.commune_id', $communeId);
                        })->sum('votant_suivi');
                    return round(($participationRate/$commune->nbrinscrit)*100, 2).'%' ?? '0';
                })
                ->rawColumns(['circonscription', 'lieuvote', 'bureauvote', 'votant', 'recense', 'avote', 'participation'])
                ->make(true);
        }
    }

    public function getListSection(Request $request, $single){
        if ($request->ajax()) {
            
            // $agents = Rabatteur::with('parrains')->latest()->get();
            // $parrains = CorParrain::userlimit()->latest()->get();
            // $sections = Quartier::userlimit()->with('agentterrains')->latest()->get();
            $communes = Section::userlimit()->get();
            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune) {
                    return optional($commune->commune)->libel ?? '-';
                })
                ->addColumn('section', function ($commune) {
                    return optional($commune)->libel ?? '-';
                })
                ->addColumn('lieuvote', function ($commune) {
                    // $lieuVoteCount = DB::table('sections')->count();
                    $communeId = $commune->id;
                    $counter = LieuVote::whereIn('quartier_id', function ($query) use ($communeId) {
                        $query->select('quartiers.id')
                            ->from('quartiers')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.id', $communeId);
                    })->count();
                    return $counter??"0";
                })
                ->addColumn('bureauvote', function ($commune) {
                    $communeId = $commune->id;
                    $bureauVoteCount = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.id', $communeId);
                    })->count();
                    // dd($bureauVoteCount);
                    return $bureauVoteCount;
                })
                ->addColumn('votant', function ($commune) {
                    $communeId = $commune->id;
                    $votantCount = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.id', $communeId);
                        })->sum('votant_suivi');
                        return $votantCount??"0";
                    })
                ->addColumn('recense', function ($commune) {
                        // $recenseCount = DB::table('corparrains')->count();
                    $communeId = $commune->id;
                    $recenseCount = CorParrain::whereIn('nom_lv', function ($query) use ($communeId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.id', $communeId);
                    })->count();
                    return $recenseCount??"0";
                })
                ->addColumn('avote', function ($commune) {
                    // $voteCount = DB::table('corparrains')
                    //     ->whereIn('nom_lv', function ($query) {
                    //         $query->select('libel')
                    //             ->from('lieu_votes');
                    //     })
                    //     ->sum('a_vote');
                    $communeId = $commune->id;
                    $voteCount = CorParrain::whereIn('nom_lv', function ($query) use ($communeId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.id', $communeId);
                    })->sum("a_vote");
                    return $voteCount??"0";
                })
                ->addColumn('participation', function ($commune) {
                    $communeId = $commune->id;
                    $participationRate = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.id', $communeId);
                        })->sum('votant_suivi');
                    return round(($participationRate/$commune->nbrinscrit)*100, 2).'%' ?? '0';
                })
                ->rawColumns(['circonscription', 'section', 'lieuvote', 'bureauvote', 'votant', 'recense', 'avote', 'participation'])
                ->make(true);
        }
    }
    
    public function getListRCommune(Request $request, $single){
        if ($request->ajax()) {
            
            // $agents = Rabatteur::with('parrains')->latest()->get();
            // $parrains = CorParrain::userlimit()->latest()->get();
            // $sections = Quartier::userlimit()->with('agentterrains')->latest()->get();
            $communes = RCommune::userlimit()->get();
            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune) {
                    return optional($commune->section->commune)->libel ?? '-';
                })
                ->addColumn('section', function ($commune) {
                    return optional($commune->section)->libel ?? '-';
                })
                ->addColumn('commune', function ($commune) {
                    return optional($commune)->libel ?? '-';
                })
                ->addColumn('lieuvote', function ($commune) {
                    // $lieuVoteCount = DB::table('sections')->count();
                    $communeId = $commune->id;
                    $counter = LieuVote::whereIn('quartier_id', function ($query) use ($communeId) {
                        $query->select('quartiers.id')
                            ->from('quartiers')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->where('rcommunes.id', $communeId);
                    })->count();
                    return $counter??"0";
                })
                ->addColumn('bureauvote', function ($commune) {
                    $communeId = $commune->id;
                    $bureauVoteCount = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->where('rcommunes.id', $communeId);
                    })->count();
                    // dd($bureauVoteCount);
                    return $bureauVoteCount;
                })
                ->addColumn('votant', function ($commune) {
                    $communeId = $commune->id;
                    $votantCount = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->where('rcommunes.id', $communeId);
                        })->sum('votant_suivi');
                        return $votantCount??"0";
                    })
                ->addColumn('recense', function ($commune) {
                        // $recenseCount = DB::table('corparrains')->count();
                    $communeId = $commune->id;
                    $recenseCount = CorParrain::whereIn('nom_lv', function ($query) use ($communeId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->where('rcommunes.id', $communeId);
                    })->count();
                    return $recenseCount??"0";
                })
                ->addColumn('avote', function ($commune) {
                    // $voteCount = DB::table('corparrains')
                    //     ->whereIn('nom_lv', function ($query) {
                    //         $query->select('libel')
                    //             ->from('lieu_votes');
                    //     })
                    //     ->sum('a_vote');
                    $communeId = $commune->id;
                    $voteCount = CorParrain::whereIn('nom_lv', function ($query) use ($communeId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->where('rcommunes.id', $communeId);
                    })->sum("a_vote");
                    return $voteCount??"0";
                })
                ->addColumn('participation', function ($commune) {
                    $communeId = $commune->id;
                    $participationRate = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->where('rcommunes.id', $communeId);
                        })->sum('votant_suivi');
                    return round(($participationRate/$commune->nbrinscrit)*100, 2).'%' ?? '0';
                })
                ->rawColumns(['circonscription', 'section', 'commune', 'lieuvote', 'bureauvote', 'votant', 'recense', 'avote', 'participation'])
                ->make(true);
        }
    }
    
    public function getListQuartier(Request $request, $single){
        if ($request->ajax()) {
            
            // $agents = Rabatteur::with('parrains')->latest()->get();
            // $parrains = CorParrain::userlimit()->latest()->get();
            // $sections = Quartier::userlimit()->with('agentterrains')->latest()->get();
            $communes = Quartier::userlimit()->get();
            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune) {
                    return optional($commune->section->section->commune)->libel ?? '-';
                })
                ->addColumn('section', function ($commune) {
                    return optional($commune->section->section)->libel ?? '-';
                })
                ->addColumn('commune', function ($commune) {
                    return optional($commune->section)->libel ?? '-';
                })
                ->addColumn('quartier', function ($commune) {
                    return optional($commune)->libel ?? '-';
                })
                ->addColumn('lieuvote', function ($commune) {
                    // $lieuVoteCount = DB::table('sections')->count();
                    $communeId = $commune->id;
                    $counter = LieuVote::whereIn('quartier_id', function ($query) use ($communeId) {
                        $query->select('quartiers.id')
                            ->from('quartiers')
                            ->where('quartiers.id', $communeId);
                    })->count();
                    return $counter??"0";
                })
                ->addColumn('bureauvote', function ($commune) {
                    $communeId = $commune->id;
                    $bureauVoteCount = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->where('quartiers.id', $communeId);
                    })->count();
                    // dd($bureauVoteCount);
                    return $bureauVoteCount;
                })
                ->addColumn('votant', function ($commune) {
                    $communeId = $commune->id;
                    $votantCount = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->where('quartiers.id', $communeId);
                        })->sum('votant_suivi');
                        return $votantCount??"0";
                    })
                ->addColumn('recense', function ($commune) {
                        // $recenseCount = DB::table('corparrains')->count();
                    $communeId = $commune->id;
                    $recenseCount = CorParrain::whereIn('nom_lv', function ($query) use ($communeId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->where('quartiers.id', $communeId);
                    })->count();
                    return $recenseCount??"0";
                })
                ->addColumn('avote', function ($commune) {
                    // $voteCount = DB::table('corparrains')
                    //     ->whereIn('nom_lv', function ($query) {
                    //         $query->select('libel')
                    //             ->from('lieu_votes');
                    //     })
                    //     ->sum('a_vote');
                    $communeId = $commune->id;
                    $voteCount = CorParrain::whereIn('nom_lv', function ($query) use ($communeId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->where('quartiers.id', $communeId);
                    })->sum("a_vote");
                    return $voteCount??"0";
                })
                ->addColumn('participation', function ($commune) {
                    $communeId = $commune->id;
                    $participationRate = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->where('quartiers.id', $communeId);
                        })->sum('votant_suivi');
                    return round(($participationRate/$commune->nbrinscrit)*100, 2).'%' ?? '0';
                })
                ->rawColumns(['circonscription', 'section', 'commune', 'quartier', 'lieuvote', 'bureauvote', 'votant', 'recense', 'avote', 'participation'])
                ->make(true);
        }
    }
    
    public function getListBureauvote(Request $request, $single){
        if ($request->ajax()) {
            
            //$agents = AgentTerrain::userlimit()->with('parrains')->with('section')->latest()->get();
            $bureauvotes = BureauVote::userlimit()->get();
            return DataTables::of($bureauvotes)
                ->addColumn('lieuv', function ($bureauvote) {
                    return optional($bureauvote->lieuVote)->libel ?? '-';
                })
                ->addColumn('votant', function ($bureauvote) {
                    $counter = 0;
                    $counter += ($bureauvote->votant_suivi);
                    return $counter.'' ?? '0';
                })
                ->addColumn('participation', function($bureauvote) {
                    $counter = 0;
                    $counter += ($bureauvote->votant_suivi);
                    return round( $bureauvote->objectif!=0?($counter/$bureauvote->objectif)*100:0.0,2).'%' ?? '0';
                })
                ->rawColumns(['lieuv','votant','participation'])
                ->make(true);
        }
    }
    
    public function getListLieuvote(Request $request, $single){
        if ($request->ajax()) {
            
            // $agents = Rabatteur::with('parrains')->latest()->get();
            // $parrains = CorParrain::userlimit()->latest()->get();
            // $sections = Quartier::userlimit()->with('agentterrains')->latest()->get();
            $searchidx = get_item_of_datatables($request->all());

            // dd($allSearchValuesIsNull, $allSearchValuesIsNull2, str_replace(['(', ')'], "", $searchVal));

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("libel", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("libel", $searchidx)?($searchidx["libel"]):$searchidx["name"];
                    $lieuVotes = LieuVote::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' );
                }else if(array_key_exists("bureauvote", $searchidx)){
                    // LieuVote::userlimit()->with("bureauvotes");
                    $queryB = DB::table('lieu_votes')
                        ->join('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->select('lieu_votes.*', DB::raw('COUNT(bureau_votes.id) as total_bureau_votes'))
                        ->groupBy('lieu_votes.id');
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));

                    if(array_key_exists("libel", $searchidx)) $queryB = $queryB->where('lieu_votes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["libel"]).'%' );
                    $lieuVotes = $queryB->get();
                }else{
                    $lieuVotes = LieuVote::userlimit();
                }
            }else{
                $lieuVotes = LieuVote::userlimit();
            }

            return DataTables::of($lieuVotes)
                ->addColumn('lieuvote', function ($lieuvote) {
                    return $lieuvote->libel.'' ?? '-';
                })
                ->addColumn('bureauvote', function ($commune) {
                    $communeId = $commune->id;
                    $bureauVoteCount = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->where('lieu_votes.id', $communeId);
                    })->count();
                    // dd($bureauVoteCount);
                    return $bureauVoteCount;
                })
                ->addColumn('votant', function ($commune) {
                    $communeId = $commune->id;
                    $votantCount = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->where('lieu_votes.id', $communeId);
                        })->sum('votant_suivi');
                        return $votantCount??"0";
                    })
                ->addColumn('recense', function ($commune) {
                        // $recenseCount = DB::table('corparrains')->count();
                    $communeId = $commune->id;
                    $recenseCount = CorParrain::whereIn('nom_lv', function ($query) use ($communeId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->where('lieu_votes.id', $communeId);
                    })->count();
                    return $recenseCount??"0";
                })
                ->addColumn('avote', function ($commune) {
                    // $voteCount = DB::table('corparrains')
                    //     ->whereIn('nom_lv', function ($query) {
                    //         $query->select('libel')
                    //             ->from('lieu_votes');
                    //     })
                    //     ->sum('a_vote');
                    $communeId = $commune->id;
                    $voteCount = CorParrain::whereIn('nom_lv', function ($query) use ($communeId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->where('lieu_votes.id', $communeId);
                    })->sum("a_vote");
                    return $voteCount??"0";
                })
                ->addColumn('participation', function ($commune) {
                    $communeId = $commune->id;
                    $participationRate = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->where('lieu_votes.id', $communeId);
                        })->sum('votant_suivi');
                    return round(($participationRate/$commune->nbrinscrit)*100, 2).'%' ?? '0';
                })
                ->rawColumns(['lieuvote', 'bureauvote', 'votant', 'recense', 'avote', 'participation'])
                ->toJson();
        }
    }
    
    public function listCommune(){
        return view("app.suivis.index-commune");
    }
    public function listSection(){
        return view("app.suivis.index-section");
    }
    public function listRcommune(){
        return view("app.suivis.index-rcommune");
    }
    public function listQuartier(){
        return view("app.suivis.index-quartier");
    }
    
    public function listLieuvote(){
        return view("app.suivis.index-lieuvote");
    }

    public function listBureauvote(){
        return view("app.suivis.index-bureauvote");
    }

    public function listAgentterrain(){
        return view("app.suivis.index-agentterrain");
    }

}
