<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.candidats.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('candidats.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.candidats.inputs.nom')
                        </h5>
                        <span>{{ $candidat->nom ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.candidats.inputs.prenom')
                        </h5>
                        <span>{{ $candidat->prenom ?? '-' }}</span>
                    </div>
                    <!-- <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.candidats.inputs.code')
                        </h5>
                        <span>{{ $candidat->code ?? '-' }}</span>
                    </div> -->
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.candidats.inputs.photo')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $candidat->photo ? \Storage::url($candidat->photo) : '' }}"
                            size="150"
                        />
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.candidats.inputs.couleur')
                        </h5>
                        <span>{{ $candidat->couleur ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.candidats.inputs.parti')
                        </h5>
                        <span>{{ $candidat->parti ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('candidats.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Candidat::class)
                    <a href="{{ route('candidats.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
