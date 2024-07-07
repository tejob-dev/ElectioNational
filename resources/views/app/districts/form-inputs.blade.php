@php $editing = isset($district) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="libel"
            label="Libel"
            :value="old('libel', ($editing ? $district->libel : ''))"
            maxlength="255"
            placeholder="Libel"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="nbrinscrit"
            label="Nbrinscrit"
            :value="old('nbrinscrit', ($editing ? $district->nbrinscrit : '0'))"
            max="255"
            placeholder="Nbrinscrit"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="objectif"
            label="Objectif"
            :value="old('objectif', ($editing ? $district->objectif : '0'))"
            max="255"
            placeholder="Objectif"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="seuil"
            label="Seuil"
            :value="old('seuil', ($editing ? $district->seuil : '0'))"
            max="255"
            placeholder="Seuil"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
