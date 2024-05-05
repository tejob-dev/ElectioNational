@php $editing = isset($commune) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="libel"
            label="Libellé"
            :value="old('libel', ($editing ? $commune->libel : ''))"
            maxlength="255"
            
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="nbrinscrit"
            label="Inscrit"
            :value="old('nbrinscrit', ($editing ? $commune->nbrinscrit : ''))"
            placeholder=""
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="objectif"
            label="Objectif"
            :value="old('objectif', ($editing ? $commune->objectif : ''))"
            placeholder=""
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="seuil"
            label="Seuil"
            :value="old('seuil', ($editing ? $commune->seuil : ''))"
            placeholder=""
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
