<x-app-layout>
    <x-slot name="stylec">
        <link rel="stylesheet" href="/cssc/bootstrap.min.css">
        <link rel="stylesheet" href="/cssc/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/cssc/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/cssc/buttons.bootstrap4.min.css">
        
        <style>
            a{
                text-decoration: none!important;
            }
            
            #table1_info, #table1_length, #table1_paginate, #table1_filter{
                    display: inline-block;
                    width: 50%;
            }
        </style>
    </x-slot>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->hasPermissionTo("can-open-section-only"))
                @php
                    $user = auth()->user();
                    $name = $user->name;
                    $prenom = $user->prenom;
                    $agent_Section = App\Models\AgentDeSection::where([
                      ["nom","like", $name],
                      ["prenom","like", $prenom],
                    ])->with("section")->first();
                @endphp
            Recensement au niveau des communes - Section: {{ optional($agent_Section->section)->libel ?? "-"}}
            @else
                @lang('crud.rcommunes.index_title')
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }} Communes ou Departements ou Régions"
                                        autocomplete="off"
                                    ></x-inputs.text>
                                    
                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right flex justify-end">
                           
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-auto scrolling-touch">
                    <table id="table1" class="table table-borderless table-hover">
                        <thead class="text-gray-700">
                            <tr>
                            </tr>
                                <th class="px-4 py-3 text-left">
                                Régions
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Departements
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Communes
                                </th>
                                <th class="px-4 py-3 text-right">
                                    Parrainés
                                </th>
                                <th class="px-4 py-3 text-right">
                                    Electorat
                                </th>
                                <th class="px-4 py-3 text-right">
                                    Objectif
                                </th>
                        </thead>
                        <tbody class="text-gray-600 text-center">
                            @forelse($sections as $section)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-left">
                                        {{ $section?->section?->commune?->libel ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $section?->section?->libel ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $section?->libel ?? '-' }}
                                    </td>
                                    @php
                                    $queryB = App\Models\RCommune::userlimit()
                                    //->leftJoin('sections', 'communes.id', '=', 'sections.commune_id')
                                    //->leftJoin('rcommunes', 'sections.id', '=', 'rcommunes.section_id')
                                    ->leftJoin('quartiers', 'rcommunes.id', '=', 'quartiers.r_commune_id')
                                    ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                                    ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                                    ->leftJoin('elector_parrains', function ($join) {
                                        $join->on('lieu_votes.libel', '=', 'elector_parrains.nom_lv')
                                            ->where('elector_parrains.elect_date', '=', '2023');
                                    })
                                    ->leftJoin('parrains', 'lieu_votes.code', '=', 'parrains.code_lv')
                                    ->select('rcommunes.*', DB::raw('COUNT(DISTINCT parrains.id) as total_parrains'), DB::raw('COUNT(DISTINCT elector_parrains.id) as total_electorats'))
                                    ->where('rcommunes.id', '=', $section->id)
                                    //->where('elector_parrains.elect_date', '=', "2023")
                                    ->groupBy('rcommunes.id')->first();
                                    //dd($queryB);
                                    $parrainCount = $queryB?->total_parrains??0;
                                    $electorCount = $queryB?->total_electorats??0;         
                                    @endphp
                                    <td class="px-4 py-3 text-right">
                                        {{ $parrainCount ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        {{ $electorCount ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        {{ $section->objectif ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="mt-10 px-4">
                                        {!! $sections->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
    
    <x-slot name="scriptc">
        
    </x-slot>
</x-app-layout>
