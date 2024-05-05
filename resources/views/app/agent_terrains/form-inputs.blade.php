@php $editing = isset($agentTerrain) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nom"
            label="Nom"
            :value="old('nom', ($editing ? $agentTerrain->nom : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="prenom"
            label="Prénom"
            :value="old('prenom', ($editing ? $agentTerrain->prenom : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <!-- <x-inputs.group class="w-full">
        <x-inputs.text
            name="code"
            label="Code"
            :value="old('code', ($editing ? $agentTerrain->code : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group> -->

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="telephone"
            label="Telephone"
            :value="old('telephone', ($editing ? $agentTerrain->telephone : ''))"
            maxlength="255"
            placeholder="Ex: 0707080809"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="section_id" label="Departement" required>
            @php $selected = old('section_id', ($editing ? $agentTerrain->section_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de la Section</option>
            @php
                $curr_user = auth()->user();
            @endphp
            
            @if($curr_user->hasPermissionTo("can-open-section-only")){
                
                @php
                    $name = $curr_user->name;
                    $prenom = $curr_user->prenom;
                    $agent_Section = App\Models\AgentDeSection::where([
                        ["nom","like", $name],
                        ["prenom","like", $prenom],
                    ])->with("section.commune")->first();
                    $sectionId = $agent_Section->section;
                @endphp
                <option value="{{ $sectionId->id }}" {{ $selected == $sectionId->id ? 'selected' : '' }} >{{ $sectionId->libel }}</option>
            @else
                @foreach($sections as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            @endif
        </x-inputs.select>
    </x-inputs.group>
    
    <x-inputs.group class="w-full">
        <x-inputs.select name="sous_section_id" label="Sous-section" required>
            @php $selected = old('sous_section_id', ($editing ? $agentTerrain->sous_section_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de la Sous-section</option>
            @foreach($soussections as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
