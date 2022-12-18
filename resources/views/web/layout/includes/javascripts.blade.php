<script src="{{asset('themes/frontend/assets/v1/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('themes/frontend/assets/v1/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="{{ mix('js/vue-app.js') }}"></script>
<script src="{{asset('themes/frontend/assets/v1/js/stock_header.js')}}"></script>
<script src="{{asset('themes/frontend/assets/v1/js/custom.js')}}"></script>
<script src="{{ asset('themes/assets/js/jquery.validate.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

@if(View::hasSection('captcha'))
<script src="https://www.google.com/recaptcha/api.js?render={{ Config('commonconstants.recaptcha.site_key') }}"></script>
@endif
{{-- @if(View::hasSection('moneycontrol'))
<script src="https://stat2.moneycontrol.com/mcjs/common/jquery-1.7.2.min.js"></script>
<script>
  var ct_v = '170940';
</script>
<!-- <script src="https://www.gstatic.com/swiffy/v7.3.0/runtime.js"></script> -->
<script src="https://stat4.moneycontrol.com/mcjs/mcradar/market_radar_aws.js?ver=20200516"></script>
<script src="https://stat.moneycontrol.co.in/mcjs/mcradar/jquery-ui-1.10.3.custom.min.js"></script>
<script src=" https://stat.moneycontrol.co.in/mcjs/portfolio_plus/datepicker.js?"></script>
<script src="https://stat.moneycontrol.co.in/mcjs/mcradar/jquery.webticker.js"></script>
@endif --}}
<script>
$(".subsribe_btn").click(function(e) {
    $("#msg_id").html('');
    e.preventDefault();
    var formData = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        email: $("#email").val(),
        recaptcha_v3: $("#recaptcha_v3").val()
    };
    $.ajax({
        url: $('.subsribe_btn').attr('data-url'),
        type: "post",
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            $('#sendNewsletterFrm').prop('disabled', true);
        },
        success: function(data) {
            // alert(data['msg']);
            $('#sendNewsletterFrm').prop('disabled', false);
            $("#msg_id").removeClass('text-danger');
            $("#msg_id").html(data['msg']);
            $('#newsletterFrm')[0].reset();
            return false;
        },
        error: function(error) {
            $("#msg_id").addClass('text-danger');
            $("#msg_id").html(error.responseJSON);
        }
    });
});
$(function() {
    $("#signupFrm").validate({
        rules: {
          f_name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          mobile: {
            required: true,
            number: true
          },
        //   pincode: {
        //     required: true,
        //     number: true
        //   }
        },
        messages: {
          f_name: "Enter you name",
          email: {
            required: "Enter email ID",
            email: "Enter valid email ID"
          },
          mobile: {
            required: "Enter phone number",
            number: "Enter valid phone number"
          },
        }
      }),
      $("#sendSignupFrm").click(function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("{{ Config('commonconstants.recaptcha.site_key') }}", {
            action: 'signup_form'
          }).then(function(token) {
            var a = $("#signupFrm");
            if (1 == a.valid()) {
              if (token) {
                $("#recaptcha_v3").val(token);
                console.log($("#recaptcha_v3").val());
                var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  f_name: $("#f_name").val(),
                  email: $("#email").val(),
                  mobile: $("#mobile").val(),
                  company: $("#company").val(),
                  pincode:'123344',
                  recaptcha_v3: $("#recaptcha_v3").val()
                };
                $.ajax({
                  url: "{{ route('web.signup.save') }}",
                  type: "post",
                  data: formData,
                  dataType: 'json',
                  beforeSend: function() {
                    $('#sendSignupFrm').prop('disabled', true);
                    $("#sendSignupFrm").text("Processing ...");
                  },
                  success: function(data) {
                    // console.log(data);
                    // alert(data['msg']);
                    $('#sendSignupFrm').prop('disabled', false);
                    $("#sendSignupFrm").text("Sign Up");
                    $("#msg_id").html(data['msg']);
                    if (data['url'] != '') {
                      window.location.href = data['url'];
                    }
                  },
                  error: function(e) {
                    // console.log(e);
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
@stack('scripts')