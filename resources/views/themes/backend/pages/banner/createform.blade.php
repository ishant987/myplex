@extends('themes.backend.layouts.app')
@section('editor') @stop
@section('fancybox') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('banner.create') }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text">{{ __('banner.add_txt') }}</h5>
      </div>
      <div class="card-block">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

        <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.banner.store')}}" method="POST">
          {{ csrf_field() }}

          <x-form.group_lyt1_2_10 label="{{ __('admin.featured_img_txt') }}" for="media_id" error="{{ $errors->first('media_id') }}" info="{!! __('admin.info.featured_img') !!}" required="true">
            <div class="media_img_area">
              <x-link_media_popup href="0" src="{{ route('admin.media.gallery', 0) }}">
                {{ __('admin.browse_media_txt') }}
              </x-link_media_popup>
              <x-form.field.hidden value="" name="media_id" id="featuredImgVal-0" />
              <x-form.field.button_def class="btn-danger btn-mini waves-effect waves-light remove_featured show-scn m-t-10 d-none" id="featuredImgRemov-0" text="{{ __('admin.remove_media_txt') }}" />
            </div>
          </x-form.group_lyt1_2_10>

          @if($fldsHide['title'] == $boolFalse)
          <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" error="{{ $errors->first('title') }}">
            <x-form.field.text id="title" name="title" value="{{ old('title') }}" />
          </x-form.group_lyt1_2_10>
          @endif

          @if($fldsHide['descp'] == $boolFalse)
          <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="descp" error="{{ $errors->first('descp') }}">
            <x-form.field.textarea id="descp" name="descp" value="{!! old('descp') !!}" rows="8" class="editor_full" />
          </x-form.group_lyt1_2_10>
          @endif

          <x-form.group_lyt1_2_10 label="{{ __('admin.link_txt') }}" for="link" error="{{ $errors->first('link') }}">
            <x-form.field.text id="link" name="link" value="{{ old('link') }}" />
          </x-form.group_lyt1_2_10>

          @if($fldsHide['link_text'] == $boolFalse)
          <x-form.group_lyt1_2_10 label="{{ __('admin.link_text_txt') }}" for="link_text" error="{{ $errors->first('link_text') }}">
            <x-form.field.text id="link_text" name="link_text" value="{{ old('link_text') }}" />
          </x-form.group_lyt1_2_10>
          @endif

          <x-form.group_lyt1_2_10 label="{{ __('admin.target_txt') }}" for="link_target" error="{{ $errors->first('link_target') }}" info="{!! __('admin.info.link_target') !!}">
            <select id="link_target" class="form-control" name="link_target">
              <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
              @foreach( $linkTargetArr as $id => $optVal )
              <option value="{{ $optVal }}" {{ ( $optVal == old('link_target') ) ? 'selected' : '' }}>{{ $optVal }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>

          <div class="form-group has-primary row">
            <label class="col-sm-2 col-form-label">{{ __('banner.group_txt') }} <span class="required">*</span></label>
            <div class="col-sm-5">
              <x-form.field.text id="bnr_group" name="bnr_group" value="{{ old('bnr_group') != '' ? old('bnr_group') : 'group' }}" />
            </div>
            <div class="col-sm-5">
              <select id="bnr_group_dd" class="form-control" name="bnr_group_dd">
                <option value="">{{ __('admin.def_drop_optn_styl6_txt') }}</option>
                @foreach($groupArr as $value => $optValGrp )
                <option value="{{ $optValGrp }}" {{ ( $optValGrp == old('bnr_group_dd') ) ? 'selected' : '' }}>{{ $optValGrp }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" error="{{ $errors->first('c_order') }}">
            <x-form.field.text id="c_order" name="c_order" value="{{ old('c_order') > 0 ? old('c_order') : '' }}" />
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
@push('scripts')
<script>
  $("#bnr_group_dd").change(function() {
    var data = $("#bnr_group_dd").val();
    /*alert(data);*/
    /*if(data != ""){*/
    $("#bnr_group").val(data);
    /*}*/
  });
</script>
@endpush