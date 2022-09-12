@extends('themes.frontend.layouts.app-popup')
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
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif
@section('content')
<section class="questionSection popup-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @if(isset($answer->answer))
        <form name="ansForm" id="ansForm" action="{{ route('web.draft-answer.save', $answer->aeqa_id) }}" method="post" class="quesForm">
          @else
          <form name="ansForm" id="ansForm" action="{{ route('web.add-answer.save', $aeq_id) }}" method="post" class="quesForm">
            @endif
            {{ csrf_field() }}
            <x-form.field.hidden name="recaptcha_v3" id="recaptcha_v3" />
            <x-form.field.hidden name="stype" id="stype" value="" />
            <x-form.group_lyt3 label="{{ __('askexpert.answer_txt') }}" for="answer" error="{{ $errors->first('answer') }}" required="true">
              <x-form.field.textarea id="answer" name="answer" value="{{ (isset($answer->answer))?$answer->answer:old('answer') }}" />
            </x-form.group_lyt3>

            <div class="form-group ask-expert-submit">
              <x-form.field.button3 id="aeaBtn" name="aeaBtn" value="1" type="submit" text="{{ __('web.submit_txt') }}" />
              <x-form.field.button3 id="aeaBtn2" name="aeaBtn" value="3" type="submit" text="{{ __('askexpert.draft_txt') }}" />
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
</section>
@stop
@push('scripts')
<script>
  $(function() {
    $("#ansForm").validate({
        rules: {
          answer: {
            required: true
          }
        },
        messages: {
          answer: "{{ __('web.jq_validate.enter_an_txt').strtolower(__('askexpert.answer_txt')) }}."
        }
      }),
      $("#aeaBtn,#aeaBtn2").click(function(e) {
        var fired_button = $(this).val();
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("{{ Config('commonconstants.recaptcha.site_key') }}", {
            action: 'askanswerpage'
          }).then(function(token) {
            var a = $("#ansForm");
            if (1 == a.valid()) {
              // alert(token);
              if (token) {
                $("#recaptcha_v3").val(token);
                // alert($("#recaptcha_v3").val());
                $("#stype").val(fired_button);
                $("#ansForm").submit();
              }
            }
          });
        });
      })
  });
</script>
@endpush