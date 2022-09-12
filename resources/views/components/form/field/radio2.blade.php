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

<input class="form-check-input {{ $class }}" id="{{ $id }}" type="radio" name="{{ $name }}" value="{{ $value }}" @if( ($checked != "" && $value != "") && ($value == $checked) ) checked="checked" @endif @if($required == "true") required="required" @endif @if($disabled == "true") disabled="disabled" @endif @if($readonly == "true") readonly="readonly" @endif>
<label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
<div class="check"></div>
