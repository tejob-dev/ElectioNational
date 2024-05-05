@php $editing = isset($corParrain) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom_prenoms"
            label="Nom/Prénoms"
            :value="old('nom_prenoms', ($editing ? $corParrain->nom_prenoms : ''))"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone"
            label="Téléphone"
            :value="old('phone', ($editing ? $corParrain->phone : ''))"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="carte_elect"
            label="Carte Electeur"
            :value="old('carte_elect', ($editing ? $corParrain->carte_elect : ''))"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom_lv"
            label="Lieu de Votes"
            :value="old('nom_lv', ($editing ? $corParrain->nom_lv : ''))"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="agent_res_nompren"
            label="Agent Responsable"
            :value="old('agent_res_nompren', ($editing ? $corParrain->agent_res_nompren : ''))"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="agent_res_phone"
            label="Agent Téléphone"
            :value="old('agent_res_phone', ($editing ? $corParrain->agent_res_phone : ''))"
        ></x-inputs.text>
    </x-inputs.group>

    @if($editing)
    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="a_vote"
            label="A Vote"
            :checked="old('a_vote', ($editing ? $corParrain->a_vote : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
    @endif
</div>
