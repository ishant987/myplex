@props([
'class' => '',
'label' => '',
'name' => '',
'id' => '',
'value' => '',
'checked' => '',
'required' => '',
'disabled' => '',
'readonly' => ''
])
<div class="radio radio-inline">
	<label>
		<input id="{{ $id }}" @if($class) class="{{ $class }}" @endif type="radio" name="{{ $name }}" value="{{ $value }}" @if( ($checked != "" && $value != "") && ($value == $checked) ) checked="checked" @endif @if($required == "true") required="required" @endif @if($disabled == "true") disabled="disabled" @endif @if($readonly == "true") readonly="readonly" @endif>
		<i class="helper"></i>{{ $label }}
	</label>
</div>