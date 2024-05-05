@php $editing = isset($alert) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="responsable"
            label="Traitement"
            :value="old('reponsable', ($editing ? $alert->responsable : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
