<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myplexus</title>

    <link rel="shortcut icon" href="{{asset('assets/images/favicon-my.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />


</head>
<body>
    
    <div class="content">
        <header class="header">
            <figure class="header-fig">
                <a href="{{url('report-dashboard')}}"><img src="{{asset('assets/images/my-logo.png')}}" alt=""></a>
            </figure>
        </header>
        @yield('content')
    </div>

    <footer class="footer">
        <p>Copyright © {{date('Y')}} All Rights Reserved.</p>
    </footer>



  

    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/icon.js')}}"></script>
    <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/jquery-ui.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    

    <script>
    window.addEventListener("load",  function() {
        getIndicesName();
        getOneYearDate();
        getRollingReturnToDate();
        
    });

    $( function() {
        var dateFormat = "dd-mm-yy",
        from = $( "#from" )
            .datepicker({
            dateFormat: dateFormat,
            defaultDate: new Date(),
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            yearRange: "-100:+0",
            maxDate: 0,
            })
            .on( "change", function() {
            to.datepicker( "option", "minDate", getDate( this ) );
            }),
        to = $( "#to" ).datepicker({
            dateFormat: dateFormat,
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            yearRange: "0:+100",
        })
        .on( "change", function() {
            from.datepicker( "option", "maxDate", getDate( this ) );
        });
    
        function getDate( element ) {
        var date;
        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }
    
        return date;
        }
    } );

    $(document).ready(function() {

        $( "#from_date_cagr" ).datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            yearRange: "-100:+0",
            maxDate: "-12m"
        });
    });

    $(document).ready(function() {

    $( "#rolling_return_from_date" ).datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            yearRange: "-100:+0",
            maxDate: "-13m"
        });
    });



    $(document).ready(function() {
        $('.single-select2').select2();
    });

    $(document).ready( function () {
        $('#myDatatable').DataTable();
    } );

    // $(document).ready( function () {
    //     $('#myDatatable').DataTable({
    //         fnDrawCallback: function( row, data, dataIndex ) {
    //             $( "table.result-table" ).wrap( "<div class='scroll-div'></div>" );
    //         }
    //     });
    // } );

    function getIndicesName()
    {
        var fund_code = $('#fund_name_id').val();
        if(fund_code != '')
        {
            $.ajax({
                type: "get",
                url: "{{ url('get-indices-name') }}",
                data: {
                    fund_code: fund_code
                },
                success: function(data, textStatus, jqXHR) {
                    if(data!='not_found')
                    {
                        $('#indices_name_id').val(data);
                    }
                    else
                    {
                        $('#indices_name_id').val('');
                    }
                }
            })
        }
        else
        {
            $('#indices_name_id').val('');
        }
        
    }

    function getOneYearDate()
    {
        var selectedDate = $('.from_date_for_cagr').val();
        if(selectedDate != '')
        {
              // Convert entry_date_str to a Date object
              var selectedDate = $.datepicker.parseDate("dd-mm-yy", selectedDate);

            // Calculate the future date based on the term
            var future_date = new Date(selectedDate);
            future_date.setFullYear(selectedDate.getFullYear() + parseInt(1));

            // Format the future_date as a string in "dd-mm-yy" format
            var future_date_str = $.datepicker.formatDate("dd-mm-yy", future_date);
            // Enable the report_date datepicker and set minDate
            $("#cagr_to_date").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                yearRange: "-100:+100",
                defaultDate: future_date_str,
                minDate: future_date_str,
            });
        }
        else
        {
            $('#cagr_to_date').datepicker("destroy");
        }
            
    }

    function parseDate(input) {
        var [day, month, year] = input.split('-');
        return new Date(year, month - 1, day);
    }

    function formatDate(date) {
        return `${date.getDate().toString().padStart(2, '0')}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getFullYear()}`;
    }

    function getEntryDate()
    {
        var term = $('#sip_term').val();
        var term_month = $('#sip_term_month').val();
        $("#sip_entry_date").val('');
        $("#report_date").val('');
        $("#sip_entry_date").datepicker("destroy");
        if(term !='' || term_month != '')
        {
            if(term == ''){
                term = 0; 
            }
            if(term_month == ''){
                term_month = 0;
            }
            var maxDate = parseInt(term)*12+parseInt(term_month);
            console.log('ok '+maxDate);
            $( "#sip_entry_date" ).datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                yearRange: "-100:+0",
                maxDate: "-"+maxDate+"m"
            });
        }
        else
        {
            $("#sip_entry_date").datepicker("destroy");
        }
    }

    function getReportDate()
    {
        var entry_date = $('#sip_entry_date').val();
        var term = $('#sip_term').val();
        var term_month = $('#sip_term_month').val();
        $("#report_date").val('');
        $("#report_date").datepicker("destroy");
        if(entry_date !='' && term !='')
        {
            if(term_month == '')
            {
                term_month = 0;
            }
            console.log(term_month);

             // Convert entry_date_str to a Date object
            var entry_date = $.datepicker.parseDate("dd-mm-yy", entry_date);

            // Calculate the future date based on the term
            var future_date = new Date(entry_date);
            future_date.setFullYear(entry_date.getFullYear() + parseInt(term));
            future_date.setMonth(future_date.getMonth() + (term_month-1));
            future_date.setDate(future_date.getDate() + 2);

            // Format the future_date as a string in "dd-mm-yy" format
            var future_date_str = $.datepicker.formatDate("dd-mm-yy", future_date);
            // Enable the report_date datepicker and set minDate
            $("#report_date").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                yearRange: "-100:+100",
                defaultDate: future_date_str,
                minDate: future_date_str, // Set minDate to one year after entry_date
                onSelect: function (dateText) {
                    $("#hidden_report_date").val(dateText);
                }
            });

        }
        else
        {
            $("#report_date").datepicker("destroy");
            $("#report_date").val('');
        }
    }

    function sipSearchFormValidation()
    {
        var report_date = $("#report_date").val();
        var sip_entry_date =  $("#sip_entry_date").val();
        var sip_term = $('#sip_term').val();
        var sip_term_month = $('#sip_term_month').val();
        var check = 0;

        if (sip_term == '' && sip_term_month == '') {
            $('#sip_term_err_msg').html('Either the term (year) or term (month) field is required');
            check = 1;
        } else {
            $('#sip_term_err_msg').html('');
        }

        if(sip_entry_date == '')
        {
            $('#sip_entry_date_err_msg').html('The entry date field is required');
            check = 1;
        }
        else
        {
            $('#sip_entry_date_err_msg').html('');
        }
        if(report_date == '')
        {
            $('#report_date_err_msg').html('The report date field is required');
            check = 1;
        }
        else
        {
            $('#report_date_err_msg').html('');
        }
        if(check == 1)
        {
            return false;
        }
        else
        {
            return true;
        }
        return false;
    }



    $('body').on('input', '.onlynum', function() {
        this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
    });

    function getRollingReturnToDate()
    {
        var from_date = $('#rolling_return_from_date').val();
        if(from_date != '')
        {
            var entry_date = $.datepicker.parseDate("dd-mm-yy", from_date);

            // Calculate the future date based on the term
            var future_date = new Date(entry_date);
            future_date.setFullYear(entry_date.getFullYear() + parseInt(1));
            future_date.setMonth(future_date.getMonth() + 1);
            future_date.setDate(future_date.getDate() - 1);

            // Format the future_date as a string in "dd-mm-yy" format
            var future_date_str = $.datepicker.formatDate("dd-mm-yy", future_date);
            $('#rolling_return_to').val(future_date_str);
        }
        else
        {
            $('#rolling_return_to').val('');
        }
    }

    </script>

</body>
</html>