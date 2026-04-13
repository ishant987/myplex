<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('captcha'); ?> <?php $__env->stopSection(); ?>
<?php if(isset($dataArr['meta_title'])): ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['meta_title']); ?><?php $__env->stopSection(); ?>
<?php else: ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['title']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_key'])): ?>
<?php $__env->startSection('meta-keywords'); ?><?php echo e($dataArr['meta_key']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_descp'])): ?>
<?php $__env->startSection('meta-description'); ?><?php echo e($dataArr['meta_descp']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['image_path'])): ?>
<?php $__env->startSection('meta-image'); ?><?php echo e($dataArr['image_path']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if($dataArr['full_url']): ?>
<?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>Contact Us</h4>
                    <p>We are always here to help you make the best decisions for your finances.</p>
                </div>
            </div>
        </div>
    </div>
</section>  
<section class="inner_contact_us">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="Contact_heading text-center">
                    <h4>Plexus Managment Service</h4>
                    <p>
                        We are here to show you a better way of investment using the tools that will help you make the best decisions for your wealth.
                    </p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="main_contact_bg">
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="light_bg_contact">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="contact_icon">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/contact_call.png')); ?>"/>
                                    </div>
                                    <div class="contact_text">
                                        <span>INDIA - <a href="">09073977460</a></span>
                                        <span>INDIA - <a href="">033-40646145</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="light_bg_contact">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="contact_icon">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/contact_mail.png')); ?>"/>
                                    </div>
                                    <div class="contact_text">
                                        <a href="">contact@myplexus.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="light_bg_contact">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="contact_icon">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/contact_map.png')); ?>"/>
                                    </div>
                                    <div class="contact_text">
                                        <p>11/5, 75C Park Street.
                                            Kolkata-700016</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="get_in_touch_text">
                        <h4>Get in touch with us</h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="contat_form">
                                <form action="<?php echo e(route('web.contact.save')); ?>" name="cntctFrm" id="cntctFrm" method="post">
                                    <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="recaptcha_v3" id="recaptcha_v3" >
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <input type="text" class="form-control"  placeholder="First Name" name="first_name" id="first_name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <input type="text" class="form-control"  placeholder="Last Name" name="last_name" id="last_name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <input type="text" class="form-control"  placeholder="Email ID" name="email" id="email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <input type="text" class="form-control"  placeholder="Contact" name="mobile" id="mobile">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="">
                                                <textarea class="form-control"  placeholder="Enter message..." rows="10" name="message" id="message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <input type="submit" class="compare_scheme_btn btn-block" id="sendCntctFrm" name="sendCntctFrm" value="Submit information"/>
                                        </div>
                                    </div>
                                </form>
                                <div id="cmsg_id"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="box_need_help">
                                <div class="need_help">
                                    <h3>Need any help?</h3>
                                    <p>If you have any questions or need help understanding anything, please don't hesitate to contact us. We would be more than happy to assist you in making the best choices for your financial future. </p>
                                    <a href="" class="call_back_btn compare_scheme_btn d-inline-block w-auto">Get a call back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>   

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
  $(function() {
    $("#cntctFrm").validate({
        rules: {
          first_name: {
            required: true
          },
          last_name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          mobile: {
            required: false,
            number: true
          },
          message: {
            required: true
          }
        },
        messages: {
          first_name: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('contact.first_name_txt'))); ?>",
          last_name: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('contact.last_name_txt'))); ?>",
          email: {
            required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('contact.email_txt'))); ?>",
            email: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('contact.email_txt'))); ?>"
          },
          mobile: {
            number: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.mobile_txt'))); ?>"
          },
          message: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('contact.message_txt'))); ?>"
        }
      }),
      $("#sendCntctFrm").click(function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("<?php echo e(Config('commonconstants.recaptcha.site_key')); ?>", {
            action: 'contact_form'
          }).then(function(token) {
            var a = $("#cntctFrm");
            if (1 == a.valid()) {
              if (token) {
                $("#recaptcha_v3").val(token);
                var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  first_name: $("#cntctFrm #first_name").val(),
                  last_name: $("#cntctFrm #last_name").val(),
                  email: $("#cntctFrm #email").val(),
                  mobile: $("#cntctFrm #mobile").val(),
                  message: $("#cntctFrm #message").val(),
                  recaptcha_v3: $("#cntctFrm #recaptcha_v3").val()
                };
                $.ajax({
                  url: "<?php echo e(route('web.contact.save')); ?>",
                  type: "post",
                  data: formData,
                  dataType: 'json',
                  beforeSend: function() {
                    $('#sendCntctFrm').prop('disabled', true);
                    $("#sendCntctFrm").text("<?php echo e($defDataArr['web_lang']['processing_txt']); ?>");
                  },
                  success: function(data) {
                    console.log(data);
                    // alert(data['msg']);
                    $('#sendCntctFrm').prop('disabled', false);
                    $("#sendCntctFrm").text("<?php echo e($defDataArr['web_lang']['submit_query_txt']); ?>");
                    $("#cmsg_id").html(data['msg']);
                    if (data['url'] != '') {
                      window.location.href = data['url'];
                    }
                  },
                  error: function(e) {
                    console.log(e);
                    $("#cmsg_id").html('There is error while submit');
                  }
                });
              }
            }
          });
        });
      });
  });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/pages/contact.blade.php ENDPATH**/ ?>