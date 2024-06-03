<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Recensement - Electorat {{$curr_year}}
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
                            @can('create', App\Models\ElectorParrain::class)
                            <a
                                href="{{ route('elector-parrains.create') }}"
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
                                    @lang('crud.cor_parrains.inputs.nom_prenoms')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.cor_parrains.inputs.phone')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.cor_parrains.inputs.carte_elect')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Section
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Lieu de Vote
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Parrain
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Tel.&nbsp;Parrain
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($electorParrains as $electorParrain)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $electorParrain->subid ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $electorParrain->nom_prenoms ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $electorParrain->phone ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $electorParrain->carte_elect ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $electorParrain->lieuVote?->quartier?->libel ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $electorParrain->nom_lv ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $electorParrain->agent_res_nompren ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $electorParrain->agent_res_phone ?? '-' }}
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
                                        @can('update', $electorParrain)
                                        <a
                                            href="{{ route('elector-parrains.edit', $electorParrain) }}"
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
                                        @endcan @can('view', $electorParrain)
                                        <a
                                            href="{{ route('elector-parrains.show', $electorParrain) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $electorParrain)
                                        <form
                                            action="{{ route('elector-parrains.destroy', $electorParrain) }}"
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
                                <td colspan="8">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <div class="mt-10 px-4">
                                        {!! $electorParrains->render() !!}
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
