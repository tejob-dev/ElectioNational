<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(sizeof($sections) == 1 && $isOperateur)
            Recensement des parrains - Section: {{$sections[0]->libel}}
            @else
            @lang('crud.parrains.index_title')
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
                                    <x-inputs.text name="search" value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }} communes ou sections ou parrains"
                                        autocomplete="off"></x-inputs.text>
                                    &nbsp;
                                    &nbsp;
                                    <div class="relative" style="width:200px;">
                                        <select id="my-select" name="items"
                                            class="block appearance-none w-full py-2 px-3 pr-8 leading-tight border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
                                            <option value="0">communes</option>
                                            <option value="1">sections</option>
                                            <option value="5">sous sections</option>
                                            <option value="2">quartiers</option>
                                            <option value="3">lieu de votes</option>
                                            <option selected value="4">parrains</option>
                                        </select>
                                    </div>
                                    &nbsp;
                                    &nbsp;
                                    <div class="ml-1">
                                        <button type="submit" class="button button-primary">
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @if(!auth()->user()->hasRole('Invité de section'))
                            <a
                                href="{{ route('parrains.export') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-paper"></i>
                                Exporter
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @php
                    $breakall = false;
                    if($breakSearch){
                        $breakall = true;
                    }
                @endphp
                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    ID
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Agent
                                </th>
                                <th class="px-4 py-3">
                                    Tel.&nbsp;Agent
                                </th>
                                <th class="px-4 py-3">
                                    Recenseur
                                </th>
                                <th class="px-4 py-3">
