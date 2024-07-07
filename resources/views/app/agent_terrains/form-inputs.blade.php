@php $editing = isset($agentTerrain) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom"
            label="Nom"
            :value="old('nom', ($editing ? $agentTerrain->nom : ''))"
            maxlength="255"
            placeholder="Nom"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="prenom"
            label="Prenom"
            :value="old('prenom', ($editing ? $agentTerrain->prenom : ''))"
            maxlength="255"
            placeholder="Prenom"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="code"
            label="Code"
            :value="old('code', ($editing ? $agentTerrain->code : ''))"
            maxlength="255"
            placeholder="Code"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="telephone"
            label="Telephone"
            :value="old('telephone', ($editing ? $agentTerrain->telephone : ''))"
            maxlength="255"
            placeholder="Telephone"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="profil" label="Profil" maxlength="255" required
            >{{ old('profil', ($editing ? $agentTerrain->profil : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="district_id" label="District">
            @php $selected = old('district_id', ($editing ? $agentTerrain->district_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the District</option>
            @foreach($districts as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="region_id" label="Region">
            @php $selected = old('region_id', ($editing ? $agentTerrain->region_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Region</option>
            @foreach($regions as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="departement_id" label="Departement">
            @php $selected = old('departement_id', ($editing ? $agentTerrain->departement_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Departement</option>
            @foreach($departements as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="commune_id" label="Commune">
            @php $selected = old('commune_id', ($editing ? $agentTerrain->commune_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Commune</option>
            @foreach($communes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
