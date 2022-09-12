@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('scrips.create') }}
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ __('admin.scrip.add_txt') }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            <div class="row">
               <div class="col-lg-6 col-md-12">
                  <x-link url="{{ route('admin.scrips.createmanual')}}" class="btn btn-success waves-effect waves-light btn-block">
                     <strong>{{ __('admin.bulk_upload.add_manual_txt') }}</strong><br>{{ __('admin.bulk_upload.add_manual_info') }}
                  </x-link>
               </div>
               <div class="col-lg-6 col-md-12">
                  <x-form.field.button_html data-toggle="modal" data-target="#large-Modal">
                     <strong>{{ __('admin.bulk_upload.file_upload_txt') }}</strong><br>{{ __('admin.bulk_upload.file_upload_info') }}
                  </x-form.field.button_html>
               </div>
            </div>
         </div>
         <!-- end of card-block -->
      </div>
   </div>
</div>

<x-form.modal>
   <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">{{ __('admin.scrip.bulk_upload_hdng') }}</h4>
         <x-form.field.button_model></x-form.field.button_model>
      </div>
      <form id="upload_bulk_sheet_form" name="upload_bulk_sheet_form" method="post" action="{{ route('admin.scrips.uploadfile') }}" enctype="multipart/form-data">
         {{ csrf_field() }}
         <div class="modal-body">
            <h6>{{ __('admin.bulk_upload.select_file_txt') }}</h6>
            <p>{{ __('admin.bulk_upload.select_file_info') }}</p>
            <div>
               <div class="fileupload fileupload-new" data-provides="fileupload">
                  <x-form.field.file id="file_upload" name="file_upload" />
               </div>
               <div class="m-t-10">
                  <span class="help-block">{{ __('admin.bulk_upload.file_format_info') }}</span>
                  <span class="help-block">
                     <i>
                        <b>
                           <x-link url="{{ asset('themes/backend/assets/formats/scrip-bulk-upload.xlsx') }}" class="text-right f-w-600" target="_blank">
                              {{ __('common.click_here_txt') }}
                           </x-link>
                        </b> {{ __('admin.bulk_upload.demo_file_format_info') }}
                     </i>
                  </span>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <x-form.field.button type="button" data-dismiss="modal" class="btn-danger" text="{{ __('admin.cancel_txt') }}" />
            <x-form.field.button id="submit" name="submit" text="{{ __('admin.submit_txt') }}" />
         </div>
      </form>
   </div>
</x-form.modal>
@stop