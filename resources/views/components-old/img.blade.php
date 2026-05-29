@props([
    'src',
    'class' => '',
    'id' => '',
    'alt' => config('app.name'),
    'title' => '',
    'width' => '',
    'height' => '',
    'data_id' => ''
])
<img src="{{ $src }}" @if($class) class="{{ $class }}" @endif alt="@if($alt){!!$alt!!}@else{!!config('app.name')!!}@endif" @if($title) title="{!! $title !!}" @endif @if($width == true) width="{{ $width }}" @endif @if($height == true) height="{{ $height }}" @endif @if($data_id) data-id="{{ $data_id }}" @endif @if($id != '') id="{{ $id }}" @endif>