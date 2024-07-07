<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.parrains.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('parrains.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.nom_pren_par')
                        </h5>
                        <span>{{ $parrain->nom_pren_par ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.telephone_par')
                        </h5>
                        <span>{{ $parrain->telephone_par ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            Recenseur
                        </h5>
                        <span>{{ $parrain->recenser ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.nom')
                        </h5>
                        <span>{{ $parrain->nom ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.prenom')
                        </h5>
                        <span>{{ $parrain->prenom ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.list_elect')
                        </h5>
                        <span>{{ $parrain->list_elect ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.cart_elect')
                        </h5>
                        <span>{{ $parrain->cart_elect ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.telephone')
                        </h5>
                        <span>{{ $parrain->telephone ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.date_naiss')
                        </h5>
                        <span>{{ $parrain->date_naiss ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.commune_id')
                        </h5>
                        <span
                            >{{ optional($parrain->commune)->libel ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.residence')
                        </h5>
                        <span>{{ $parrain->residence ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.profession')
                        </h5>
                        <span>{{ $parrain->profession ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.parrains.inputs.observation')
                        </h5>
                        <span>{{ $parrain->observation ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            Statut
                        </h5>
                        <span>{{ $parrain->status ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('parrains.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Parrain::class)
                    <a href="{{ route('parrains.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
