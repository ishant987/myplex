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