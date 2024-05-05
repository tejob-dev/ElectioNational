<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.operateur_suivis.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('operateur-suivis.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.operateur_suivis.inputs.nom')
                        </h5>
                        <span>{{ $operateurSuivi->nom ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.operateur_suivis.inputs.prenoms')
                        </h5>
                        <span>{{ $operateurSuivi->prenoms ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.operateur_suivis.inputs.telephone')
                        </h5>
                        <span>{{ $operateurSuivi->telephone ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('operateur-suivis.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\OperateurSuivi::class)
                    <a
                        href="{{ route('operateur-suivis.create') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\lieu_vote_operateur_suivi::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Lieux Votes </x-slot>

                <livewire:operateur-suivi-lieu-votes-detail
                    :operateurSuivi="$operateurSuivi"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
