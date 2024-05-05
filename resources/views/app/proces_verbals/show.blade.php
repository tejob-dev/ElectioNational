<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.proces_verbals.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('proces-verbals.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.proces_verbals.inputs.libel')
                        </h5>
                        <span>{{ $procesVerbal->libel ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.proces_verbals.inputs.photo')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $procesVerbal->photo ? \Storage::url($procesVerbal->photo) : '' }}"
                            size="150"
                        />
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.proces_verbals.inputs.bureau_vote_id')
                        </h5>
                        <span
                            >{{ optional($procesVerbal->bureauVote)->libel ??
                            '-' }} - {{
                                    optional($procesVerbal->bureauVote->lieuVote)->libel
                                    ?? '-' }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('proces-verbals.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\ProcesVerbal::class)
                    <a
                        href="{{ route('proces-verbals.create') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
