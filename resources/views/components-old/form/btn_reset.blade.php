@props([
    'name'=>'tp_rst_btn',
    'id'=>'tp_rst_btn',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.reset_txt'),
    'text' => __('admin.reset_txt'),
])
<button id="{{ $id }}" {{ $attributes->merge(['class' => 'btn waves-effect waves-light btn-sm btn-c-p btn-warning '.$class ]) }} type="submit" name="{{ $name }}" data-toggle="tooltip" data-placement="{{ $placement }}" data-trigger="hover" data-original-title="{{ $title }}" onclick="return resetfilter();">{{ $text }}</button>