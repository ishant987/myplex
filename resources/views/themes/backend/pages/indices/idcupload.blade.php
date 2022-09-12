@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('indices.values.create') }}
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ __('admin.indices.upld_daily_txt') }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            <form id="upload_bulk_sheet_form" name="upload_bulk_sheet_form" method="post" action="{{ route('admin.indices.values.store') }}" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="row">
                  <div class="col-sm-12">
                     <div class="modal-body">
                        <h6>{{ __('admin.bulk_upload.select_file_txt') }}</h6>
                        <div>
                           <div class="fileupload fileupload-new" data-provides="fileupload">
                              <x-form.field.file id="file_upload" name="file_upload" />
                           </div>
                           <div class="m-t-10 has-primary">
                              <span class="col-form-label info">
                                 <x-link url="{{ asset('themes/backend/assets/formats/upload-daily-indices-value.csv') }}" class="b-b-primary text-primary" target="_blank">{{ __('common.click_here_txt') }}</x-link>{{ __('admin.bulk_upload.dwnld_csv_file_format_info') }}
                              </span>
                           </div>
                           <div class="m-t-10 has-primary">
                              <span class="col-form-label info">{!! __('admin.indices.file_format_info') !!}</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <x-form.group_lyt1_2_10 class="m-t-10">
                        <x-form.field.button id="submit" name="submit" text="{{ __('admin.upload_txt') }}" value="upload" />
                        <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}" />
                        <x-form.field.button_def name="submit" text="{{ __('admin.load_previous_txt') }}" class="btn btn-md btn-out-dashed waves-effect waves-light btn-info btn-square m-l-50" onclick="return confirm('{{ __('message.confirm.holiday') }}')?confirm('{{ __('message.confirm.click_ok_txt') }}'):false" type="submit" value="holiday" />
                     </x-form.group_lyt1_2_10>
                  </div>
               </div>
            </form>
         </div>
         <!-- end of card-block -->
      </div>
   </div>
</div>
@stop