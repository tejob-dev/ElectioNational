<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Importer les rabatteurs
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

                <x-form
                    method="POST"
                    action="{{ route('import.rabatteurs.validated') }}"
                    class="mt-4"
                    has-files
                >
                    <x-inputs.group class="w-full">
                        <div
                        >
                            <x-inputs.partials.label
                                name="title_csv_file"
                                label="Importer les rabatteurs (NB: le fichier doit être de 3 colonnes sans titre, nom&prenom/Numero/LV)"
                            ></x-inputs.partials.label
                            ><br />
                    
                            <div class="mt-2">
                                <input
                                    type="file"
                                    name="csv_file"
                                    id="csv_file"
                                    accept="text/csv"
                                />
                            </div>
                        </div>
                    </x-inputs.group>

                    <div class="mt-10">
                        <a
                            href="{{ route('rabatteurs.index') }}"
                            class="button"
                        >
                            <i
                                class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <button
                            type="submit"
                            class="button button-primary float-right"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            Valider
                        </button>
                    </div>
                </x-form>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>

