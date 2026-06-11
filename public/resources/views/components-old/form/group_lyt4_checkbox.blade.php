@props([
    'class'=> '',
    'fldclass' => '',
    'name',
    'id' => '',
    'value' => '',
    'checked' => '',
    'labelName' => '',
    'required' => '',
    'disabled' => '',
    'readonly' => '',
	'error'=>'',
    'info'=>''
])
<div class="form-group form-check {{$class}}">
	<label class="form-check-label" for="{{ $id?$id:'' }}">
  	<input id="{{ $id }}" type="checkbox" name="{{ $name }}" value="{{ $value }}" @if( ($checked != "" && $value != "") && ($value == $checked) ) checked="checked" @endif @if($required == "true") required="required" @endif @if($disabled == "true") disabled="disabled" @endif @if($readonly == "true") readonly="readonly" @endif class="form-check-input {{$fldclass}}"/>
  	@if($labelName)
        <span class="checkmark"></span>{{ $labelName }}
    @endif
    @if($info)
        <small class="form-text text-muted">{!! $info !!}</small>
    @endif
    @if($error)
       <small class="form-text text-error">{{ $error }}</small>
    @endif
</div>