Departements
                                </th>
                                <th class="px-4 py-3">
                                    Sous Section
                                </th>
                                <th class="px-4 py-3 ">
                                    Nom
                                </th>
                                <th class="px-4 py-3 ">
                                    Prenom
                                </th>
                                <th class="px-4 py-3 ">
                                    Date de naissance
                                </th>
                                <th class="px-4 py-3 ">
                                    Liste électorale
                                </th>
                                <th class="px-4 py-3 ">
                                    Nº&nbsp;Carte
                                </th>
                                <th class="px-4 py-3 ">
                                    Tel.
                                </th>
                                <th class="px-4 py-3 text-left">
                                    LV
                                </th>
                                <th class="px-4 py-3 ">
                                    Résidence
                                </th>
                                <th class="px-4 py-3">
                                    Profession
                                </th>
                                <th colspan="4" class="px-4 py-3 text-right">
                                    Idée du projet
                                </th>
                                <th class="px-4 py-3 ">
                                    Lieu du projet
                                </th>
                                <th class="px-4 py-3 ">
                                    Parrainé le
                                </th>
                                <th class="px-4 py-3 ">
                                    Statut
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($sections as $section)
                            <!--<tr class="bg-gray-50">-->
                            <!--    <td colspan="21" class="px-4 pt-4 text-left">-->
                            <!--        <h3>{{ $section->libel }}</h3>-->
                            <!--    </td>-->
                            <!--</tr>-->
                            @if($searchType == 0 || $searchType == 1 || $searchType == 4)
                            @foreach($section->agentterrains->reverse()->values() as $agentterrain)
                            @foreach($agentterrain->parrains->reverse()->values() as $parrain)
                            
                            @if( $breakSearch && 
                            (
                                ( 
                                    preg_match("/".$breakSearch."/i", $parrain->nom)  
                                    || preg_match("/".$breakSearch."/i", $parrain->prenom)  
                                    || preg_match("/".$breakSearch."/i", $parrain->telephone)  
                                ) 
                            ))
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->id ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ ($parrain->agentterrain)->nom ?? '-' }} {{ ($parrain->agentterrain)->prenom ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                {{ ($parrain->agentterrain)->telephone ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                {{ ($parrain->recenser) ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                {{ optional($parrain->agentterrain->section)->libel ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                {{ optional($parrain->agentterrain->sousSection)->libel ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->nom ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->prenom ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->date_naiss ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->date_naiss)->format('d/m/Y'): '-' }}
                                    
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $parrain->list_elect ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->cart_elect ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->telephone ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->code_lv ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->residence ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->profession ?? '-' }}
                                </td>
                                <td colspan="4" class="px-4 py-3 text-left">
                                    {{ $parrain->idee_projet ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $parrain->lieu_projet ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->created_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('d/m/Y')." à ".Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('H:i'): '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $parrain->status ?? '-' }}
                                    @if($parrain->status == "Non traité")
                                        <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:yellow; border-radius:25px;"></span>
                                    @elseif($parrain->status == "Ok")
                                        <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:green; border-radius:25px;"></span>
                                    @elseif($parrain->status == "Abs")
                                        <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:orange; border-radius:25px;"></span>
                                    @elseif($parrain->status == "Autre")
                                        <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:brown; border-radius:25px;"></span>
                                    @endif
                                </td>
                            </tr>
                            @else
                                @if(!$breakall)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-left">
                                            {{ $parrain->id ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ ($parrain->agentterrain)->nom ?? '-' }} {{ ($parrain->agentterrain)->prenom ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                        {{ ($parrain->agentterrain)->telephone ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                        {{ ($parrain->recenser) ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                        {{ optional($parrain->agentterrain->section)->libel ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                        {{ optional($parrain->agentterrain->sousSection)->libel ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $parrain->nom ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $parrain->prenom ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $parrain->date_naiss ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->date_naiss)->format('d/m/Y'): '-' }}
                                            
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $parrain->list_elect ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $parrain->cart_elect ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $parrain->telephone ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $parrain->code_lv ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $parrain->residence ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $parrain->profession ?? '-' }}
                                        </td>
                                        <td colspan="4" class="px-4 py-3 text-left">
                                            {{ $parrain->idee_projet ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $parrain->lieu_projet ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $parrain->created_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('d/m/Y')." à ".Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('H:i'): '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $parrain->status ?? '-' }}
                                            @if($parrain->status == "Non traité")
                                                <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:yellow; border-radius:25px;"></span>
                                            @elseif($parrain->status == "Ok")
                                                <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:green; border-radius:25px;"></span>
                                            @elseif($parrain->status == "Abs")
                                                <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:orange; border-radius:25px;"></span>
                                            @elseif($parrain->status == "Autre")
                                                <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:brown; border-radius:25px;"></span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endif
                            
                            @endforeach
                            @endforeach
                            @endif
                            
                            <!--pour la recherche des quartier-->
                            @if($searchType == 2)
                            @foreach($section->quartiers as $quartier)
                            @if( $breakSearch && 
                                (
                                    ( 
                                        preg_match("/".str_replace(" ", "\s", $breakSearch)."/i", $quartier->libel)
                                    ) 
                                )
                            )
                            @php $breakall = true; @endphp
                            @foreach($quartier->section->agentterrains->reverse()->values() as $agentterrain)
                            @foreach($agentterrain->parrains->reverse()->values() as $parrain)
                                @foreach($quartier->lieuvotes as $lieuvote)
                                @if(preg_match("/".str_replace(" ", "\s", $lieuvote->libel)."/i", $parrain->code_lv) )
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->id ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ ($parrain->agentterrain)->nom ?? '-' }} {{ ($parrain->agentterrain)->prenom ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                    {{ ($parrain->agentterrain)->telephone ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                    {{ ($parrain->recenser) ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                    {{ optional($parrain->agentterrain->section)->libel ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                    {{ optional($parrain->agentterrain->sousSection)->libel ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->nom ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->prenom ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->date_naiss ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->date_naiss)->format('d/m/Y'): '-' }}
                                        
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ $parrain->list_elect ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->cart_elect ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->telephone ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->code_lv ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->residence ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->profession ?? '-' }}
                                    </td>
                                    <td colspan="4" class="px-4 py-3 text-left">
                                        {{ $parrain->idee_projet ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ $parrain->lieu_projet ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->created_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('d/m/Y')." à ".Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('H:i'): '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ $parrain->status ?? '-' }}
                                        @if($parrain->status == "Non traité")
                                            <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:yellow; border-radius:25px;"></span>
                                        @elseif($parrain->status == "Ok")
                                            <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:green; border-radius:25px;"></span>
                                        @elseif($parrain->status == "Abs")
                                            <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:orange; border-radius:25px;"></span>
                                        @elseif($parrain->status == "Autre")
                                            <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:brown; border-radius:25px;"></span>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            @endforeach
                            @endforeach
                            @if($breakall) @break @endif
                            @endif
                            @endforeach
                            @endif
                            
                            <!--pour la recherche des lieu de vote-->
                            @if($searchType == 3)
                            @foreach($section->quartiers as $quartier)
                            @foreach($quartier->lieuvotes as $lieuvote)
                            
                            @if( $breakSearch && 
                                
                                     
                                preg_match("/".str_replace(" ", "\s", $breakSearch)."/i", $lieuvote->libel)
                                     
                                
                            )
                            <!--@php  $breakall = true; @endphp-->
                            @foreach($section->agentterrains as $agentterrain)
                            @foreach($agentterrain->parrains->sortByDesc('id')->values() as $parrain)
                                @if( $breakSearch && 
                                    
                                        ( 
                                            preg_match("/".$breakSearch."/i", $parrain->code_lv)
                                        ) 
                                    
                                )
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->id ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ ($parrain->agentterrain)->nom ?? '-' }} {{ ($parrain->agentterrain)->prenom ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                    {{ ($parrain->agentterrain)->telephone ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                    {{ ($parrain->recenser) ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                    {{ optional($parrain->agentterrain->section)->libel ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                    {{ optional($parrain->agentterrain->sousSection)->libel ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->nom ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->prenom ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->date_naiss ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->date_naiss)->format('d/m/Y'): '-' }}
                                        
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ $parrain->list_elect ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->cart_elect ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->telephone ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->code_lv ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->residence ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->profession ?? '-' }}
                                    </td>
                                    <td colspan="4" class="px-4 py-3 text-left">
                                        {{ $parrain->idee_projet ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ $parrain->lieu_projet ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $parrain->created_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('d/m/Y')." à ".Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('H:i'): '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ $parrain->status ?? '-' }}
                                        @if($parrain->status == "Non traité")
                                            <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:yellow; border-radius:25px;"></span>
                                        @elseif($parrain->status == "Ok")
                                            <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:green; border-radius:25px;"></span>
                                        @elseif($parrain->status == "Abs")
                                            <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:orange; border-radius:25px;"></span>
                                        @elseif($parrain->status == "Autre")
                                            <span class="py-3 mx-2" style="margin:0px 4px; width:10px; height:3px; padding:2px; background-color:brown; border-radius:25px;"></span>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            
                            
                            @endforeach
                            
                            @endforeach
                            
                            @endif
                            @endforeach
                            @endforeach
                            @endif
                            
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
</x-app-layout>
