@props([
    'class' => '',
    'type' => 'submit',
    'text'
])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn btn-primary btn-md btn-block waves-effect waves-light text-center '.$class ]) }}>{{ $text }}</button>