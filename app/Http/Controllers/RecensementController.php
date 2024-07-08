<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\Region;
use App\Models\Commune;
use App\Models\Parrain;
use App\Models\Section;
use App\Models\District;
use App\Models\LieuVote;
use App\Models\Quartier;
use App\Models\RCommune;

use App\Models\Departement;
use App\Models\SousSection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AgentDeSection;
use App\Models\ElectorParrain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecensementController extends Controller
{

    protected $rgphval = 0;
    protected $rgphattente = 0;
    protected $objectif = 0;
    protected $allcount = 0;
    protected $fghijlist = [];
 
    public function getCommuneList(Request $request, $single){
        if ($request->ajax()) {
            // dd($lieus);
            $searchidx = get_item_of_datatables($request->all());
                
            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("communes", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("communes", $searchidx)?($searchidx["communes"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $items = Commune::where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $items = Commune::where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("districts", $searchidx) 
                    || array_key_exists("regions", $searchidx)
                    || array_key_exists("departements", $searchidx)
                    // || array_key_exists("departm", $searchidx)
                    // || array_key_exists("communem", $searchidx)
                    // || array_key_exists("sectionm", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = Commune::
                        leftJoin('departements', 'communes.departement_id', '=', 'departements.id')
                        ->leftJoin('regions', 'departements.region_id', '=', 'regions.id')
                        ->leftJoin('districts', 'regions.district_id', '=', 'districts.id')
                        ->select('communes.*')
                        ->groupBy('communes.id');

                    // if( array_key_exists("parrainm", $searchidx) ) $queryB = $queryB->having('total_parrains', '=', str_replace(['(', ')'], "",  $searchidx["parrainm"]));

                    if(array_key_exists("districts", $searchidx)) $queryB = $queryB->where('districts.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["districts"]).'%' );
                    if(array_key_exists("regions", $searchidx)) $queryB = $queryB->where('regions.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["regions"]).'%' );
                    if(array_key_exists("departements", $searchidx)) $queryB = $queryB->where('departements.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["departements"]).'%' );
                    if(array_key_exists("communes", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["communes"]).'%' );
                    
                    // dd($searchidx["sectionm"], $queryB->get());
                    $items = $queryB->get();  //CHANGE
                }else{
                    $items = new Commune; 
                    $items = $items->newQuery();  //CHANGE
                }
            }else{
                $items = new Commune; 
                $items = $items->newQuery();
            }
            // $parrains = Parrain::all();
            return DataTables::of($items)
                ->addColumn('districts', function ($item) {
                    $this->fghijlist = [];
                    return optional($item)->departement?->region?->district?->libel ?? '-';
                })
                ->addColumn('regions', function ($item) {
                    
                    return optional($item)->departement?->region?->libel ?? '-';
                })
                ->addColumn('departements', function ($item) {
                    
                    return optional($item)->departement?->libel ?? '-';
                })
                ->addColumn('communes', function ($item) {
                    
                    return optional($item)->libel ?? '-';
                })
                ->addColumn('rgph', function ($item) {
                    $counter = Commune::where('id', "=", $item->id)->selectRaw('SUM(rgph_population) AS rgph_population_sum')
                    ->value('rgph_population_sum');

                    $this->rgphval = $counter;
                    return $counter ?? '-';
                })
                ->addColumn('rgphattente', function ($item) {
                    $this->rgphattente = round($this->rgphval*0.45);
                    return $this->rgphattente;
                })
                ->addColumn('inscritcei', function ($item) {
                    return $item?->nbrinscrit;
                })
                ->addColumn('objectif', function ($item) {
                    $this->objectif = $this->rgphattente - ($item?->nbrinscrit);
                    return $this->objectif;
                })
                ->addColumn('electorat', function ($item) {
                    $count  = ElectorParrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            // ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('communes.id', $item->id);
                    })
                    ->where("elect_date", "=", "2023")
                    ->selectRaw('COUNT(elector_parrains.id) AS elector_parrains_count')
                    ->value('elector_parrains_count');

                    $this->fghijlist[0] = $count;
                    return $count??"0";
                })
                ->addColumn('recensescni', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('id')
                            ->from('communes')
                            // ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('id', $item->id);
                    })
                    ->where("cni_dispo", "=", "Oui")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[1] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesncni', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            // ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('communes.id', $item->id);
                    })
                    ->where("cni_dispo", "=", "Non")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[2] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesextr', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            // ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('communes.id', $item->id);
                    })
                    ->where("extrait", "=", "Oui")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[3] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesnextr', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            // ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('communes.id', $item->id);
                    })
                    ->where("extrait", "=", "Non")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[4] = $count;
                    return $count??"0";
                })
                ->addColumn('recenses', function ($item) {
                    $this->allcount = 0;
                    foreach($this->fghijlist as $itemval){
                        $this->allcount += $itemval;
                    }
                    return $this->allcount??"0";
                })
                ->addColumn('restrecenses', function ($item) {
                    $restrecenses = $this->objectif - $this->allcount;
                    return $restrecenses??"0";
                })
                ->rawColumns([
                    'districts',
                    'regions',
                    'departements',
                    'communes',
                    'rgph',
                    'rgphattente', 
                    'inscritcei', 
                    'objectif',
                    'recenses',
                    'electorat',
                    'recensescni',
                    'recensesncni',
                    'recensesextr',
                    'recensesnextr',
                    'restrecenses',
                    ])
                ->toJson();

            

            // dd($dataJson->getContent());

            
                // ->make(true);

        }
    }

    public function getDepartementList(Request $request, $single){
        if ($request->ajax()) {
            // dd($lieus);
            $searchidx = get_item_of_datatables($request->all());
                
            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("departements", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("departements", $searchidx)?($searchidx["departements"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $items = Departement::where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $items = Departement::where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("districts", $searchidx) 
                    || array_key_exists("regions", $searchidx)
                    // || array_key_exists("departm", $searchidx)
                    // || array_key_exists("communem", $searchidx)
                    // || array_key_exists("sectionm", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = Departement::
                        leftJoin('regions', 'departements.region_id', '=', 'regions.id')
                        ->leftJoin('districts', 'regions.district_id', '=', 'districts.id')
                        ->select('departements.*')
                        ->groupBy('departements.id');

                    // if( array_key_exists("parrainm", $searchidx) ) $queryB = $queryB->having('total_parrains', '=', str_replace(['(', ')'], "",  $searchidx["parrainm"]));

                    if(array_key_exists("districts", $searchidx)) $queryB = $queryB->where('districts.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["districts"]).'%' );
                    if(array_key_exists("regions", $searchidx)) $queryB = $queryB->where('regions.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["regions"]).'%' );
                    if(array_key_exists("departements", $searchidx)) $queryB = $queryB->where('departements.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["departements"]).'%' );
                    
                    // dd($searchidx["sectionm"], $queryB->get());
                    $items = $queryB->get();  //CHANGE
                }else{
                    $items = new Departement; 
                    $items = $items->newQuery();  //CHANGE
                }
            }else{
                $items = new Departement; 
                $items = $items->newQuery();
            }
            // $parrains = Parrain::all();
            return DataTables::of($items)
                ->addColumn('districts', function ($item) {
                    $this->fghijlist = [];
                    return optional($item)->region?->district?->libel ?? '-';
                })
                ->addColumn('regions', function ($item) {
                    
                    return optional($item)->region?->libel ?? '-';
                })
                ->addColumn('departements', function ($item) {
                    
                    return optional($item)->libel ?? '-';
                })
                ->addColumn('rgph', function ($item) {
                    $counter = Commune::whereIn('departement_id', function ($query) use($item) {
                        $query->select('departements.id')
                            ->from('departements')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('departements.id', $item->id);
                    })
                    ->selectRaw('SUM(rgph_population) AS rgph_population_sum')
                    ->value('rgph_population_sum');

                    $this->rgphval = $counter;
                    return $counter ?? '-';
                })
                ->addColumn('rgphattente', function ($item) {
                    $this->rgphattente = round($this->rgphval*0.45);
                    return $this->rgphattente;
                })
                ->addColumn('inscritcei', function ($item) {
                    return $item?->nbrinscrit;
                })
                ->addColumn('objectif', function ($item) {
                    $this->objectif = $this->rgphattente - ($item?->nbrinscrit);
                    return $this->objectif;
                })
                ->addColumn('electorat', function ($item) {
                    $count  = ElectorParrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('departements.id', $item->id);
                    })
                    ->where("elect_date", "=", "2023")
                    ->selectRaw('COUNT(elector_parrains.id) AS elector_parrains_count')
                    ->value('elector_parrains_count');

                    $this->fghijlist[0] = $count;
                    return $count??"0";
                })
                ->addColumn('recensescni', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('departements.id', $item->id);
                    })
                    ->where("cni_dispo", "=", "Oui")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[1] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesncni', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('departements.id', $item->id);
                    })
                    ->where("cni_dispo", "=", "Non")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[2] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesextr', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('departements.id', $item->id);
                    })
                    ->where("extrait", "=", "Oui")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[3] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesnextr', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            // ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('departements.id', $item->id);
                    })
                    ->where("extrait", "=", "Non")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[4] = $count;
                    return $count??"0";
                })
                ->addColumn('recenses', function ($item) {
                    $this->allcount = 0;
                    foreach($this->fghijlist as $itemval){
                        $this->allcount += $itemval;
                    }
                    return $this->allcount??"0";
                })
                ->addColumn('restrecenses', function ($item) {
                    $restrecenses = $this->objectif - $this->allcount;
                    return $restrecenses??"0";
                })
                ->rawColumns([
                    'districts',
                    'regions',
                    'departements',
                    'rgph',
                    'rgphattente', 
                    'inscritcei', 
                    'objectif',
                    'recenses',
                    'electorat',
                    'recensescni',
                    'recensesncni',
                    'recensesextr',
                    'recensesnextr',
                    'restrecenses',
                    ])
                ->toJson();

            

            // dd($dataJson->getContent());

            
                // ->make(true);

        }
    }

    public function getRegionList(Request $request, $single){

        if ($request->ajax()) {
            // dd($lieus);
            $searchidx = get_item_of_datatables($request->all());
                
            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("regions", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("regions", $searchidx)?($searchidx["regions"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $items = Region::where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $items = Region::where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("districts", $searchidx) 
                    // || array_key_exists("regionm", $searchidx)
                    // || array_key_exists("departm", $searchidx)
                    // || array_key_exists("communem", $searchidx)
                    // || array_key_exists("sectionm", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = Region::leftJoin('districts', 'regions.district_id', '=', 'districts.id')
                        ->select('regions.*')
                        ->groupBy('regions.id');

                    // if( array_key_exists("parrainm", $searchidx) ) $queryB = $queryB->having('total_parrains', '=', str_replace(['(', ')'], "",  $searchidx["parrainm"]));

                    if(array_key_exists("districts", $searchidx)) $queryB = $queryB->where('districts.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["districts"]).'%' );
                    if(array_key_exists("regions", $searchidx)) $queryB = $queryB->where('regions.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["regions"]).'%' );
                    
                    // dd($searchidx["sectionm"], $queryB->get());
                    $items = $queryB->get();  //CHANGE
                }else{
                    $items = new Region; 
                    $items = $items->newQuery();  //CHANGE
                }
            }else{
                $items = new Region; 
                $items = $items->newQuery();
            }
            // $parrains = Parrain::all();
            return DataTables::of($items)
                ->addColumn('districts', function ($item) {
                    $this->fghijlist = [];
                    return optional($item)->district?->libel ?? '-';
                })
                ->addColumn('regions', function ($item) {
                    
                    return optional($item)->libel ?? '-';
                })
                ->addColumn('rgph', function ($item) {
                    $counter = Commune::whereIn('departement_id', function ($query) use($item) {
                        $query->select('departements.id')
                            ->from('departements')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('regions.id', $item->id);
                    })
                    ->selectRaw('SUM(rgph_population) AS rgph_population_sum')
                    ->value('rgph_population_sum');

                    $this->rgphval = $counter;
                    return $counter ?? '-';
                })
                ->addColumn('rgphattente', function ($item) {
                    $this->rgphattente = round($this->rgphval*0.45);
                    return $this->rgphattente;
                })
                ->addColumn('inscritcei', function ($item) {
                    return $item?->nbrinscrit;
                })
                ->addColumn('objectif', function ($item) {
                    $this->objectif = $this->rgphattente - ($item?->nbrinscrit);
                    return $this->objectif;
                })
                ->addColumn('electorat', function ($item) {
                    $count  = ElectorParrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('regions.id', $item->id);
                    })
                    ->where("elect_date", "=", "2023")
                    ->selectRaw('COUNT(elector_parrains.id) AS elector_parrains_count')
                    ->value('elector_parrains_count');

                    $this->fghijlist[0] = $count;
                    return $count??"0";
                })
                ->addColumn('recensescni', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('regions.id', $item->id);
                    })
                    ->where("cni_dispo", "=", "Oui")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[1] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesncni', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('regions.id', $item->id);
                    })
                    ->where("cni_dispo", "=", "Non")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[2] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesextr', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('regions.id', $item->id);
                    })
                    ->where("extrait", "=", "Oui")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[3] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesnextr', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            // ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('regions.id', $item->id);
                    })
                    ->where("extrait", "=", "Non")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[4] = $count;
                    return $count??"0";
                })
                ->addColumn('recenses', function ($item) {
                    $this->allcount = 0;
                    foreach($this->fghijlist as $itemval){
                        $this->allcount += $itemval;
                    }
                    return $this->allcount??"0";
                })
                ->addColumn('restrecenses', function ($item) {
                    $restrecenses = $this->objectif - $this->allcount;
                    return $restrecenses??"0";
                })
                ->rawColumns([
                    'districts',
                    'regions',
                    'rgph',
                    'rgphattente', 
                    'inscritcei', 
                    'objectif',
                    'recenses',
                    'electorat',
                    'recensescni',
                    'recensesncni',
                    'recensesextr',
                    'recensesnextr',
                    'restrecenses',
                    ])
                ->toJson();

            

            // dd($dataJson->getContent());

            
                // ->make(true);

        }

    }

    public function getDistrictList(Request $request, $single){
        if ($request->ajax()) {
            // dd($lieus);
            $searchidx = get_item_of_datatables($request->all());
                
            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("districts", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("districts", $searchidx)?($searchidx["districts"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $items = District::where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $items = District::where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                // }else if(array_key_exists("parrainm", $searchidx) 
                //     || array_key_exists("regionm", $searchidx)
                //     || array_key_exists("departm", $searchidx)
                //     || array_key_exists("communem", $searchidx)
                //     || array_key_exists("sectionm", $searchidx)
                // ){
                //     /// QUERY MODIFIER BASED ON RELATIONSHIP
                //     $queryB = LieuVote::userlimit()->with('quartier.section.section.commune', 'parrains')
                //         ->leftJoin('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                //         ->leftJoin('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                //         ->leftJoin('sections', 'rcommunes.section_id', '=', 'sections.id')
                //         ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                //         // ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                //         ->leftJoin('parrains', 'lieu_votes.libel', '=', 'parrains.code_lv')
                //         ->select('lieu_votes.*', DB::raw('COUNT(parrains.id) as total_parrains'))
                //         ->where('lieu_votes.imported', '=', 0)
                //         ->groupBy('lieu_votes.id');

                //     if( array_key_exists("parrainm", $searchidx) ) $queryB = $queryB->having('total_parrains', '=', str_replace(['(', ')'], "",  $searchidx["parrainm"]));

                //     if(array_key_exists("regionm", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["regionm"]).'%' );
                //     if(array_key_exists("departm", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["departm"]).'%' );
                //     if(array_key_exists("communem", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["communem"]).'%' );
                //     if(array_key_exists("sectionm", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["sectionm"]).'%' );

                //     if(array_key_exists("libel", $searchidx)) $queryB = $queryB->where('lieu_votes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["libel"]).'%' );
                //     // dd($searchidx["sectionm"], $queryB->get());
                //     $lieus = $queryB->get();  //CHANGE
                }else{
                    $items = new District; 
                    $items = $items->newQuery();  //CHANGE
                }
            }else{
                $items = new District; 
                $items = $items->newQuery();
            }
            // $parrains = Parrain::all();
            return DataTables::of($items)
                ->addColumn('districts', function ($item) {
                    $this->fghijlist = [];
                    return optional($item)->libel ?? '-';
                })
                ->addColumn('rgph', function ($item) {
                    $counter = Commune::whereIn('departement_id', function ($query) use($item) {
                        $query->select('departements.id')
                            ->from('departements')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('districts.id', $item->id);
                    })
                    ->selectRaw('SUM(rgph_population) AS rgph_population_sum')
                    ->value('rgph_population_sum');

                    $this->rgphval = $counter;
                    return $counter ?? '-';
                })
                ->addColumn('rgphattente', function ($item) {
                    $this->rgphattente = round($this->rgphval*0.45);
                    return $this->rgphattente;
                })
                ->addColumn('inscritcei', function ($item) {
                    return $item?->nbrinscrit;
                })
                ->addColumn('objectif', function ($item) {
                    $this->objectif = $this->rgphattente - ($item?->nbrinscrit);
                    return $this->objectif;
                })
                ->addColumn('electorat', function ($item) {
                    $count  = ElectorParrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('districts.id', $item->id);
                    })
                    ->where("elect_date", "=", "2023")
                    ->selectRaw('COUNT(elector_parrains.id) AS elector_parrains_count')
                    ->value('elector_parrains_count');

                    $this->fghijlist[0] = $count;
                    return $count??"0";
                })
                ->addColumn('recensescni', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('districts.id', $item->id);
                    })
                    ->where("cni_dispo", "=", "Oui")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[1] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesncni', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('districts.id', $item->id);
                    })
                    ->where("cni_dispo", "=", "Non")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[2] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesextr', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('districts.id', $item->id);
                    })
                    ->where("extrait", "=", "Oui")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[3] = $count;
                    return $count??"0";
                })
                ->addColumn('recensesnextr', function ($item) {
                    $count  = Parrain::whereIn('commune_id', function ($query) use($item) {
                        $query->select('communes.id')
                            ->from('communes')
                            ->join('departements', 'communes.departement_id', '=', 'departements.id')
                            ->join('regions', 'departements.region_id', '=', 'regions.id')
                            ->join('districts', 'regions.district_id', '=', 'districts.id')
                            ->where('districts.id', $item->id);
                    })
                    ->where("extrait", "=", "Non")
                    ->selectRaw('COUNT(parrains.id) AS parrains_count')
                    ->value('parrains_count');

                    $this->fghijlist[4] = $count;
                    return $count??"0";
                })
                ->addColumn('recenses', function ($item) {
                    $this->allcount = 0;
                    foreach($this->fghijlist as $itemval){
                        $this->allcount += $itemval;
                    }
                    return $this->allcount??"0";
                })
                ->addColumn('restrecenses', function ($item) {
                    $restrecenses = $this->objectif - $this->allcount;
                    return $restrecenses??"0";
                })
                ->rawColumns([
                    'districts',
                    'rgph',
                    'rgphattente', 
                    'inscritcei', 
                    'objectif',
                    'recenses',
                    'electorat',
                    'recensescni',
                    'recensesncni',
                    'recensesextr',
                    'recensesnextr',
                    'restrecenses',
                    ])
                ->toJson();

            

            // dd($dataJson->getContent());

            
                // ->make(true);

        }
    }

    public function getLVList(Request $request, $single){
        if ($request->ajax()) {
            // dd($lieus);
            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("libel", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("libel", $searchidx)?($searchidx["libel"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $lieus = LieuVote::userlimit()->where('imported', '=', 0)->where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $lieus = LieuVote::userlimit()->where('imported', '=', 0)->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("parrainm", $searchidx) 
                    || array_key_exists("regionm", $searchidx)
                    || array_key_exists("departm", $searchidx)
                    || array_key_exists("communem", $searchidx)
                    || array_key_exists("sectionm", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = LieuVote::userlimit()->with('quartier.section.section.commune', 'parrains')
                        ->leftJoin('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                        ->leftJoin('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->leftJoin('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                        // ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                        ->leftJoin('parrains', 'lieu_votes.libel', '=', 'parrains.code_lv')
                        ->select('lieu_votes.*', DB::raw('COUNT(parrains.id) as total_parrains'))
                        ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('lieu_votes.id');

                    if( array_key_exists("parrainm", $searchidx) ) $queryB = $queryB->having('total_parrains', '=', str_replace(['(', ')'], "",  $searchidx["parrainm"]));

                    if(array_key_exists("regionm", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["regionm"]).'%' );
                    if(array_key_exists("departm", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["departm"]).'%' );
                    if(array_key_exists("communem", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["communem"]).'%' );
                    if(array_key_exists("sectionm", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["sectionm"]).'%' );

                    if(array_key_exists("libel", $searchidx)) $queryB = $queryB->where('lieu_votes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["libel"]).'%' );
                    // dd($searchidx["sectionm"], $queryB->get());
                    $lieus = $queryB->get();  //CHANGE
                }else{
                    $lieus = LieuVote::userlimit()->where('imported', '=', 0);  //CHANGE
                }
            }else{
                $lieus = LieuVote::userlimit()->where('imported', '=', 0); //CHANGE
            }
                
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
                        $query->select('lieu_votes.code')
                            ->from('lieu_votes')
                            ->where('lieu_votes.id', $lieuId)
                            ->where('lieu_votes.imported', false);
                    })->count();  
                    return $parrainCount;
                })
                ->addColumn('electorm', function ($lieu) {
                    // $parrainCount = Parrain::where('code_lv', 'like', '%'.$lieu->libel.'%')->count();
                    $lieuId = $lieu->id;
                    $electorCount = ElectorParrain::whereIn('nom_lv', function ($query) use ($lieuId) {
                        $query->select('lieu_votes.libel')
                            ->from('lieu_votes')
                            ->where('lieu_votes.id', $lieuId)
                            ->where('lieu_votes.imported', false);
                    })->where('elect_date', "=", "2023")->count();  
                    return $electorCount;
                })
                ->rawColumns(['regionm','departm','communem', 'sectionm', 'parrainm'])
                ->toJson();

            // dd($dataJson->getContent());

            
                // ->make(true);

        }
    }
    
    public function getQuartierList(Request $request, $single){
        if ($request->ajax()) {

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) == 1 && (array_key_exists("sectionm", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("sectionm", $searchidx)?($searchidx["sectionm"]):$searchidx["name"];
                    if(array_key_exists("name", $searchidx))
                    $quartiers = Quartier::userlimit()->where('libel', '=', ''.str_replace(['(', ')'], "",  $searVal).'' )->get();
                    else $quartiers = Quartier::userlimit()->where('libel', 'like', '%'.str_replace(['(', ')'], "",  $searVal).'%' ); //CHANGE
                }else if(array_key_exists("parrainm", $searchidx) 
                    || array_key_exists("regionm", $searchidx)
                    || array_key_exists("departm", $searchidx)
                    || array_key_exists("communem", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = Quartier::userlimit()->with('section.section.commune')
                        ->leftJoin('rcommunes', 'quartiers.r_commune_id', '=', 'rcommunes.id')
                        ->leftJoin('sections', 'rcommunes.section_id', '=', 'sections.id')
                        ->leftJoin('communes', 'sections.commune_id', '=', 'communes.id')
                        ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                        ->leftJoin('elector_parrains', function ($join) {
                            $join->on('lieu_votes.libel', '=', 'elector_parrains.nom_lv')
                                ->where('elector_parrains.elect_date', '=', '2023');
                        })
                        ->leftJoin('parrains', 'lieu_votes.libel', '=', 'parrains.code_lv')
                        ->select('quartiers.*', DB::raw('COUNT(parrains.id) as total_parrains'))
                        ->where('lieu_votes.imported', '=', 0)
                        ->groupBy('quartiers.id');

                    if( array_key_exists("parrainm", $searchidx) ) $queryB = $queryB->having('total_parrains', '=', str_replace(['(', ')'], "",  $searchidx["parrainm"]));

                    if(array_key_exists("regionm", $searchidx)) $queryB = $queryB->where('communes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["regionm"]).'%' );
                    if(array_key_exists("departm", $searchidx)) $queryB = $queryB->where('sections.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["departm"]).'%' );
                    if(array_key_exists("communem", $searchidx)) $queryB = $queryB->where('rcommunes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["communem"]).'%' );

                    if(array_key_exists("sectionm", $searchidx)) $queryB = $queryB->where('quartiers.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["sectionm"]).'%' );
                    $quartiers = $queryB->get();  //CHANGE
                }else{
                    $quartiers = Quartier::userlimit();  //CHANGE
                }
            }else{
                $quartiers = Quartier::userlimit(); //CHANGE
            }
            
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
                        $query->select('lieu_votes.code')
                        ->from('lieu_votes')
                        ->leftJoin('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
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
                ->addColumn('electorm', function ($quartier)  {
                    $electorCount = 0;
                    $quartierId = $quartier->id;
                    $electorCount = ElectorParrain::where('elect_date', "=", "2023")
                        ->whereIn('nom_lv', function ($query) use ($quartierId) {
                            $query->select('lieu_votes.libel')
                                ->from('lieu_votes')
                                ->leftJoin('quartiers', 'lieu_votes.quartier_id', '=', 'quartiers.id')
                                ->where('quartiers.id', $quartierId)
                                ->where('lieu_votes.imported', false);
                        })
                        ->count();
                   

                    // foreach ($quartier->lieuVotes->where("imported", "=", false) as $lieuVote){
                    //     $parrainCount += Parrain::where('code_lv', 'like', '%'.$lieuVote->libel.'%')->count();;
                    // }
                    // foreach ($quartier->section->agentTerrains as $terrain) {
                    //     $parrainCount += $terrain->parrains->count();
                    // }
                    return $electorCount.'';
                })
                ->rawColumns(['regionm', 'departm', 'communem', 'sectionm', 'parrainm', 'electorm'])
                ->toJson();
        }
    }
    
    public function getParrainList(Request $request, $single){
        if ($request->ajax()) {

            $searchidx = get_item_of_datatables($request->all());

            if(sizeof($searchidx) > 0){
                // dd($searchidx);
                if( sizeof($searchidx) <= 2 && (array_key_exists("nom", $searchidx) || array_key_exists("prenom", $searchidx) || array_key_exists("name", $searchidx)) ){ 
                    $searVal = array_key_exists("nom", $searchidx)?($searchidx["nom"]):"";
                    $searVal .= array_key_exists("prenom", $searchidx)?(" ".$searchidx["prenom"]):"";
                    $searVal .= array_key_exists("name", $searchidx)?($searchidx["name"]):"";
                    // dd($searVal);
                    $parrains = Parrain::userlimit()
                    ->where("imported", "=", false)
                    ->select('parrains.*', DB::raw('CONCAT(COALESCE(parrains.nom, ""), " ", COALESCE(parrains.prenom, "")) as nom_prenom'))
                    ->havingRaw('nom_prenom LIKE ?', ['%'.str_replace(['(', ')'], "",  $searVal).'%'] ); //CHANGE
                }else if(array_key_exists("agent", $searchidx) 
                    || array_key_exists("codelv", $searchidx)
                ){
                    /// QUERY MODIFIER BASED ON RELATIONSHIP
                    $queryB = Parrain::userlimit()
                    ->where("parrains.imported", "=", false)->with('agentterrain.section')
                        ->join('agent_terrains', 'parrains.telephone_par', '=', 'agent_terrains.telephone')
                        ->join('quartiers', 'agent_terrains.section_id', '=', 'quartiers.id')
                        ->leftJoin('lieu_votes', 'parrains.code_lv', '=', 'lieu_votes.code')
                        ->select('parrains.*', DB::raw('CONCAT(COALESCE(agent_terrains.nom, ""), " ", COALESCE(agent_terrains.prenom, "")) as nom_prenom'))
                        ->groupBy('parrains.id');

                    if(array_key_exists("codelv", $searchidx)) $queryB = $queryB->where('lieu_votes.libel', 'like', '%'.str_replace(['(', ')'], "",  $searchidx["codelv"]).'%' );
                    // if( array_key_exists("parrainm", $searchidx) ) $queryB = $queryB->having('total_parrains', '=', str_replace(['(', ')'], "",  $searchidx["parrainm"]));

                    if(array_key_exists("agent", $searchidx)) $queryB = $queryB->havingRaw('nom_prenom LIKE ?', ['%'.str_replace(['(', ')'], "",  $searchidx["agent"]).'%'] );
                    // dd($queryB->first());
                    $parrains = $queryB->get();  //CHANGE
                }else{
                    $parrains = Parrain::userlimit()
                    ->where("imported", "=", false);  //CHANGE
                }
            }else{
                $parrains = Parrain::userlimit()
                ->where("imported", "=", false); //CHANGE
            }
    
            return DataTables::of($parrains)
                ->addColumn('district', function ($parrain) {
                    // dd($parrain->agentterrain);
                    return (optional($parrain->commune)->departement?->region?->district?->libel ?? "N/A");
                })
                ->addColumn('region', function ($parrain) {
                    return (optional($parrain->commune)->departement?->region?->libel ?? "N/A");
                })
                ->addColumn('departement', function ($parrain) {
                    return (optional($parrain->commune)->departement?->libel ?? "N/A");
                })
                ->addColumn('commune', function ($parrain) {
                    return (optional($parrain->commune)->libel ?? "N/A");
                })
                ->addColumn('agent', function ($parrain) {
                    return (optional($parrain->agentterrain)->nom ?? $parrain->nom_pren_par)." ".(optional($parrain->agentterrain)->prenom ?? '');
                })
                ->addColumn('profil', function ($parrain) {
                    return (optional($parrain->agentterrain)->profil ?? "-");
                })
                ->addColumn('telephoneag', function ($parrain) {
                    return (optional($parrain->agentterrain)->telephone ?? $parrain->telephone_par);
                })
                ->addColumn('section', function ($parrain) {
                    return (optional($parrain->agentterrain)->section->libel ?? '-');
                })
                ->addColumn('codelv', function ($parrain) {
                    return (optional($parrain->lieuVote)->libel ?? "AUTRE CIRCONSCRIPTION");
                })
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
                ->rawColumns(['agent',
                'codelv', 
                'commune', 
                'profil', 
                'telephoneag', 'section', 'createdat', 'pphoto'])
                ->toJson();
        }
    }
    
    public function listDistrict(Request $request){
        $curr_user = Auth::user();
        $agent_Section = null;
        $isOperateur = false;
        $sectionModel = new District();
        $query = $sectionModel->newQuery();

        if($request->search){
            $sear = $request->search;
            if($request->items == 0){
                $query //->with("commune")
                ->where("libel", "like", "%".$request->search."%");
                // ->orWhereHas("commune", function($q) use($sear){
                //     $q->where("libel", "like", "%".$sear."%");
                // });
            }
            // if($request->items == 1){
            //     $query->where("libel", "like", "%".$request->search."%");
            // }
            
            // if($request->items == 2){
            //     $query->orWhereHas("quartiers", function($q) use($sear){
            //         $q->where("libel", "like", "%".$sear."%");
            //     })
            //     ->with(['quartiers' => function ($query) use ($sear) {
            //         $query->where('libel', "like", "%".$sear."%");
            //     }]);
            // }
            
            // if($request->items == 3){
            //     $query->orWhereHas("quartiers.lieuvotes", function($q) use($sear){
            //         $q->where("libel", "like", "%".$sear."%");;
            //     })
            //     ->with(['quartiers.lieuvotes' => function ($query) use ($sear) {
            //         $query->where('libel', "like", "%".$sear."%");
            //     }]);
            // }
            
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
        

        return view("app.recens.index-district", compact("sections", "isOperateur"));
    }
   
    public function listRegion(Request $request){
        $curr_user = Auth::user();
        $agent_Section = null;
        $isOperateur = false;
        $sectionModel = new Region();
        $query = $sectionModel->newQuery();

        if($request->search){
            $sear = $request->search;
            if($request->items == 0){
                $query //->with("commune")
                ->where("libel", "like", "%".$request->search."%");
                // ->orWhereHas("commune", function($q) use($sear){
                //     $q->where("libel", "like", "%".$sear."%");
                // });
            }
            // if($request->items == 1){
            //     $query->where("libel", "like", "%".$request->search."%");
            // }
            
            // if($request->items == 2){
            //     $query->orWhereHas("quartiers", function($q) use($sear){
            //         $q->where("libel", "like", "%".$sear."%");
            //     })
            //     ->with(['quartiers' => function ($query) use ($sear) {
            //         $query->where('libel', "like", "%".$sear."%");
            //     }]);
            // }
            
            // if($request->items == 3){
            //     $query->orWhereHas("quartiers.lieuvotes", function($q) use($sear){
            //         $q->where("libel", "like", "%".$sear."%");;
            //     })
            //     ->with(['quartiers.lieuvotes' => function ($query) use ($sear) {
            //         $query->where('libel', "like", "%".$sear."%");
            //     }]);
            // }
            
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
        

        return view("app.recens.index-region", compact("sections", "isOperateur"));
    }
    
    public function listDepartement(Request $request){
        $curr_user = Auth::user();
        $agent_Section = null;
        $isOperateur = false;
        $sectionModel = new Departement();
        $query = $sectionModel->newQuery();

        if($request->search){
            $sear = $request->search;
            if($request->items == 0){
                $query //->with("commune")
                ->where("libel", "like", "%".$request->search."%");
                // ->orWhereHas("commune", function($q) use($sear){
                //     $q->where("libel", "like", "%".$sear."%");
                // });
            }
            // if($request->items == 1){
            //     $query->where("libel", "like", "%".$request->search."%");
            // }
            
            // if($request->items == 2){
            //     $query->orWhereHas("quartiers", function($q) use($sear){
            //         $q->where("libel", "like", "%".$sear."%");
            //     })
            //     ->with(['quartiers' => function ($query) use ($sear) {
            //         $query->where('libel', "like", "%".$sear."%");
            //     }]);
            // }
            
            // if($request->items == 3){
            //     $query->orWhereHas("quartiers.lieuvotes", function($q) use($sear){
            //         $q->where("libel", "like", "%".$sear."%");;
            //     })
            //     ->with(['quartiers.lieuvotes' => function ($query) use ($sear) {
            //         $query->where('libel', "like", "%".$sear."%");
            //     }]);
            // }
            
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
        

        return view("app.recens.index-departement", compact("sections", "isOperateur"));
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
        $sectionModel = new Section();
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

        // dd($sections);

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
        $sectionModel = new RCommune;
        $query = $sectionModel->newQuery();

        if($request->search){
            $sear = $request->search;
            $query->with("section.commune")
            ->where("libel", "like", "%".$request->search."%")
            ->orWhereHas('section', function($q) use ($sear) {
                $q->where('libel', 'like', '%' . $sear . '%')
                  ->orWhereHas('commune', function($q) use ($sear) {
                      $q->where('libel', 'like', '%' . $sear . '%');
                  });
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
