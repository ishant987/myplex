@props([
    'name' => '',
    'id' => '',
    'value' => ''
])
<input type="hidden" value="{{ $value }}" name="{{ $name }}" @if($id) id="{{ $id }}" @endif>