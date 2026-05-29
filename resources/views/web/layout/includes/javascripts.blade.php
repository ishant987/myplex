<script src="{{ asset('themes/frontend/assets/infosolz/js/bootstrap.min.js') }}"></script>


<script src="{{ asset('themes/frontend/assets/v1/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('themes/frontend/assets/v1/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ mix('js/vue-app.js') }}"></script>
<script src="{{ asset('themes/frontend/assets/v1/js/stock_header.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script src="{{ asset('themes/frontend/assets/v1/js/custom.js') }}"></script>
<script src="{{ asset('themes/assets/js/jquery.validate.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="{{ asset('themes/frontend/assets/infosolz/js/icon.js') }}"></script>
<script src="{{ asset('themes/frontend/assets/infosolz/js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
 <!-- ShareThis Script -->
 <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property={{ env('SHARE_BUTTON_PROPERTY') }}&product=inline-share-buttons" async="async"></script>



@if (View::hasSection('captcha'))
    <script src="https://www.google.com/recaptcha/api.js?render={{ Config('commonconstants.recaptcha.site_key') }}">
    </script>
@endif

{{-- @if (View::hasSection('moneycontrol'))
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
    // // Ensure ShareThis widget loads properly after the page has loaded
    // $(document).ready(function () {
    //     $('#customShareButton').on('click', function () {
    //        // console.log('hii');
    //         const shareWidget = document.querySelector('#shareThisWidget');
    //         if (shareWidget) {
    //             console.log('hii2');
    //             // Simulate a click on the hidden ShareThis widget
    //             shareWidget.style.display = 'block'; // Show the widget temporarily if needed
    //             setTimeout(() => {
    //                 shareWidget.style.display = 'none'; // Hide it again after showing
    //             }, 100); // Delay helps ensure it triggers correctly
    //         }
    //     });
    // });

 
    $(document).ready(function () {
        $('#customShareButton').on('click', function () {
            console.log('Share button clicked!'); // For debugging

            const shareWidget = document.querySelector('#shareThisWidget');

            if (shareWidget) {
                console.log('ShareThis widget found!'); // For debugging

                // Trigger the ShareThis widget programmatically
                try {
                    ShareThis.open(); // Use ShareThis's internal API to open the widget
                } catch (e) {
                    console.error('Error opening ShareThis:', e);
                }
            }
        });
    });

</script>
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
                                    "_token": $('meta[name="csrf-token"]').attr(
                                        'content'),
                                    f_name: $("#f_name").val(),
                                    email: $("#email").val(),
                                    mobile: $("#mobile").val(),
                                    company: $("#company").val(),
                                    pincode: '123344',
                                    recaptcha_v3: $("#recaptcha_v3").val()
                                };
                                $.ajax({
                                    url: "{{ route('web.signup.save') }}",
                                    type: "post",
                                    data: formData,
                                    dataType: 'json',
                                    beforeSend: function() {
                                        $('#sendSignupFrm').prop('disabled',
                                            true);
                                        $("#sendSignupFrm").text(
                                            "Processing ...");
                                    },
                                    success: function(data) {
                                        // console.log(data);
                                        // alert(data['msg']);
                                        $('#sendSignupFrm').prop('disabled',
                                            false);
                                        $("#sendSignupFrm").text("Sign Up");
                                        $("#msg_id").html(data['msg']);
                                        if (data['url'] != '') {
                                            window.location.href = data['url'];
                                        }
                                    },
                                    error: function(e) {
                                        // console.log(e);
                                        $("#msg_id").html(
                                            'There is error while submit');
                                    }
                                });
                            }
                        }
                    });
                });
            });
    });


    $(document).ready(function() {

        $('#dynamic_year').change(function() {
            var selectedYear = $(this).val();
            var currentYear = new Date().getFullYear();
            var currentMonth = new Date().getMonth() + 1;

            // Clear previous selection
            $('#dynamic_month').val('');
            $('#dynamic_month').prop('disabled', !selectedYear);

            if (selectedYear) {
                var monthOptions = '<option value="">Select Month</option>';
                for (var month = 1; month <= 12; month++) {
                    if (selectedYear == currentYear && month >= currentMonth) {
                        continue; // Skip current and future months if current year is selected
                    }
                    var monthName = new Date(currentYear, month - 1, 1).toLocaleString('default', {
                        month: 'long'
                    });
                    monthOptions += '<option value="' + month + '">' + monthName + '</option>';
                }
                $('#dynamic_month').html(monthOptions);
            }
        });
    });
    
    
