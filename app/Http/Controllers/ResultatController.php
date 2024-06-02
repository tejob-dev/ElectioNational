<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Parrain;
use App\Models\Section;
use App\Models\Candidat;
use App\Models\LieuVote;
use App\Models\Quartier;
use App\Models\RCommune;
use App\Models\BureauVote;
use App\Models\AgentTerrain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ResultatController extends Controller
{
    //
    protected $bultnulls = 0;
    protected $bultblancs = 0;
    protected $votants = 0;
    protected $candidnote = [0,0,0,0,0,0,0,0,0,0,0,0];

    public function getListCommune(Request $request, $single){
        if ($request->ajax()) {
            
            //$agents = AgentTerrain::userlimit()->with('parrains')->with('section')->latest()->get();
            // $sections = Quartier::userlimit()->latest()->get();
            // $totalCount = Commune::userlimit()->count();
            // $communes = Commune::userlimit()
            // ->skip($request->start)
            // ->take($request->length);

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("circonscription", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("circonscription", $searchidx)?($searchidx["circonscription"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $communes = Commune::userlimit()->where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $communes = Commune::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(
                    // array_key_exists("circonscription", $searchidx)
                    // || array_key_exists("section", $searchidx)
                    // || array_key_exists("commune", $searchidx)
                    // || array_key_exists("quartier", $searchidx)
                    array_key_exists("lieuvote", $searchidx)
                    || array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("bulnul", $searchidx)
                    || array_key_exists("bulblanc", $searchidx)
                    || array_key_exists("suffrage", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = Commune::userlimit()
                    // ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                    
                        ->leftJoin('sections', 'communes.id', '=', 'sections.commune_id')
                        ->leftJoin('rcommunes', 'sections.id', '=', 'rcommunes.section_id')
                        ->leftJoin('quartiers', 'rcommunes.id', '=', 'quartiers.r_commune_id')
                        ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                        ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->leftJoin('cor_parrains', 'lieu_votes.libel', '=', 'cor_parrains.nom_lv')
                        ->select('communes.*', 
                        DB::raw('COUNT(DISTINCT lieu_votes.id) as total_lieuvotes'),
                        DB::raw('COUNT(DISTINCT bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes, SUM(bureau_votes.bult_nul) as total_bureau_bulnul, SUM(bureau_votes.bult_blan) as total_bureau_bulblanc, SUM(bureau_votes.votant_resul - (bureau_votes.bult_blan + bureau_votes.bult_nul)) as total_effective_votes'))
                        // ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('communes.id');
                    
                    if(array_key_exists("circonscription", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["circonscription"]).'%' );
                    // if(array_key_exists("section", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["section"]).'%' );
                    // if(array_key_exists("commune", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["commune"]).'%' );
                    // if(array_key_exists("quartier", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["quartier"]).'%' );

                    if( array_key_exists("lieuvote", $searchidx) ) $queryB = $queryB->having('total_lieuvotes', '=', str_replace(['(', ')'], "",  $searchidx["lieuvote"]));
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));                    
                    if( array_key_exists("bulnul", $searchidx) ) $queryB = $queryB->having('total_bureau_bulnul', '=', str_replace(['(', ')'], "",  $searchidx["bulnul"]));
                    if( array_key_exists("bulblanc", $searchidx) ) $queryB = $queryB->having('total_bureau_bulblanc', '=', str_replace(['(', ')'], "",  $searchidx["bulblanc"]));
                    if( array_key_exists("suffrage", $searchidx) ) $queryB = $queryB->having('total_effective_votes', '=', str_replace(['(', ')'], "",  $searchidx["suffrage"]));

                    $communes = $queryB->get();  //CHANGE
                }else{
                    $communes = Commune::userlimit();  //CHANGE
                }
            }else{
                $communes = Commune::userlimit(); //CHANGE
            }

            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune) {
                    return optional($commune)->libel ?? '-';
                })
                ->addColumn('lieuvote', function ($commune) {
                    $counter = 0;
                    $communeId = $commune->id;
                    $counter = LieuVote::whereIn('quartier_id', function ($query) use ($communeId) {
                        $query->select('quartiers.id')
                            ->from('quartiers')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.commune_id', $communeId);
                    })->count();
                    return $counter.'' ?? '0';
                })
                ->addColumn('bureauvote', function ($commune) {
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.commune_id', $communeId);
                    })->count();
                    return $counter.'' ?? '0';
                })
                ->addColumn('votant', function ($commune) {
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.commune_id', $communeId);
                    })
                    ->selectRaw('SUM(votant_suivi + votant_resul) AS votant_count')
                    ->value('votant_count');

                    $this->votants = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulnul', function ($commune) {
                    $counter = 0;
                    // foreach($sections as $section){
                    //     foreach($section->lieuVotes as $lieus){
                    //         foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //             $counter += $bureau->bult_nul;
                    //         }
                    //     }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->where('sections.commune_id', $communeId);
                    })->sum('bult_nul');
                    $this->bultnulls = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulblanc', function ($commune){
                    $counter = 0;
                    // foreach($sections as $section){
                        //     foreach($section->lieuVotes as $lieus){
                            //         foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //             $counter += $bureau->bult_blan;
                    //         }
                    //     }
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->where('sections.commune_id', $communeId);
                    })->sum('bult_blan');
                    $this->bultblancs = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('suffrage', function ($commune){
                    return ($this->votants - ($this->bultblancs + $this->bultnulls));
                })
                ->addColumn('participation', function($commune) {
                    $counter = 0;
                    // foreach($sections as $section){
                    //     foreach($section->lieuVotes as $lieus){
                    //         foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //             $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                    //         }
                    //     }
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->where('sections.commune_id', $communeId);
                    })
                    ->selectRaw('SUM(votant_suivi + votant_resul) AS votant_count')
                    ->value('votant_count');
                    return round( $commune->nbrinscrit!=0?($counter/$commune->nbrinscrit)*100:0.0, 2).'%' ?? '0';
                })
                ->addColumn('candidata', function($commune) {
                    //$counter = 0;
                    $bvids = "";
                    // foreach($sections as $section){
                    //     foreach($section->lieuVotes as $lieus){
                    //         foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //             $notes = $bureau->candidat_note;
                    //             $currbv = "b".$bureau->id.",";
                    //             if($notes && preg_match('/'.$currbv.'/i', $bvids) == false){
                    //                 $lists = json_decode($notes);
                    //                 $this->candidnote[0] += intval($lists->rhdp);
                    //                 $this->candidnote[1] += intval($lists->pdci);
                    //                 $this->candidnote[2] += intval($lists->ppa);
                    //                 $this->candidnote[3] += intval($lists->indep);
                    //                 $bvids .= "b".$bureau->id.",";
                    //             }
                    //         }
                    //     }
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }

                    $communeId = $commune->id;
                    $bvlist = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->where('sections.commune_id', $communeId);
                    })->get();

                    foreach($bvlist as $bureau){
                        $notes = $bureau->candidat_note;
                        $currbv = "b".$bureau->id.",";
                        if($notes && preg_match('/'.$currbv.'/i', $bvids) == false){
                            $lists = json_decode($notes);
                            $this->candidnote[0] += intval($lists->pdci);
                            $this->candidnote[1] += intval($lists->ppaci);
                            $this->candidnote[2] += intval($lists->rhdp);
                            $this->candidnote[3] += intval($lists->fpi);
                            $this->candidnote[4] += intval($lists->udpi);
                            $bvids .= "b".$bureau->id.",";
                        }
                    }
                    
                    return $this->candidnote[0] ?? '0';
                })
                ->addColumn('candidatb', function($commune)  {
                    return $this->candidnote[1] ?? '0';
                })
                ->addColumn('candidatc', function($commune)  {
                    return $this->candidnote[2] ?? '0';
                })
                ->addColumn('candidatd', function($commune)  {
                    return $this->candidnote[3] ?? '0';
                })
                ->addColumn('candidate', function($lieuvote) {
                    return $this->candidnote[4] ?? '0';
                })
                // ->addColumn('candidatf', function($lieuvote) use ($sections) {
                //     return $this->candidnote[5] ?? '0';
                // })
                // ->addColumn('candidatg', function($lieuvote) use ($sections) {
                //     return $this->candidnote[6] ?? '0';
                // })
                // ->addColumn('candidath', function($lieuvote) use ($sections) {
                //     return $this->candidnote[7] ?? '0';
                // })
                ->rawColumns(
                    ['circonscription', 'lieuvote',
                     'bureauvote', 'votant',
                     'bulnul', 'bulblanc',
                     'suffrage', 'participation',
                     'candidata', 'candidatb',
                    'candidatc', 'candidatd',
                    'candidate', 
                    // 'candidatf',
                      ])
                    //   ->setTotalRecords($totalCount)
                    //   ->setFilteredRecords(intval($request->length))
                      ->toJson();
        }
    }

    public function getListSection(Request $request, $single){
        if ($request->ajax()) {
            
            //$agents = AgentTerrain::userlimit()->with('parrains')->with('section')->latest()->get();
            // $sections = Quartier::userlimit()->latest()->get();
            // $totalCount = Section::userlimit()->count();
            // $communes = Section::userlimit()
            // ->with("quartiers.sections.lieuVotes")
            // ->skip($request->start)
            // ->take($request->length);

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("section", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("section", $searchidx)?($searchidx["section"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $communes = Section::userlimit()->where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $communes = Section::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("circonscription", $searchidx)
                    // || array_key_exists("section", $searchidx)
                    // || array_key_exists("commune", $searchidx)
                    // || array_key_exists("quartier", $searchidx)
                    || array_key_exists("lieuvote", $searchidx)
                    || array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("bulnul", $searchidx)
                    || array_key_exists("bulblanc", $searchidx)
                    || array_key_exists("suffrage", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = Section::userlimit()->with('commune')
                    // ->leftJoin('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                    
                        ->leftJoin('rcommunes', 'sections.id', '=', 'rcommunes.section_id')
                        ->leftJoin('quartiers', 'rcommunes.id', '=', 'quartiers.r_commune_id')
                        ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                        ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->leftJoin('cor_parrains', 'lieu_votes.libel', '=', 'cor_parrains.nom_lv')
                        ->select('sections.*', 
                        DB::raw('COUNT(DISTINCT lieu_votes.id) as total_lieuvotes'),
                        DB::raw('COUNT(DISTINCT bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes, SUM(bureau_votes.bult_nul) as total_bureau_bulnul, SUM(bureau_votes.bult_blan) as total_bureau_bulblanc, SUM(bureau_votes.votant_resul - (bureau_votes.bult_blan + bureau_votes.bult_nul)) as total_effective_votes'))
                        // ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('sections.id');
                    
                    if(array_key_exists("circonscription", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["circonscription"]).'%' );
                    if(array_key_exists("section", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["section"]).'%' );
                    // if(array_key_exists("commune", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["commune"]).'%' );
                    // if(array_key_exists("quartier", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["quartier"]).'%' );

                    if( array_key_exists("lieuvote", $searchidx) ) $queryB = $queryB->having('total_lieuvotes', '=', str_replace(['(', ')'], "",  $searchidx["lieuvote"]));
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));                    
                    if( array_key_exists("bulnul", $searchidx) ) $queryB = $queryB->having('total_bureau_bulnul', '=', str_replace(['(', ')'], "",  $searchidx["bulnul"]));
                    if( array_key_exists("bulblanc", $searchidx) ) $queryB = $queryB->having('total_bureau_bulblanc', '=', str_replace(['(', ')'], "",  $searchidx["bulblanc"]));
                    if( array_key_exists("suffrage", $searchidx) ) $queryB = $queryB->having('total_effective_votes', '=', str_replace(['(', ')'], "",  $searchidx["suffrage"]));

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
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         // dd($quartier->sections); exit();
                    //         $counter += $section->lieuVotes()->userlimit()->count();
                    //     }
                    // }

                    $communeId = $commune->id;
                    $counter = LieuVote::whereIn('quartier_id', function ($query) use ($communeId) {
                        $query->select('quartiers.id')
                            ->from('quartiers')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.id', $communeId);
                    })->count();
                    return $counter.'' ?? '0';
                })
                ->addColumn('bureauvote', function ($commune) {
                    $counter = 0;
                    // foreach($sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //         //     }
                            
                    //     }
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             $counter += $lieus->bureauVotes()->userlimit()->count();
                    //         }
                    //         // dd($quartier->sections); exit();
                    //         // $counter += $section->lieuVotes()->userlimit()->count();
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.id', $communeId);
                    })->count();
                    return $counter.'' ?? '0';
                })
                ->addColumn('votant', function ($commune) {
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                        
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                            ->where('sections.id', $communeId);
                    })
                    ->selectRaw('SUM(votant_suivi + votant_resul) AS votant_count')
                    ->value('votant_count');

                    $this->votants = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulnul', function ($commune) {
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += $bureau->bult_nul;
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->where('sections.id', $communeId);
                    })->sum('bult_nul');
                    $this->bultnulls = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulblanc', function ($commune){
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += $bureau->bult_blan;
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->where('sections.id', $communeId);
                    })->sum('bult_blan');
                    $this->bultblancs = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('suffrage', function ($commune){
                    return ($this->votants - ($this->bultblancs + $this->bultnulls));
                })
                ->addColumn('participation', function($commune) {
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->where('sections.id', $communeId);
                    })
                    ->selectRaw('SUM(votant_suivi + votant_resul) AS votant_count')
                    ->value('votant_count');
                    return round( $commune->nbrinscrit!=0?($counter/$commune->nbrinscrit)*100:0.0, 2).'%' ?? '0';
                })
                ->addColumn('candidata', function($commune) {
                    //$counter = 0;
                    $bvids = "";
                    $communeId = $commune->id;
                    $bvlist = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->join('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->where('sections.id', $communeId);
                    })->get();

                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $notes = $bureau->candidat_note;
                    //                 $currbv = "b".$bureau->id.",";
                    //                 if($notes && preg_match('/'.$currbv.'/i', $bvids) == false){
                    //                     $lists = json_decode($notes);
                    //                     $this->candidnote[0] += intval($lists->rhdp);
                    //                     $this->candidnote[1] += intval($lists->pdci);
                    //                     $this->candidnote[2] += intval($lists->ppa);
                    //                     $this->candidnote[3] += intval($lists->indep);
                    //                     $bvids .= "b".$bureau->id.",";
                    //                 }
                    //             }
                    //         }
                    //     }
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }

                    foreach($bvlist as $bureau){
                        $notes = $bureau->candidat_note;
                        $currbv = "b".$bureau->id.",";
                        if($notes && preg_match('/'.$currbv.'/i', $bvids) == false){
                            $lists = json_decode($notes);
                            $this->candidnote[0] += intval($lists->pdci);
                            $this->candidnote[1] += intval($lists->ppaci);
                            $this->candidnote[2] += intval($lists->rhdp);
                            $this->candidnote[3] += intval($lists->fpi);
                            $this->candidnote[4] += intval($lists->udpi);
                            $bvids .= "b".$bureau->id.",";
                        }
                    }
                    return $this->candidnote[0] ?? '0';
                })
                ->addColumn('candidatb', function($commune)  {
                    return $this->candidnote[1] ?? '0';
                })
                ->addColumn('candidatc', function($commune)  {
                    return $this->candidnote[2] ?? '0';
                })
                ->addColumn('candidatd', function($commune)  {
                    return $this->candidnote[3] ?? '0';
                })
                ->addColumn('candidate', function($lieuvote) {
                    return $this->candidnote[4] ?? '0';
                })
                // ->addColumn('candidatf', function($lieuvote) use ($sections) {
                //     return $this->candidnote[5] ?? '0';
                // })
                // ->addColumn('candidatg', function($lieuvote) use ($sections) {
                //     return $this->candidnote[6] ?? '0';
                // })
                // ->addColumn('candidath', function($lieuvote) use ($sections) {
                //     return $this->candidnote[7] ?? '0';
                // })
                ->rawColumns(
                    ['circonscription', 'section', 'lieuvote',
                     'bureauvote', 'votant',
                     'bulnul', 'bulblanc',
                     'suffrage', 'participation',
                     'candidata', 'candidatb',
                    'candidatc', 'candidatd',
                    'candidate', 
                    // 'candidatf',
                      ])
                    //   ->setTotalRecords($totalCount)
                    //   ->setFilteredRecords(intval($request->length))
                      ->toJson();
        }
    }
    
    public function getListRCommune(Request $request, $single){
        if ($request->ajax()) {
            
            //$agents = AgentTerrain::userlimit()->with('parrains')->with('section')->latest()->get();
            // $sections = Quartier::userlimit()->latest()->get();
            // $totalCount = RCommune::userlimit()->count();
            // $communes = RCommune::userlimit()
            // ->skip($request->start)
            // ->take($request->length);

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("commune", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("commune", $searchidx)?($searchidx["commune"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $communes = RCommune::userlimit()->where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $communes = RCommune::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("circonscription", $searchidx)
                    || array_key_exists("section", $searchidx)
                    // || array_key_exists("commune", $searchidx)
                    // || array_key_exists("quartier", $searchidx)
                    || array_key_exists("lieuvote", $searchidx)
                    || array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("bulnul", $searchidx)
                    || array_key_exists("bulblanc", $searchidx)
                    || array_key_exists("suffrage", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = RCommune::userlimit()->with('section.commune')
                        // ->leftJoin('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->leftJoin('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')

                        ->leftJoin('quartiers', 'rcommunes.id', '=', 'quartiers.r_commune_id')
                        ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                        ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->leftJoin('cor_parrains', 'lieu_votes.libel', '=', 'cor_parrains.nom_lv')
                        ->select('rcommunes.*', 
                        DB::raw('COUNT(DISTINCT lieu_votes.id) as total_lieuvotes'),
                        DB::raw('COUNT(DISTINCT bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes, SUM(bureau_votes.bult_nul) as total_bureau_bulnul, SUM(bureau_votes.bult_blan) as total_bureau_bulblanc, SUM(bureau_votes.votant_resul - (bureau_votes.bult_blan + bureau_votes.bult_nul)) as total_effective_votes'))
                        // ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('rcommunes.id');
                    
                    if(array_key_exists("circonscription", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["circonscription"]).'%' );
                    if(array_key_exists("section", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["section"]).'%' );
                    if(array_key_exists("commune", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["commune"]).'%' );
                    // if(array_key_exists("quartier", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["quartier"]).'%' );

                    if( array_key_exists("lieuvote", $searchidx) ) $queryB = $queryB->having('total_lieuvotes', '=', str_replace(['(', ')'], "",  $searchidx["lieuvote"]));
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));                    
                    if( array_key_exists("bulnul", $searchidx) ) $queryB = $queryB->having('total_bureau_bulnul', '=', str_replace(['(', ')'], "",  $searchidx["bulnul"]));
                    if( array_key_exists("bulblanc", $searchidx) ) $queryB = $queryB->having('total_bureau_bulblanc', '=', str_replace(['(', ')'], "",  $searchidx["bulblanc"]));
                    if( array_key_exists("suffrage", $searchidx) ) $queryB = $queryB->having('total_effective_votes', '=', str_replace(['(', ')'], "",  $searchidx["suffrage"]));

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
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         // dd($quartier->sections); exit();
                    //         $counter += $section->lieuVotes()->userlimit()->count();
                    //     }
                    // }

                    $communeId = $commune->id;
                    $counter = LieuVote::whereIn('quartier_id', function ($query) use ($communeId) {
                        $query->select('quartiers.id')
                            ->from('quartiers')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->where('rcommunes.id', $communeId);
                    })->count();
                    return $counter.'' ?? '0';
                })
                ->addColumn('bureauvote', function ($commune) {
                    $counter = 0;
                    // foreach($sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //         //     }
                            
                    //     }
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             $counter += $lieus->bureauVotes()->userlimit()->count();
                    //         }
                    //         // dd($quartier->sections); exit();
                    //         // $counter += $section->lieuVotes()->userlimit()->count();
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->where('rcommunes.id', $communeId);
                    })->count();
                    return $counter.'' ?? '0';
                })
                ->addColumn('votant', function ($commune) {
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                        
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                            ->where('rcommunes.id', $communeId);
                    })
                    ->selectRaw('SUM(votant_suivi + votant_resul) AS votant_count')
                    ->value('votant_count');

                    $this->votants = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulnul', function ($commune) {
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += $bureau->bult_nul;
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->where('rcommunes.id', $communeId);
                    })->sum('bult_nul');
                    $this->bultnulls = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulblanc', function ($commune){
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += $bureau->bult_blan;
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->where('rcommunes.id', $communeId);
                    })->sum('bult_blan');
                    $this->bultblancs = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('suffrage', function ($commune){
                    return ($this->votants - ($this->bultblancs + $this->bultnulls));
                })
                ->addColumn('participation', function($commune) {
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->where('rcommunes.id', $communeId);
                    })
                    ->selectRaw('SUM(votant_suivi + votant_resul) AS votant_count')
                    ->value('votant_count');
                    return round( $commune->nbrinscrit!=0?($counter/$commune->nbrinscrit)*100:0.0, 2).'%' ?? '0';
                })
                ->addColumn('candidata', function($commune) {
                    //$counter = 0;
                    $bvids = "";
                    $communeId = $commune->id;
                    $bvlist = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->join('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->where('rcommunes.id', $communeId);
                    })->get();

                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $notes = $bureau->candidat_note;
                    //                 $currbv = "b".$bureau->id.",";
                    //                 if($notes && preg_match('/'.$currbv.'/i', $bvids) == false){
                    //                     $lists = json_decode($notes);
                    //                     $this->candidnote[0] += intval($lists->rhdp);
                    //                     $this->candidnote[1] += intval($lists->pdci);
                    //                     $this->candidnote[2] += intval($lists->ppa);
                    //                     $this->candidnote[3] += intval($lists->indep);
                    //                     $bvids .= "b".$bureau->id.",";
                    //                 }
                    //             }
                    //         }
                    //     }
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }

                    foreach($bvlist as $bureau){
                        $notes = $bureau->candidat_note;
                        $currbv = "b".$bureau->id.",";
                        if($notes && preg_match('/'.$currbv.'/i', $bvids) == false){
                            $lists = json_decode($notes);
                            $this->candidnote[0] += intval($lists->pdci);
                            $this->candidnote[1] += intval($lists->ppaci);
                            $this->candidnote[2] += intval($lists->rhdp);
                            $this->candidnote[3] += intval($lists->fpi);
                            $this->candidnote[4] += intval($lists->udpi);
                            $bvids .= "b".$bureau->id.",";
                        }
                    }
                    return $this->candidnote[0] ?? '0';
                })
                ->addColumn('candidatb', function($commune)  {
                    return $this->candidnote[1] ?? '0';
                })
                ->addColumn('candidatc', function($commune)  {
                    return $this->candidnote[2] ?? '0';
                })
                ->addColumn('candidatd', function($commune)  {
                    return $this->candidnote[3] ?? '0';
                })
                ->addColumn('candidate', function($lieuvote) {
                    return $this->candidnote[4] ?? '0';
                })
                // ->addColumn('candidatf', function($lieuvote) use ($sections) {
                //     return $this->candidnote[5] ?? '0';
                // })
                // ->addColumn('candidatg', function($lieuvote) use ($sections) {
                //     return $this->candidnote[6] ?? '0';
                // })
                // ->addColumn('candidath', function($lieuvote) use ($sections) {
                //     return $this->candidnote[7] ?? '0';
                // })
                ->rawColumns(
                    ['circonscription', 'section', 'commune', 'lieuvote',
                     'bureauvote', 'votant',
                     'bulnul', 'bulblanc',
                     'suffrage', 'participation',
                     'candidata', 'candidatb',
                    'candidatc', 'candidatd',
                    'candidate', 
                    // 'candidatf',
                      ])
                    //   ->setTotalRecords($totalCount)
                    //   ->setFilteredRecords(intval($request->length))
                      ->toJson();
        }
    }
    
    public function getListQuartier(Request $request, $single){
        if ($request->ajax()) {
            
            //$agents = AgentTerrain::userlimit()->with('parrains')->with('section')->latest()->get();
            // $sections = Quartier::userlimit()->latest()->get();
            // $totalCount = Quartier::userlimit()->count();
            // $communes = Quartier::userlimit()
            // ->skip($request->start)
            // ->take($request->length);

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("quartier", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("quartier", $searchidx)?($searchidx["quartier"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $communes = Quartier::userlimit()->where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $communes = Quartier::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("circonscription", $searchidx)
                    || array_key_exists("section", $searchidx)
                    || array_key_exists("commune", $searchidx)
                    // || array_key_exists("quartier", $searchidx)
                    || array_key_exists("lieuvote", $searchidx)
                    || array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("bulnul", $searchidx)
                    || array_key_exists("bulblanc", $searchidx)
                    || array_key_exists("suffrage", $searchidx)
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
                        DB::raw('COUNT(DISTINCT bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes, SUM(bureau_votes.bult_nul) as total_bureau_bulnul, SUM(bureau_votes.bult_blan) as total_bureau_bulblanc, SUM(bureau_votes.votant_resul - (bureau_votes.bult_blan + bureau_votes.bult_nul)) as total_effective_votes'))
                        // ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('quartiers.id');
                    
                    if(array_key_exists("circonscription", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["circonscription"]).'%' );
                    if(array_key_exists("section", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["section"]).'%' );
                    if(array_key_exists("commune", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["commune"]).'%' );
                    if(array_key_exists("quartier", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["quartier"]).'%' );

                    if( array_key_exists("lieuvote", $searchidx) ) $queryB = $queryB->having('total_lieuvotes', '=', str_replace(['(', ')'], "",  $searchidx["lieuvote"]));
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));                    
                    if( array_key_exists("bulnul", $searchidx) ) $queryB = $queryB->having('total_bureau_bulnul', '=', str_replace(['(', ')'], "",  $searchidx["bulnul"]));
                    if( array_key_exists("bulblanc", $searchidx) ) $queryB = $queryB->having('total_bureau_bulblanc', '=', str_replace(['(', ')'], "",  $searchidx["bulblanc"]));
                    if( array_key_exists("suffrage", $searchidx) ) $queryB = $queryB->having('total_effective_votes', '=', str_replace(['(', ')'], "",  $searchidx["suffrage"]));

                    $communes = $queryB->get();  //CHANGE
                }else{
                    $communes = Quartier::userlimit();  //CHANGE
                }
            }else{
                $communes = Quartier::userlimit(); //CHANGE
            }
            
            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune){
                    return optional($commune->section->section->commune)->libel ?? '-';
                })
                ->addColumn('section', function ($commune){
                    return optional($commune->section->section)->libel ?? '-';
                })
                ->addColumn('commune', function ($commune){
                    return optional($commune->section)->libel ?? '-';
                })
                ->addColumn('quartier', function ($commune){
                    return optional($commune)->libel ?? '-';
                })
                ->addColumn('lieuvote', function ($commune){
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         // dd($quartier->sections); exit();
                    //         $counter += $section->lieuVotes()->userlimit()->count();
                    //     }
                    // }

                    $communeId = $commune->id;
                    $counter = LieuVote::whereIn('quartier_id', function ($query) use ($communeId) {
                        $query->select('quartiers.id')
                            ->from('quartiers')
                            ->where('quartiers.id', $communeId);
                    })->count();
                    return $counter.'' ?? '0';
                })
                ->addColumn('bureauvote', function ($commune){
                    $counter = 0;
                    // foreach($sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //         //     }
                            
                    //     }
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             $counter += $lieus->bureauVotes()->userlimit()->count();
                    //         }
                    //         // dd($quartier->sections); exit();
                    //         // $counter += $section->lieuVotes()->userlimit()->count();
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->where('quartiers.id', $communeId);
                    })->count();
                    return $counter.'' ?? '0';
                })
                ->addColumn('votant', function ($commune){
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                        
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                            ->where('quartiers.id', $communeId);
                    })
                    ->selectRaw('SUM(votant_suivi + votant_resul) AS votant_count')
                    ->value('votant_count');

                    $this->votants = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulnul', function ($commune){
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += $bureau->bult_nul;
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->where('quartiers.id', $communeId);
                    })->sum('bult_nul');
                    $this->bultnulls = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulblanc', function ($commune){
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += $bureau->bult_blan;
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->where('quartiers.id', $communeId);
                    })->sum('bult_blan');
                    $this->bultblancs = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('suffrage', function ($commune){
                    return ($this->votants - ($this->bultblancs + $this->bultnulls));
                })
                ->addColumn('participation', function($commune){
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $commune->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->where('quartiers.id', $communeId);
                    })
                    ->selectRaw('SUM(votant_suivi + votant_resul) AS votant_count')
                    ->value('votant_count');
                    return round( $commune->nbrinscrit!=0?($counter/$commune->nbrinscrit)*100:0.0, 2).'%' ?? '0';
                })
                ->addColumn('candidata', function($commune){
                    //$counter = 0;
                    $bvids = "";
                    $communeId = $commune->id;
                    $bvlist = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->join('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->where('quartiers.id', $communeId);
                    })->get();

                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $notes = $bureau->candidat_note;
                    //                 $currbv = "b".$bureau->id.",";
                    //                 if($notes && preg_match('/'.$currbv.'/i', $bvids) == false){
                    //                     $lists = json_decode($notes);
                    //                     $this->candidnote[0] += intval($lists->rhdp);
                    //                     $this->candidnote[1] += intval($lists->pdci);
                    //                     $this->candidnote[2] += intval($lists->ppa);
                    //                     $this->candidnote[3] += intval($lists->indep);
                    //                     $bvids .= "b".$bureau->id.",";
                    //                 }
                    //             }
                    //         }
                    //     }
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                        
                    // }

                    foreach($bvlist as $bureau){
                        $notes = $bureau->candidat_note;
                        $currbv = "b".$bureau->id.",";
                        if($notes && preg_match('/'.$currbv.'/i', $bvids) == false){
                            $lists = json_decode($notes);
                            $this->candidnote[0] += intval($lists->pdci);
                            $this->candidnote[1] += intval($lists->ppaci);
                            $this->candidnote[2] += intval($lists->rhdp);
                            $this->candidnote[3] += intval($lists->fpi);
                            $this->candidnote[4] += intval($lists->udpi);
                            $bvids .= "b".$bureau->id.",";
                        }
                    }
                    return $this->candidnote[0] ?? '0';
                })
                ->addColumn('candidatb', function($commune)  {
                    return $this->candidnote[1] ?? '0';
                })
                ->addColumn('candidatc', function($commune)  {
                    return $this->candidnote[2] ?? '0';
                })
                ->addColumn('candidatd', function($commune)  {
                    return $this->candidnote[3] ?? '0';
                })
                ->addColumn('candidate', function($lieuvote){
                    return $this->candidnote[4] ?? '0';
                })
                // ->addColumn('candidatf', function($lieuvote) use ($sections) {
                //     return $this->candidnote[5] ?? '0';
                // })
                // ->addColumn('candidatg', function($lieuvote) use ($sections) {
                //     return $this->candidnote[6] ?? '0';
                // })
                // ->addColumn('candidath', function($lieuvote) use ($sections) {
                //     return $this->candidnote[7] ?? '0';
                // })
                ->rawColumns(
                    ['circonscription', 'section', 'commune', 'quartier', 'lieuvote',
                     'bureauvote', 'votant',
                     'bulnul', 'bulblanc',
                     'suffrage', 'participation',
                     'candidata', 'candidatb',
                    'candidatc', 'candidatd',
                    'candidate', 
                    // 'candidatf',
                      ])
                      ->toJson();
        }
    }

    public function getListLieuvote(Request $request, $single){
        if ($request->ajax()) {
            
            // dd($request->all());
            //$agents = AgentTerrain::userlimit()->with('parrains')->with('section')->latest()->get();
            $candidats = Candidat::all();
            // $sections = Quartier::userlimit()->latest()->get();
            // $totalCount = LieuVote::userlimit()->count();
            // $lieuvotes = LieuVote::userlimit();
            // ->skip($request->start)
            // ->take($request->length);

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("lieuvote", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("lieuvote", $searchidx)?($searchidx["lieuvote"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $lieuvotes = LieuVote::userlimit()->where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $lieuvotes = LieuVote::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(
                    // array_key_exists("circonscription", $searchidx)
                    // || array_key_exists("section", $searchidx)
                    // || array_key_exists("commune", $searchidx)
                    // || array_key_exists("quartier", $searchidx)
                    array_key_exists("lieuvote", $searchidx)
                    || array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("bulnul", $searchidx)
                    || array_key_exists("bulblanc", $searchidx)
                    || array_key_exists("suffrage", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = LieuVote::userlimit()
                        // ->leftJoin('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        // ->leftJoin('sections', 'rcommunes.section_id', '=', 'sections.id')
                        // ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                        // ->leftJoin('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')

                        ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->leftJoin('cor_parrains', 'lieu_votes.libel', '=', 'cor_parrains.nom_lv')
                        ->select('lieu_votes.*', 
                        DB::raw('COUNT(DISTINCT lieu_votes.id) as total_lieuvotes'),
                        DB::raw('COUNT(DISTINCT bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes, SUM(bureau_votes.bult_nul) as total_bureau_bulnul, SUM(bureau_votes.bult_blan) as total_bureau_bulblanc, SUM(bureau_votes.votant_resul - (bureau_votes.bult_blan + bureau_votes.bult_nul)) as total_effective_votes'))
                        // ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('lieu_votes.id');
                    
                    // if(array_key_exists("circonscription", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["circonscription"]).'%' );
                    // if(array_key_exists("section", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["section"]).'%' );
                    // if(array_key_exists("commune", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["commune"]).'%' );
                    // if(array_key_exists("quartier", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["quartier"]).'%' );
                    if(array_key_exists("lieuvote", $searchidx)) $queryB = $queryB->where('lieu_votes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["lieuvote"]).'%' );

                    // if( array_key_exists("lieuvote", $searchidx) ) $queryB = $queryB->having('total_lieuvotes', '=', str_replace(['(', ')'], "",  $searchidx["lieuvote"]));
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));                    
                    if( array_key_exists("bulnul", $searchidx) ) $queryB = $queryB->having('total_bureau_bulnul', '=', str_replace(['(', ')'], "",  $searchidx["bulnul"]));
                    if( array_key_exists("bulblanc", $searchidx) ) $queryB = $queryB->having('total_bureau_bulblanc', '=', str_replace(['(', ')'], "",  $searchidx["bulblanc"]));
                    if( array_key_exists("suffrage", $searchidx) ) $queryB = $queryB->having('total_effective_votes', '=', str_replace(['(', ')'], "",  $searchidx["suffrage"]));

                    $lieuvotes = $queryB->get();  //CHANGE
                }else{
                    $lieuvotes = LieuVote::userlimit();  //CHANGE
                }
            }else{
                $lieuvotes = LieuVote::userlimit(); //CHANGE
            }

            return DataTables::of($lieuvotes)
                ->addColumn('lieuvote', function ($lieuvote) {
                    $this->bultnulls = 0;
                    $this->bultblancs = 0;
                    $this->votants = 0;
                    $this->candidnote = [0,0,0,0,0,0,0,0,0,0,0,0];
                    return $lieuvote->libel.'' ?? '-';
                })
                ->addColumn('bureauvote', function ($lieuvote) {
                    $counter = 0;
                    // foreach($sections as $section){
                    //     // foreach($section->quartiers as $quartier){
                    //         //     }
                            
                    //     }
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             $counter += $lieus->bureauVotes()->userlimit()->count();
                    //         }
                    //         // dd($quartier->sections); exit();
                    //         // $counter += $section->lieuVotes()->userlimit()->count();
                    //     }
                    // }
                    $communeId = $lieuvote->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->where('lieu_votes.id', $communeId);
                    })->count();
                    return $counter.'' ?? '0';
                })
                ->addColumn('votant', function ($lieuvote) {
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                        
                    // }
                    $communeId = $lieuvote->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                            ->from('lieu_votes')
                            ->where('lieu_votes.id', $communeId);
                    })
                    ->selectRaw('SUM(votant_suivi + votant_resul) AS votant_count')
                    ->value('votant_count');

                    $this->votants = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulnul', function ($lieuvote) {
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += $bureau->bult_nul;
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $lieuvote->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->where('lieu_votes.id', $communeId);
                    })->sum('bult_nul');
                    $this->bultnulls = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulblanc', function ($lieuvote) {
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += $bureau->bult_blan;
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $lieuvote->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->where('lieu_votes.id', $communeId);
                    })->sum('bult_blan');
                    $this->bultblancs = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('suffrage', function ($lieuvote) {
                    return ($this->votants - ($this->bultblancs + $this->bultnulls));
                })
                ->addColumn('participation', function($lieuvote) {
                    $counter = 0;
                    // foreach($commune->quartiers as $quartier){
                    //     foreach($quartier->sections as $section){
                    //         foreach($section->lieuVotes as $lieus){
                    //             foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                    //                 $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                    //             }
                    //         }
                    //         // foreach($section->quartiers as $quartier){
                    //         //     }
                    //     }
                    // }
                    $communeId = $lieuvote->id;
                    $counter = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->where('lieu_votes.id', $communeId);
                    })
                    ->selectRaw('SUM(votant_suivi + votant_resul) AS votant_count')
                    ->value('votant_count');
                    return round( $lieuvote->nbrinscrit!=0?($counter/$lieuvote->nbrinscrit)*100:0.0, 2).'%' ?? '0';
                })
                ->addColumn('candidata', function($lieuvote) use ($candidats) {
                    //$counter = 0;
                    $communeId = $lieuvote->id;
                    $bvlist = BureauVote::whereIn('lieu_vote_id', function ($query) use ($communeId) {
                        $query->select('lieu_votes.id')
                        ->from('lieu_votes')
                        ->where('lieu_votes.id', $communeId);
                    })->get();

                    // foreach($sections as $section){
                    //     foreach($section->lieuVotes as $lieus){
                    //         if($lieus->libel == $lieuvote->libel){
                    foreach($bvlist as $bureau){
                        $notes = $bureau->candidat_note;
                        if($notes){
                            $lists = json_decode($notes);
                            $cand_pos = 0;
                            foreach ($candidats as $candidat){
                                $namek = $candidat->code;
                                if(is_object($lists) && property_exists($lists, "$namek")){    
                                    $this->candidnote[$cand_pos] += intval($lists->$namek);
                                }
                                $cand_pos++;
                            }
                        }
                    }
                    //         }
                    //     }
                    //     // foreach($section->quartiers as $quartier){
                    //     //     }
                    // }
                    
                    return $this->candidnote[0] ?? '0';
                })
                ->addColumn('candidatb', function($lieuvote) {
                    return $this->candidnote[1] ?? '0';
                })
                ->addColumn('candidatc', function($lieuvote) {
                    return $this->candidnote[2] ?? '0';
                })
                ->addColumn('candidatd', function($lieuvote) {
                    return $this->candidnote[3] ?? '0';
                })
                ->addColumn('candidate', function($lieuvote) {
                    return $this->candidnote[4] ?? '0';
                })
                // ->addColumn('candidatf', function($lieuvote) use ($sections) {
                //     return $this->candidnote[5] ?? '0';
                // })
                // ->addColumn('candidatg', function($lieuvote) use ($sections) {
                //     return $this->candidnote[6] ?? '0';
                // })
                // ->addColumn('candidath', function($lieuvote) use ($sections) {
                //     return $this->candidnote[7] ?? '0';
                // })
                ->rawColumns(
                    ['lieuvote',
                     'bureauvote', 'votant',
                     'bulnul', 'bulblanc',
                     'suffrage', 'participation',
                     'candidata', 'candidatb',
                    'candidatc', 'candidatd',
                    'candidate', 
                    // 'candidatf',
                    //  'candidatg', 'candidath',
                      ])
                    //   ->setTotalRecords($totalCount)
                    //   ->setFilteredRecords($totalCount)
                      ->make(true);
        }
    }

    public function getListBureauvote(Request $request, $single){
        if ($request->ajax()) {
            
            //$agents = AgentTerrain::userlimit()->with('parrains')->with('section')->latest()->get();
            $candidats = Candidat::all();
            // $totalCount = BureauVote::userlimit()->count();
            // $bureauvotes = BureauVote::userlimit()
            // ->skip($request->start)
            // ->take($request->length);

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("libel", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("libel", $searchidx)?($searchidx["libel"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $bureauvotes = BureauVote::userlimit()->where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $bureauvotes = BureauVote::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(
                    array_key_exists("lieuv", $searchidx)
                    // || array_key_exists("section", $searchidx)
                    // || array_key_exists("commune", $searchidx)
                    // || array_key_exists("quartier", $searchidx)
                    || array_key_exists("lieuvote", $searchidx)
                    || array_key_exists("bureauvote", $searchidx)
                    || array_key_exists("votant", $searchidx)
                    || array_key_exists("bulnul", $searchidx)
                    || array_key_exists("bulblanc", $searchidx)
                    || array_key_exists("suffrage", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = BureauVote::userlimit()->with("lieuVote")
                        // ->leftJoin('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        // ->leftJoin('sections', 'rcommunes.section_id', '=', 'sections.id')
                        // ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                        ->leftJoin('lieu_votes', 'bureau_votes.lieu_vote_id', '=', 'lieu_votes.id')
                        // ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                        ->leftJoin('cor_parrains', 'lieu_votes.libel', '=', 'cor_parrains.nom_lv')
                        ->select('bureau_votes.*', 
                        DB::raw('COUNT(DISTINCT lieu_votes.id) as total_lieuvotes'),
                        DB::raw('COUNT(DISTINCT bureau_votes.id) as total_bureau_votes, SUM(bureau_votes.votant_suivi) as total_bureau_votes_votant_suivi, COUNT(cor_parrains.id) as total_bureau_votes_recense, SUM(cor_parrains.a_vote) as total_bureau_avotes, SUM(bureau_votes.bult_nul) as total_bureau_bulnul, SUM(bureau_votes.bult_blan) as total_bureau_bulblanc, SUM(bureau_votes.votant_resul - (bureau_votes.bult_blan + bureau_votes.bult_nul)) as total_effective_votes'))
                        // ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('bureau_votes.id');
                    
                    if(array_key_exists("lieuv", $searchidx)) $queryB = $queryB->where('lieu_votes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["lieuv"]).'%' );
                    // if(array_key_exists("section", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["section"]).'%' );
                    // if(array_key_exists("commune", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["commune"]).'%' );
                    // if(array_key_exists("quartier", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["quartier"]).'%' );
                    if(array_key_exists("libel", $searchidx)) $queryB = $queryB->where('bureau_votes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["libel"]).'%' );

                    if( array_key_exists("lieuvote", $searchidx) ) $queryB = $queryB->having('total_lieuvotes', '=', str_replace(['(', ')'], "",  $searchidx["lieuvote"]));
                    if( array_key_exists("bureauvote", $searchidx) ) $queryB = $queryB->having('total_bureau_votes', '=', str_replace(['(', ')'], "",  $searchidx["bureauvote"]));
                    if( array_key_exists("votant", $searchidx) ) $queryB = $queryB->having('total_bureau_votes_votant_suivi', '=', str_replace(['(', ')'], "",  $searchidx["votant"]));                    
                    if( array_key_exists("bulnul", $searchidx) ) $queryB = $queryB->having('total_bureau_bulnul', '=', str_replace(['(', ')'], "",  $searchidx["bulnul"]));
                    if( array_key_exists("bulblanc", $searchidx) ) $queryB = $queryB->having('total_bureau_bulblanc', '=', str_replace(['(', ')'], "",  $searchidx["bulblanc"]));
                    if( array_key_exists("suffrage", $searchidx) ) $queryB = $queryB->having('total_effective_votes', '=', str_replace(['(', ')'], "",  $searchidx["suffrage"]));

                    $bureauvotes = $queryB->get();  //CHANGE
                }else{
                    $bureauvotes = BureauVote::userlimit();  //CHANGE
                }
            }else{
                $bureauvotes = BureauVote::userlimit(); //CHANGE
            }

            return DataTables::of($bureauvotes)
                ->addColumn('lieuv', function ($bureauvote) {
                    $this->bultnulls = 0;
                    $this->bultblancs = 0;
                    $this->votants = 0;
                    $this->candidnote = [0,0,0,0,0,0,0,0,0,0,0,0];
                    return optional($bureauvote->lieuVote)->libel ?? '-';
                })
                ->addColumn('votant', function ($bureauvote) {
                    $counter = 0;
                    $counter += ($bureauvote->votant_resul);
                    $this->votants = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulnul', function ($bureauvote) {
                    $counter = 0;
                    $counter += $bureauvote->bult_nul;
                    $this->bultnulls = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulblanc', function ($bureauvote) {
                    $counter = 0;
                    $counter += $bureauvote->bult_blan;
                    $this->bultblancs = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('suffrage', function ($bureauvote) {
                    return ($this->votants - ($this->bultblancs + $this->bultnulls));
                })
                ->addColumn('participation', function($bureauvote) {
                    $counter = 0;
                    $counter += ($bureauvote->votant_resul);
                    return round( $bureauvote->objectif!=0?($counter/$bureauvote->objectif)*100:0.0, 2).'%' ?? '0';
                })
                ->addColumn('candidata', function($bureauvote) use($candidats) {
                    //$counter = 0;
                    $notes = $bureauvote->candidat_note;
                    if($notes){
                        $lists = json_decode($notes);
                        $cand_pos = 0;
                        foreach ($candidats as $candidat){
                            $namek = $candidat->code;
                            if(is_object($lists) && property_exists($lists, "$namek")){    
                                $this->candidnote[$cand_pos] += intval($lists->$namek);
                            }
                            $cand_pos++;
                        }
                    }
                    return $this->candidnote[0] ?? '0';
                })
                ->addColumn('candidatb', function($lieuvote){
                    return $this->candidnote[1] ?? '0';
                })
                ->addColumn('candidatc', function($lieuvote){
                    return $this->candidnote[2] ?? '0';
                })
                ->addColumn('candidatd', function($lieuvote){
                    return $this->candidnote[3] ?? '0';
                })
                ->addColumn('candidate', function($lieuvote){
                    return $this->candidnote[4] ?? '0';
                })
                // ->addColumn('candidatf', function($lieuvote){
                //     return $this->candidnote[5] ?? '0';
                // })
                // ->addColumn('candidatg', function($lieuvote){
                //     return $this->candidnote[6] ?? '0';
                // })
                // ->addColumn('candidath', function($lieuvote){
                //     return $this->candidnote[7] ?? '0';
                // })
                ->addColumn('pverb', function($bureauvote) {
                    $listofpv = "";
                    foreach($bureauvote->procesverbals as $pverb){
                        if($pverb->photo){
                            $listofpv .= '<div class="KBmodal" data-content-url="<div style=\'position:relative;\'> <h3 style=\'background-color:white;color:black;font-weight:bold;position:absolute;left:0;top:0;\'>'.(optional($bureauvote->lieuvote)->libel??"-".' - '.$bureauvote->libel).'</h3> <img src=\''.(Storage::url($pverb->photo)).'\' style=\'max-width: 1550px; max-height: 670px;\'></div>" data-content-type="html"><i class="ion ion-md-camera"></i></div>&nbsp;';
                        }
                    }
                    return $listofpv;
                })
                ->rawColumns(['lieuv','votant',
                    'bulnul', 'bulblanc',
                    'suffrage', 'participation',
                    'candidata', 'candidatb',
                    'candidatc', 'candidatd',
                    'candidate', 
                    // 'candidatf',
                    // 'candidatg', 'candidath',
                    'pverb'
                ])
                ->toJson();
        }
    }

    public function listCommune(){
        return view("app.resultat.index-commune");
    }
    public function listSection(){
        return view("app.resultat.index-section");
    }
    public function listRcommune(){
        return view("app.resultat.index-rcommune");
    }
    public function listQuartier(){
        return view("app.resultat.index-quartier");
    }
    
    public function listLieuvote(){
        return view("app.resultat.index-lieuvote");
    }
    
    public function listBureauvote(){
        return view("app.resultat.index-bureauvote");
    }

}
