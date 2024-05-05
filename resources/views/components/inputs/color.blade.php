@props([
    'name',
    'label',
    'value',
])

<x-inputs.basic type="color" :name="$name" label="{{ $label ?? ''}}" :value="$value ?? ''" :attributes="$attributes"></x-inputs.basic>