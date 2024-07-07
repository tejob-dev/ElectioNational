@php $editing = isset($departement) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="libel"
            label="Libel"
            :value="old('libel', ($editing ? $departement->libel : ''))"
            maxlength="255"
            placeholder="Libel"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="nbrinscrit"
            label="Nbrinscrit"
            :value="old('nbrinscrit', ($editing ? $departement->nbrinscrit : '0'))"
            max="255"
            placeholder="Nbrinscrit"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="objectif"
            label="Objectif"
            :value="old('objectif', ($editing ? $departement->objectif : '0'))"
            max="255"
            placeholder="Objectif"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="seuil"
            label="Seuil"
            :value="old('seuil', ($editing ? $departement->seuil : '0'))"
            max="255"
            placeholder="Seuil"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="region_id" label="Region" required>
            @php $selected = old('region_id', ($editing ? $departement->region_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Region</option>
            @foreach($regions as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
