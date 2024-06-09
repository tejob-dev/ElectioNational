<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="display: block;width: fit-content;">
                @php $nbrinscritTo = make_separate_thousand(App\Models\LieuVote::userlimit()->selectRaw('SUM(nbrinscrit) AS nbrinscrit_count')->value('nbrinscrit_count')); @endphp                
                {{ 'ELECTION PRESIDENTIELLE'}} | {{ "Inscrits : ".$nbrinscritTo}}
            </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!auth()->user()->hasPermissionTo("accueil viewer"))
              <script>window.location = "/recens/sections";</script>
            @endif
            <div class="rounded-lg shadow-xs p-6" style="background:linear-gradient(to top, rgb(255 255 255), rgb(152 87 87 / 0%)), linear-gradient(to top, rgb(255 255 255 / 73%), rgb(255 255 255 / 0%)), linear-gradient(to top, rgb(255 255 255 / 14%), rgb(255 255 255 / 0%));">
                <div class="grid grid-cols-4 gap-4 mb-4" style="grid-template-columns: repeat(4, minmax(0, 1fr));">
                    <div class="shadow-md bg-gray-100 rounded-lg p-4 text-center">
                        <h3 class="text-lg font-bold mb-2">Régions</h3>
                        <hr class="w-full bg-gray-300"/>
                        <h3 class="text-lg font-semibold mb-2" id="commune">@php $valueCom = DB::table('communes')->select(DB::raw('SUM(objectif) as total_objectif, SUM(nbrinscrit) as total_nbrinscrit, COUNT(*) as count'))->first(); $count = $valueCom->count; $countComnbinscrit = $valueCom->total_nbrinscrit;  $countComnbobjectif = $valueCom->total_objectif; echo $count>9?$count:"0".$count; @endphp</h3>
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4 text-center">
                        <h3 class="text-lg font-bold mb-2">Départements</h3>
                        <hr class="w-full bg-gray-300"/>
                        <h3 class="text-lg font-semibold mb-2" id="section">@php $count = DB::table('sections')->select(DB::raw('COUNT(*) as count'))->first()->count; echo $count>9?$count:"0".$count; @endphp</h3>
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4 text-center">
                        <h3 class="text-lg font-bold mb-2">Communes</h3>
                        <hr class="w-full bg-gray-300"/>
                        <h3 class="text-lg font-semibold mb-2" id="rcommune">@php $count = DB::table('rcommunes')->select(DB::raw('COUNT(*) as count'))->first()->count; echo $count>9?$count:"0".$count; @endphp</h3>
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4 text-center">
                        <h3 class="text-lg font-bold mb-2">Sections</h3>
                        <hr class="w-full bg-gray-300"/>
                        <h3 class="text-lg font-semibold mb-2" id="quartier">@php $count = DB::table('quartiers')->select(DB::raw('COUNT(*) as count'))->first()->count; echo $count>9?$count:"0".$count; @endphp</h3>
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4 text-center">
                        <h3 class="text-lg font-bold mb-2">Lieux de vote</h3>
                        <hr class="w-full bg-gray-300"/>
                        <h3 class="text-lg font-semibold mb-2" id="lieuv">@php $count = DB::table('lieu_votes')->select(DB::raw('COUNT(*) as count'))->first()->count; echo $count>9?make_separate_thousand($count):"0".make_separate_thousand($count); @endphp</h3>
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4 text-center">
                        <h3 class="text-lg font-bold mb-2">Bureaux de vote</h3>
                        <hr class="w-full bg-gray-300"/>
                        <h3 class="text-lg font-semibold mb-2" id="bureauv">@php $countBv = DB::table('bureau_votes')->select(DB::raw('COUNT(*) as count'))->first()->count; echo $countBv>9?make_separate_thousand($countBv):"0".make_separate_thousand($countBv); @endphp</h3>
                        
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4 text-center">
                        <h3 class="text-lg font-bold mb-2">Inscrits</h3>
                        <hr class="w-full bg-gray-300"/>
                        <h3 class="text-lg font-semibold mb-2" id="bureauv">@php echo $nbrinscritTo; @endphp</h3>
                        
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4 text-center">
                        <h3 class="text-lg font-bold mb-2">Candidats</h3>
                        <hr class="w-full bg-gray-300"/>
                        <h3 class="text-lg font-semibold mb-2" id="candidat">@php $count = DB::table('candidats')->select(DB::raw('COUNT(*) as count'))->first()->count; echo $count>9?$count:"0".$count; @endphp</h3>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="shadow-md bg-gray-100 rounded-lg p-4">
                        <h4 class="text-lg font-semibold mb-2">Recensements</h4>
                        <hr class="w-full bg-gray-300"/>
                        <div class="w-full h-10">
                        </div>
                        @php
                        //$parrainCount = 0;
                        //$communes = App\Models\Commune::userlimit()->get();
                        //foreach ($communes as $commune) {
                        //    foreach (optional($commune)->sections()->userlimit()->get() as $section) {
                        //        foreach ($section->agentterrains as $agentterrain) {
                        //            foreach ($agentterrain->parrains as $parrain) {
                        //                $parrainCount += 1;
                        //            }
                        //        } 
                        //    }
                        //}           
                        $parrainCount = DB::table('parrains')
                        ->selectRaw('COUNT(*) as total_parrain_count')
                        ->first()->total_parrain_count ?? 0;
                        @endphp
                        <div class="grid grid-cols-2 gap-2">
                            <div class="border-r border-r-black-400">
                                <span class="text-gray-900 font-semibold">Récensés:</span>
                                <span class="text-gray-700" id="parraine">{{ make_separate_thousand($parrainCount) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-900 font-semibold">Objectif:</span>
                                <span class="text-gray-700">{{ ($countComnbobjectif) ?? "NaN" }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4">
                        <h4 class="text-lg font-semibold mb-2">Suivi Du Scrutin</h4>
                        <hr class="w-full bg-gray-300"/>
                        <div class="w-full h-10">
                        </div>
                        @php
                            $bureauVotesCounts = DB::table('agent_terrains')
                                ->join('quartiers', 'agent_terrains.section_id', '=', 'quartiers.id')
                                ->join('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                                ->join('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                                ->selectRaw('SUM(bureau_votes.votant_suivi) as total_votant_suivi, SUM(bureau_votes.votant_resul) as total_votant_resul')
                                ->whereNotNull('agent_terrains.section_id')
                                ->first();

                            $counter = $bureauVotesCounts->total_votant_suivi ?? 0;
                            $counter2 = $bureauVotesCounts->total_votant_resul ?? 0;

                            // Count the total a_vote from CorParrain
                            $total_count_avote = DB::table('cor_parrains')
                                ->selectRaw('SUM(a_vote) as total_a_vote')
                                ->selectRaw('COUNT(*) as total_count')
                                ->first() ?? (object)[];

                            $elector_par_total_count_avote = DB::table('elector_parrains')
                                ->selectRaw('COUNT(*) as total_count')
                                ->where('elect_date', '=', '2023')
                                ->first() ?? (object)[];

                            $avote = $total_count_avote->total_a_vote;

                        @endphp
                        <div class="grid grid-cols-2 gap-2">
                            <div class="border-r border-r-black-400">
                                <span class="text-gray-900 font-semibold">Votants:</span>
                                <span class="text-gray-700">{{$counter.'' ?? '0'}}</span>
                            </div>
                            <div>
                                <span class="text-gray-900 font-semibold">Participation:</span>
                                <span class="text-gray-700">{{round(($counter/($countComnbinscrit??1))*100, 2).'%' ?? '0'}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4">
                        <h4 class="text-lg font-semibold mb-2">Suivi de l'electorat</h4>
                        <hr class="w-full bg-gray-300"/>
                        <div class="w-full h-10">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="border-r border-r-black-400">
                                <span class="text-gray-900 font-semibold">Electorat:</span>
                                <span class="text-gray-700">{{make_separate_thousand($elector_par_total_count_avote->total_count) ?? '0'}}</span>
                            </div>
                            <div>
                                <span class="text-gray-900 font-semibold">A vote:</span>
                                <span class="text-gray-700">{{ $avote??'0'}}</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="shadow-md bg-gray-100 rounded-lg p-4">
                        <h4 class="text-lg font-semibold mb-2">Résultats</h4>
                        <hr class="w-full bg-gray-300"/>
                        <div class="w-full h-10">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="border-r border-r-black-400">
                                <span class="text-gray-900 font-semibold">Votants:</span>
                                <span class="text-gray-700">{{$counter2.'' ?? '0'}}</span>
                            </div>
                            <div>
                                <span class="text-gray-900 font-semibold">Taux:</span>
                                <span class="text-gray-700">{{round(($counter2/($countComnbinscrit??1))*100, 2).'%' ?? '0'}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4 text-center">
                        <h4 class="text-xxl font-semibold mb-2" style="font-size:1em; color:red">PV REÇUS/{{make_separate_thousand($countBv)}}</h4>
                        @php
                            $bvcount = DB::table('bureau_votes')
                            ->join('proces_verbals', 'bureau_votes.id', '=', 'proces_verbals.bureau_vote_id')
                            ->selectRaw('COUNT(proces_verbals.id) as total_proces_verbals')
                            ->first()->total_proces_verbals ?? 0;
                        @endphp
                        <div class="w-full h-10">
                            <hr class="w-full bg-gray-300"/>
                        </div>
                        <h4 class="text-xl font-bold mb-2" style="font-size:2em;color:red">{{ strlen($bvcount)==1?"00".$bvcount:(strlen($bvcount)==2?"0".$bvcount:$bvcount)}}</h4>
                    </div>
                    <div class="shadow-md bg-gray-100 rounded-lg p-4 text-center">
                        <h4 class="text-xxl font-semibold mb-2" style="font-size:1em;color:red">TAUX DE RECEPTION DES PV</h4>
                        @php
                            $countBv = ($countBv == 0)?1:$countBv;
                            $tauxpv = (($bvcount/$countBv)*100);
                        @endphp
                        <div class="w-full h-10">
                            <hr class="w-full bg-gray-300"/>
                        </div>
                        <h4 class="text-xl font-bold mb-2" style="font-size:2em;color:red">{{round($tauxpv, 2)."%"}}</h4>
                    </div>
                </div>
            </div>

            <div class="rounded-lg my-4">
                <div class="grid grid-cols-4 gap-3" style="grid-template-columns: repeat(5, minmax(0, 1fr));">
                    @php
                    $candidats = App\Models\Candidat::all();

                    $suffrage = DB::table('bureau_votes')
                        ->selectRaw('SUM(votant_resul - (bult_blan + bult_nul)) as total_suffrage')
                        ->first()->total_suffrage ?? 0;

                    $bvs = DB::table('bureau_votes')
                        ->get(['candidat_note']); // Get only the necessary column
                    @endphp
                    @foreach ($candidats as $candidat)
                        @php

                            $candidnote = 0;

                            if ($candidat->code) {
                                $namek = $candidat->code;

                                // Using DB facade to query and process the candidat_note field

                                foreach ($bvs as $bvl) {
                                    $notes = $bvl->candidat_note;
                                    if ($notes) {
                                        $lists = json_decode($notes);
                                        if (is_object($lists) && property_exists($lists, $namek)) {
                                            $candidnote += intval($lists->$namek);
                                        }
                                    }
                                }
                            }
                        @endphp
                        <div class="rounded-lg shadow-md bg-white" style="margin:10px 2px 0px 2px; display: flex;flex-direction: column;align-items: center;">
                            <img src="{{  $candidat->photo ? \Storage::url($candidat->photo) : '' }}" alt="Candidat {{$candidat->nom}}" class="my-4 p-2 rounded-full" style="background-color:{{$candidat->couleur}};width:100px;">
                            <h1 class="font-bold text-2xl my-1 text-center" style="font-size:1.0em;">{{$candidat->nom." ".$candidat->prenom}}</h1>
                            <h2 class=" text-xl my-2" style="font-size:0.8em;">{{$candidat->parti}}</h2>
                            <div class="w-full h-10">
                                <hr class="w-full bg-gray-300"/>
                            </div>
                            <h4 class="text-xl font-bold mb-2" style="font-size:1.5em; color:{{$candidat->couleur}};">{{round( ($suffrage!=0?($candidnote/$suffrage):0*100) , 2)."%"}}</h4>
                            <h4 class="text-xxl font-semibold mb-2" style="font-size:1.5em; color:{{$candidat->couleur}};">{{ strlen($candidnote)==1?"00".$candidnote:(strlen($candidnote)==2?"0".$candidnote:$candidnote)}}</h4>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
        <script>
            var speed = 10;
            /* Call this function with a string containing the ID name to
             * the element containing the number you want to do a count animation on.*/
            function incEltNbr(id, sped) {
              elt = document.getElementById(id);
              endNbr = Number(document.getElementById(id).innerHTML);
              incNbrRec(0, endNbr, elt, sped);
            }
            
            /*A recursive function to increase the number.*/
            function incNbrRec(i, endNbr, elt, sped) {
              if (i <= endNbr) {
                if(i<10) elt.innerHTML = "0"+i; else elt.innerHTML = i;
                setTimeout(function() {//Delay a bit before calling the function again.
                  incNbrRec(i + 1, endNbr, elt);
                }, sped*5);
              }
            }
            
            incEltNbr("section", 100);
            incEltNbr("commune", 150);
            incEltNbr("rcommune", 200);
            incEltNbr("quartier", 250);
            // incEltNbr("lieuv", 2000);
            // incEltNbr("bureauv", 2000);
            incEltNbr("candidat", 500);
            
            // incEltNbr("parraine", 600);
        </script>
    </div>
</x-app-layout>