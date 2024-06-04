@php $editing = isset($electorParrain) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom_prenoms"
            label="Nom/Prénoms"
            :value="old('nom_prenoms', ($editing ? $electorParrain->nom_prenoms : ''))"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone"
            label="Téléphone"
            :value="old('phone', ($editing ? $electorParrain->phone : ''))"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="carte_elect"
            label="Carte Electeur"
            :value="old('carte_elect', ($editing ? $electorParrain->carte_elect : ''))"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom_lv"
            label="Lieu de Votes"
            :value="old('nom_lv', ($editing ? $electorParrain->nom_lv : ''))"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="agent_res_nompren"
            label="Agent Responsable"
            :value="old('agent_res_nompren', ($editing ? $electorParrain->agent_res_nompren : ''))"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="agent_res_phone"
            label="Agent Téléphone"
            :value="old('agent_res_phone', ($editing ? $electorParrain->agent_res_phone : ''))"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="recenser"
            label="Agent Recenseur"
            :value="old('recenser', ($editing ? $electorParrain->recenser : ''))"
        ></x-inputs.text>
    </x-inputs.group>

    
</div>