</script>


<!-- <script>
    $(function() {
        $("#datepicker").datepicker();
    });
</script> -->
{{-- <script>
        document.getElementById('dateInput').addEventListener('change', function() {
            document.getElementById('dateForm').submit();
        });
</script> --}}

{{-- <script>
  document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('dateInput').addEventListener('change', function() {
          document.getElementById('dateForm').submit();
      });
  });
</script> --}}


<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select An Item",
            // allowClear: true
        });

  $.fn.dataTable.ext.type.order['rank-asc'] = function(a, b) {
            return (a === 'N/A') ? 1 : (b === 'N/A') ? -1 : a - b;
        };

        $.fn.dataTable.ext.type.order['rank-desc'] = function(a, b) {
            return (a === 'N/A') ? 1 : (b === 'N/A') ? -1 : b - a;
        };

        // $('.datatable').DataTable({
        //     paging: false,
        //     searching: false,
        //     info: false,
        //     // order: [[2, 'asc']], // Initial sort order set to the 'rank' column
        //     // columnDefs: [
        //     //     { type: 'rank', targets: 2 }, // Apply custom sorting to the 'rank' column
        //     //     { type: 'numeric', targets: 1 } // Ensure 'ratio' column sorts numerically
        //     // ],
        //     language: {
        //         emptyTable: "No information available for this search"
        //     }
        // });
    });

    function fund_multiple(selectElement) {
        
        var min = parseInt($(selectElement).attr('data-min') || 0);
        var max = parseInt($(selectElement).attr('data-max') || Infinity);
        var selectedOptions = $(selectElement).val() || [];        

        // Check both min and max conditions
        var isValidSelection = selectedOptions.length >= min && selectedOptions.length <= max;

        // Build the message based on validity
        var message = '';
        if (selectedOptions.length < min) {
            message = '<p>You must select at least ' + min + ' items.</p>';
        } else if (selectedOptions.length > max) {
            message = '<p>You can select a maximum of ' + max + ' items.</p>';
        }

        // Update button state based on validity
        $('#submit_btn').prop('disabled', !isValidSelection);

        // Display the message
        $('#fund_msgg').html(message);
    }


    function get_fund_types_js(thiss) {

        var count = $('#select_fund_multiple').select2('data').length;

        if (thiss == 'by_category') {

            $('#submit_btn').prop('disabled', false);
            
        } else if (thiss == 'by_fund') {

            var select_fund_multiple = $('#select_fund_multiple');
            fund_multiple(select_fund_multiple);

        }
    }

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })


    
function selectCompareTypeList(val){

    const map = {
        Scheme: '#fund_wrapper',
        Scheme1: '#allocation_select_fund',
        Index: '#index_wrapper',
        Index1: '#allocation_select_index',
        Currency: '#currency_wrapper',
        Currency1: '#allocation_select_currency',
        Commodity: '#commodity_wrapper',
        Commodity1: '#allocation_select_commodity'
    };

    // hide all
    $('#fund_wrapper,#index_wrapper,#currency_wrapper,#commodity_wrapper')
        .addClass('d-none');

    // show selected
    if(map[val]){
        $(map[val]).removeClass('d-none');
        $(map[val+'1']).select2();
    }
}
</script>


@stack('scripts')
