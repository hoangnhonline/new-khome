(function($){
  "use strict";

  // Slide Carousel
    $(document).ready(function() {
        $(".owl-carousel").each(function(index, el) {
            var config = $(this).data();
            config.navText = ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'];
            config.smartSpeed="800";

            if($(this).hasClass('owl-style2')){
                config.animateOut="fadeOut";
                config.animateIn="fadeIn";    
            }

            if($(this).hasClass('dotsData')){
                config.dotsData="true";
            }

            $(this).owlCarousel(config);
        });
    });

    function hidemenu(){
        $('.float_item .btn_control_float').parents('.float_item').animate({width: '25px'});
    }
    function hidesearch(){
        $('#btn_top').parents('.float_top_item').animate({height: '30px'}, 500);
    }
    function hidephapam(){
        $('#btn_bottom').parents('.float_top_item').animate({height: '30px'}, 500);
    }

    $('#btn_left').on("click", function() {
        $(this).toggleClass('btn_left-block');
        if ($(this).hasClass('btn_left-block')) {
            $(this).parents('.float_item').animate({width: '25px'}, 500);
        } else {
            $(this).parents('.float_item').stop(true, true).animate({width: '225px'}, 500);
            hidesearch();
            hidephapam();
        }
    })

    $('#btn_top').on("click", function() {
        $(this).toggleClass('btn_top-block');
        if ($(this).hasClass('btn_top-block')) {
            $(this).parents('.float_top_item').stop(true, true).animate({height: '285px'}, 500);
            hidemenu();
            hidephapam();
        } else {
            $(this).parents('.float_top_item').animate({height: '30px'}, 500);
        }
    })

    $('#btn_bottom').on("click", function() {
        $(this).toggleClass('btn_bottom-block');
        if ($(this).hasClass('btn_bottom-block')) {
            $(this).parents('.float_top_item').stop(true, true).animate({height: '260px'}, 500);
            hidemenu();
            hidesearch();
        } else {
            $(this).parents('.float_top_item').animate({height: '30px'}, 500);
        }
    })

})(jQuery); // End of use strict