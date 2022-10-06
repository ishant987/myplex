@extends('themes.backend.layouts.app')
@section('editor') @stop

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

        <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.news.update', $dataArr->n_id) }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

          <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" error="{{ $errors->first('title') }}" required="true">
            <x-form.field.text id="title" name="title" value="{{ $dataArr['title'] }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.slug_txt') }}" for="slug" error="{{ $errors->first('slug') }}" required="true" info="{!! __('admin.info.edit_slug') !!}">
            <x-form.field.text id="slug" name="slug" value="{{ $dataArr->slug }}" readonly="true" onclick="updateSlugValue();" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="description" error="{{ $errors->first('description') }}">
            <x-form.field.textarea id="description" name="description" value="{!! $dataArr['description'] !!}" rows="7" class="editor_full" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('news.media_txt') }}" for="media_type" error="{{ $errors->first('media_type') }}">
            <select id="media_type" class="form-control" name="media_type">
              <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
              @foreach($moduleAtrArr['media_type']['value'] as $key => $optValMt )
              <option value="{{ $optValMt }}" @if( $optValMt==old('media_type') ) {{ 'selected' }} @elseif( $optValMt==$dataArr['media_type'] ) {{ 'selected' }} @endif>{{ $moduleAtrArr['media_type']['text'][$optValMt] }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>

          <div class="@if(old('media_type') == $moduleAtrArr['media_type']['value']['0']) {{ "show-scn" }} @elseif($dataArr['media_type'] == $moduleAtrArr['media_type']['value']['0']) {{ "show-scn" }} @else {{ "hide-scn" }} @endif" id="img_div">
            <x-form.group_lyt1_2_10 label="{{ __('admin.featured_img_txt') }}" for="image" error="{{ $errors->first('image') }}" required="true" info="{!! __('news.info.image') !!}">
              @if($dataArr['image'])
              <x-link_tooltip url="{{ $moduleAtrArr['media_folder'].$dataArr['image'] }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" placement="right">
                <x-img src="{{ $moduleAtrArr['media_folder'].$dataArr['image'] }}" width="{{ $moduleAtrArr['img_width']['mid'] }}" class="img-fluid img-thumbnail img-100 m-b-10" />
              </x-link_tooltip>
              @endif
              <x-form.field.file id="image" name="image" />
            </x-form.group_lyt1_2_10>
          </div>

          <div class="@if(old('media_type') == $moduleAtrArr['media_type']['value']['1']) {{ "show-scn" }} @elseif($dataArr['media_type'] == $moduleAtrArr['media_type']['value']['1']) {{ "show-scn" }} @else {{ "hide-scn" }} @endif" id="video_div">

            <x-form.group_lyt1_2_10 label="{{ __('news.video_from_txt') }}" for="video_from" error="{{ $errors->first('video_from') }}" required="true">
              <select id="video_from" class="form-control" name="video_from">
                <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
                @foreach($moduleAtrArr['video_type']['value'] as $key => $optValVt )
                <option value="{{ $optValVt }}" @if($optValVt==old('video_from')) {{ 'selected' }} @elseif($optValVt==$dataArr['video_from']) {{ 'selected' }} @endif>{{ $moduleAtrArr['video_type']['text'][$optValVt] }}</option>
                @endforeach
              </select>
            </x-form.group_lyt1_2_10>

            <div class="@if(old('video_from') == $moduleAtrArr['video_type']['value']['0']) {{ "show-scn" }} @elseif($dataArr['video_from'] == $moduleAtrArr['video_type']['value']['0']) {{ "show-scn" }} @else {{ "hide-scn" }} @endif" id="lcl_video_div">
              <x-form.group_lyt1_2_10 label="{{ __('news.video_file_txt') }}" for="video_file" error="{{ $errors->first('video_file') }}" required="true" info="{!! __('news.info.video') !!}">
                @if($dataArr['video_data'] != '' && $dataArr['video_from'] == $moduleAtrArr['video_type']['value']['0'])
                <x-link_tooltip url="{{ $moduleAtrArr['media_folder'].$dataArr['video_data'] }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" class="f-30 m-b-10" placement="right">
                  <i class="fa fa-file-movie-o"></i>
                </x-link_tooltip>
                @endif
                <x-form.field.file id="video_file" name="video_file" />
              </x-form.group_lyt1_2_10>
            </div>

            <div class="@if(old('video_from') == $moduleAtrArr['video_type']['value']['1']) {{ "show-scn" }} @elseif($dataArr['video_from'] == $moduleAtrArr['video_type']['value']['1']) {{ "show-scn" }} @else {{ "hide-scn" }} @endif" id="ytube_video_div">
              <x-form.group_lyt1_2_10 label="{{ __('news.youtube_code_txt') }}" for="youtube_code" error="{{ $errors->first('youtube_code') }}" required="true" info="{!! __('news.info.youtube_code') !!}">
                <x-form.field.text id="youtube_code" name="youtube_code" value="{{ $dataArr['video_from'] == $moduleAtrArr['video_type']['value']['1'] ? $dataArr['video_data'] : '' }}" />
              </x-form.group_lyt1_2_10>
            </div>

            <div class="@if(old('media_type') == $moduleAtrArr['media_type']['value']['1']) {{ "show-scn" }} @elseif($dataArr['media_type'] == $moduleAtrArr['media_type']['value']['1']) {{ "show-scn" }} @else {{ "hide-scn" }} @endif" id="video_image_div">
              <x-form.group_lyt1_2_10 label="{{ __('news.video_image_txt') }}" for="video_image" error="{{ $errors->first('video_image') }}" info="{!! __('news.info.video_image') !!}">
                @if($dataArr['video_image'])
                <div class="m-b-10">
                  <x-link_tooltip url="{{ $moduleAtrArr['media_folder'].$dataArr['video_image'] }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" placement="right">
                    <x-img src="{{ $moduleAtrArr['media_folder'].$dataArr['video_image'] }}" width="{{ $moduleAtrArr['img_width']['mid'] }}" class="img-fluid img-thumbnail img-100" />
                  </x-link_tooltip>
                </div>
                <x-link class="btn waves-effect waves-light delLink btn-danger btn-mini m-b-10 delLink" url="{{ route('admin.news.deletefile', [$dataArr->n_id, $dataArr['video_image'], 'video_image']) }}">
                  {{ __('admin.remove_txt') }}
                </x-link>
                @endif
                <x-form.field.file id="video_image" name="video_image" />
              </x-form.group_lyt1_2_10>
            </div>
          </div>

          <x-form.group_lyt1_2_10 label="{{ __('news.source_txt') }}" for="news_source" error="{{ $errors->first('news_source') }}">
            <x-form.field.text id="news_source" name="news_source" value="{{ $dataArr['news_source'] }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('news.source_link') }}" for="news_source_link" error="{{ $errors->first('news_source_link') }}" info="{!! __('admin.info.valid_url') !!}">
            <x-form.field.text id="news_source_link" name="news_source_link" value="{{ $dataArr['news_source_link'] }}" type="url" />
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
<script src="{{asset('themes/backend/js/news.script.js')}}"></script>
<script>
  // File types validate
  var file = document.getElementById('image');
  file.onchange = function(e) {
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch (ext) {
      case 'jpg':
      case 'jpeg':
      case 'png':
        break;
      default:
        alert('{{ __('
          message.warning.validate_file_type ') }}');
        this.value = '';
    }
  };
  var videoFile = document.getElementById('video_file');
  videoFile.onchange = function(e) {
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch (ext) {
      case 'mp4':
        break;
      default:
        alert('{{ __('
          message.warning.validate_file_type ') }}');
        this.value = '';
    }
  };
  var videoImage = document.getElementById('video_image');
  videoImage.onchange = function(e) {
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch (ext) {
      case 'jpg':
      case 'jpeg':
      case 'png':
        break;
      default:
        alert('{{ __('
          message.warning.validate_file_type ') }}');
        this.value = '';
    }
  };
</script>
@endpush