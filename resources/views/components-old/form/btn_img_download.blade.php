@props([
    'name'=>'download_img',
    'id'=>'download_img',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.download_img_txt'),
    'form_name' => 'listDataForm',
    'message' => '',
])
<button id="{{ $id }}" {{ $attributes->merge(['class' => 'btn waves-effect waves-light btn-sm btn-primary f-right m-r-5 '.$class ]) }} type="submit" name="{{ $name }}" data-toggle="tooltip" data-placement="{{ $placement }}" data-trigger="hover" data-original-title="{{ $title }}" onclick="return bulkImageDownload(this, '{{ $form_name }}', '{{ $message }}');"><i class="icofont icofont-download-alt"></i></button>
