@props([
    'class'=> '',
	'error'=>'',
    'info'=>''
])
<div class="form-group form-check {{$class}}">
	{{ $slot }}
    @if($info)
        <small class="form-text text-muted">{!! $info !!}</small>
    @endif
	@if($error)
	   <small class="form-text text-error">{{ $error }}</small>
	@endif
</div>