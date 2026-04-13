<?php $__env->startSection('captcha'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery-validate'); ?> <?php $__env->stopSection(); ?>
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
<?php $__env->startPush('styles'); ?>
<style>
  .custom-banner {
    background-image: url('<?php echo e($dataArr['image_path']); ?>');
  }
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php if($dataArr['full_url']): ?>
<?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
<div class="custom-banner no-bg analysis-login-banner">
  <div class="container">
    <?php if(isset($dataArr['custom_fields']['textarea_29'])): ?>
    <h1 class="f-b"><?php echo nl2br($dataArr['custom_fields']['textarea_29']['value']); ?></h1>
    <?php endif; ?>
  </div>
</div>

<div class="myplexus-login-page">
  <div class="login-page">
    <div class="container">
      <div class="login-block bg-gry br-5 box-shadow">
        <div class="login-wrap">
          <div class="col-lg-9 col-md-9 col-sm-12 m-auto analysis-login-main-box">
            <?php echo $dataArr['descp']; ?>

            <form action="<?php echo e(route('web.signup.save')); ?>" name="signupFrm" id="signupFrm" method="post">
              <?php echo e(csrf_field()); ?>

              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.hidden','data' => ['name' => 'recaptcha_v3','id' => 'recaptcha_v3']]); ?>
<?php $component->withName('form.field.hidden'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'recaptcha_v3','id' => 'recaptcha_v3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label><?php echo e(__('common.f_name_txt')); ?></label>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text2','data' => ['id' => 'f_name','name' => 'f_name','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.f_name_txt')).'','value' => ''.e(old('f_name')).'']]); ?>
<?php $component->withName('form.field.text2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'f_name','name' => 'f_name','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.f_name_txt')).'','value' => ''.e(old('f_name')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label><?php echo e(__('common.l_name_txt')); ?></label>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text2','data' => ['id' => 'l_name','name' => 'l_name','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.l_name_txt')).'','value' => ''.e(old('l_name')).'']]); ?>
<?php $component->withName('form.field.text2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'l_name','name' => 'l_name','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.l_name_txt')).'','value' => ''.e(old('l_name')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label><?php echo e(__('common.email_txt')); ?></label>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text2','data' => ['type' => 'email','id' => 'email','name' => 'email','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.email_txt')).'','value' => ''.e(old('email')).'']]); ?>
<?php $component->withName('form.field.text2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'email','id' => 'email','name' => 'email','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.email_txt')).'','value' => ''.e(old('email')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label><?php echo e(__('common.mobile_txt')); ?></label>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text2','data' => ['type' => 'tel','id' => 'mobile','name' => 'mobile','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.mobile_txt')).'','value' => ''.e(old('mobile')).'']]); ?>
<?php $component->withName('form.field.text2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'tel','id' => 'mobile','name' => 'mobile','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.mobile_txt')).'','value' => ''.e(old('mobile')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label><?php echo e(__('subscribeduser.company_txt')); ?></label>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text2','data' => ['id' => 'company','name' => 'company','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.company_txt')).'','value' => ''.e(old('company')).'']]); ?>
<?php $component->withName('form.field.text2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'company','name' => 'company','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.company_txt')).'','value' => ''.e(old('company')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label><?php echo e(__('subscribeduser.pincode_txt')); ?></label>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text2','data' => ['id' => 'pincode','name' => 'pincode','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.pincode_txt')).'','value' => ''.e(old('pincode')).'']]); ?>
<?php $component->withName('form.field.text2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'pincode','name' => 'pincode','class' => 'box-shadow','placeholder' => ''.e(__('subscribeduser.placeholder.pincode_txt')).'','value' => ''.e(old('pincode')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
              </div>

              <div class="row register-analysis-bottom">
                <div class="col-lg-12 col-md-12 col-sm-12 text-right register-action">
                  <label>&nbsp;</label>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button3','data' => ['class' => 'form-submit btn-bg-2 text-white text-uppercase','type' => 'button','id' => 'sendSignupFrm','name' => 'sendSignupFrm','text' => ''.e($defDataArr['web_lang']['register_txt']).'']]); ?>
<?php $component->withName('form.field.button3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'form-submit btn-bg-2 text-white text-uppercase','type' => 'button','id' => 'sendSignupFrm','name' => 'sendSignupFrm','text' => ''.e($defDataArr['web_lang']['register_txt']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
              </div>
            </form>
            <div id="msg_id"></div>
            <div class="no-account-wrap">
              <div class="no-account-container">
                <div class="no-acount-message">
                  <span class="text-green"><?php echo e(__('auth.sign_in_prfx_txt')); ?></span>
                </div>
                <div class="creat-account-message">
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.login')).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.login')).'']); ?><?php echo e(__('auth.sign_in2_txt')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
  $(function() {
    $("#signupFrm").validate({
        rules: {
          f_name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          mobile: {
            required: true,
            number: true
          },
          pincode: {
            required: true,
            number: true
          }
        },
        messages: {
          f_name: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.f_name_txt'))); ?>",
          email: {
            required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt'))); ?>",
            email: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt'))); ?>"
          },
          mobile: {
            required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.mobile_txt'))); ?>",
            number: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.mobile_txt'))); ?>"
          },
          pincode: {
            required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('subscribeduser.pincode_txt'))); ?>",
            number: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('subscribeduser.pincode_txt'))); ?>"
          }
        }
      }),
      $("#sendSignupFrm").click(function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("<?php echo e(Config('commonconstants.recaptcha.site_key')); ?>", {
            action: 'signup_form'
          }).then(function(token) {
            var a = $("#signupFrm");
            if (1 == a.valid()) {
              if (token) {
                $("#recaptcha_v3").val(token);
                // alert($("#recaptcha_v3").val());
                var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  f_name: $("#f_name").val(),
                  l_name: $("#l_name").val(),
                  email: $("#email").val(),
                  mobile: $("#mobile").val(),
                  company: $("#company").val(),
                  pincode: $("#pincode").val(),
                  recaptcha_v3: $("#recaptcha_v3").val()
                };
                $.ajax({
                  url: "<?php echo e(route('web.signup.save')); ?>",
                  type: "post",
                  data: formData,
                  dataType: 'json',
                  beforeSend: function() {
                    $('#sendSignupFrm').prop('disabled', true);
                    $("#sendSignupFrm").text("<?php echo e($defDataArr['web_lang']['processing_txt']); ?>");
                  },
                  success: function(data) {
                    // console.log(data);
                    // alert(data['msg']);
                    $('#sendSignupFrm').prop('disabled', false);
                    $("#sendSignupFrm").text("<?php echo e($defDataArr['web_lang']['register_txt']); ?>");
                    $("#msg_id").html(data['msg']);
                    if (data['url'] != '') {
                      window.location.href = data['url'];
                    }
                  },
                  error: function(e) {
                    // console.log(e);
                    $("#msg_id").html('There is error while submit');
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
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/themes/frontend/pages/signup.blade.php ENDPATH**/ ?>