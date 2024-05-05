@php $editing = null; @endphp

<div class="flex flex-wrap">

    @if($type == 0)
{{--         <x-inputs.group class="w-full">
            <x-inputs.select name="rabatteur_id" label="Le rabatteur" required>
                @php $selected = old('rabatteur_id', ($editing ? '' : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix</option>
                    @foreach($rabatteurs as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }} {{ App\Models\Rabatteur::find($value)->prenoms }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group> --}}
        <x-inputs.group class="w-full">
            <x-inputs.select name="lieu_vote_id" label="Le Lieu Vote" required>
                @php $selected = old('lieu_vote_id', ($editing ? $bureauVote->lieu_vote_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de Lieu Vote</option>
                @foreach($lieuVotes as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>    
    @elseif($type == 1)
        <x-inputs.group class="w-full">
            <x-inputs.select name="lieu_vote_id" label="Le Lieu Vote" required>
                @php $selected = old('lieu_vote_id', ($editing ? $bureauVote->lieu_vote_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de Lieu Vote</option>
                @foreach($lieuVotes as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>   
    @elseif($type == 2)
        <x-inputs.group class="w-full">
            <x-inputs.select name="bureau_vote_id" label="Bureau Vote" required>
                @php $selected = old('bureau_vote_id', ($editing ? '' : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de Bureau Vote</option>
                @foreach($bureauVotes as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }} - {{ optional(App\Models\BureauVote::find($value)->lieuVote)->libel??'-' }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>   
    @endif

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="numberph"
            label="Téléphone"
            :value="old('libel', ($editing ? $commune->libel : ''))"
            placeholder="Ex: 0708090510,0708090510.. (Si contient une valeur la selection est ignoré!)"
        ></x-inputs.text>
    </x-inputs.group>

    <input type="hidden" name="type" value="{{$type}}">

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="message"
            label="Le message"
            maxLength="150"
            max="150"
            placeholder="Limite de texte à 150 caractères!"
            required
            >{{ old('message', (''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
