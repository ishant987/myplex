@props([
    'style' => 'primary',
    'class'=> '',
    'fldclass' => '',
    'name',
    'id' => '',
    'value' => '',
    'checked' => '',
    'labelName' => '',
    'required' => '',
    'disabled' => '',
    'readonly' => ''
])
<div class="checkbox-fade fade-in-{{$style}} {{$class}}">
    <label>
       <input id="{{ $id }}" type="checkbox" name="{{ $name }}" value="{{ $value }}" @if( ($checked != "" && $value != "") && ($value == $checked) ) checked="checked" @endif class="{{ $fldclass}}" @if($required == "true") required="required" @endif @if($disabled == "true") disabled="disabled" @endif @if($readonly == "true") readonly="readonly" @endif />
        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-{{$style}}"></i></span>
        @if($labelName)
        <span class="text-inverse">{{ $labelName }}</span>
        @endif
    </label>
</div>