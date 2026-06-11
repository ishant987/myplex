@props([
    'class' => '',
    'value' => '',
    'rows' => 5
])
<textarea {{ $attributes->merge(['class' => 'form-control '.$class ]) }} rows="{{ $rows }}">{{ $value }}</textarea>