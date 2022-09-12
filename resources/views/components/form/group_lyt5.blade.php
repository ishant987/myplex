@props([
'label'=>'', 
'for'=>'',
'class'=>'',
'error'=>'',
'required'=>'',
'info'=>''
])
<div class="form-group row align-items-center {{ $class}}">
	@if($label)
	<label for="{{ $for?$for:'' }}" class="col-auto col-form-label">
		{{ $label?$label:'' }} 
		@if($required == 'true' || $required == 'y')<span class="required">*</span>@endif
	</label>
	@endif
	<div class="col-sm-10">
		<div class="input-group">
			{{ $slot }}
			@if($info)
			<small class="form-text text-muted">{!! $info !!}</small>
			@endif
			@if($error)
			<small class="form-text text-error">{{ $error }}</small>
			@endif
		</div>
	</div>
</div>