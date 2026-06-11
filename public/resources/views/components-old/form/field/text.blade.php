@props([
    'class' => '',
    'type' => 'text',
    'readonly' => false
])
<input {{ $attributes->merge(['class' => 'form-control '.$class ]) }} type="{{ $type }}" @if($readonly) readonly="readonly" @endif>
