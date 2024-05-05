@php $editing = isset($quartier) @endphp

<div class="flex flex-wrap">
    
    @php
        $forhidden = "";
        $fordisable = "";
        
        if(auth()->user()->hasPermissionTo('can-change-libel-quart') == false){
            $forhidden = "hidden";
            $fordisable = "disabled";
        }
    @endphp
    
    @if(!empty($forhidden))
        <span class="px-4 my-2 w-full"><label class="label font-medium text-gray-700">Quartier: </label> <strong>{{old('libel', ($editing ? $quartier->libel : ''))}}</strong> </span>
    @endif

    <x-inputs.group class="w-full {{$forhidden}}">
        <x-inputs.text
            name="libel"
            label="Libellé"
            :value="old('libel', ($editing ? $quartier->libel : ''))"
            maxlength="255"
            
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full {{$forhidden}}">
        <x-inputs.number
            name="nbrinscrit"
            label="Inscrit"
            :value="old('nbrinscrit', ($editing ? $quartier->nbrinscrit : ''))"
            placeholder=""
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="objectif"
            label="Objectif"
            :value="old('objectif', ($editing ? $quartier->objectif : ''))"
            placeholder=""
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full {{$forhidden}}">
        <x-inputs.number
            name="seuil"
            label="Seuil"
            :value="old('seuil', ($editing ? $quartier->seuil : ''))"
            placeholder=""
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="section_id" label="Departement" required>
            @php $selected = old('section_id', ($editing ? $quartier->section_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de Section</option>
            @foreach($sections as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
