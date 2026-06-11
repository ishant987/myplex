$('#media_type').bind('change', function() {
    var media_type = $(this).val();
    switch(media_type) {
        case 'i':
        $("#img_div").show();
        $("#video_div").hide();
        break;
        case 'v':
        $("#video_div").show();
        $("#img_div").hide();
        break;
        default:
        $("#video_div").hide();
        $("#img_div").hide();
    }
});

$('#video_from').bind('change', function() {
    var video_from = $(this).val();
    switch(video_from) {
        case 'l':
        $("#lcl_video_div").show();
        $("#ytube_video_div").hide();
        break;
        case 'y':
        $("#ytube_video_div").show();
        $("#lcl_video_div").hide();
        break;
        default:
        $("#ytube_video_div").hide();
        $("#lcl_video_div").hide();
    }
});