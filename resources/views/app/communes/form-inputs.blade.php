@php $editing = isset($commune) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="libel"
            label="Libel"
            :value="old('libel', ($editing ? $commune->libel : ''))"
            maxlength="255"
            placeholder="Libel"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="code"
            label="Code"
            :value="old('code', ($editing ? $commune->code : ''))"
            maxlength="255"
            placeholder="Code"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="nbrinscrit"
            label="Nbrinscrit"
            :value="old('nbrinscrit', ($editing ? $commune->nbrinscrit : '0'))"
            max="255"
            placeholder="Nbrinscrit"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="objectif"
            label="Objectif"
            :value="old('objectif', ($editing ? $commune->objectif : '0'))"
            max="255"
            placeholder="Objectif"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="seuil"
            label="Seuil"
            :value="old('seuil', ($editing ? $commune->seuil : '0'))"
            max="255"
            placeholder="Seuil"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="rgph_population"
            label="Rgph Population"
            :value="old('rgph_population', ($editing ? $commune->rgph_population : '0'))"
            max="255"
            placeholder="Rgph Population"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="departement_id" label="Departement" required>
            @php $selected = old('departement_id', ($editing ? $commune->departement_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Departement</option>
            @foreach($departements as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
