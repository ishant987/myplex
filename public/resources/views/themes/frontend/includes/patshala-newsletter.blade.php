<div class="patshala-new patshala-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 patshala">
        @if(isset($stngDataArr['paathshaala_heading']))
        <h3>{{ $stngDataArr['paathshaala_heading'] }}</h3>
        @endif
        <div class="patshala-new-lft br-5">
          @if(count($pthPgsMdl) > 0)
          <ul>
            @foreach($pthPgsMdl as $key => $pthRecord)
            @if( $pthRecord->getPageName() != false )
            <li><a href="{{ $pthRecord->getPageName() }}">{!! $pthRecord->title !!}</a></li>
            @endif
            @endforeach
          </ul>
          @endif
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 newsletter">
        @if(isset($stngDataArr['newsletter_heading']))
        <h3>{{ $stngDataArr['newsletter_heading'] }}</h3>
        @endif
        <div class="news-wrap">
          @if(isset($stngDataArr['newsletter_description']))
          <p>{!! nl2br($stngDataArr['newsletter_description']) !!}</p>
          @endif
          <form action="{{ route('web.newsletter.save') }}" name="newsletterFrm" id="newsletterFrm" method="post">
            {{ csrf_field() }}
            <x-form.field.hidden name="recaptcha_v3" id="recaptcha_v3" />
            <div class="f-fields d-flex">
              <div class="f-email">
                <input type="email" name="email" id="email" placeholder="Enter Email" />
              </div>
              <div class="f-submit">
                <input type="button" id="sendNewsletterFrm" name="sendNewsletterFrm" value="{{ $defDataArr['web_lang']['submit_txt'] }}" />
              </div>
            </div>
          </form>
          <div id="msg_id"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
  $(function() {
    $("#newsletterFrm").validate({
        rules: {
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          email: {
            required: "{{ $defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt')) }}",
            email: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt')) }}"
          }
        }
      }),
      $("#sendNewsletterFrm").click(function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("{{ Config('commonconstants.recaptcha.site_key') }}", {
            action: 'newsletter_form'
          }).then(function(token) {
            var a = $("#newsletterFrm");
            if (1 == a.valid()) {
              if (token) {
                $("#recaptcha_v3").val(token);
                // alert($("#recaptcha_v3").val());
                var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  email: $("#email").val(),
                  recaptcha_v3: $("#recaptcha_v3").val()
                };
                $.ajax({
                  url: "{{ route('web.newsletter.save') }}",
                  type: "post",
                  data: formData,
                  dataType: 'json',
                  beforeSend: function() {
                    $('#sendNewsletterFrm').prop('disabled', true);
                    $("#sendNewsletterFrm").attr('value', "{{ $defDataArr['web_lang']['processing_txt'] }}");
                  },
                  success: function(data) {
                    // alert(data['msg']);
                    $('#sendNewsletterFrm').prop('disabled', false);
                    $("#sendNewsletterFrm").attr('value', "{{ $defDataArr['web_lang']['submit_txt'] }}");
                    $("#msg_id").html(data['msg']);
                    $('#newsletterFrm')[0].reset();
                  },
                  error: function() {
                    $("#msg_id").html('There is error while submit');
                  }
                });
              }
            }
          });
        });
      });
  });
</script>
@endpush