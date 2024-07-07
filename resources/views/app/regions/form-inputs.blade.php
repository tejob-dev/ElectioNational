@php $editing = isset($region) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="libel"
            label="Libel"
            :value="old('libel', ($editing ? $region->libel : ''))"
            maxlength="255"
            placeholder="Libel"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="nbrinscrit"
            label="Nbrinscrit"
            :value="old('nbrinscrit', ($editing ? $region->nbrinscrit : '0'))"
            max="255"
            placeholder="Nbrinscrit"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="objectif"
            label="Objectif"
            :value="old('objectif', ($editing ? $region->objectif : '0'))"
            max="255"
            placeholder="Objectif"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="seuil"
            label="Seuil"
            :value="old('seuil', ($editing ? $region->seuil : '0'))"
            max="255"
            placeholder="Seuil"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="district_id" label="District" required>
            @php $selected = old('district_id', ($editing ? $region->district_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the District</option>
            @foreach($districts as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
