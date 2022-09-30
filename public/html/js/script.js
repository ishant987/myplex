
// Selec2 Dropdown

$('#analytics-1').select2({
    placeholder: "Choose an Option"
});
$('#analytics-2').select2({
    placeholder: "Choose an Option"
});
$('#analytics-3').select2({
    placeholder: "Choose an Option"
});

$('#daily-price-select2-1').select2({
    placeholder: "Choose an Option"
})
$('#daily-price-select2-2').select2({
    placeholder: "Choose an Option"
})

$('#composition-select2-1').select2({
    placeholder: "Choose an Option"
})
$('#composition-select2-2').select2({
    placeholder: "Choose an Option"
})

$('#ratio-select2-1').select2({
    placeholder: "Choose an Option"
});
$('#ratio-select2-2').select2({
    placeholder: "Choose an Option"
});

$('#select-fund').select2({
    placeholder: "Choose an Option"
});
$('#day-sip').select2({
    placeholder: "Choose"
});
$('#day-sip-2').select2({
    placeholder: "Ex: 1"
});
$('#choose-classy').select2({
    placeholder: "Classification"
});
$('#fund-house').select2({
    placeholder: "Choose"
});
$('#fund-house-2').select2({
    placeholder: "Choose"
});
$('#blogPostFilter').select2({
    placeholder: "Sort by"
});
$('#mutual-fund-taxation-1').select2({
    placeholder: "Recent Archives"
});
$('#mutual-fund-taxation-2').select2({
    placeholder: "Archives Year Wise"
});
$('#select-calcy').select2({
    placeholder: "Nothing Selected"
});
$('#annual-inflation').select2({
    placeholder: "Nothing Selected"
});
$('#retirement-current-age').select2({
    placeholder: "Select current age"
});
$('#retirement-expected-age').select2({
    placeholder: "Select retirement age"
});
$('#retirement-life-expectancy').select2({
    placeholder: "Life Expectancy"
});
$('#retirement-return-accu-period').select2({
    placeholder: "Rate of return during accumulation period"
});
$('#retirement-return-retirement').select2({
    placeholder: "Seelect rate of return after retirement"
});
$('#retirement-inflation').select2({
    placeholder: "Select inflation"
});
$('#inflation-user-plan').select2({
    placeholder: "Select Plan"
});
$('#ps-weekly-select-fund').select2({
    placeholder: "Open ended balanced Hybrid fund"
});
$('#ps-weekly-return').select2({
    placeholder: "Return %"
});
$('#ps-monthly-select-fund').select2({
    placeholder: "Open ended balanced Hybrid fund"
});
$('#ps-monthly-return').select2({
    placeholder: "Return %"
});
$('#fund-performance-returns').select2({
    placeholder: "Aditya Birla sun life  mid cap"
});
$('#fund-performance-ratio').select2({
    placeholder: "Aditya Birla sun life  mid cap"
});
$('#fund-performance-portfolios').select2({
    placeholder: "Exis Nifty ETF"
});
$('#scheme-fund-house').select2({
    placeholder: "Baroda Pioneer Mutual Fund"
});
$('#scheme-classification').select2({
    placeholder: "Baroda Pioneer Mutual Fund"
});
$('#select-topic').select2({
    placeholder: "Please Select"
});
$('#select-video').select2({
    placeholder: "Please Select"
});
$('#ask-expert-query').select2({
    placeholder: "Search by Topic"
});
$('#home-select-one').select2({
    placeholder: "Select Scheme Name"
});
$('#home-select-two').select2({
    placeholder: "Select Category"
});
$('#home-select-three').select2({
    placeholder: "Classification"
});


// Toggle Questions

$(".user-question button").on("click", function () {
    $(this).parent().parent().parent().parent().parent().toggleClass("active-block");
});


// About US - Our Team Owl Carousel

$(document).ready(function () {
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                dots: false,
                margin: 20
            },
            600: {
                items: 3,
                nav: false,
                dots: false,
                margin: 30
            },
            1024: {
                items: 3,
                nav: false,
                dots: false,
                margin: 30
            },
            1280: {
                items: 4,
                nav: true,
                loop: false,
                dots: false,
                margin: 40
            }
        }
    })
});


// Filter Table

$(document).ready(function () {
    $('#filtertable01').DataTable();
    $('#filtertable02').DataTable();
    $('#filtertable03').DataTable();
    $('#filtertable04').DataTable();
    $('#filtertable05').DataTable();
    $('#filtertable06').DataTable();
    $('#filtertable07').DataTable();
    $('#filtertable08').DataTable();
    $('#filtertable09').DataTable();
    $('#filtertable10').DataTable();
    $('#filtertable11').DataTable();
    $('#mutualFundDictionaryTable').DataTable();
    $('#sip_calc_table').DataTable();
    $('#performance-weekly').DataTable();
    $('#performance-monthly').DataTable();
    $('#fund-perform-ratio-data').DataTable();
    $('#fund-perform-ratio-portfolios').DataTable();
});


// Table Toggle

$(document).ready(function () {

    $(".table-toggle-1").click(function () {
        $("#filtertable08_wrapper").slideToggle("slow");
        $('.table-toggle-1').toggleClass("hide");
    });

    $(".table-toggle-2").click(function () {
        $("#filtertable10_wrapper").slideToggle("slow");
        $('.table-toggle-2').toggleClass("hide");
    });

    $(".table-toggle-3").click(function () {
        $("#filtertable11_wrapper").slideToggle("slow");
        $('.table-toggle-3').toggleClass("hide");
    });

    $('.hide-table .dataTables_wrapper').hide();

});


// Blogs Filter

$(document).ready(function () {
    $('#blogPostFilter').on('change', function () {
        let selectedFitler = $(this).val();
        if (selectedFitler.startsWith('blog-')) {
            $('#blog-post-wrap .blog-post-box').hide();
            $('.' + selectedFitler).parent().show();
        } else {
            $('#blog-post-wrap .blog-post-box').show();
        }
    });
});


// SIP Performance Calculator Table

$("a#show-table").click(function () {
    $("#sip-performance-calc-data").slideToggle("slow");
    $(this).text($(this).text() == 'Show In Table' ? 'Hide Table' : 'Show In Table');
});


// Upload File

let fileInput = document.getElementById("file-upload-input");
let fileSelect = document.getElementsByClassName("file-upload-select")[0];
fileSelect.onclick = function () {
    fileInput.click();
}
fileInput.onchange = function () {
    let filename = fileInput.files[0].name;
    let selectName = document.getElementsByClassName("file-select-name")[0];
    selectName.innerText = filename;
}

