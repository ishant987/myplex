@props([
'for'=>'',
'label'=>'', 
'class'=>'',
'error'=>'',
'required'=>'',
'info'=>''
])
<div class="form-group col-sm-6 {{ $class}} {{ $error?'has-danger':'' }}">
	<label class="col-form-label" for="{{ $for?$for:'' }}">
		{{ $label?$label:'' }}
		@if($required == 'true' || $required == 'y')<span class="required">*</span>@endif
	</label>
	{{ $slot }}
	@if($info)
	<small class="form-text text-muted">{!! $info !!}</small>
	@endif  
	@if($error)
	<small class="form-text text-error">{{ $error }}</small>
	@endif
</div>