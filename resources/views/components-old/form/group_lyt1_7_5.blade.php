@props([
'label'=>'', 
'for'=>'',
'class'=>'',
'error'=>'',
'required'=>'',
'info'=>''
])
<div class="form-group has-primary row {{ $class}} {{ $error?'has-danger':'' }}">
  <label for="{{ $for?$for:'' }}" class="col-sm-7 col-form-label">
  	{{ $label?$label:'' }} 
  	@if($required == 'true' || $required == 'y')<span class="required">*</span>@endif
  </label>
  <div class="col-sm-5">
    {{ $slot }}  
    @if($info)
    <div class="col-form-label info">{!! $info !!}</div>
    @endif  
    @if($error)
    <div class="col-form-label">{{ $error }}</div>
    @endif
  </div>
</div>