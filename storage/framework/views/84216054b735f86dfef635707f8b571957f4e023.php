<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php if(View::hasSection('moneycontrol')): ?>
<script src="https://stat2.moneycontrol.com/mcjs/common/jquery-1.7.2.min.js"></script>
<script>
  var ct_v = '170940';
</script>
<!-- <script src="https://www.gstatic.com/swiffy/v7.3.0/runtime.js"></script> -->
<script src="https://stat4.moneycontrol.com/mcjs/mcradar/market_radar_aws.js?ver=20200516"></script>
<script src="https://stat.moneycontrol.co.in/mcjs/mcradar/jquery-ui-1.10.3.custom.min.js"></script>
<script src=" https://stat.moneycontrol.co.in/mcjs/portfolio_plus/datepicker.js?"></script>
<script src="https://stat.moneycontrol.co.in/mcjs/mcradar/jquery.webticker.js"></script>
<?php endif; ?>
<?php if(View::hasSection('select2')): ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $('#topic').select2({
    placeholder: "Search by Topic"
  });
</script>
<?php endif; ?>
<!-- <script src="<?php echo e(asset('themes/frontend/assets/js/script.js')); ?>"></script> -->
<?php if(View::hasSection('owl-carousel')): ?>
<script src="<?php echo e(asset('themes/frontend/assets/js/owl-carousel/owl.carousel.js')); ?>"></script>
<?php endif; ?>
<?php if(View::hasSection('datatables')): ?>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<?php endif; ?>
<?php if(View::hasSection('jquery-validate')): ?>
<script src="<?php echo e(asset('themes/assets/js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/assets/js/additional-methods.min.js')); ?>"></script>
<?php endif; ?>
<?php if(View::hasSection('captcha')): ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo e(Config('commonconstants.recaptcha.site_key')); ?>"></script>
<?php endif; ?>
<?php if(View::hasSection('fancybox')): ?>
<script src="<?php echo e(asset('themes/assets/fancybox-v3.2.5/dist/jquery.fancybox.min.js')); ?>"></script>
<script>
  $(document).ready(function() {
    $("[data-fancybox-full]").fancybox({
      /*toolbar  : false,*/
      smallBtn: true
    });
    $("[data-fancybox]").fancybox({
      /*toolbar  : false,*/
      smallBtn: true,
      iframe: {
        css: {
          width: '900px',
          height: '400px'
        }
      }
    });
  });
</script>
<?php endif; ?>
<?php if(View::hasSection('like-unlike')): ?>
<script>
  $('.like-unlike').on('click', function(e) {
    e.preventDefault();
    var type = $(this).attr("data-type");
    var data_id = $(this).attr("data-id");
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type: "POST",
      url: "<?php echo e(route('web.likeunlike')); ?>",
      data: {
        _token: token,
        type: type,
        data_id: data_id
      },
      dataType: "json",
      success: function(data) {
        // console.log(data);
        var type = data['type'];
        // alert($(this));
        if (type != '') {
          if (type == 'success') {
            var thisObj = $(".like-unlike[data-id|='" + data["data_id"] + "']");
            $(thisObj).html('<sup class="like-counter">' + data['total'] + '</sup>');
            if ($(thisObj).hasClass('like'))
              $(thisObj).removeClass('like').addClass('liked');
            else
              $(thisObj).removeClass('liked').addClass('like');
          } else {
            if (data['redirect'] != '') {
              location.href = data['redirect'];
            }
          }
        }
      },
    });
  });
</script>
<?php endif; ?>
<?php if(View::hasSection('ans-like-unlike')): ?>
<script>
  $('.re-like-unlike').on('click', function(e) {
    e.preventDefault();
    var type = $(this).attr("data-type");
    var data_id = $(this).attr("data-id");
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type: "POST",
      url: "<?php echo e(route('web.likeunlike')); ?>",
      data: {
        _token: token,
        type: type,
        data_id: data_id
      },
      dataType: "json",
      success: function(data) {
        // console.log(data);
        var type = data['type'];
        // alert($(this));
        if (type != '') {
          if (type == 'success') {
            var likedObj = $(".re-like-unlike[data-id|='" + data["data_id"] + "']");
            $(likedObj).html('<sup class="like-counter">' + data['total'] + '</sup>');
            if ($(likedObj).hasClass('like'))
              $(likedObj).removeClass('like').addClass('liked');
            else
              $(likedObj).removeClass('liked').addClass('like');
          } else {
            if (data['redirect'] != '') {
              location.href = data['redirect'];
            }
          }
        }
      },
    });
  });
</script>
<?php endif; ?>

<?php if( View::hasSection('new-javascript-section') ): ?>
<script>
	$('document').ready(function() {
		console.log('script section');
	});
</script>
<?php endif; ?>

<?php if(View::hasSection('login-redirect')): ?>
<?php if(!\Auth::check()): ?>
<script>
  $(document).ready(function() {
    setTimeout(function() {
      window.location.href = "<?php echo e(route('web.login')); ?>"; //will redirect to login page
    }, {
      {
        Config('frontconstants.page_redirect_time_sec')
      }
    }* 1000); //will call the function after some secs.
  });
</script>
<?php endif; ?>
<?php endif; ?>


<script src="<?php echo e(mix('js/vue-app.js')); ?>"></script>

<?php echo $__env->yieldContent('page-footer-scripts'); ?>
<?php echo $__env->yieldContent('section-footer-scripts'); ?>
<?php echo $__env->yieldPushContent('scripts'); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/themes/frontend/includes/javascripts.blade.php ENDPATH**/ ?>