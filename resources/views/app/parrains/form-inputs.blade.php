@php $editing = isset($parrain) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom_pren_par"
            label="Nom prenom Agent"
            :value="old('nom_pren_par', ($editing ? $parrain->nom_pren_par : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="telephone_par"
            label="Telephone Agent"
            :value="old('telephone_par', ($editing ? $parrain->telephone_par : ''))"
            maxlength="255"
            placeholder="Ex: 0707080809"
            required
        ></x-inputs.text>
    </x-inputs.group>
    
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="recenser"
            label="Nom/prenom recenseur"
            :value="old('recenser', ($editing ? $parrain->recenser : ''))"
            placeholder=""
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom"
            label="Nom"
            :value="old('nom', ($editing ? $parrain->nom : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="prenom"
            label="prenom"
            :value="old('prenom', ($editing ? $parrain->prenom : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="list_elect"
            label="Liste Électoral"
            :value="old('list_elect', ($editing ? $parrain->list_elect : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="cart_elect"
            label="Carte Électeur"
            :value="old('cart_elect', ($editing ? $parrain->cart_elect : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="telephone"
            label="Telephone"
            :value="old('telephone', ($editing ? $parrain->telephone : ''))"
            maxlength="255"
            placeholder="Ex: 0707080809"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="date_naiss"
            label="Date De Naissance"
            value="{{ old('date_naiss', ($editing ? optional($parrain->date_naiss)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="commune_id" label="Commune" required>
            @php $selected = old('commune_id', ($editing ? $parrain->commune_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Commune</option>
            @foreach($communes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="residence"
            label="Résidence"
            :value="old('residence', ($editing ? $parrain->residence : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="profession"
            label="Proféssion"
            :value="old('profession', ($editing ? $parrain->profession : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="observation"
            label="Observation"
            required
            >{{ old('observation', ($editing ? $parrain->observation : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
    
    <x-inputs.group class="w-full">
        <x-inputs.select name="status" label="Statut">
            @php $selected = old('status', ($editing ? $parrain->status : '')) @endphp
            <option value="Non traité" {{ $selected == 'Non traité' ? 'selected' : '' }} >Non traité</option>
            <option value="Ok" {{ $selected == 'Ok' ? 'selected' : '' }} >Ok</option>
            <option value="Abs" {{ $selected == 'Abs' ? 'selected' : '' }} >Abs</option>
            <option value="Autre" {{ $selected == 'Autre' ? 'selected' : '' }} >Autre</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
