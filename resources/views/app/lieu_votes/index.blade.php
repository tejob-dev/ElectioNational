<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->can('can-open-section-only'))
                @lang('crud.lieu_votes.index_title')
            @else
                @lang('crud.lieu_votes.index_title')
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
                            @can('create', App\Models\LieuVote::class)
                            <a
                                href="{{ route('lieu-votes.create') }}"
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
                                    Region
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Departement
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Commune
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Section
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Lieu De Vote
                                </th>
                                <!-- <th class="px-4 py-3 text-left">
                                    @lang('crud.lieu_votes.inputs.code')
                                </th> -->
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.lieu_votes.inputs.nbrinscrit')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.lieu_votes.inputs.objectif')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.lieu_votes.inputs.seuil')
                                </th>
                                
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($lieuVotes as $lieuVote)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ optional(optional(optional($lieuVote->quartier)->section)->section)->commune->libel ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional(optional($lieuVote->quartier)->section)->section->libel ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($lieuVote->quartier)->section->libel ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($lieuVote->quartier)->libel ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $lieuVote->libel ?? '-' }}
                                </td>
                                <!-- <td class="px-4 py-3 text-left">
                                    {{ $lieuVote->code ?? '-' }}
                                </td> -->
                                <td class="px-4 py-3 text-right">
                                    {{ $lieuVote->nbrinscrit ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $lieuVote->objectif ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $lieuVote->seuil ?? '-' }}
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
                                        @can('update', $lieuVote)
                                        <a
                                            href="{{ route('lieu-votes.edit', $lieuVote) }}"
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
                                        @endcan @can('view', $lieuVote)
                                        <a
                                            href="{{ route('lieu-votes.show', $lieuVote) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $lieuVote)
                                        <form
                                            action="{{ route('lieu-votes.destroy', $lieuVote) }}"
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
                                <td colspan="7">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="mt-10 px-4">
                                        {!! $lieuVotes->render() !!}
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
