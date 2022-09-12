@extends('themes.backend.layouts.app')
@section('editor') @stop
@section('fancybox') @stop

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

        <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.testimonial.update', $dataArr->tmnl_id) }}" method="POST">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

          <x-form.group_lyt1_2_10 label="{{ __('testimonial.name_txt') }}" for="name" error="{{ $errors->first('name') }}" required="true">
            <x-form.field.text id="name" name="name" value="{{ $dataArr->name }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('testimonial.designation_txt') }}" for="designation" error="{{ $errors->first('designation') }}">
            <x-form.field.text id="designation" name="designation" value="{{ $dataArr->designation }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('testimonial.company_txt') }}" for="company" error="{{ $errors->first('company') }}">
            <x-form.field.text id="company" name="company" value="{{ $dataArr->company }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="descp" error="{{ $errors->first('descp') }}">
            <x-form.field.textarea id="descp" name="descp" value="{!! $dataArr->descp !!}" rows="8" class="editor" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('testimonial.prof_pic_txt') }}" for="media_id" error="{{ $errors->first('media_id') }}" info="{!! __('testimonial.info.prof_pic') !!}">
            <div class="media_img_area">
              <x-link_media_popup href="0" src="{{ route('admin.media.gallery', 0) }}">
                @if( $dataArr->media_id > 0 && !empty( $dataArr->media ) )
                <x-img src="{{ $dataArr->media->getModuleVars()['media_folder'].$dataArr->media->path }}" class="img-fluid img-thumbnail img-100 display-media" alt="{{ $dataArr->media->alt }}" title="{{ $dataArr->media->title }}" data_id="{{ $dataArr->media_id }}" />
                @else
                {{ __('admin.browse_media_txt') }}
                @endif
              </x-link_media_popup>
              <x-form.field.hidden value="{{ $dataArr->media_id }}" name="media_id" id="featuredImgVal-0" />
              <x-form.field.button_def class="btn-danger btn-mini waves-effect waves-light remove_featured show-scn m-t-10{{ ( $dataArr->media_id > 0 &&  !empty( $dataArr->media ) ) ? '' : ' d-none' }}" id="featuredImgRemov-0" text="{{ __('admin.remove_media_txt') }}" />
            </div>
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" error="{{ $errors->first('c_order') }}">
            <x-form.field.text id="c_order" name="c_order" value="{{ $dataArr->c_order > 0 ? $dataArr->c_order : '' }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="role" error="{{ $errors->first('status') }}" required="true">
            <select name="status" id="status" class="form-control">
              @foreach( $statusArr as $id => $status )
              <option value="{{ $id }}" @if((old('status')> 0) && ($id == old('status'))) {{ 'selected' }} @elseif((($dataArr->status > 0) && ($id == $dataArr->status))) {{ 'selected' }} @endif>{{ $status }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>

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