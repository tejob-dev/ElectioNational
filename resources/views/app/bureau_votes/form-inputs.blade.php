@php $editing = isset($bureauVote) @endphp

<div class="flex flex-wrap">

    @if(auth()->user()->hasPermissionTo('can-modify-bvvote-field'))
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="libel"
            label="Libellé"
            :value="old('libel', ($editing ? $bureauVote->libel : ''))"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="objectif"
            label="Objectif"
            :value="old('objectif', ($editing ? $bureauVote->objectif : ''))"
            placeholder=""
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="seuil"
            label="Seuil"
            :value="old('seuil', ($editing ? $bureauVote->seuil : ''))"
            placeholder=""
        ></x-inputs.number>
    </x-inputs.group>
    <x-inputs.group class="w-full">
        <x-inputs.select name="lieu_vote_id" label="Lieu Vote">
            @php $selected = old('lieu_vote_id', ($editing ? $bureauVote->lieu_vote_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de Lieu Vote</option>
            @foreach($lieuVotes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    @endif
    
    @if($editing && auth()->user()->hasPermissionTo('can-modify-bvvote-field-resultat'))
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="votant_resul"
            label="Votant Résultat"
            :value="old('votant_resul', ($editing ? $bureauVote->votant_resul : ''))"
            placeholder=""
        ></x-inputs.number>
    </x-inputs.group>
    
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="bult_nul"
            label="Bultins Null"
            :value="old('bult_nul', ($editing ? $bureauVote->bult_nul : ''))"
            placeholder=""
        ></x-inputs.number>
    </x-inputs.group>
    
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="bult_blan"
            label="Bultins Blanc"
            :value="old('bult_blan', ($editing ? $bureauVote->bult_blan : ''))"
            placeholder=""
        ></x-inputs.number>
    </x-inputs.group>

    @php
        $notes = $bureauVote->candidat_note;
        $canditNote = [];
        $candits = App\Models\Candidat::get();
        foreach ($candits as $key => $candd) {
            $canditNote[$key] = 0;
            if($notes){
                $namek = $candd->code;
                $lists = json_decode($notes);
                if(is_object($lists) && property_exists($lists, "$namek")){
                    $canditNote[$key] += intval($lists->$namek);
                }
            }
        }
    @endphp
    @foreach ($candits as $key => $candi)
        @php $posit = $canditNote[$key]; @endphp
        <x-inputs.group class="w-full">
            <x-inputs.number
                name="{{$candi->code}}"
                label="Vote de {{$candi->nom.' '.$candi->prenom}}"
                :value="$posit"
                placeholder=""
            ></x-inputs.number>
        </x-inputs.group>

    @endforeach
    @endif

</div>
