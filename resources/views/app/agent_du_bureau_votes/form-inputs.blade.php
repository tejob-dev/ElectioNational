@php $editing = isset($agentDuBureauVote) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom"
            label="Nom"
            :value="old('nom', ($editing ? $agentDuBureauVote->nom : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="prenom"
            label="Prenom"
            :value="old('prenom', ($editing ? $agentDuBureauVote->prenom : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="telphone"
            label="Téléphone"
            :value="old('telphone', ($editing ? $agentDuBureauVote->telphone : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="bureau_vote_id" label="Bureau Vote" required>
            @php $selected = old('bureau_vote_id', ($editing ? $agentDuBureauVote->bureau_vote_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de Bureau Vote</option>
            @foreach($bureauVotes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }} - {{ optional(App\Models\BureauVote::find($value)->lieuVote)->libel
                            ?? '-' }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
