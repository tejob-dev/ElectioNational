<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Liste des messages envoyé au agent.
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
                                        placeholder="{{ __('crud.common.search') }} dans les messages"
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
                            
                            <a
                                href="{{ route('agentmessages.make', 0) }}"
                                class="button button-primary m-2" style="margin: 4px"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                Ecrire aux Rabatteurs
                            </a>
                            <a
                                href="{{ route('agentmessages.make', 1) }}"
                                class="button button-warning m-2" style="margin: 4px; background-color:brown; color:white"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                Ecrire au agent des LV
                            </a>
                            <a
                                href="{{ route('agentmessages.make', 2) }}"
                                class="button button-dark m-2" style="margin: 4px; background-color:coral;color:white"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                Ecrire au agent des BV
                            </a>
                            
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
                                    Agents
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Messages
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Date d'envoi
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @php $counter = 0; @endphp
                            @forelse($agentmessages as $agentmessage)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ ($loop->count - (++$counter - 1)) }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $agentmessage->lieuvote ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $agentmessage->message ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $agentmessage->created_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $agentmessage->created_at)->format('d/m/Y H:i'): '-' }}
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
                                        @if (auth()->user()->hasPermissionTo('delete-message-sendto-agent'))
                                        <form
                                            action="{{ route('agentmessages.destroy', ["agentmessage"=>$agentmessage->id]) }}"
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
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="mt-10 px-4">
                                        {!! $agentmessages->render() !!}
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
