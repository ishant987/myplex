@props([
    'name' => 'media_id',
    'id' => '',
    'class' => '',
    'type' => 'button',
    'text' => ''
])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn '.$class ]) }} name="{{ $name }}" @if($id) id="{{ $id }}" @endif>{{ $text }}</button>