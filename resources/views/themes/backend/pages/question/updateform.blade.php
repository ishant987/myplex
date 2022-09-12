@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['route'], $dataArr) }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text">{{ $editDataAtrArr['title']}}</h5>
      </div>
      <div class="card-block">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

        <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.question.update', $dataArr->aeq_id) }}" method="POST">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

          <x-form.group_lyt1_2_10 label="{{ __('askexpert.question.label_txt') }}" for="title" error="{{ $errors->first('title') }}" required="true" info="{!! __('admin.info.descp') !!}">
            <x-form.field.textarea id="question" name="question" value="{!! $dataArr->question !!}" rows="8" />
          </x-form.group_lyt1_2_10>

          <x-form.section_label>{{ __('askexpert.pictures_txt') }}</x-form.section_label>

          <x-form.group_lyt1_2_10 label="{{ __('askexpert.picture1_txt') }}">
            @if($dataArr->image1)
            <x-img src="{{ $moduleAtrArr['media_folder'].$dataArr->image1 }}" class="m-b-10 img-fluid" />
            @endif
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('askexpert.picture2_txt') }}">
            @if($dataArr->image2)
            <x-img src="{{ $moduleAtrArr['media_folder'].$dataArr->image2 }}" class="m-b-10 img-fluid" />
            @endif
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('askexpert.picture3_txt') }}">
            @if($dataArr->image3)
            <x-img src="{{ $moduleAtrArr['media_folder'].$dataArr->image3 }}" class="m-b-10 img-fluid" />
            @endif
          </x-form.group_lyt1_2_10>

          <x-form.section_label>{{ __('askexpert.video_txt') }}</x-form.section_label>

          @if($dataArr->video_from && $dataArr->video_data)
          @switch($dataArr->video_from)
          @case($moduleAtrArr['video_type']['0'])
          <x-form.group_lyt1_2_10 label="{{ __('askexpert.local_file_txt') }}">
            {{ \App\Lib\Core\Core::htmlVideoPlayer($moduleAtrArr['media_folder'].$dataArr->video_data) }}
          </x-form.group_lyt1_2_10>
          @break
          @case($moduleAtrArr['video_type']['1'])
          <x-form.group_lyt1_2_10 label="{{ __('askexpert.yt_share_link_text') }}">
            <div class="ytubeVideo">
              {{ \App\Lib\Core\Core::ytubePlayer($moduleAtrArr['media_folder'].$dataArr->video_data) }}
            </div>
          </x-form.group_lyt1_2_10>
          @break
          @endswitch
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