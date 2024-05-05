@php $editing = isset($user) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Nom"
            :value="old('name', ($editing ? $user->name : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="prenom"
            label="Prénom"
            :value="old('prenom', ($editing ? $user->prenom : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            :value="old('email', ($editing ? $user->email : ''))"
            maxlength="255"
            placeholder=""
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="date_naiss"
            label="Date De Naissance"
            value="{{ old('date_naiss', ($editing ? optional($user->date_naiss)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.password
            name="password"
            label="Mot de passe"
            maxlength="255"
            placeholder=""
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="commune_id" label="Region">
            @php $selected = old('commune_id', ($editing ? $user->commune_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de Region</option>
            @foreach($communes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="departement_id" label="Departement">
            @php $selected = old('departement_id', ($editing ? $user->departement_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Faites votre choix de Departement</option>
            @foreach($departements as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $user->photo ? \Storage::url($user->photo) : '' }}')"
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

    @can('can set rules', App\Models\User::class)
    <div class="px-4 my-4">
        <h4 class="font-bold text-lg text-gray-700">
            Assigné @lang('crud.roles.name')
        </h4>

        <div class="py-2">
            @foreach ($roles as $role)
                @if(auth()->user()->hasPermissionTo('can-set-only-rule-ops'))
                    @if ($role->name == "Opérateur de section")
                        <div>
                            <x-inputs.checkbox
                                id="role{{ $role->id }}"
                                name="roles[]"
                                label="{{ ucfirst($role->name) }}"
                                value="{{ $role->id }}"
                                :checked="isset($user) ? $user->hasRole($role) : false"
                                :add-hidden-value="false"
                            ></x-inputs.checkbox>
                        </div>
                    @endif
                @else
                    @if(Auth::user()->super_admin)
                        <div>
                            <x-inputs.checkbox
                                id="role{{ $role->id }}"
                                name="roles[]"
                                label="{{ ucfirst($role->name) }}"
                                value="{{ $role->id }}"
                                :checked="isset($user) ? $user->hasRole($role) : false"
                                :add-hidden-value="false"
                            ></x-inputs.checkbox>
                        </div>
                    @else
                        @if ($role->name != "super-admin")
                        <div>
                            <x-inputs.checkbox
                                id="role{{ $role->id }}"
                                name="roles[]"
                                label="{{ ucfirst($role->name) }}"
                                value="{{ $role->id }}"
                                :checked="isset($user) ? $user->hasRole($role) : false"
                                :add-hidden-value="false"
                            ></x-inputs.checkbox>
                        </div>
                        @endif
                    @endif
                @endif
            @endforeach
        </div>
    </div>
    @endcan
</div>
