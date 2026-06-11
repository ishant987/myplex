@props([
    'class' => ''
])
<button type="button" {{ $attributes->merge(['class' => 'close '.$class ]) }} data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>