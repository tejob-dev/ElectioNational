<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->hasRole('Opérateur de section'))
                @lang('crud.parrains.index_title') - Section: {{optional($parrains[0])->agentTerrain->section->libel??"Pas de donnée"}}
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
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }} parrains"
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
                            @can('create', App\Models\Parrain::class)
                            <a
                                href="{{ route('parrains.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    ID
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Parrain
                                </th>
                                <th class="px-4 py-3">
                                    Tel.&nbsp;Parrain
                                </th>
                                <th class="px-4 py-3">
                                    Recenseur
                                </th>
                                <th class="px-4 py-3">
                                    Section
                                </th>
                                <!-- <th class="px-4 py-3">
                                    Sous Section
                                </th> -->
                                <th class="px-4 py-3 ">
                                    Nom
                                </th>
                                <th class="px-4 py-3 ">
                                    Prénoms
                                </th>
                                <th class="px-4 py-3 ">
                                    Date de naissance
                                </th>
                                <th class="px-4 py-3 ">
                                    Liste électorale
                                </th>
                                <!-- <th class="px-4 py-3 ">
                                    Nº&nbsp;Carte
                                </th> -->
                                <th class="px-4 py-3 ">
                                    Tel.
                                </th>
                                <th class="px-4 py-3 ">
                                    LV
                                </th>
                                <th class="px-4 py-3 ">
                                    Résidence
                                </th>
                                <th class="px-4 py-3">
                                    Profession
                                </th>
                                <th class="px-4 py-3">
                                    Observation
                                </th>
                                <th class="px-4 py-3">
                                    Parrainé le
                                </th>
                                <th class="px-4 py-3 text-right">
                                    Statut
                                </th>
                                <th >
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($parrains as $parrain)
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
                                    {{ $parrain->recenser ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ ($parrain->agentterrain->section)->libel ?? '-' }}
                                </td>
                                <!-- <td class="px-4 py-3 text-left">
                                    {{ ($parrain->agentterrain->sousSection)->libel ?? '-' }}
                                </td> -->
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->nom ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->prenom ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->date_naiss ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->date_naiss)->format('d/m/Y'): '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->list_elect ?? '-' }}
                                </td>
                                <!-- <td class="px-4 py-3 text-left">
                                    {{ $parrain->cart_elect ?? '-' }}
                                </td> -->
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
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->observation ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $parrain->created_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('d/m/Y')." à ".Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parrain->created_at)->format('H:i'): '-' }}
                                </td>
                                <td class="px-4 py-3 text-center flex">
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
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $parrain)
                                        <a
                                            href="{{ route('parrains.edit', $parrain) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view', $parrain)
                                        <a
                                            href="{{ route('parrains.show', $parrain) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $parrain)
                                        <form
                                            action="{{ route('parrains.destroy', $parrain) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="
                                                        icon
                                                        ion-md-trash
                                                        text-red-600
                                                    "
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="14">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="14">
                                    <div class="mt-10 px-4">
                                        {!! $parrains->render() !!}
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
