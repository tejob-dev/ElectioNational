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
                                    Région
                                </th>
                                <th class="px-4 py-3 text-right">
                                    Parrainé
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
                                    $parrainCount = 0;
                                    foreach ($commune->sections as $section) {
                                        foreach ($section->agentterrains as $agentterrain) {
                                            $parrainCount += $agentterrain->parrains->count();
                                        }
                                    }          
                                    @endphp
                                    <td class="px-4 py-3 text-right">
                                        {{ $parrainCount ?? '-' }}
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