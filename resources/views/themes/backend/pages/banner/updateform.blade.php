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

        <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.banner.update', $dataArr->bnr_id) }}" method="POST">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

          <x-form.group_lyt1_2_10 label="{{ __('admin.featured_img_txt') }}" for="media_id" error="{{ $errors->first('media_id') }}" info="{!! __('admin.info.featured_img') !!}" required="true">
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

          @if($fldsHide['title'] == $boolFalse)
          <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" error="{{ $errors->first('title') }}">
            <x-form.field.text id="title" name="title" value="{{ $dataArr->title }}" />
          </x-form.group_lyt1_2_10>
          @endif

          @if($fldsHide['descp'] == $boolFalse)
          <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="descp" error="{{ $errors->first('descp') }}">
            <x-form.field.textarea id="descp" name="descp" value="{!! $dataArr['descp'] !!}" rows="8" class="editor_full" />
          </x-form.group_lyt1_2_10>
          @endif

          <x-form.group_lyt1_2_10 label="{{ __('admin.link_txt') }}" for="link" error="{{ $errors->first('link') }}">
            <x-form.field.text id="link" name="link" value="{{ $dataArr->link }}" />
          </x-form.group_lyt1_2_10>

          @if($fldsHide['link_text'] == $boolFalse)
          <x-form.group_lyt1_2_10 label="{{ __('admin.link_text_txt') }}" for="link_text" error="{{ $errors->first('link_text') }}">
            <x-form.field.text id="link_text" name="link_text" value="{{ $dataArr->link_text }}" />
          </x-form.group_lyt1_2_10>
          @endif

          <x-form.group_lyt1_2_10 label="{{ __('admin.target_txt') }}" for="link_target" error="{{ $errors->first('link_target') }}" info="{!! __('admin.info.link_target') !!}">
            <select id="link_target" class="form-control" name="link_target">
              <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
              @foreach( $linkTargetArr as $id => $optVal )
              <option value="{{ $optVal }}" @if( old('link_target')==$optVal ) {{ 'selected' }} @elseif( $dataArr->link_target == $optVal ) {{ 'selected' }} @endif>{{ $optVal }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>

          <div class="form-group has-primary row">
            <label class="col-sm-2 col-form-label">{{ __('banner.group_txt') }} <span class="required">*</span></label>
            <div class="col-sm-5">
              <x-form.field.text id="bnr_group" name="bnr_group" value="{{ $dataArr->bnr_group }}" />
            </div>
            <div class="col-sm-5">
              <select id="bnr_group_dd" class="form-control" name="bnr_group_dd">
                <option value="">{{ __('admin.def_drop_optn_styl6_txt') }}</option>
                @foreach($groupArr as $value => $optValGrp )
                <option value="{{ $optValGrp }}" @if( old('bnr_group_dd')==$optValGrp ) {{ 'selected' }} @elseif( $dataArr->bnr_group == $optValGrp ) {{ 'selected' }} @endif>{{ $optValGrp }}</option>
                @endforeach
              </select>
            </div>
          </div>

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