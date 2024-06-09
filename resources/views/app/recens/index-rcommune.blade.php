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
                                        {{ $section->section->section->commune->libel ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $section->section->section->libel ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $section->section->libel ?? '-' }}
                                    </td>
                                    @php
                                    $parrainCount = 0;
                                    foreach ($section->agentterrains as $agentterrain) {
                                        $parrainCount += $agentterrain->parrains->count();
                                    }           
                                    @endphp
                                    <td class="px-4 py-3 text-right">
                                        {{ $parrainCount ?? '-' }}
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
                            
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
    
    <x-slot name="scriptc">
        
    </x-slot>
</x-app-layout>
