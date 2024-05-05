@php $editing = isset($supLieuDeVote) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom"
            label="Nom"
            :value="old('nom', ($editing ? $supLieuDeVote->nom : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="prenom"
            label="Prénom"
            :value="old('prenom', ($editing ? $supLieuDeVote->prenom : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="telephone"
            label="Telephone"
            :value="old('telephone', ($editing ? $supLieuDeVote->telephone : ''))"
            maxlength="255"
            placeholder="Ex: 0707080809"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="lieu_vote_id" label="Lieu Vote" required>
            @php $selected = old('lieu_vote_id', ($editing ? $supLieuDeVote->lieu_vote_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de Lieu Vote</option>
            @foreach($lieuVotes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
