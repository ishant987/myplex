@props([
    'href' => '0',
    'class' => '',
    'src' => ''
])
<a url="javascript:;" data-href="{{ $href }}" data-fancybox-media data-type="iframe" data-src="{{ $src }}" id="featuredImg-{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-primary btn-mini waves-effect waves-light '.$class ]) }}>{{ $slot }}</a>