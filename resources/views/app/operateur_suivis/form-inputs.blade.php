@php $editing = isset($operateurSuivi) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom"
            label="Nom"
            :value="old('nom', ($editing ? $operateurSuivi->nom : ''))"
            maxlength="255"
            placeholder="Nom"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="prenoms"
            label="Prenoms"
            :value="old('prenoms', ($editing ? $operateurSuivi->prenoms : ''))"
            maxlength="255"
            placeholder="Prenoms"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="telephone"
            label="Telephone"
            :value="old('telephone', ($editing ? $operateurSuivi->telephone : ''))"
            maxlength="255"
            placeholder="Telephone"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
