@extends('themes.backend.layouts.app')
@section('fancybox') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('team.create') }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text">{{ __('admin.team.add_txt') }}</h5>
      </div>
      <div class="card-block">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

        <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.team.store')}}" method="POST">
          {{ csrf_field() }}

          <x-form.group_lyt1_2_10 label="{{ __('admin.team.name_txt') }}" for="name" error="{{ $errors->first('name') }}" required="true">
            <x-form.field.text id="name" name="name" value="{{ old('name') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.prof_pic_txt') }}" for="media_id" error="{{ $errors->first('media_id') }}" info="{!! __('admin.team.prof_pic_info') !!}">
            <div class="media_img_area">
              <x-link_media_popup href="0" src="{{ route('admin.media.gallery', 0) }}">
                {{ __('admin.browse_media_txt') }}
              </x-link_media_popup>
              <x-form.field.hidden value="" name="media_id" id="featuredImgVal-0" />
              <x-form.field.button_def class="btn-danger btn-mini waves-effect waves-light remove_featured show-scn m-t-10 d-none" id="featuredImgRemov-0" text="{{ __('admin.remove_media_txt') }}" />
            </div>
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.designation_txt') }}" for="designation" error="{{ $errors->first('designation') }}">
            <x-form.field.text id="designation" name="designation" value="{{ old('designation') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.team.linkedin_link_txt') }}" for="linkedin_link" error="{{ $errors->first('linkedin_link') }}" info="{!! __('admin.info.valid_url') !!}">
            <x-form.field.text id="linkedin_link" name="linkedin_link" value="{{ old('linkedin_link') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" error="{{ $errors->first('c_order') }}" info="{!! __('admin.info.number') !!}">
            <x-form.field.text type="number" id="c_order" name="c_order" value="{{ old('c_order') > 0 ? old('c_order') : '' }}" />
          </x-form.group_lyt1_2_10>

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