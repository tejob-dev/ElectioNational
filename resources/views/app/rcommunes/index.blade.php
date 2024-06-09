<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->can('can-open-section-only'))
                @lang('crud.rcommunes.index_title')
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
                                        placeholder="{{ __('crud.common.search') }} rcommunes"
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
                            @can('create', App\Models\Quartier::class)
                            <a
                                href="{{ route('rcommunes.create') }}"
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
                                <!--<th class="px-4 py-3 text-left">-->
                                <!--    @lang('crud.rcommunes.inputs.section_id')-->
                                <!--</th>-->
                                <!--<th class="px-4 py-3 text-left">-->
                                <!--    Quartiers-->
                                <!--</th>-->
                                <!--<th class="px-4 py-3 text-right">-->
                                <!--    @lang('crud.rcommunes.inputs.nbrinscrit')-->
                                <!--</th>-->
                                <!--<th class="px-4 py-3 text-right">-->
                                <!--    @lang('crud.rcommunes.inputs.objectif')-->
                                <!--</th>-->
                                <!--<th class="px-4 py-3 text-right">-->
                                <!--    @lang('crud.rcommunes.inputs.seuil')-->
                                <!--</th>-->
                                <th class="px-4 py-3 text-left">
                                    Regions
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Departements
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Communes
                                </th>
                                <th class="px-4 py-3 text-right">
                                    Objectif
                                </th>
                                <th class="px-4 py-3 text-right">
                                    Seuil
                                </th>
                                
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($rcommunes as $rcommune)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ optional(optional($rcommune->section)->commune)->libel ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($rcommune->section)->libel ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $rcommune->libel ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $rcommune->objectif ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $rcommune->seuil ?? '-' }}
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
                                        
                                        <a
                                            href="{{ route('rcommunes.edit', $rcommune) }}"
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
                                      
                                        <a
                                            href="{{ route('rcommunes.show', $rcommune) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        
                                        <form
                                            action="{{ route('rcommunes.destroy', $rcommune) }}"
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
                                        
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="mt-10 px-4">
                                        {!! $rcommunes->render() !!}
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
