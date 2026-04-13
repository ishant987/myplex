@extends('themes.backend.layouts.app')
@section('fancybox') @stop
@section('multiselectAvailableSelected') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('topic.create') }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text">{{ __('askexpert.topic.add_txt') }}</h5>
      </div>
      <div class="card-block">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.topic.store')}}" method="POST">
          {{ csrf_field() }}

          <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" error="{{ $errors->first('title') }}" required="true">
            <x-form.field.text id="title" name="title" value="{{ old('title') }}" onblur="setSlugValue();" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.slug_txt') }}" for="slug" error="{{ $errors->first('slug') }}" required="true" info="{{ __('admin.info.add_slug') }}">
            <x-form.field.text id="slug" name="slug" value="{{ old('slug') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.parent_txt') }}" for="role" error="{{ $errors->first('parent') }}">
            <select id="parent" class="form-control" name="parent">
              <option value="">{{ __('admin.def_drop_optn_styl5_txt') }}</option>
              @foreach($parentDataArr as $value => $optVal )
              <option value="{{ $value }}" {{ ( $value == old('parent') ) ? 'selected' : '' }}>{{ $optVal }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>

          @if( $fldsHide['image'] == $boolFalse )
          <x-form.group_lyt1_2_10 label="{{ __('admin.featured_img_txt') }}" for="media_id" error="{{ $errors->first('media_id') }}" info="{!! __('askexpert.info.topic_featured_img') !!}">
            <div class="media_img_area">
              <x-link_media_popup href="0" src="{{ route('admin.media.gallery', 0) }}">
                {{ __('admin.browse_media_txt') }}
              </x-link_media_popup>
              <x-form.field.hidden value="" name="media_id" id="featuredImgVal-0" />
              <x-form.field.button_def class="btn-danger btn-mini waves-effect waves-light remove_featured show-scn m-t-10 d-none" id="featuredImgRemov-0" text="{{ __('admin.remove_media_txt') }}" />
            </div>
          </x-form.group_lyt1_2_10>
          @endif

          <div class="row m-b-20{{ $errors->first('assigned_to')?' has-danger':'' }}">
            <div class="col-sm-12">
              <label class="col-form-label">{{ __('admin.assigned_to_txt') }}</label>
            </div>
            <div class="col-sm-5">
              <label class="col-form-label">{{ __('askexpert.topic.available_usr_txt') }}</label>
              <select name="assigned_from[]" id="multiselect" class="form-control multiselect" size="15" multiple="multiple">
                @if(count($dataList) > 0)
                @foreach( $dataList as $key => $value )
                <option value="{{ $value->u_id }}">{{ $value->fullinfo }}</option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="col-sm-2 m-t-100">
              <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="fa fa-forward" aria-hidden="true"></i></button>
              <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
              <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
              <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="fa fa-backward" aria-hidden="true"></i></button>
            </div>
            <div class="col-sm-5">
              <label class="col-form-label">{{ __('askexpert.topic.selected_usr_txt') }}</label>
              <select name="assigned_to[]" id="multiselect_to" class="form-control multiselect" size="15" multiple="multiple"></select>
            </div>
            @if($errors->first('assigned_to'))
            <div class="col-sm-12 col-form-label">{{ $errors->first('assigned_to') }}</div>
            @endif
          </div>

          @if( $fldsHide['c_order'] == $boolFalse )
          <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" error="{{ $errors->first('c_order') }}">
            <x-form.field.text id="c_order" name="c_order" value="{{ old('c_order') > 0 ? old('c_order') : '' }}" />
          </x-form.group_lyt1_2_10>
          @endif

          <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="status" error="{{ $errors->first('status') }}" required="true">
            <select id="status" class="form-control" name="status">
              @foreach( $statusArr as $id => $status )
              <option value="{{ $id }}" {{ ( $id == old('status') ) ? 'selected' : '' }}>{{ $status }}</option>
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