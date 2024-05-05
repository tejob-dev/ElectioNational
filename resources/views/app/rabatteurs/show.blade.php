<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.rabatteurs.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('rabatteurs.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.rabatteurs.inputs.nom')
                        </h5>
                        <span>{{ $rabatteur->nom ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.rabatteurs.inputs.prenoms')
                        </h5>
                        <span>{{ $rabatteur->prenoms ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.rabatteurs.inputs.telephone')
                        </h5>
                        <span>{{ $rabatteur->telephone ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('rabatteurs.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Rabatteur::class)
                    <a href="{{ route('rabatteurs.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\lieu_vote_rabatteur::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Lieux Votes </x-slot>

                <livewire:rabatteur-lieu-votes-detail :rabatteur="$rabatteur" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
