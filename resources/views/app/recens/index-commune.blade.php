<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.communes.index_title')
        </h2>
    </x-slot>
    <!-- @php if($isOperateur){ echo "- Section: ".$agent_Section->section->libel;} @endphp -->
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
                                        placeholder="{{ __('crud.common.search') }}"
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
                        <div class="md:w-1/2 text-right">
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    Régions
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
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($communes as $commune)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-left">
                                        {{ $commune->libel ?? '-' }}
                                    </td>
                                    @php

                                    $queryB = App\Models\Commune::userlimit()
                                    ->leftJoin('sections', 'communes.id', '=', 'sections.commune_id')
                                    ->leftJoin('rcommunes', 'sections.id', '=', 'rcommunes.section_id')
                                    ->leftJoin('quartiers', 'rcommunes.id', '=', 'quartiers.r_commune_id')
                                    ->leftJoin('lieu_votes', 'quartiers.id', '=', 'lieu_votes.quartier_id')
                                    ->leftJoin('bureau_votes', 'lieu_votes.id', '=', 'bureau_votes.lieu_vote_id')
                                    ->leftJoin('elector_parrains', function ($join) {
                                        $join->on('lieu_votes.libel', '=', 'elector_parrains.nom_lv')
                                            ->where('elector_parrains.elect_date', '=', '2023');
                                    })
                                    ->leftJoin('parrains', 'lieu_votes.code', '=', 'parrains.code_lv')
                                    ->select('communes.*', DB::raw('COUNT(DISTINCT parrains.id) as total_parrains'), DB::raw('COUNT(DISTINCT elector_parrains.id) as total_electorats'))
                                    ->where('communes.id', '=', $commune->id)
                                    //->where('elector_parrains.elect_date', '=', "2023")
                                    ->groupBy('communes.id')->first();
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
                                        {{ $commune->objectif ?? '-' }}
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
                                        {!! $communes->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>