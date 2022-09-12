$('.as_seen_slider').slick({
    infinite: true,
    slidesToShow: 6,
    slidesToScroll: 6,
    arrows: false,
    dots: false,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
            }
    },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
    },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
    }
  ]
});



$('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.slider-nav',
    autoplay: true,
    autoplaySpeed: 2000,
});
$('.slider-nav').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
     arrows: false,
    centerMode: false,
    focusOnSelect: true,
    autoplay: true,
    autoplaySpeed: 2000,
});



AOS.init();