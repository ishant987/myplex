@props([
    'name'=>'tp_fltr_btn',
    'id'=>'tp_fltr_btn',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.filter_txt'),
    'text' => __('admin.filter_txt'),
])
<button id="{{ $id }}" {{ $attributes->merge(['class' => 'btn waves-effect waves-light btn-sm btn-c-p btn-info '.$class ]) }} type="submit" name="{{ $name }}" data-toggle="tooltip" data-placement="{{ $placement }}" data-trigger="hover" data-original-title="{{ $title }}" onclick="return filter();">{{ $text }}</button>