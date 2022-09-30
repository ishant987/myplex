@extends('themes.backend.layouts.app')
@section('fancybox') @stop

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['breadcrumb'], $dataArr) }}
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

        <form name="eDataFrm" id="eDataFrm" action="{{ route($editDataAtrArr['update_route'], $dataArr->cc_id) }}" method="POST">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

          <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" error="{{ $errors->first('title') }}" required="true">
            <x-form.field.text id="title" name="title" value="{{ $dataArr->title }}" />
          </x-form.group_lyt1_2_10>

          @if( $fldsHide['slug'] == $boolFalse )
          <x-form.group_lyt1_2_10 label="{{ __('admin.slug_txt') }}" for="slug" error="{{ $errors->first('slug') }}" required="true" info="{{ __('admin.info.edit_slug') }}">
            <x-form.field.text id="slug" name="slug" value="{{ $dataArr->slug }}" readonly="true" onclick="updateSlugValue();" />
          </x-form.group_lyt1_2_10>
          @endif

          @if( $fldsHide['parent'] == $boolFalse )
          <x-form.group_lyt1_2_10 label="{{ __('admin.parent_txt') }}" for="role" error="{{ $errors->first('parent') }}">
            <select id="parent" class="form-control" name="parent">
              <option value="">{{ __('admin.def_drop_optn_styl5_txt') }}</option>
              @foreach($parentCatArr as $value => $optTitle )
              <option value="{{ $value }}" @if( old('parent')==$value ) {{ 'selected' }} @elseif( $dataArr->parent == $value ) {{ 'selected' }} @endif>{{ $optTitle }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>
          @endif

          @if( $fldsHide['descp'] == $boolFalse )
          <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="descp" error="{{ $errors->first('descp') }}" info="{!! __('admin.info.descp') !!}">
            <x-form.field.textarea id="descp" name="descp" value="{!! $dataArr['descp'] !!}" rows="8" />
          </x-form.group_lyt1_2_10>
          @endif

          @if( $fldsHide['image'] == $boolFalse )
          <x-form.group_lyt1_2_10 label="{{ __('admin.featured_img_txt') }}" for="media_id" error="{{ $errors->first('media_id') }}" info="{!! __('admin.info.featured_img') !!}">
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
          @endif

          @if( $fldsHide['c_order'] == $boolFalse )
          <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" error="{{ $errors->first('c_order') }}">
            <x-form.field.text id="c_order" name="c_order" value="{{ $dataArr->c_order > 0 ? $dataArr->c_order : '' }}" />
          </x-form.group_lyt1_2_10>
          @endif

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