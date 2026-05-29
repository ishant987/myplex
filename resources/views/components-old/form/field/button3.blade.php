@props([
'class' => 'form-submit btn-bg-2 text-white',
'type' => 'submit',
'text' => __('admin.submit_txt')
])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn '.$class ]) }}>{{ $text }}</button>