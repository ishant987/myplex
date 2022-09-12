@props([
'id' =>'large-Modal',
'idclass' => '',
'class' => 'modal-lg'
])

<div class="modal fade {{ $idclass }}" id="{{ $id }}" tabindex="-1" role="dialog">
   <div class="modal-dialog {{ $class }}" role="document">

      {{ $slot }}

   </div>
</div>