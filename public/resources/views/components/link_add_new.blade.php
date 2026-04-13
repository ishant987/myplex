@props([
    'url',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.add_new_txt'),
    'target' => ''
])
<a href="{{ $url }}" {{ $attributes->merge(['class' => 'btn waves-effect waves-light btn-sm f-right btn-primary '.$class ]) }} data-toggle="tooltip" data-placement="{{ $placement }}" data-trigger="hover" data-original-title="{{ $title }}" @if($target != '') target="{{ $target }}" @endif><i class="icofont icofont-plus"></i></a>