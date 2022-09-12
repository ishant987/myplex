@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('aums.values.create') }}
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ __('admin.fund.aums.upld_lbl_txt') }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            <form id="upload_bulk_sheet_form" name="upload_bulk_sheet_form" method="post" action="{{ route('admin.aums.values.store') }}" enctype="multipart/form-data">
               {{ csrf_field() }}
               <x-form.group_lyt1_2_10 label="{{ __('admin.save_values_m_y_txt') }}" for="entry_month" error="{{ $errors->first('entry_month') }}" required="true">
                  <div class="row">
                     <div class="col-sm-6">
                        <select id="entry_month" class="form-control" name="entry_month">
                           <option value="">{{ __('admin.month_def_opt_txt') }}</option>
                           @if(!empty($otherData['months_list']))
                           @foreach ($otherData['months_list'] as $key => $mValue)
                           <option value="{{ $key }}" {{ ( $key == old('entry_month') ) ? 'selected' : '' }}>{{ $mValue }}</option>
                           @endforeach
                           @endif
                        </select>
                     </div>
                     <div class="col-sm-6">
                        <select id="entry_year" class="form-control" name="entry_year">
                           @if(!empty($otherData['year_list']))
                           @foreach ($otherData['year_list'] as $yValue)
                           <option value="{{ $yValue }}" {{ ( $yValue == old('entry_year') ) ? 'selected' : '' }}>{{ $yValue }}</option>
                           @endforeach
                           @endif
                        </select>
                     </div>
                  </div>
               </x-form.group_lyt1_2_10>
               <div class="form-group has-primary row">
                  <label class="col-sm-2 col-form-label">{{ __('admin.last_save_txt') }}</label>
                  <div class="col-sm-10">
                     <div class="col-form-label">{{ $otherData['last_saved_date'] }}</div>
                  </div>
               </div>
               <x-form.group_lyt1_2_10 label="{{ __('admin.file_txt') }}" for="file_upload" error="{{ $errors->first('file_upload') }}" info="{!! __('admin.fund.aums.file_format_info') !!}" required="true">
                  <x-form.field.file id="file_upload" name="file_upload" />
               </x-form.group_lyt1_2_10>
               <div class="row">
                  <div class="col-sm-12">
                     <x-form.group_lyt1_2_10 class="m-t-10">
                        <x-form.field.button id="submit" name="submit" text="{{ __('admin.upload_txt') }}" value="upload" />
                        <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}" />
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