@props([
    'url' => '#',
    'class' => '',
    'id' => '',
    'title' => '',
    'target' => '',
    'message' => '',
    'role' => ''
])
<a @if($class) class="{{ $class }}" @endif href="{{ $url }}" @if($title != '') title="{{ $title }}" @endif @if($target != '') target="{{ $target }}" @endif @if($message != '') data-message="{{ $message }}" @endif  @if($id != '') id="{{ $id }}" @endif @if($role != '') role="{{ $role }}" @endif>{{$slot}}</a>
