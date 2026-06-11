jQuery(function ($) {


    $('body').addClass('active_subscription');
    $('.subscription_heading').parents('body').removeClass('active_subscription');

    $('.subs_in .close').click(function () {
        $('body').addClass('active_subscription');
    });


    $(".toggle_password").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });


    $("#toggle").click(function () {
        $(this).toggleClass("on");
        $(".head,.main_foot,.page_detail,.subscription_heading").toggleClass("menu_close");
    });

    $("#toggle").click(function () {
        setTimeout(function () {
            $(".head").toggleClass("logo_change");
        }, 300);
    });


    $("#toggle").click(function () {
        $("body").toggleClass("change");
    });


    /*TAB*/
    $('.tabsct .tab').hide();
    $('.tabsct .tab').eq($('.tabs .active').parent().index()).show();
    $('.tabs a').click(function () {
        $('.tabs a').removeClass('active');
        $(this).addClass('active');
        $('.tabsct .tab').hide();
        $('.tabsct .tab').eq($(this).parent().index()).show();
    });

    // $().ready(function () {
    //     $('ul.tabs li').click(function () {
    //         $('ul.tabs li a').removeClass('active');
    //         $(this).find('a').addClass('active');
    //         $('.tab').hide();
    //         $($('.tab')[$(this).index()]).show();
    //     })
    //     $('ul.tabs li:first').click();
    // });





    $(".close").click(function () {
        $(".subscription_heading").css("display", "none");
    });




    $('.bttn_grp button').on('click', function () {
        $('.preloader').removeClass('hide_pre_loader');
    });

    $(window).on('load', function () {
        $('.preloader').addClass('hide_pre_loader');
    });






    $(function () {
        var today = new Date();
        var fiveYearsAgo = new Date();
        fiveYearsAgo.setFullYear(today.getFullYear() - 5);

        $(".datepicker").datepicker({
            minDate: fiveYearsAgo,
            maxDate: -1,
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true
        });

        $(".datepicker").attr("autocomplete", "off");

    });


    // $('input[name="ranking"]').click(function () {
    //     if ($(this).val() === 'as_on') {
    //         $('.div_show').addClass('toggle_div');
    //         $('.div_hide').addClass('show_hide');
    //     } else {
    //         $('.div_show').removeClass('toggle_div');
    //         $('.div_hide').removeClass('show_hide');
    //     }
    // });



    $('input[type="radio"]').on('click', function () {
        $(this).removeAttr('checked');
        $(this).attr('checked', 'checked');
    });







    /* RADIO BUTTON (RANGE-AS ON) */

    $(document).ready(function () {
        // Check localStorage for the saved ranking value
        const savedRanking = localStorage.getItem('ranking');
        if (savedRanking) {
            $('input[name="ranking"][value="' + savedRanking + '"]').prop('checked', true);
            if (savedRanking === 'as_on') {
                $('.div_show').addClass('toggle_div');
                $('.div_hide').addClass('show_hide');
            } else {
                $('.div_show').removeClass('toggle_div');
                $('.div_hide').removeClass('show_hide');
            }
        }

        $('input[name="ranking"]').click(function () {
            const selectedValue = $(this).val();
            localStorage.setItem('ranking', selectedValue); // Save the selected value to localStorage
            if (selectedValue === 'as_on') {
                $('.div_show').addClass('toggle_div');
                $('.div_hide').addClass('show_hide');
            } else {
                $('.div_show').removeClass('toggle_div');
                $('.div_hide').removeClass('show_hide');
            }
        });
    });





    /* RADIO BUTTON (BY CATEGORY-BY FUND) */

    $(document).ready(function () {
        // Check localStorage for the saved ranking value
        const savedRanking = localStorage.getItem('Category');
        if (savedRanking) {
            $('input[name="Category"][value="' + savedRanking + '"]').prop('checked', true);
            if (savedRanking === 'by_fund') {
                $('.div_show_1').addClass('toggle_div_1');
                $('.div_hide_1').addClass('show_hide_1');
            } else {
                $('.div_show_1').removeClass('toggle_div_1');
                $('.div_hide_1').removeClass('show_hide_1');
            }
        }

        $('input[name="Category"]').click(function () {
            const selectedValue = $(this).val();
            localStorage.setItem('Category', selectedValue); // Save the selected value to localStorage
            if (selectedValue === 'by_fund') {
                $('.div_show_1').addClass('toggle_div_1');
                $('.div_hide_1').addClass('show_hide_1');
            } else {
                $('.div_show_1').removeClass('toggle_div_1');
                $('.div_hide_1').removeClass('show_hide_1');
            }
        });
    });



    /* RADIO BUTTON (By Ratio-By Composition) */

    // $(document).ready(function () {
    // Check localStorage for the saved ranking value
    // const savedRanking = localStorage.getItem('filter');
    // if (savedRanking) {
    //     $('input[name="filter"][value="' + savedRanking + '"]').prop('checked', true);
    //     if (savedRanking === 'by_composition') {
    //         $('.div_show_2').addClass('toggle_div_2');
    //         $('.div_hide_2').addClass('show_hide_2');
    //     } else {
    //         $('.div_show_2').removeClass('toggle_div_2');
    //         $('.div_hide_2').removeClass('show_hide_2');
    //     }
    // }

    // $('input[name="filter"]').click(function () {
    //     const selectedValue = $(this).val();
    //     localStorage.setItem('filter', selectedValue);
    //     if (selectedValue === 'by_composition') {
    //         $('.div_show_2').addClass('toggle_div_2');
    //         $('.div_hide_2').addClass('show_hide_2');
    //     } else {
    //         $('.div_show_2').removeClass('toggle_div_2');
    //         $('.div_hide_2').removeClass('show_hide_2');
    //     }
    // });
    // });


    // $('.radio_btn_checked input').change(function(){
    //     $(this).attr('checked',true);
    //     $(this).parent('label').siblings('label').find('input').removeAttr('checked');
    //   });


    $(".open_popup").click(function () {
        var FundTypeID = $(this).attr('FundTypeID');
        var dateInputValue = $("#dateInput").val();
        var typeValue = $("#type").val();

        var html = null;

        $.ajax({
            url: '/getChangesFund',
            method: 'GET',
            data: {
                fund_type_id: FundTypeID,
                date: dateInputValue,
                type: typeValue
            },
            success: function (response) {

                $.each(response.changes_fund, function (index, fund) {
                    html += '<tr>';
                    html += '<td>' + fund.fund_name + '</td>';
                    html += '<td>' + parseFloat(fund.change_value).toFixed(2) + '</td>';
                    html += '</tr>';
                });

                $('.table_popup table tbody').html(html);

                $(".popup-overlay, .table_popup").show();
            },
            error: function (xhr, status, error) {

                console.error(error);
            }
        });

        // $(".popup-overlay, .table_popup").show();
    });

    //For industry
    $(".open_industry").click(function () {
        $(".popup-overlay, .industry_popup").show();
    });

    $(".open_industry_percentage").click(function () {
        $(".popup-overlay, .industry_percentage_popup").show();
    });

    //For scrip
    $(".open_scrip").click(function () {
        $(".popup-overlay, .scrip_popup").show();
    });

    $(".open_scrip_percentage").click(function () {
        $(".popup-overlay, .scrip_percentage_popup").show();
    });



    $(".close_popup, .popup-overlay").click(function () {
        $(".popup-overlay, .table_popup, .industry_popup, .industry_percentage_popup, .scrip_popup, .scrip_percentage_popup").hide();
    });

    $(document).ready(function () {

        $('.open-popup-factsheet').click(function () {
            var element = $(this);

            var biasValue = parseFloat(element.data('bias'));
            var type = element.data('type');
            var offset = element.data('offset');

            var fundCode = $('#fund_code').val();
            var closestEntryDate = $('#closest_entry_date').val();
            var indicesName = $('#indices_name').val();

            // console.log('biasValue', biasValue);

            if (biasValue !== 0) {
                $.ajax({
                    url: '/fundFasctSheet/getTopScripTopIndustries',
                    method: 'GET',
                    data: {
                        fundCode: fundCode,
                        closestEntryDate: closestEntryDate,
                        indicesName: indicesName,
                        type: type,
                        offset: offset
                    },
                    success: function (response) {
                        // console.log('response', response);

                        let th1, th2;

                        if (type === 'scrip') {
                            th1 = 'Scrip Name';
                        } else if (type === 'industry') {
                            th1 = 'Industry Name';
                        }
                        th2 = 'Bias';

                        // Dynamically update the table headers
                        $('.table_popup table thead tr').html('<th>' + th1 + '</th><th>' + th2 + '</th>');

                        let html = '';
                        $.each(response.data, function (index, data) {
                            var totalPercentage = data.total_percentage !== null ? parseFloat(data.total_percentage) : 0;
                            var result = parseFloat(data.total_content_per) - totalPercentage;

                            html += '<tr>';
                            html += '<td>' + data.show_name + '</td>';
                            html += '<td>' + result.toFixed(2) + '</td>';
                            html += '</tr>';
                        });

                        $('.table_popup table tbody').html(html);

                        $(".popup-overlay, .table_popup").show();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });

        $('.open-popup-scrip-industry').click(function () {
            var fundCodes = $('#fund_codes').val();
            var lastDate = $('#lastDate').val();

            var using = $(this).data('using');
            var category = $(this).data('category');
            var parameter = $(this).data('parameter');

            $.ajax({
                url: '/scrip-industry-details-fundwise',
                method: 'GET',
                data: {
                    fundCodes: fundCodes,
                    using: using,
                    category: category,
                    parameter: parameter,
                    lastDate: lastDate
                },
                success: function (response) {
                    console.log('response', response);

                    let th1, th2;

                    th1 = 'Fund Name';

                    if (category === 'content_per') {
                        th2 = 'Content Per(%)';
                    } else if (category === 'amount') {
                        th2 = 'Amount(Cr.)';
                    }

                    // Dynamically update the table headers
                    $('.table_popup table thead tr').html('<th>' + th1 + '</th><th>' + th2 + '</th>');

                    let html = '';
                    $.each(response, function (index, data) {

                        const contentPer = data.content_per !== null ? Number(data.content_per).toFixed(2) : '0.00';
                        const amount = data.amount !== null ? Number(data.amount).toFixed(2) : '0.00';
                        const allocation = data.allocation !== null ? Number(data.allocation).toFixed(2) : '0.00';

                        html += '<tr>';
                        html += '<td>' + data.fund_name + '</td>';
                        if (category === 'content_per') {
                            // if (using === 'industry') {
                            //     html += '<td>' + allocation + '</td>';
                            // }
                            // else {
                            //     html += '<td>' + contentPer + '</td>';
                            // }
                            html += '<td>' + allocation + '</td>';
                        } else if (category === 'amount') {
                            html += '<td>' + amount + '</td>';
                        }

                        html += '</tr>';
                    });

                    $('.table_popup table tbody').html(html);

                    $(".popup-overlay, .table_popup").show();


                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });

            // $(".popup-overlay, .table_popup").show();
        });
    });

    $(".tabs li a").click(function (e) {
        e.preventDefault();
        $(".tabs li a").removeClass("active");
        $(this).addClass("active");

        var tabName = $(this).text().trim().toLowerCase();
        $(".perform_head h2").removeClass("active");
        $(".perform_head h2." + tabName).addClass("active");
    });

    $('.single_index').each(function () {
        var $this = $(this);
        var $tabs = $this.find('ul.tabs__1 li a');
        var $contents = $this.find('.tab__1');

        $tabs.click(function () {
            $tabs.removeClass('active');
            $(this).addClass('active');
            $contents.removeClass('active');
            $contents.eq($(this).parent().index()).addClass('active');
        }).trigger('click');
    });

    /*FILE UPLOAD*/

    $(function () {
        var container = $('.upload_file'), inputFile = $('#file'), img, btn, txt = '+';

        if (!container.find('#upload').length) {
            container.find('.input').append('<input type="button" value="' + txt + '" id="upload">');
            btn = $('#upload');
            container.prepend('<img src="" class="hidden" alt="Uploaded file" id="uploadImg">');
            img = $('#uploadImg');
        }

        btn.on('click', function () {
            img.animate({ opacity: 0 }, 300);
            inputFile.click();
        });

        inputFile.on('change', function (e) {
            container.find('.upload_file label').html(inputFile.val());

            var i = 0;
            for (i; i < e.originalEvent.srcElement.files.length; i++) {
                var file = e.originalEvent.srcElement.files[i],
                    reader = new FileReader();

                reader.onloadend = function () {
                    img.attr('src', reader.result).animate({ opacity: 1 }, 700);
                }
                reader.readAsDataURL(file);
                img.removeClass('hidden');
            }

            btn.val(txtAfter);
        });
    });



    $(window).scroll(function () {
        if ($(document).scrollTop() > 0) {
            $("body").addClass("subs_hide_show");
        } else {
            $("body").removeClass("subs_hide_show");
        }
    });

    $('#allocation_select_fund').on('change', function () {
        var selectedOptions = $(this).val();
        if (selectedOptions.length > 20) {
            alert('You can select a maximum of 20 items.');
            var lastSelectedOption = selectedOptions.pop();
            $(this).val(selectedOptions).trigger('change');
        }
    });

    // $('.select-2').each(function () {
    //     var $selectElement = $(this);
    //     var dynamicPlaceholder = $selectElement.data('placeholder');

    //     // Initialize Select2 with dynamic placeholder and allowClear option
    //     $selectElement.select2({
    //         placeholder: dynamicPlaceholder || 'Select an option', // Default placeholder if none provided
    //         allowClear: true
    //     });
    // });



    $(document.body).delegate('select.ui-datepicker-year', 'mousedown', function () {
        (function (sel) {
            var el = $(sel);
            var ops = $(el).children().get();
            if (ops.length > 0 && $(ops).first().val() < $(ops).last().val()) {
                $(el).empty();
                $(el).html(ops.reverse());
            }
        })(this);
    });
});



// Custom sorting for Rank column
$.fn.dataTable.ext.type.order['rank-asc'] = function(a, b) {
    return (a === 'N/A') ? 1 : (b === 'N/A') ? -1 : a - b;
};

$.fn.dataTable.ext.type.order['rank-desc'] = function(a, b) {
    return (a === 'N/A') ? 1 : (b === 'N/A') ? -1 : b - a;
};

// Custom sorting for Value column
$.fn.dataTable.ext.type.order['value-asc'] = function(a, b) {
    return (a === 'N/A') ? 1 : (b === 'N/A') ? -1 : parseFloat(a) - parseFloat(b);
};

$.fn.dataTable.ext.type.order['value-desc'] = function(a, b) {
    return (a === 'N/A') ? 1 : (b === 'N/A') ? -1 : parseFloat(b) - parseFloat(a);
};

// Initialize DataTable with custom sorting applied
$('.filter_datatable').DataTable({
    paging: false,
    searching: false,
    info: false,
    filter: true,
    order: [[2, 'asc']], // Initial sort order set to the 'Value' column
    columnDefs: [
        { type: 'value', targets: 2 }, // Apply custom sorting to the 'Value' column
        { type: 'rank', targets: 3 }, // Apply custom sorting to the 'Rank' column
    ],
    language: {
        emptyTable: "No information available for this search"
    }
});


