@props([
'for'=>'',
'label'=>'',
'class'=>'',
'error'=>'',
'required'=>'',
'info'=>''
])
<div class="form-group {{ $class}} {{ $error?'has-danger':'' }}">
	<label>
		{{ $label?$label:'' }}
		@if($required == 'true' || $required == 'y')<span class="required">*</span>@endif
	</label>
	<div class="custom-file uploadWrap">
		{{ $slot }}
		<label class="custom-file-label" id="label_{{ $for?$for:'1' }}" for="{{ $for?$for:'' }}">Choose file...</label>
	</div>
	@if($info)
	<small class="form-text text-muted">{!! $info !!}</small>
	@endif
	@if($error)
	<small class="form-text text-error">{{ $error }}</small>
	@endif
</div>
