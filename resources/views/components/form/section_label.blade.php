@props(['class' => ''])

<h4 {{ $attributes->merge(['class' => 'sub-title '.$class ]) }}>{{ $slot }}</h4>