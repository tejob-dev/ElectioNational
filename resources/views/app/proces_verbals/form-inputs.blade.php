@php $editing = isset($procesVerbal) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="libel"
            label="Libellé"
            :value="old('libel', ($editing ? $procesVerbal->libel : ''))"
            maxlength="255"
            
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $procesVerbal->photo ? \Storage::url($procesVerbal->photo) : '' }}')"
        >
            <x-inputs.partials.label
                name="photo"
                label="Photo"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="photo"
                    id="photo"
                    @change="fileChosen"
                />
            </div>

            @error('photo') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="bureau_vote_id" label="Bureau Vote" required>
            @php $selected = old('bureau_vote_id', ($editing ? $procesVerbal->bureau_vote_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de Bureau Vote</option>
            @foreach($bureauVotes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }} - {{ App\Models\BureauVote::find($value)->lieuVote->libel }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
