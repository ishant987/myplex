@props([
    'name'=>'delete',
    'id'=>'delete',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.multiple_delete_txt'),
    'form_name' => 'listDataForm',
    'message' => '',
])
<button id="{{ $id }}" {{ $attributes->merge(['class' => 'btn waves-effect waves-light btn-sm btn-danger f-right m-r-5 '.$class ]) }} type="submit" name="{{ $name }}" data-toggle="tooltip" data-placement="{{ $placement }}" data-trigger="hover" data-original-title="{{ $title }}" onclick="return bulkDelete(this, '{{ $form_name }}', '{{ $message }}');"><i class="icofont icofont-ui-delete"></i></button>