jQuery(function ($) {


    $(".toggle_password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });


    $("#toggle").click(function() {
        $(this).toggleClass("on");
        $(".head,.main_foot,.page_detail,.subscription_heading").toggleClass("menu_close");
    });

    $("#toggle").click(function() {
        setTimeout(function() {
            $(".head").toggleClass("logo_change");
        }, 300); 
    });
    

    $( function() {
        $( "#datepicker" ).datepicker();
    });
    



     /*FILE UPLOAD*/

     $(function(){
        var container = $('.upload_file'), inputFile = $('#file'), img, btn, txt = '+';
                
        if(!container.find('#upload').length){
            container.find('.input').append('<input type="button" value="'+txt+'" id="upload">');
            btn = $('#upload');
            container.prepend('<img src="" class="hidden" alt="Uploaded file" id="uploadImg">');
            img = $('#uploadImg');
        }
                
        btn.on('click', function(){
            img.animate({opacity: 0}, 300);
            inputFile.click();
        });
    
        inputFile.on('change', function(e){
            container.find('.upload_file label').html( inputFile.val() );
            
            var i = 0;
            for(i; i < e.originalEvent.srcElement.files.length; i++) {
                var file = e.originalEvent.srcElement.files[i], 
                    reader = new FileReader();
    
                reader.onloadend = function(){
                    img.attr('src', reader.result).animate({opacity: 1}, 700);
                }
                reader.readAsDataURL(file);
                img.removeClass('hidden');
            }
            
            btn.val( txtAfter );
        });
    });
    


        $(window).scroll(function () {
        if ($(document).scrollTop() > 10) {
        $("body").addClass("subs_hide_show");
        } else {
        $("body").removeClass("subs_hide_show");
        }
    });



});



