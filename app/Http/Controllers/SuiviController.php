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
            // $sections = Quartier::userlimit()->with('agentterrains', 'lieuVotes')->latest();
            // $communes = Commune::userlimit()->oldest()->get();

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("circonscription", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("circonscription", $searchidx)?($searchidx["circonscription"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $communes = Commune::userlimit()->where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $communes = Commune::userlimit()->where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' ); //CHANGE
                    // dd($communes->get());
                }else if(
                    // array_key_exists("circonscription", $searchidx)
                    // || array_key_exists("section", $searchidx)
                    // || array_key_exists("quartier", $searchidx)
                    array_key_exists("lieuvote", $searchidx)
                    || array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("recense", $searchidx)
                    || array_key_exists("avote", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = Commune::userlimit()->with('sections')
                    // ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                        ->leftJoin('sections', 'communes.id', '=', 'sections.commune_id')
                        ->leftJoin('rcommunes', 'sections.id', '=', 'rcommunes.section_id')
                        ->leftJoin('quartiers', 'rcommunes.id', '=', 'quartiers.r_commune_id')
                        ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                        ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->leftJoin('cor_parrains', 'lieu_votes.libel', '=', 'cor_parrains.nom_lv')
                        ->select('communes.*',
                         DB::raw('COUNT(DISTINCT lieu_votes.id) as total_lieuvotes'),
                         DB::raw('COUNT(DISTINCT bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes'))
                        // ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('communes.id');
                    
                    // dd($searchidx);
                    if(array_key_exists("circonscription", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["circonscription"]).'%' );
                    // if(array_key_exists("section", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["section"]).'%' );
                    // if(array_key_exists("commune", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["commune"]).'%' );
                    // if(array_key_exists("quartier", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["quartier"]).'%' );
                    if( array_key_exists("lieuvote", $searchidx) ) $queryB = $queryB->having('total_lieuvotes', '=', str_replace(['(', ')'], "",  $searchidx["lieuvote"]));
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));
                    if( array_key_exists("recense", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_recense', '=', str_replace(['(', ')'], "",  $searchidx["recense"]));
                    if( array_key_exists("avote", $searchidx) ) $queryB = $queryB->having('total_bureau_avotes', '=', str_replace(['(', ')'], "",  $searchidx["avote"]));
                    // dd($searchidx, $queryB->first());

                    $communes = $queryB->get();  //CHANGE
                }else{
                    $communes = Commune::userlimit();  //CHANGE
                }
            }else{
                $communes = Commune::userlimit(); //CHANGE
            }

            // dd($communes);
            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune) {
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
                ->toJson();
        }
    }

    public function getListSection(Request $request, $single){
        if ($request->ajax()) {
            
            // $agents = Rabatteur::with('parrains')->latest()->get();
            // $parrains = CorParrain::userlimit()->latest()->get();
            // $sections = Quartier::userlimit()->with('agentterrains')->latest()->get();
            // $communes = Section::userlimit()->get();

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("section", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("section", $searchidx)?($searchidx["section"]):$searchidx["name"];
                    $communes = Section::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("circonscription", $searchidx)
                    // || array_key_exists("section", $searchidx)
                    // || array_key_exists("quartier", $searchidx)
                    || array_key_exists("lieuvote", $searchidx)
                    || array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("recense", $searchidx)
                    || array_key_exists("avote", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = Section::userlimit()->with('commune', 'quartiers.sections.lieuVotes')
                    // ->leftJoin('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                    
                        ->leftJoin('rcommunes', 'sections.id', '=', 'rcommunes.section_id')
                        ->leftJoin('quartiers', 'rcommunes.id', '=', 'quartiers.r_commune_id')
                        ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                        ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->leftJoin('cor_parrains', 'lieu_votes.libel', '=', 'cor_parrains.nom_lv')
                        ->select('sections.*',
                         DB::raw('COUNT(DISTINCT lieu_votes.id) as total_lieuvotes'),
                         DB::raw('COUNT(DISTINCT bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes'))
                        // ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('sections.id');
                    
                    // dd($searchidx);
                    if(array_key_exists("circonscription", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["circonscription"]).'%' );
                    // if(array_key_exists("section", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["section"]).'%' );
                    // if(array_key_exists("commune", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["commune"]).'%' );
                    // if(array_key_exists("quartier", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["quartier"]).'%' );
                    if( array_key_exists("lieuvote", $searchidx) ) $queryB = $queryB->having('total_lieuvotes', '=', str_replace(['(', ')'], "",  $searchidx["lieuvote"]));
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));
                    if( array_key_exists("recense", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_recense', '=', str_replace(['(', ')'], "",  $searchidx["recense"]));
                    if( array_key_exists("avote", $searchidx) ) $queryB = $queryB->having('total_bureau_avotes', '=', str_replace(['(', ')'], "",  $searchidx["avote"]));
                    // dd($searchidx, $queryB->first());

                    $communes = $queryB->get();  //CHANGE
                }else{
                    $communes = Section::userlimit();  //CHANGE
                }
            }else{
                $communes = Section::userlimit(); //CHANGE
            }

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
                    $counter = 0;

                    foreach ($commune->quartiers as $quartier) {
                        foreach ($quartier->sections as $section) {
                            $counter += $section->lieuVotes->count();
                        }
                    }
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
            // $communes = RCommune::userlimit()->get();

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("commune", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("commune", $searchidx)?($searchidx["commune"]):$searchidx["name"];
                    $communes = RCommune::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("circonscription", $searchidx)
                    || array_key_exists("section", $searchidx)
                    // || array_key_exists("quartier", $searchidx)
                    || array_key_exists("lieuvote", $searchidx)
                    || array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("recense", $searchidx)
                    || array_key_exists("avote", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = RCommune::userlimit()->with('section.commune')
                    // ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->leftJoin('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                    
                        ->leftJoin('quartiers', 'rcommunes.id', '=', 'quartiers.r_commune_id')
                        ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                        ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->leftJoin('cor_parrains', 'lieu_votes.libel', '=', 'cor_parrains.nom_lv')
                        ->select('rcommunes.*', 
                        DB::raw('COUNT(DISTINCT lieu_votes.id) as total_lieuvotes'),
                        DB::raw(' COUNT(DISTINCT bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes'))
                        // ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('rcommunes.id');
                    
                    if(array_key_exists("circonscription", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["circonscription"]).'%' );
                    if(array_key_exists("section", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["section"]).'%' );
                    if(array_key_exists("commune", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["commune"]).'%' );
                    // if(array_key_exists("quartier", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["quartier"]).'%' );
                    if( array_key_exists("lieuvote", $searchidx) ) $queryB = $queryB->having('total_lieuvotes', '=', str_replace(['(', ')'], "",  $searchidx["lieuvote"]));
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));
                    if( array_key_exists("recense", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_recense', '=', str_replace(['(', ')'], "",  $searchidx["recense"]));
                    if( array_key_exists("avote", $searchidx) ) $queryB = $queryB->having('total_bureau_avotes', '=', str_replace(['(', ')'], "",  $searchidx["avote"]));
                    // dd($queryB->first());

                    $communes = $queryB->get();  //CHANGE
                }else{
                    $communes = RCommune::userlimit();  //CHANGE
                }
            }else{
                $communes = RCommune::userlimit(); //CHANGE
            }

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
                ->toJson();
        }
    }
    
    public function getListQuartier(Request $request, $single){
        if ($request->ajax()) {
            
            // $agents = Rabatteur::with('parrains')->latest()->get();
            // $parrains = CorParrain::userlimit()->latest()->get();
            // $sections = Quartier::userlimit()->with('agentterrains')->latest()->get();

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("quartier", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("quartier", $searchidx)?($searchidx["quartier"]):$searchidx["name"];
                    $communes = Quartier::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("circonscription", $searchidx)
                    || array_key_exists("section", $searchidx)
                    || array_key_exists("commune", $searchidx)
                    || array_key_exists("quartier", $searchidx)
                    || array_key_exists("lieuvote", $searchidx)
                    || array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("recense", $searchidx)
                    || array_key_exists("avote", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = Quartier::userlimit()->with('section.section.commune', 'lieuVotes')
                        ->leftJoin('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->leftJoin('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                        ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                        ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->leftJoin('cor_parrains', 'lieu_votes.libel', '=', 'cor_parrains.nom_lv')
                        ->select('quartiers.*', 
                        DB::raw('COUNT(DISTINCT lieu_votes.id) as total_lieuvotes'),
                        DB::raw('COUNT(DISTINCT bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes'))
                        // ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('quartiers.id');
                    
                    if(array_key_exists("circonscription", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["circonscription"]).'%' );
                    if(array_key_exists("section", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["section"]).'%' );
                    if(array_key_exists("commune", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["commune"]).'%' );
                    if(array_key_exists("quartier", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["quartier"]).'%' );

                    if( array_key_exists("lieuvote", $searchidx) ) $queryB = $queryB->having('total_lieuvotes', '=', str_replace(['(', ')'], "",  $searchidx["lieuvote"]));
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));
                    if( array_key_exists("recense", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_recense', '=', str_replace(['(', ')'], "",  $searchidx["recense"]));
                    if( array_key_exists("avote", $searchidx) ) $queryB = $queryB->having('total_bureau_avotes', '=', str_replace(['(', ')'], "",  $searchidx["avote"]));

                    $communes = $queryB->get();  //CHANGE
                }else{
                    $communes = Quartier::userlimit();  //CHANGE
                }
            }else{
                $communes = Quartier::userlimit(); //CHANGE
            }


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
            $bureauvotes = BureauVote::userlimit();

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                  //CHANGE
                if( sizeof($searchidx) == 1 && (array_key_exists("libel", $searchidx) || array_key_exists("name", $searchidx)) ){   //CHANGE
                    $searVal = array_key_exists("libel", $searchidx)?($searchidx["libel"]):$searchidx["name"];  //CHANGE
                    $bureauvotes = BureauVote::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); 
                }else if( array_key_exists("lieuv", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = BureauVote::userlimit()->with("lieuVote")
                        ->join('lieu_votes', 'bureau_votes.lieu_vote_id', '=', 'lieu_votes.id')
                        ->select('bureau_votes.*')
                        ->groupBy('bureau_votes.id');
                    // if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    // if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));
                    // if( array_key_exists("recense", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_recense', '=', str_replace(['(', ')'], "",  $searchidx["recense"]));
                    // if( array_key_exists("avote", $searchidx) ) $queryB = $queryB->having('total_bureau_avotes', '=', str_replace(['(', ')'], "",  $searchidx["avote"]));

                    if(array_key_exists("lieuv", $searchidx)) $queryB = $queryB->where('lieu_votes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["lieuv"]).'%' );
                    if(array_key_exists("libel", $searchidx)) $queryB = $queryB->where('bureau_votes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["libel"]).'%' );
                    $bureauvotes = $queryB->get();  //CHANGE
                }else{
                    $bureauvotes = BureauVote::userlimit();  //CHANGE
                }
            }else{
                $bureauvotes = BureauVote::userlimit();  //CHANGE
            }

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

            if(sizeof($searchidx) > 0){
                  //CHANGE
                if( sizeof($searchidx) == 1 && (array_key_exists("libel", $searchidx) || array_key_exists("name", $searchidx)) ){   //CHANGE
                    $searVal = array_key_exists("libel", $searchidx)?($searchidx["libel"]):$searchidx["name"];  //CHANGE
                    $lieuVotes = LieuVote::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); 
                }else if( array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("recense", $searchidx)
                    || array_key_exists("avote", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = LieuVote::userlimit()->with("bureauvotes")
                        ->join('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->join('cor_parrains', 'lieu_votes.libel', '=', 'cor_parrains.nom_lv')
                        ->select('lieu_votes.*', DB::raw('COUNT(bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes'))
                        ->groupBy('lieu_votes.id');
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));
                    if( array_key_exists("recense", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_recense', '=', str_replace(['(', ')'], "",  $searchidx["recense"]));
                    if( array_key_exists("avote", $searchidx) ) $queryB = $queryB->having('total_bureau_avotes', '=', str_replace(['(', ')'], "",  $searchidx["avote"]));

                    if(array_key_exists("libel", $searchidx)) $queryB = $queryB->where('lieu_votes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["libel"]).'%' );
                    $lieuVotes = $queryB->get();  //CHANGE
                }else{
                    $lieuVotes = LieuVote::userlimit();  //CHANGE
                }
            }else{
                $lieuVotes = LieuVote::userlimit();  //CHANGE
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
