@props([
    'class' => ''
])
<input {{ $attributes->merge(['class' => 'form-control '.$class ]) }} type="file">