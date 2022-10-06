@extends('themes.frontend.layouts.app')
@section('select2') @stop
@section('captcha') @stop
@section('jquery-validate') @stop
@if(isset($dataArr['meta_title']))
@section('page-title'){{$dataArr['meta_title']}}@stop
@else
@section('page-title'){{$dataArr['title']}}@stop
@endif
@if(isset($dataArr['meta_key']))
@section('meta-keywords'){{$dataArr['meta_key']}}@stop
@endif
@if(isset($dataArr['meta_descp']))
@section('meta-description'){{$dataArr['meta_descp']}}@stop
@endif
@if(isset($dataArr['image_path']))
@section('meta-image'){{$dataArr['image_path']}}@stop
@push('styles')
<style>
  .custom-banner {
    background-image: url('{{ $dataArr['image_path'] }}');
  }
</style>
@endpush
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif
@section('content')
<div class="custom-banner no-bg ask-question-banner">
  <div class="container">
    @if ($dataArr['descp'])
    <h1 class="f-b">{!! $dataArr['descp'] !!}</h1>
    @endif
  </div>
</div>

<div class="ask-expert-main">
  <div class="ask-expert-sec">
    <div class="container">
      <h3>{!! $dataArr['title'] !!}</h3>
      <div class="ask-expert-cols">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-12">
            @if (isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_60']))
            <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_60']['value'] }}" class="img-fluid" />
            @endif
            @if (isset($dataArr['custom_fields']['text_61']))
            <p>{!! nl2br($dataArr['custom_fields']['text_61']['value']) !!}</p>
            @endif
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12">
            @if (isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_62']))
            <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_62']['value'] }}" class="img-fluid" />
            @endif
            @if (isset($dataArr['custom_fields']['text_63']))
            <p>{!! nl2br($dataArr['custom_fields']['text_63']['value']) !!}</p>
            @endif
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12">
            @if (isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_64']))
            <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_64']['value'] }}" class="img-fluid" />
            @endif
            @if (isset($dataArr['custom_fields']['text_65']))
            <p>{!! nl2br($dataArr['custom_fields']['text_65']['value']) !!}</p>
            @endif
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12">
            @if (isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_66']))
            <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_66']['value'] }}" class="img-fluid" />
            @endif
            @if (isset($dataArr['custom_fields']['text_67']))
            <p>{!! nl2br($dataArr['custom_fields']['text_67']['value']) !!}</p>
            @endif
          </div>
        </div>
      </div>

      <div class="ask-expert-form select2-styles">
        <form name="quesForm" id="quesForm" action="{{ route('web.ask-question.save') }}" method="post" class="quesForm" enctype="multipart/form-data">
          {{ csrf_field() }}
          <x-form.field.hidden name="recaptcha_v3" id="recaptcha_v3" />

          <div class="ask-expert-topic common-top{{ $errors->first('aet_id')?' has-danger':'' }}">
            <label>{{ __('askexpert.topic_txt') }}<sup class="asterisk">*</sup></label>
            <div class="col-12 px-0">
              <select class="js-example-placeholder-single js-states form-control" name="aet_id" id="aet_id">
                <option value="">{{ __('web.def_drop_optn_txt') }}</option>
                @foreach($topicsModel as $key => $value)
                <option value="{{ $value->aet_id }}">{{ $value->title }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="ask-expert-question common-top other_title{{ $errors->first('title')?' has-danger':'' }}">
            <div class="col-12 px-0">
              <label>{{ __('askexpert.topic_other_txt') }}<sup class="asterisk">*</sup></label>
              <input type="text" id="title" name="title" class="br-5 box-shadow" value="{{ old('title') }}">
            </div>
          </div>

          <div class="ask-expert-question common-top{{ $errors->first('question')?' has-danger':'' }}">
            <div class="col-12 px-0">
              <label>{{ __('askexpert.question_txt') }}<sup class="asterisk">*</sup></label>
              <textarea id="question" name="question" rows="10" class="br-5 box-shadow">{{ old('question') }}</textarea>
            </div>
          </div>

          <div class="ask-expert-picture">

            <div class="col-12 px-0 common-top{{ $errors->first('question')?' has-danger':'' }}">
              <h6>{{ __('askexpert.pictures_txt') }}</h6>
              <label>{{ __('askexpert.picture1_txt') }}</label>
              <div class="register-analysis-bottom">
                <div class="col-12 register-analysis-file px-0">
                  <div class="file-upload">
                    <div class="file-upload-select-cm file-upload-select-2 box-shadow br-5">
                      <div class="file-select-button">Browse</div>
                      <div class="file-select-name-2">No file chosen...</div>
                      <input type="file" name="picture1" id="picture1" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <span class="message">{{ __('askexpert.picture_info_txt') }}</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 px-0 common-top{{ $errors->first('question')?' has-danger':'' }}">
              <label>{{ __('askexpert.picture2_txt') }}</label>
              <div class="register-analysis-bottom">
                <div class="col-12 register-analysis-file px-0">
                  <div class="file-upload">
                    <div class="file-upload-select-cm file-upload-select-3 box-shadow br-5">
                      <div class="file-select-button">Browse</div>
                      <div class="file-select-name-3">No file chosen...</div>
                      <input type="file" name="picture2" id="picture2" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <span class="message">{{ __('askexpert.picture_info_txt') }}</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 px-0 common-top{{ $errors->first('question')?' has-danger':'' }}">
              <label>{{ __('askexpert.picture3_txt') }}</label>
              <div class="register-analysis-bottom">
                <div class="col-12 register-analysis-file px-0">
                  <div class="file-upload">
                    <div class="file-upload-select-cm file-upload-select-4 box-shadow br-5">
                      <div class="file-select-button">Browse</div>
                      <div class="file-select-name-4">No file chosen...</div>
                      <input type="file" name="picture3" id="picture3" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <span class="message">{{ __('askexpert.picture_info_txt') }}</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="ask-expert-picture ask-expert-video{{ $errors->first('video_type')?' has-danger':'' }}">
              <div class="col-12 px-0 common-top">
                <h6>{{ __('askexpert.video_txt') }}</h6>
                <label>{{ __('askexpert.video_type_txt') }}</label>
                <div class="register-analysis-bottom">
                  <div class="col-12 px-0">
                    <select class="js-example-placeholder-single js-states form-control" name="video_type" id="video_type">
                      <option value="">{{ __('web.def_drop_optn_txt') }}</option>
                      <option value="{{ $defDataArr['video_types']['value']['0'] }}">{{ $defDataArr['video_types']['text']['l'] }}</option>
                      <option value="{{ $defDataArr['video_types']['value']['1'] }}">{{ $defDataArr['video_types']['text']['y'] }}</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 px-0 common-top video_type local_video{{ $errors->first('local_video')?' has-danger':'' }}">
              <label>{{ __('askexpert.local_file_txt') }}<sup class="asterisk">*</sup></label>
              <div class="register-analysis-bottom">
                <div class="col-12 register-analysis-file px-0">
                  <div class="file-upload">
                    <div class="file-upload-select-cm file-upload-select-5 box-shadow br-5">
                      <div class="file-select-button">Browse</div>
                      <div class="file-select-name-5">No file chosen...</div>
                      <input type="file" name="local_video" id="local_video" accept="video/mp4">
                    </div>
                    <span class="message">{{ __('askexpert.local_video_info_txt') }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="ask-expert-question common-top video_type yt_video{{ $errors->first('yt_video')?' has-danger':'' }}">
              <div class="col-12 px-0">
                <label>{{ __('askexpert.yt_share_link_text') }}<sup class="asterisk">*</sup></label>
                <input type="text" id="yt_video" name="yt_video" class="br-5 box-shadow" value="{{ old('yt_video') }}">
                <span class="message">{{ __('askexpert.yt_share_info_txt') }}</span>
              </div>
            </div>

          </div>

          <div class="ask-expert-submit">
            <input type="submit" id="ask-expert-submit" name="askQstBtn" value="{{ __('askexpert.ask_question_txt') }}" id="ask-expert-submit" />
          </div>

        </form>
        {{-- Alert message start --}}
        @if(session()->has('alert'))
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        @endif
        {{-- Alert message end --}}
      </div>

    </div>
  </div>
</div>
@stop
@push('scripts')
<script>
  $('#aet_id').select2({
    placeholder: "Please Select"
  });

  let fileInput2 = document.getElementById("picture1");
  let fileSelect2 = document.getElementsByClassName("file-upload-select-2")[0];
  fileSelect2.onclick = function() {
    fileInput2.click();
  }
  fileInput2.onchange = function() {
    let filename2 = fileInput2.files[0].name;
    let selectName2 = document.getElementsByClassName("file-select-name-2")[0];
    selectName2.innerText = filename2;
  }

  let fileInput3 = document.getElementById("picture2");
  let fileSelect3 = document.getElementsByClassName("file-upload-select-3")[0];
  fileSelect3.onclick = function() {
    fileInput3.click();
  }
  fileInput3.onchange = function() {
    let filename3 = fileInput3.files[0].name;
    let selectName3 = document.getElementsByClassName("file-select-name-3")[0];
    selectName3.innerText = filename3;
  }

  let fileInput4 = document.getElementById("picture3");
  let fileSelect4 = document.getElementsByClassName("file-upload-select-4")[0];
  fileSelect4.onclick = function() {
    fileInput4.click();
  }
  fileInput4.onchange = function() {
    let filename4 = fileInput4.files[0].name;
    let selectName4 = document.getElementsByClassName("file-select-name-4")[0];
    selectName4.innerText = filename4;
  }

  let fileInput5 = document.getElementById("local_video");
  let fileSelect5 = document.getElementsByClassName("file-upload-select-5")[0];
  fileSelect5.onclick = function() {
    fileInput5.click();
  }
  fileInput5.onchange = function() {
    let filename5 = fileInput5.files[0].name;
    let selectName5 = document.getElementsByClassName("file-select-name-5")[0];
    selectName5.innerText = filename5;
  }

  $(function() {
    $('.other_title').hide();
    $('.video_type').hide();

    $("#aet_id").change(function() {
      var val = $(this).val();
      if (val != "" && val == "{{ $defDataArr['other_aet_id'] }}") {
        $('.other_title').show();
      } else {
        $('.other_title').hide();
      }
    });

    $("#video_type").change(function() {
      var val = $(this).val();
      $('.video_type').hide();
      if (val != "" && val == "{{ $defDataArr['video_types']['value']['0'] }}") {
        $('.local_video').show();
      }
      if (val != "" && val == "{{ $defDataArr['video_types']['value']['1'] }}") {
        $('.yt_video').show();
      }
    });

    $("#quesForm").validate({
        rules: {
          aet_id: {
            required: true
          },
          title: {
            required: true
          },
          question: {
            required: true
          },
          picture1: {
            accept: "image/*",
            extension: "jpg|jpeg|png"
          },
          picture2: {
            accept: "image/*",
            extension: "jpg|jpeg|png"
          },
          picture3: {
            accept: "image/*",
            extension: "jpg|jpeg|png"
          },
          local_video: {
            required: true,
            accept: "video/*",
            extension: "mp4"
          },
          yt_video: {
            required: true,
            url: true
          }
        },
        messages: {
          aet_id: "{{ __('web.jq_validate.select_a_txt').strtolower(__('askexpert.topic_txt')) }}",
          title: "{{ __('web.jq_validate.enter_a_txt').strtolower(__('askexpert.topic_txt')) }}.",
          question: "{{ __('web.jq_validate.enter_a_txt').strtolower(__('askexpert.question_txt')) }}.",
          picture1: {
            accept: "{{ __('web.jq_validate.enter_valid_txt').strtolower(__('askexpert.picture1_txt')) }}",
            extension: "{{ __('web.jq_validate.enter_valid_txt').strtolower(__('front.error.img_ext')) }}"
          },
          picture2: {
            accept: "{{ __('web.jq_validate.enter_valid_txt').strtolower(__('askexpert.picture2_txt')) }}",
            extension: "{{ __('web.jq_validate.enter_valid_txt').strtolower(__('front.error.img_ext')) }}"
          },
          picture3: {
            accept: "{{ __('web.jq_validate.enter_valid_txt').strtolower(__('askexpert.picture3_txt')) }}",
            extension: "{{ __('web.jq_validate.enter_valid_txt').strtolower(__('front.error.img_ext')) }}"
          },
          local_video: {
            required: "{{ __('web.jq_validate.enter_a_txt').strtolower(__('askexpert.local_file_txt')) }}.",
            accept: "{{ __('web.jq_validate.enter_valid_txt').strtolower(__('front.error.vid_ext')) }}",
            extension: "{{ __('web.jq_validate.enter_valid_txt').strtolower(__('front.error.vid_ext')) }}"
          },
          yt_video: {
            required: "{{ __('web.jq_validate.enter_a_txt').strtolower(__('askexpert.yt_share_link_text')) }}.",
            url: "{{ __('web.jq_validate.enter_valid_txt').strtolower(__('askexpert.yt_share_link_text')) }}"
          },
        }
      }),
      $("#ask-expert-submit").click(function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("{{ Config('commonconstants.recaptcha.site_key') }}", {
            action: 'askquestionpage'
          }).then(function(token) {
            var a = $("#quesForm");
            if (1 == a.valid()) {
              // alert(token);
              if (token) {
                $("#recaptcha_v3").val(token);
                // alert($("#recaptcha_v3").val());
                $("#quesForm").submit();
              }
            }
          });
        });
      })
  });
</script>
@endpush