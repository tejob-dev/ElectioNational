<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Parrain;
use App\Models\Section;
use App\Models\Candidat;
use App\Models\LieuVote;
use App\Models\BureauVote;
use App\Models\AgentTerrain;
use App\Models\Quartier;
use Illuminate\Http\Request;
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
            $sections = Quartier::userlimit()->latest()->get();
            $communes = Commune::userlimit()->get();
            return DataTables::of($communes)
                ->addColumn('circonscription', function ($commune) use($sections) {
                    return optional($commune)->libel ?? '-';
                })
                ->addColumn('lieuvote', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        $counter += $section->lieuVotes()->userlimit()->count();
                        // foreach($section->quartiers as $quartier){
                        //     }
                        
                    }
                    return $counter.'' ?? '0';
                })
                ->addColumn('bureauvote', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            $counter += $lieus->bureauVotes()->userlimit()->count();
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        
                    }
                    return $counter.'' ?? '0';
                })
                ->addColumn('votant', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                                $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        
                    }
                    $this->votants = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulnul', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                                $counter += $bureau->bult_nul;
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        
                    }
                    $this->bultnulls = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulblanc', function ($commune) use($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                                $counter += $bureau->bult_blan;
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        
                    }
                    $this->bultblancs = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('suffrage', function ($commune) use($sections) {
                    return ($this->votants - ($this->bultblancs + $this->bultnulls));
                })
                ->addColumn('participation', function($commune) use ($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                                $counter += ($bureau->votant_suivi + $bureau->votant_resul);
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        
                    }
                    return round( $commune->nbrinscrit!=0?($counter/$commune->nbrinscrit)*100:0.0, 2).'%' ?? '0';
                })
                ->addColumn('candidata', function($commune) use ($sections) {
                    //$counter = 0;
                    $bvids = "";
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            foreach($lieus->bureauVotes()->userlimit()->get() as $bureau){
                                $notes = $bureau->candidat_note;
                                $currbv = "b".$bureau->id.",";
                                if($notes && preg_match('/'.$currbv.'/i', $bvids) == false){
                                    $lists = json_decode($notes);
                                    $this->candidnote[0] += intval($lists->rhdp);
                                    $this->candidnote[1] += intval($lists->pdci);
                                    $this->candidnote[2] += intval($lists->ppa);
                                    $this->candidnote[3] += intval($lists->indep);
                                    $bvids .= "b".$bureau->id.",";
                                }
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        
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
                ->addColumn('candidate', function($lieuvote) use ($sections) {
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
                ->make(true);
        }
    }

    public function getListLieuvote(Request $request, $single){
        if ($request->ajax()) {
            
            //$agents = AgentTerrain::userlimit()->with('parrains')->with('section')->latest()->get();
            $candidats = Candidat::all();
            $sections = Quartier::userlimit()->latest()->get();
            $lieuvotes = LieuVote::userlimit()->get();
            return DataTables::of($lieuvotes)
                ->addColumn('lieuvote', function ($lieuvote) use($sections) {
                    $this->bultnulls = 0;
                    $this->bultblancs = 0;
                    $this->votants = 0;
                    $this->candidnote = [0,0,0,0,0,0,0,0,0,0,0,0];
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
                    
                    $this->votants = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulnul', function ($lieuvote) use($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            if($lieus->libel == $lieuvote->libel){
                                foreach($lieus->bureauVotes as $bureau){
                                    $counter += $bureau->bult_nul;
                                }
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        }
                    
                    $this->bultnulls = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('bulblanc', function ($lieuvote) use($sections) {
                    $counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            if($lieus->libel == $lieuvote->libel){
                                foreach($lieus->bureauVotes as $bureau){
                                    $counter += $bureau->bult_blan;
                                }
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                        }
                    
                    $this->bultblancs = $counter;
                    return $counter.'' ?? '0';
                })
                ->addColumn('suffrage', function ($lieuvote) use($sections) {
                    return ($this->votants - ($this->bultblancs + $this->bultnulls));
                })
                ->addColumn('participation', function($lieuvote) use ($sections) {
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
                    
                    return round( $lieuvote->nbrinscrit!=0?($counter/$lieuvote->nbrinscrit)*100:0.0, 2).'%' ?? '0';
                })
                ->addColumn('candidata', function($lieuvote) use ($sections, $candidats) {
                    //$counter = 0;
                    foreach($sections as $section){
                        foreach($section->lieuVotes as $lieus){
                            if($lieus->libel == $lieuvote->libel){
                                foreach($lieus->bureauVotes as $bureau){
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
                            }
                        }
                        // foreach($section->quartiers as $quartier){
                        //     }
                    }
                    
                    return $this->candidnote[0] ?? '0';
                })
                ->addColumn('candidatb', function($lieuvote) use ($sections) {
                    return $this->candidnote[1] ?? '0';
                })
                ->addColumn('candidatc', function($lieuvote) use ($sections) {
                    return $this->candidnote[2] ?? '0';
                })
                ->addColumn('candidatd', function($lieuvote) use ($sections) {
                    return $this->candidnote[3] ?? '0';
                })
                ->addColumn('candidate', function($lieuvote) use ($sections) {
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
                ->make(true);
        }
    }

    public function getListBureauvote(Request $request, $single){
        if ($request->ajax()) {
            
            //$agents = AgentTerrain::userlimit()->with('parrains')->with('section')->latest()->get();
            $candidats = Candidat::all();
            $bureauvotes = BureauVote::userlimit()->get();
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
                ->make(true);
        }
    }

    public function listCommune(){
        return view("app.resultat.index-commune");
    }
    
    public function listLieuvote(){
        return view("app.resultat.index-lieuvote");
    }
    
    public function listBureauvote(){
        return view("app.resultat.index-bureauvote");
    }

}
