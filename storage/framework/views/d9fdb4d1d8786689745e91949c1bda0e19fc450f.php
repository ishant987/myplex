<div class="patshala-new patshala-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 patshala">
        <?php if(isset($stngDataArr['paathshaala_heading'])): ?>
        <h3><?php echo e($stngDataArr['paathshaala_heading']); ?></h3>
        <?php endif; ?>
        <div class="patshala-new-lft br-5">
          <?php if(count($pthPgsMdl) > 0): ?>
          <ul>
            <?php $__currentLoopData = $pthPgsMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pthRecord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if( $pthRecord->getPageName() != false ): ?>
            <li><a href="<?php echo e($pthRecord->getPageName()); ?>"><?php echo $pthRecord->title; ?></a></li>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 newsletter">
        <?php if(isset($stngDataArr['newsletter_heading'])): ?>
        <h3><?php echo e($stngDataArr['newsletter_heading']); ?></h3>
        <?php endif; ?>
        <div class="news-wrap">
          <?php if(isset($stngDataArr['newsletter_description'])): ?>
          <p><?php echo nl2br($stngDataArr['newsletter_description']); ?></p>
          <?php endif; ?>
          <form action="<?php echo e(route('web.newsletter.save')); ?>" name="newsletterFrm" id="newsletterFrm" method="post">
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
            <div class="f-fields d-flex">
              <div class="f-email">
                <input type="email" name="email" id="email" placeholder="Enter Email" />
              </div>
              <div class="f-submit">
                <input type="button" id="sendNewsletterFrm" name="sendNewsletterFrm" value="<?php echo e($defDataArr['web_lang']['submit_txt']); ?>" />
              </div>
            </div>
          </form>
          <div id="msg_id"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
  $(function() {
    $("#newsletterFrm").validate({
        rules: {
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          email: {
            required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt'))); ?>",
            email: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt'))); ?>"
          }
        }
      }),
      $("#sendNewsletterFrm").click(function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("<?php echo e(Config('commonconstants.recaptcha.site_key')); ?>", {
            action: 'newsletter_form'
          }).then(function(token) {
            var a = $("#newsletterFrm");
            if (1 == a.valid()) {
              if (token) {
                $("#recaptcha_v3").val(token);
                // alert($("#recaptcha_v3").val());
                var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  email: $("#email").val(),
                  recaptcha_v3: $("#recaptcha_v3").val()
                };
                $.ajax({
                  url: "<?php echo e(route('web.newsletter.save')); ?>",
                  type: "post",
                  data: formData,
                  dataType: 'json',
                  beforeSend: function() {
                    $('#sendNewsletterFrm').prop('disabled', true);
                    $("#sendNewsletterFrm").attr('value', "<?php echo e($defDataArr['web_lang']['processing_txt']); ?>");
                  },
                  success: function(data) {
                    // alert(data['msg']);
                    $('#sendNewsletterFrm').prop('disabled', false);
                    $("#sendNewsletterFrm").attr('value', "<?php echo e($defDataArr['web_lang']['submit_txt']); ?>");
                    $("#msg_id").html(data['msg']);
                    $('#newsletterFrm')[0].reset();
                  },
                  error: function() {
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
<?php $__env->stopPush(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/includes/patshala-newsletter.blade.php ENDPATH**/ ?>