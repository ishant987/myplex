@props([
    'class' => '',
    'id' => '',,
    'required' => '',
    'setdefaultoption' => 'true',
    'defaultoption' => __('admin.def_drop_optn_styl1_txt'),
    'defaultoptionvalue' => '',
    'selected' => '',
    'disabled' => '',
    'readonly' => '',
    'options' => []
])
<select id="{{ $id }}" {{ $attributes->merge(['class' => 'form-control '.$class ]) }} @if($required == "true") required="required" @endif @if($disabled == "true") disabled="disabled" @endif @if($readonly == "true") readonly="readonly" @endif>
	@if($setdefaultoption)<option value="{{ $defaultoptionvalue }}">{{ $defaultoption }}</option>@endif
	@foreach ($options as $key => $value)
		<option value="{{ $key }}" {{ ( isset($selected) && $key == $selected ) ? 'selected' : '' }}> 
		{{ $value }} 
		</option>
	@endforeach  
 </select>