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
            
            $agents = Rabatteur::with('parrains')->latest()->get();
            $parrains = CorParrain::userlimit()->latest()->get();
            $sections = Quartier::userlimit()->with('agentterrains')->latest()->get();
            $communes = Section::userlimit()->take(8)->get();
            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune) use($sections) {
                    return optional($commune->commune)->libel ?? '-';
                })
                ->addColumn('section', function ($commune) use($sections) {
                    return optional($commune)->libel ?? '-';
                })
                ->addColumn('lieuvote', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->quartiers as $quartier){
                        foreach($quartier->sections as $section){
                            $counter += $section->lieuVotes()->userlimit()->count();
                        }

                    }
                    // foreach($commune->sections as $section){
                    //     // foreach($sections as $section){
                    //     //     // foreach($section->quartiers as $quartier){
                    //     //     // }
                    //     // }
                    // }
                    
                    return $counter.'' ?? '0';
                })
                ->addColumn('bureauvote', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->quartiers as $quartier){
                        foreach($quartier->sections as $section){
                            foreach($section->lieuVotes as $lieus){
                                $counter += $lieus->bureauVotes()->userlimit()->count();
                            }
                        }
                    }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return $counter.'' ?? '0';
                })
                ->addColumn('votant', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->quartiers as $quartier){
                        foreach($quartier->sections as $section){
                            foreach($section->lieuVotes as $lieus){
                                foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                                    $counter += $bureau->votant_suivi;
                                }
                            }
                        }
                    }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return $counter.'' ?? '0';
                })
                ->addColumn('recense', function ($commune) use($parrains) {
                    $counter = 0;
                    //foreach($commune->sections as $section){
                    //foreach($agents as $agent){
                        $counter += $parrains->count();
                    //}
                    return $counter.'' ?? '0';
                })
                ->addColumn('avote', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->quartiers as $quartier){
                        foreach($quartier->sections as $section){
                            foreach($section->lieuVotes()->userlimit()->get() as $lieus){
                                //$counter += $lieus->a_vote;
                                $parrains = CorParrain::where('nom_lv', 'like', '%'.$lieus->libel.'%')->get();
                                foreach($parrains as $parrain){
                                    $counter += $parrain->a_vote;
                                }
                            }
                        }
                    }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return $counter.'' ?? '0';
                })
                ->addColumn('participation', function($commune) use ($sections) {
                    $counter = 0;
                    foreach($commune->quartiers as $quartier){
                        foreach($quartier->sections as $section){
                            foreach($section->lieuVotes as $lieus){
                                foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                                    $counter += $bureau->votant_suivi;
                                }
                            }
                        }
                    }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return round(($counter/$commune->nbrinscrit)*100, 2).'%' ?? '0';
                })
                ->rawColumns(['circonscription', 'section', 'lieuvote', 'bureauvote', 'votant', 'recense', 'avote', 'participation'])
                ->make(true);
        }
    }
    
    public function getListRCommune(Request $request, $single){
        if ($request->ajax()) {
            
            $agents = Rabatteur::with('parrains')->latest()->get();
            $parrains = CorParrain::userlimit()->latest()->get();
            $sections = Quartier::userlimit()->with('agentterrains')->latest()->get();
            $communes = RCommune::userlimit()->take(8)->get();
            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune) use($sections) {
                    return optional($commune->section->commune)->libel ?? '-';
                })
                ->addColumn('section', function ($commune) use($sections) {
                    return optional($commune->section)->libel ?? '-';
                })
                ->addColumn('commune', function ($commune) use($sections) {
                    return optional($commune)->libel ?? '-';
                })
                ->addColumn('lieuvote', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->sections as $section){
                        $counter += $section->lieuVotes()->userlimit()->count();
                    }
                    // foreach($commune->quartiers as $quartier){

                    // }
                    // foreach($commune->sections as $section){
                    //     // foreach($sections as $section){
                    //     //     // foreach($section->quartiers as $quartier){
                    //     //     // }
                    //     // }
                    // }
                    
                    return $counter.'' ?? '0';
                })
                ->addColumn('bureauvote', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            $counter += $lieus->bureauVotes()->userlimit()->count();
                        }
                    }
                    // foreach($commune->quartiers as $quartier){
                    // }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return $counter.'' ?? '0';
                })
                ->addColumn('votant', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                                $counter += $bureau->votant_suivi;
                            }
                        }
                    }
                    // foreach($commune->quartiers as $quartier){
                    // }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return $counter.'' ?? '0';
                })
                ->addColumn('recense', function ($commune) use($parrains) {
                    $counter = 0;
                    //foreach($commune->sections as $section){
                    //foreach($agents as $agent){
                        $counter += $parrains->count();
                    //}
                    return $counter.'' ?? '0';
                })
                ->addColumn('avote', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->sections as $section){
                        foreach($section->lieuVotes()->userlimit()->get() as $lieus){
                            //$counter += $lieus->a_vote;
                            $parrains = CorParrain::where('nom_lv', 'like', '%'.$lieus->libel.'%')->get();
                            foreach($parrains as $parrain){
                                $counter += $parrain->a_vote;
                            }
                        }
                    }
                    // foreach($commune->quartiers as $quartier){
                    // }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return $counter.'' ?? '0';
                })
                ->addColumn('participation', function($commune) use ($sections) {
                    $counter = 0;
                    foreach($commune->sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                                $counter += $bureau->votant_suivi;
                            }
                        }
                    }
                    // foreach($commune->quartiers as $quartier){
                    // }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return round(($counter/$commune->nbrinscrit)*100, 2).'%' ?? '0';
                })
                ->rawColumns(['circonscription', 'section', 'commune', 'lieuvote', 'bureauvote', 'votant', 'recense', 'avote', 'participation'])
                ->make(true);
        }
    }
    
    public function getListQuartier(Request $request, $single){
        if ($request->ajax()) {
            
            $agents = Rabatteur::with('parrains')->latest()->get();
            $parrains = CorParrain::userlimit()->latest()->get();
            $sections = Quartier::userlimit()->with('agentterrains')->latest()->get();
            $communes = Quartier::userlimit()->take(8)->get();
            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune) use($sections) {
                    return optional($commune->section->section->commune)->libel ?? '-';
                })
                ->addColumn('section', function ($commune) use($sections) {
                    return optional($commune->section->section)->libel ?? '-';
                })
                ->addColumn('commune', function ($commune) use($sections) {
                    return optional($commune->section)->libel ?? '-';
                })
                ->addColumn('quartier', function ($commune) use($sections) {
                    return optional($commune)->libel ?? '-';
                })
                ->addColumn('lieuvote', function ($commune) use($sections) {
                    $counter = 0;
                    $counter += $commune->lieuVotes()->userlimit()->count();
                    // foreach($commune->sections as $section){
                    // }
                    // foreach($commune->quartiers as $quartier){

                    // }
                    // foreach($commune->sections as $section){
                    //     // foreach($sections as $section){
                    //     //     // foreach($section->quartiers as $quartier){
                    //     //     // }
                    //     // }
                    // }
                    
                    return $counter.'' ?? '0';
                })
                ->addColumn('bureauvote', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->lieuVotes as $lieus){
                        $counter += $lieus->bureauVotes()->userlimit()->count();
                    }
                    // foreach($commune->sections as $section){
                    // }
                    // foreach($commune->quartiers as $quartier){
                    // }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return $counter.'' ?? '0';
                })
                ->addColumn('votant', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->lieuVotes as $lieus){
                        foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                            $counter += $bureau->votant_suivi;
                        }
                    }
                    // foreach($commune->sections as $section){
                    // }
                    // foreach($commune->quartiers as $quartier){
                    // }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return $counter.'' ?? '0';
                })
                ->addColumn('recense', function ($commune) use($parrains) {
                    $counter = 0;
                    //foreach($commune->sections as $section){
                    //foreach($agents as $agent){
                        $counter += $parrains->count();
                    //}
                    return $counter.'' ?? '0';
                })
                ->addColumn('avote', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($commune->lieuVotes()->userlimit()->get() as $lieus){
                        //$counter += $lieus->a_vote;
                        $parrains = CorParrain::where('nom_lv', 'like', '%'.$lieus->libel.'%')->get();
                        foreach($parrains as $parrain){
                            $counter += $parrain->a_vote;
                        }
                    }
                    // foreach($commune->sections as $section){
                    // }
                    // foreach($commune->quartiers as $quartier){
                    // }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return $counter.'' ?? '0';
                })
                ->addColumn('participation', function($commune) use ($sections) {
                    $counter = 0;
                    foreach($commune->lieuVotes as $lieus){
                        foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                            $counter += $bureau->votant_suivi;
                        }
                    }
                    // foreach($commune->sections as $section){
                    // }
                    // foreach($commune->quartiers as $quartier){
                    // }
                    // foreach($commune->sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    return round(($counter/$commune->nbrinscrit)*100, 2).'%' ?? '0';
                })
                ->rawColumns(['circonscription', 'section', 'commune', 'quartier', 'lieuvote', 'bureauvote', 'votant', 'recense', 'avote', 'participation'])
                ->make(true);
        }
    }
    
    public function getListBureauvote(Request $request, $single){
        if ($request->ajax()) {
            
            //$agents = AgentTerrain::userlimit()->with('parrains')->with('section')->latest()->get();
            $bureauvotes = BureauVote::userlimit()->take(8)->get();
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
            
            $agents = Rabatteur::with('parrains')->latest()->get();
            $parrains = CorParrain::userlimit()->latest()->get();
            $sections = Quartier::userlimit()->with('agentterrains')->latest()->get();
            $lieuVotes = LieuVote::userlimit()->take(8)->get();
            return DataTables::of($lieuVotes)
                ->addColumn('lieuvote', function ($lieuvote) use($sections) {
                    return $lieuvote->libel.'' ?? '-';
                })
                ->addColumn('bureauvote', function ($lieuvote) use($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            if($lieus->libel == $lieuvote->libel){
                                $counter += $lieus->bureauVotes->count();
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        }
                    
                    return $counter.'' ?? '0';
                })
                ->addColumn('votant', function ($lieuvote) use($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            if($lieus->libel == $lieuvote->libel){
                                foreach($lieus->bureauVotes as $bureau){
                                    $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                                }
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                    }
                    
                    return $counter.'' ?? '0';
                })
                ->addColumn('recense', function ($lieuvote) use($parrains) {
                    $counter = 0;
                    
                    foreach($parrains as $parrain){
                        if($parrain->nom_lv == $lieuvote->libel){
                            $counter += 1;
                        }
                    }
                    
                    return $counter.'' ?? '0';
                })
                ->addColumn('avote', function ($lieuvote) use($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            if($lieus->libel == $lieuvote->libel){
                                $counter += $lieus->a_vote;
                                $parrains = CorParrain::where('nom_lv', 'like', '%'.$lieus->libel.'%')->get();
                                foreach($parrains as $parrain){
                                    $counter += $parrain->a_vote;
                                }
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        }
                    
                    return $counter.'' ?? '0';
                })
                ->addColumn('participation', function($lieuvote) use ($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            if($lieus->libel == $lieuvote->libel){
                                foreach($lieus->bureauVotes as $bureau){
                                    $counter += $bureau->votant_suivi;
                                }
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        }
                    
                    return round( $lieuvote->nbrinscrit!=0?($counter/$lieuvote->nbrinscrit)*100:0.0,2).'%' ?? '0';
                })
                ->rawColumns(['lieuvote', 'bureauvote', 'votant', 'recense', 'avote', 'participation'])
                ->make(true);
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
