<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            
            @if(auth()->user()->can('can-open-section-only'))
                @lang('crud.bureau_votes.index_title')
            @else
                @lang('crud.bureau_votes.index_title')
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
                                        placeholder="{{ __('crud.common.search') }} bureaux de vote"
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
                            @can('create', App\Models\BureauVote::class)
                            <a
                                href="{{ route('bureau-votes.create') }}"
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
                                    Régions
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Departements
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Communes
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Sections
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Lieux De Vote
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Bureaux De Vote
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.bureau_votes.inputs.objectif')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.bureau_votes.inputs.seuil')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($bureauVotes as $bureauVote)
                            <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-left">
                                    {{ optional(optional(optional($bureauVote->lieuVote->quartier)->section)->section)->commune->libel ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional(optional($bureauVote->lieuVote->quartier)->section)->section->libel ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($bureauVote->lieuVote->quartier)->section->libel ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($bureauVote->lieuVote->quartier)->libel ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($bureauVote->lieuVote)->libel ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $bureauVote->libel ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $bureauVote->objectif ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $bureauVote->seuil ?? '-' }}
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
                                        @can('update', $bureauVote)
                                        <a
                                            href="{{ route('bureau-votes.edit', $bureauVote) }}"
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
                                        @endcan @can('view', $bureauVote)
                                        <a
                                            href="{{ route('bureau-votes.show', $bureauVote) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $bureauVote)
                                        <form
                                            action="{{ route('bureau-votes.destroy', $bureauVote) }}"
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
                                        {!! $bureauVotes->render() !!}
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
