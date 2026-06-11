@props([
'label'=>'', 
'fieldFor'=>'', 
'fieldForClass'=>'', 
'for'=>'',
'class'=>'',
'error'=>'',
'required'=>'',
'info'=>''
])
<div class="form-group has-primary row {{ $class}} {{ $error?'has-danger':'' }}">
  <label for="{{ $for?$for:'' }}" class="col-sm-2 col-form-label">
  	{{ $label?$label:'' }} 
    {!! $fieldFor?'<span class="field_for '.$fieldForClass.'">'.$fieldFor.'</span>':'' !!} 
  	@if($required == 'true' || $required == 'y')<span class="required">*</span>@endif
  </label>
  <div class="col-sm-10">
    {{ $slot }}  
    @if($info)
    <div class="col-form-label info">{!! $info !!}</div>
    @endif  
    @if($error)
    <div class="col-form-label">{{ $error }}</div>
    @endif
  </div>
</div>