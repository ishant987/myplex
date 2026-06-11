@props([
    'class' => 'btn-primary',
    'type' => 'submit',
    'text' => __('admin.save_txt'),
    'value' => ''
])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn btn-mat waves-effect waves-light m-b-0 '.$class ]) }} @if($value) value="{{ $value }}" @endif>{{ $text }}</button>