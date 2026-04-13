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

            <form action="<?php echo e(route('web.investor-signup.save')); ?>" name="investorsignupFrm" id="investorsignupFrm" method="post">
              <?php echo e(csrf_field()); ?>             

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label><?php echo e(__('First Name')); ?></label>
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
                  <label><?php echo e(__('Last Name')); ?></label>
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
                  <label><?php echo e(__('I am an')); ?></label>
                 <select id="user_type" name="user_type" class="box-shadow">
					 <option value="">Select an option</option>
					 <option value="Advisor">Advisor</option>
					 <option value="Fund House Representative">Fund House Representative</option>
					 <option value="Investor">Investor</option>
					</select>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
			<input type="checkbox" name="is_contacted_with_team" id="is_contacted_with_team" value="No" class="form-controll box-shadow w-auto" />
                  <?php echo e(__('I want to be contacted by MyPlexus Team')); ?>                  
                </div>               
              </div>

              <div class="row register-analysis-bottom">
                <div class="col-lg-12 col-md-12 col-sm-12 text-right register-action">
					<button type="button" id="sendInvestorSignupFrm" class="btn form-submit btn-bg-2 text-white text-uppercase" >Submit</button>
					                
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
	
$('#is_contacted_with_team').on('click', (e) => {
	
	if( $('#is_contacted_with_team').is(':checked') )
	{
		$('#is_contacted_with_team').val('Yes');
	} else {	
		$('#is_contacted_with_team').val('No');		
	}
});
	
	
  $(function() {
    $("#investorsignupFrm").validate({
        rules: {
          f_name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          user_type: {
            required: true
          }
        },
        messages: {
          f_name: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.f_name_txt'))); ?>",
          email: {
            required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt'))); ?>",
            email: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt'))); ?>"
          },
          user_type: {
            required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('select an option'))); ?>"
          }
        }
      }),
      $("#sendInvestorSignupFrm").click(function(e) {
        e.preventDefault();
		
		var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  f_name: $("#f_name").val(),
                  l_name: $("#l_name").val(),
                  email: $("#email").val(),
                  user_type: $("#user_type").val(),
                  is_contacted_with_team: $("#is_contacted_with_team").val()
                };
		
		 $.ajax({
                  url: "<?php echo e(route('web.investor-signup.save')); ?>",
                  type: "post",
                  data: formData,
                  dataType: 'json',
                  beforeSend: function() {
                    $('#investorsendSignupFrm').prop('disabled', true);
                    $("#investorsendSignupFrm").text("<?php echo e($defDataArr['web_lang']['processing_txt']); ?>");
                  },
                  success: function(data) {
                    // console.log(data);
                    // alert(data['msg']);
                    $('#investorsendSignupFrm').prop('disabled', false);
                    $("#investorsendSignupFrm").text("<?php echo e($defDataArr['web_lang']['register_txt']); ?>");
                    $("#msg_id").html(data['msg']);
                    if (data['url'] != '') {
						
						//console.log(data['url'];);
						
                      window.location.href = data['url'];
                    }
                  },
                  error: function(e) {
                    // console.log(e);
                    $("#msg_id").html('There is error while submit');
                  }
                });		
        
      	});
  });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/pages/investor/create-investor.blade.php ENDPATH**/ ?>