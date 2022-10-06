@props([
'class' => 'form-control',
'type' => 'text',
'readonly' => false
])
<input {{ $attributes->merge(['class' => $class ]) }} type="{{ $type }}" @if($readonly) readonly="readonly" @endif>