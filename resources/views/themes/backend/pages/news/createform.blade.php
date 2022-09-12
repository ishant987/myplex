@extends('themes.backend.layouts.app')
@section('editor') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('news.create') }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text">{{ __('news.add_txt') }}</h5>
      </div>
      <div class="card-block">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

        <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.news.store')}}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}

          <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" error="{{ $errors->first('title') }}" required="true">
            <x-form.field.text id="title" name="title" value="{{ old('title') }}" onblur="setSlugValue();" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.slug_txt') }}" for="slug" error="{{ $errors->first('slug') }}" required="true" info="{!! __('admin.info.add_slug') !!}">
            <x-form.field.text id="slug" name="slug" value="{{ old('slug') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="description" error="{{ $errors->first('description') }}">
            <x-form.field.textarea id="description" name="description" value="{!! old('description') !!}" rows="7" class="editor_full" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('news.media_txt') }}" for="media_type" error="{{ $errors->first('media_type') }}">
            <select id="media_type" class="form-control" name="media_type">
              <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
              @foreach($moduleAtrArr['media_type']['value'] as $key => $optValMt )
              <option value="{{ $optValMt }}" {{ ( $optValMt == old('media_type') ) ? 'selected' : '' }}>{{ $moduleAtrArr['media_type']['text'][$optValMt] }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>

          <div class="{{ old('media_type') == $moduleAtrArr['media_type']['value']['0'] ? "show-scn" : "hide-scn" }}" id="img_div">
            <x-form.group_lyt1_2_10 label="{{ __('admin.featured_img_txt') }}" for="image" error="{{ $errors->first('image') }}" required="true" info="{!! __('news.info.image') !!}">
              <x-form.field.file id="image" name="image" />
            </x-form.group_lyt1_2_10>
          </div>

          <div class="{{ old('media_type') == $moduleAtrArr['media_type']['value']['1'] ? "show-scn" : "hide-scn" }}" id="video_div">
            <x-form.group_lyt1_2_10 label="{{ __('news.video_from_txt') }}" for="video_from" error="{{ $errors->first('video_from') }}" required="true">
              <select id="video_from" class="form-control" name="video_from">
                <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
                @foreach($moduleAtrArr['video_type']['value'] as $key => $optValVt )
                <option value="{{ $optValVt }}" {{ ( $optValVt == old('video_from') ) ? 'selected' : '' }}>{{ $moduleAtrArr['video_type']['text'][$optValVt] }}</option>
                @endforeach
              </select>
            </x-form.group_lyt1_2_10>

            <div class="{{ old('video_from') == $moduleAtrArr['video_type']['value']['0'] ? "show-scn" : "hide-scn" }}" id="lcl_video_div">
              <x-form.group_lyt1_2_10 label="{{ __('news.video_file_txt') }}" for="video_file" error="{{ $errors->first('video_file') }}" required="true" info="{!! __('news.info.video') !!}">
                <x-form.field.file id="video_file" name="video_file" />
              </x-form.group_lyt1_2_10>
            </div>

            <div class="{{ old('video_from') == $moduleAtrArr['video_type']['value']['1'] ? "show-scn" : "hide-scn" }}" id="ytube_video_div">
              <x-form.group_lyt1_2_10 label="{{ __('news.youtube_code_txt') }}" for="youtube_code" error="{{ $errors->first('youtube_code') }}" required="true" info="{!! __('news.info.youtube_code') !!}">
                <x-form.field.text id="youtube_code" name="youtube_code" value="{{ old('youtube_code') }}" type="url" />
              </x-form.group_lyt1_2_10>
            </div>

            <div class="{{ old('media_type') == $moduleAtrArr['media_type']['value']['1'] ? "show-scn" : "hide-scn" }}" id="video_image_div">
              <x-form.group_lyt1_2_10 label="{{ __('news.video_image_txt') }}" for="video_image" error="{{ $errors->first('video_image') }}" info="{!! __('news.info.video_image') !!}">
                <x-form.field.file id="video_image" name="video_image" />
              </x-form.group_lyt1_2_10>
            </div>
          </div>

          <x-form.group_lyt1_2_10 label="{{ __('news.source_txt') }}" for="news_source" error="{{ $errors->first('news_source') }}">
            <x-form.field.text id="news_source" name="news_source" value="{{ old('news_source') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('news.source_link') }}" for="news_source_link" error="{{ $errors->first('news_source_link') }}" info="{!! __('admin.info.valid_url') !!}">
            <x-form.field.text id="news_source_link" name="news_source_link" value="{{ old('news_source_link') }}" type="url" />
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