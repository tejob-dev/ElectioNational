@php $editing = isset($lieuVote) @endphp

<div class="flex flex-wrap">
    @php
        $forhidden = "";
        $fordisable = "";
        
        if(auth()->user()->hasPermissionTo('can-change-libel-lv') == false){
            $forhidden = "hidden";
            $fordisable = "disabled";
        }
    @endphp
    
    @if(!empty($forhidden))
        <span class="px-4 my-2 w-full"><label class="label font-medium text-gray-700">Lieu de vote: </label> <strong>{{old('libel', ($editing ? $lieuVote->libel : ''))}}</strong> </span>
    @endif

    <x-inputs.group class="w-full {{$forhidden}}">
        <x-inputs.text
            name="code"
            label="Code"
            :value="old('code', ($editing ? $lieuVote->code : ''))"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full {{$forhidden}}">
        <x-inputs.text
            name="libel"
            label="Libellé"
            :value="old('libel', ($editing ? $lieuVote->libel : ''))"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full {{$forhidden}}">
        <x-inputs.number
            name="nbrinscrit"
            label="Inscrit"
            :value="old('nbrinscrit', ($editing ? $lieuVote->nbrinscrit : ''))"
            placeholder=""
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="objectif"
            label="Objectif"
            :value="old('objectif', ($editing ? $lieuVote->objectif : ''))"
            placeholder=""
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full {{$forhidden}}">
        <x-inputs.number
            name="seuil"
            label="Seuil"
            :value="old('seuil', ($editing ? $lieuVote->seuil : ''))"
            placeholder=""
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="code"
            label="Code"
            :value="old('code', ($editing ? $lieuVote->code : ''))"
            maxlength="255"
            placeholder="Code"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="a_vote"
            label="A Vote"
            :value="old('a_vote', ($editing ? $lieuVote->a_vote : '0'))"
            max="255"
            placeholder="A Vote"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="imported"
            label="Imported"
            :value="old('imported', ($editing ? $lieuVote->imported : '0'))"
            max="255"
            placeholder="Imported"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="commune_id" label="Commune" required>
            @php $selected = old('commune_id', ($editing ? $lieuVote->commune_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Commune</option>
            @foreach($communes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
