@props([
'for'=>'',
'label'=>'',
'class'=>'',
'error'=>'',
'info'=>''
])
<div class="form-field-row {{ $class}} {{ $error?'has-danger':'' }}">
	<label for="{{ $for?$for:'' }}">{{ $label?$label:'' }}</label>
	<div class="form-field">
		{{ $slot }}
		@if($info)
		<small class="form-text text-muted">{!! $info !!}</small>
		@endif
		@if($error)
		<small class="form-text text-error">{{ $error }}</small>
		@endif
	</div>
</div>