@props([
'for'=>'',
'label'=>'', 
 'class'=>'',
 'error'=>''
])
<div class="form-group form-primary {{ $class}} {{ $error?'has-danger':'' }}">
  {{ $slot }}
  @if($error)
  <div class="col-form-label">{{ $error }}</div>
  @endif
  <span class="form-bar"></span>
  <label for="{{ $for?$for:'' }}" class="float-label">{{ $label?$label:'' }}</label>
</div>