@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['route'], $dataArr) }} 
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ $editDataAtrArr['title'] }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            
            <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.media.update', $dataArr->media_id) }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               {{ method_field('PATCH') }}

              <x-form.group_lyt1_2_10 label="{{ __('media.media_file_txt') }}" for="path" error="{{ $errors->first('path') }}" required="true" info="{{ __('media.info.file_type') }}">
                @if($dataArr['path'])
                   <x-link_tooltip url="{!! $moduleAtrArr['media_folder'].$dataArr['path'] !!}" title="{!! $moduleAtrArr['view_txt'] !!}" target="{{ $moduleAtrArr['target'] }}" placement="right">
                      <x-img src="{!! $moduleAtrArr['media_folder'].$dataArr['path'] !!}" width="{{ $moduleAtrArr['img_width']['big'] }}" class="img-fluid img-thumbnail img-150 m-b-10" />
                   </x-link_tooltip>
                @endif
                <x-form.field.file id="path" name="path" />
              </x-form.group_lyt1_2_10>

              <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" 
                  error="{{ $errors->first('title') }}">
                <x-form.field.text id="title" name="title" value="{!! $dataArr['title'] !!}" />
              </x-form.group_lyt1_2_10>

              <x-form.group_lyt1_2_10 label="{{ __('media.alt_txt') }}" for="alt"
                  error="{{ $errors->first('alt') }}">
                  <x-form.field.text id="alt" name="alt" value="{!! $dataArr['alt'] !!}" />
              </x-form.group_lyt1_2_10>

              <div class="form-group has-primary row">
                <label class="col-2 col-form-label">{{ __('media.full_path_txt') }}</label>
                <div class="col-10">
                  <div class="col-form-label">
                    <x-link_tooltip url="{!! $moduleAtrArr['media_folder'].$dataArr['path'] !!}" title="{!! $moduleAtrArr['view_txt'] !!}" target="{{ $moduleAtrArr['target'] }}" placement="right">
                      {!! $moduleAtrArr['media_folder'].$dataArr['path'] !!}
                    </x-link_tooltip>
                  </div>
                </div>
              </div>

              <div class="row">
                  <div class="col-sm-12">
                     <x-form.group_lyt1_2_10 class="m-t-10">
                        <x-form.field.button id="submit" name="submit" />
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