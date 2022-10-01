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
$('.trade_details_result').slick({
  infinite: true,
  slidesToShow: 7,
  slidesToScroll: 1,
  autoplaySpeed:10,
  cssEase: "linear",
  variableWidth: true,
  speed:5000,
  arrows: false,
  dots: false,
  autoplay: true,
  responsive: [
      {
          breakpoint: 1024,
          settings: {
              slidesToShow: 5,
              slidesToScroll: 5,
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





function accordion() {
  var Accordion = function (el, multiple) {
      this.el = el || {};
      this.multiple = multiple || false;

      // Variables privadas
      var links = this.el.find(".js-accordion-link");
      // Evento
      links.on(
          "click",
          { el: this.el, multiple: this.multiple },
          this.dropdown
      );
  };

  Accordion.prototype.dropdown = function (e) {
      var $el = e.data.el,
          $this = $(this),
          $next = $this.next();

      $next.slideToggle();
      $this.parent().toggleClass("is-open");

      if (!e.data.multiple) {
          $el.find(".js-accordion-submenu")
              .not($next)
              .slideUp()
              .parent()
              .removeClass("is-open");
          $el.find(".js-accordion-submenu").not($next).slideUp();
      }
  };
  var accordion = new Accordion($("#accordion"), false);
}
accordion();



$('.investor_slider_mobile').slick({
  infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  dots: false,
  autoplay: true,   
});



$('.recent_interview_slider').slick({
  infinite: true,
  slidesToShow: 4,
  slidesToScroll: 1,
  arrows: false,
  dots: false,
  autoplay: true,
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
              slidesToShow: 1,
              slidesToScroll: 1
          }
  }
]
});

// $(document).ready(function () {
//   $('#example').DataTable({searching: false, paging: false, info: false});
// });




/*--- range slider ---------*/
$('body').on('click', '.toggle-filters', function() {
    var $this = $(this),
        rangeWrapper = $('.range-slider-wrapper'),
        advancedFilters = $('.advanced-filters');
  
    if(!rangeWrapper.hasClass('filters-expanded')) {
      
      $this.html('Hide advanced filters');
      rangeWrapper.addClass('filters-expanded');
      advancedFilters.slideDown();
      
      $('.slider').each(function() {
        var minValue = Number($(this).find('.min-value').attr('data-selected-value')),
            maxValue = Number($(this).attr('data-max')),
            value = Number($(this).attr('data-value')),
            step = Number($(this).attr('data-step')),
            $this = $(this);
        
        $this.slider({
          range: true,
          values: [minValue, maxValue],
          slide: function(event, ui) {
            var selectedMin = ui.values[0],
                selectedMax = ui.values[1],
                currentValueMin = selectedMin,
                currentValueMax = selectedMax;
            if(selectedMin > 999) {
              currentValueMin = selectedMin / 1000 + 'k';
              currentValueMax = selectedMax / 1000 + 'k';
            }
            
            $this.find('.min-value').html(currentValueMin).attr('data-selected-value', selectedMin);
            $this.find('.max-value').html(currentValueMax).attr('data-selected-value', selectedMax);
          }
          
        });
        
        var currentValueMin = minValue,
            currentValueMax = maxValue;
        if(currentValueMin > 999) {
          currentValueMin = currentValueMin / 1000 + 'k';
          currentValueMax = currentValueMax / 1000 + 'k';
        }
        $this.find('span[tabindex]:first-of-type .value').html(currentValueMin).attr('data-selected-value', minValue);
        $this.find('span[tabindex]:last-of-type').append('<span class="value max-value" data-selected-value></span>').find('.value').html(currentValueMax).attr('data-selected-value', maxValue);
      });
      
    } else {
      $this.html('Show advanced filters');
      rangeWrapper.removeClass('filters-expanded');
      advancedFilters.slideUp();
      
      $('.slider').each(function() {
        var value = Number($(this).attr('data-value')),
            $this = $(this);
        
        $this.slider({
          value: value,
          range: 'min',
          slide: function(event, ui) {
        var currentValue = ui.value;
        if(currentValue > 999) {
          currentValue = currentValue / 1000 + 'k';
        }
        $(this).find('.value').html(currentValue).attr('data-selected-value', ui.value);
      }
        });
      
    });
    }
  });
  
  $('.slider').each(function() {
    var minValue = Number($(this).attr('data-min')),
        maxValue = Number($(this).attr('data-max')),
        value = Number($(this).attr('data-value')),
        step = Number($(this).attr('data-step')),
        type = $(this).attr('data-type'),
        $this = $(this);
    
    $this.slider({
      range: 'min',
      value: value,
      min: minValue,
      max: maxValue,
      step: step,
      slide: function(event, ui) {
        var currentValue = ui.value;
        if(currentValue > 999) {
          currentValue = currentValue / 1000 + 'k';
        }
        $(this).find('.value').html(currentValue).attr('data-selected-value', ui.value);
      },
      change:function(event,ui){
        const source = $(this).parent().find('.vue-value').attr('data-from');
        $(this).parent().find('.vue-value').val(ui.value);
        if(source=='infCalucaltor'){
          document.getElementById('infCalucaltor-jquery-click').click();
        }else if(source=='retirementCalculator'){
          // document.getElementById('retirementCalulator-jquery-click').click();
        }else{
          document.getElementById('show-table-click').click();
        }
      }
    });
    
    var sliderHandle = $this.find('.ui-slider-handle'),
        currentValue = sliderHandle.parent().attr('data-value');
    sliderHandle.append('<span ref="sip" class="value min-value" data-type="'+type+'" data-selected-value="'+ currentValue +'"></span>');
    
    if(minValue > 999) {
      value = value / 1000 + 'k';
    }
    
    $this.find('.value').html(value);
  });
/*--- range slider ---------*/

