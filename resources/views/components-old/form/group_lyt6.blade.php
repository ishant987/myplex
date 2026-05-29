@props([
'label'=>'', 
'for'=>'',
'class'=>'',
'error'=>'',
'required'=>'',
'info'=>''
])
<div class="col-lg-6 {{ $class}}">
	@if($label)
	<label for="{{ $for?$for:'' }}" class="col-form-label">
		{{ $label?$label:'' }} 
		@if($required == 'true' || $required == 'y')<span class="required">*</span>@endif
	</label>
	@endif
	{{ $slot }}
	@if($info)
	<small class="form-text text-muted">{!! $info !!}</small>
	@endif
	@if($error)
	<small class="form-text text-error">{{ $error }}</small>
	@endif
</div>