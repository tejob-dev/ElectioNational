<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Liste des alertes soumisses
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
                                        placeholder="{{ __('crud.common.search') }} alertes"
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
                                    Lieux de vote
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Superviseurs
                                </th>
                                <th class="px-4 py-3 text-left" style="background-color: #ff99cc">
                                    Numéros
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Heures d’envoi
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Status
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Traitant d'alerte
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Traitement
                                </th>
                                <th class="px-4 py-3 text-left"></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($alertes as $alerte)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $alerte->lieuvote ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $alerte->supervise ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $alerte->phone ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $alerte->created_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $alerte->created_at)->format('d/m/Y H:i'): '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    @if($alerte->viewers) Traité @else Non traité @endif
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $alerte->message ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $alerte->responsable ?? '-' }}
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
                                        @can('can-update-alerte-message', App\Models\User::class)
                                        <a
                                            href="{{ route('alerte.agentlist.edit', $alerte->id) }}"
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
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="mt-10 px-4">
                                        {!! $alertes->render() !!}
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
