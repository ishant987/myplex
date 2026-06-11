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
            required: "Enter email ID",
            email: "Enter valid email ID"
        }
    }
}),
$("#sendNewsletterFrm").click(function(e) {
    e.preventDefault();
    // grecaptcha.ready(function() {
    //     grecaptcha.execute("{{ Config('commonconstants.recaptcha.site_key') }}", {
    //         action: 'newsletter_form'
    //     }).then(function(token) {
    //         var a = $("#newsletterFrm");
    //         if (1 == a.valid()) {
    //             if (token) {
    //                 $("#recaptcha_v3").val(token);
    //                 // alert($("#recaptcha_v3").val());
                   
    //             }
    //         }
    //     });
    // });
    var formData = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        email: $("#email").val(),
        recaptcha_v3: $("#recaptcha_v3").val()
    };
    $.ajax({
        url: $('.newsletterFrm').attr('action'),
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
            return false;
        },
        error: function() {
            $("#msg_id").html('There is error while submit');
        }
    });
});
});