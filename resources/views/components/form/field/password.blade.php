@props([
'id' => '',
'class' => 'form-control',
])
<input id="{{ $id }}" {{ $attributes->merge(['class' => $class ]) }} type="password">
<span toggle="#{{ $id }}" class="fa fa-fw fa-eye field-icon toggle-password"></span>