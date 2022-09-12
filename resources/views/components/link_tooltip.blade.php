@props([
    'url',
    'class'=>'b-b-primary text-primary',
    'placement' => 'top',
    'title' => '',
    'target' => ''
])
<a href="{{ $url }}" class="{{ $class }}" data-toggle="tooltip" data-placement="{{ $placement }}" data-trigger="hover" data-original-title="{{ $title }}" @if($target != '') target="{{ $target }}" @endif>{{ $slot }}</a>