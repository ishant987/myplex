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
<?php endif; ?>
<?php if($dataArr['full_url']): ?>
<?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if( isset($dataArr['custom_fields']['image_16'])): ?>
<?php $__env->startPush('styles'); ?>
<style>
  .custom-banner {
    background-image: url('<?php echo e($defDataArr['media_folder'].$dataArr['custom_fields']['image_16']['value']); ?>');
  }
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
<div class="custom-banner no-bg">
  <div class="container">
    <?php if(isset($dataArr['custom_fields']['textarea_17'])): ?>
    <h1 class="f-b"><?php echo nl2br($dataArr['custom_fields']['textarea_17']['value']); ?></h1>
    <?php endif; ?>
  </div>
</div>

<div class="connect-us-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-7 col-sm-12 c-lft">
        <?php if(isset($dataArr['custom_fields']['textarea_18'])): ?>
        <h3 class="m-b-30"><?php echo nl2br($dataArr['custom_fields']['textarea_18']['value']); ?></h3>
        <?php endif; ?>
        <?php if(isset($dataArr['image_path'])): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($dataArr['image_path']).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($dataArr['image_path']).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endif; ?>
        <div class="contact-address m-t-30">
          <div class="c-block c-block-1">
            <?php if(isset($dataArr['custom_fields']['text_19'])): ?>
            <h6 class="text-green"><?php echo e($dataArr['custom_fields']['text_19']['value']); ?></h6>
            <?php endif; ?>
            <div class="c-address">
              <?php if(isset($dataArr['custom_fields']['textarea_20'])): ?>
              <?php echo nl2br($dataArr['custom_fields']['textarea_20']['value']); ?>

              <?php endif; ?>
            </div>
            <div class="c-details">
              <?php if(isset($dataArr['custom_fields']['text_21']) || isset($dataArr['custom_fields']['text_22'])): ?>
              <ul>
                <?php if(isset($dataArr['custom_fields']['text_21'])): ?>
                <li>
                  <p>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/call-icon-2.png')).'','alt' => 'call icon']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/call-icon-2.png')).'','alt' => 'call icon']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> <?php echo e($dataArr['custom_fields']['text_21']['value']); ?>

                  </p>
                </li>
                <?php endif; ?>
                <?php if(isset($dataArr['custom_fields']['text_22'])): ?>
                <li>
                  <p>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => 'mailto:'.e($dataArr['custom_fields']['text_22']['value']).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => 'mailto:'.e($dataArr['custom_fields']['text_22']['value']).'']); ?>
                      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/web-icon-2.png')).'','alt' => 'web icon']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/web-icon-2.png')).'','alt' => 'web icon']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> <?php echo e($dataArr['custom_fields']['text_22']['value']); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </p>
                </li>
                <?php endif; ?>
              </ul>
              <?php endif; ?>
            </div>
          </div>
          <div class="c-block c-block-2">
            <?php if(isset($dataArr['custom_fields']['text_23'])): ?>
            <h6 class="text-green"><?php echo e($dataArr['custom_fields']['text_23']['value']); ?></h6>
            <?php endif; ?>
            <div class="c-address">
              <?php if(isset($dataArr['custom_fields']['textarea_24'])): ?>
              <?php echo nl2br($dataArr['custom_fields']['textarea_24']['value']); ?>

              <?php endif; ?>
            </div>
            <div class="c-details">
              <?php if(isset($dataArr['custom_fields']['text_25']) || isset($dataArr['custom_fields']['text_26'])): ?>
              <ul>
                <?php if(isset($dataArr['custom_fields']['text_25'])): ?>
                <li>
                  <p>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/call-icon-2.png')).'','alt' => 'call icon']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/call-icon-2.png')).'','alt' => 'call icon']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> <?php echo e($dataArr['custom_fields']['text_25']['value']); ?>

                  </p>
                </li>
                <?php endif; ?>
                <?php if(isset($dataArr['custom_fields']['text_26'])): ?>
                <li>
                  <p>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => 'mailto:'.e($dataArr['custom_fields']['text_26']['value']).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => 'mailto:'.e($dataArr['custom_fields']['text_26']['value']).'']); ?>
                      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/web-icon-2.png')).'','alt' => 'web icon']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/web-icon-2.png')).'','alt' => 'web icon']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> <?php echo e($dataArr['custom_fields']['text_26']['value']); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </p>
                </li>
                <?php endif; ?>
              </ul>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-md-5 col-sm-12 c-rgt">
        <?php if(isset($dataArr['custom_fields']['textarea_27'])): ?>
        <h3 class="text-green m-b-30"><?php echo nl2br($dataArr['custom_fields']['textarea_27']['value']); ?></h3>
        <?php endif; ?>
        <div class="contact-form m-t-30">
          <?php echo $dataArr['descp']; ?>

          <form action="<?php echo e(route('web.contact.save')); ?>" name="cntctFrm" id="cntctFrm" method="post">
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

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt3','data' => ['label' => ''.e(__('contact.name_txt')).'','for' => 'name','error' => ''.e($errors->first('name')).'']]); ?>
<?php $component->withName('form.group_lyt3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('contact.name_txt')).'','for' => 'name','error' => ''.e($errors->first('name')).'']); ?>
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'name','name' => 'name','placeholder' => ''.e(__('contact.placeholder.name_txt')).'','value' => ''.e(\Auth::check() ? \Auth::user()->f_name.' '.\Auth::user()->l_name : old('name')).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'name','name' => 'name','placeholder' => ''.e(__('contact.placeholder.name_txt')).'','value' => ''.e(\Auth::check() ? \Auth::user()->f_name.' '.\Auth::user()->l_name : old('name')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt3','data' => ['label' => ''.e(__('contact.email_txt')).'','for' => 'email','error' => ''.e($errors->first('email')).'']]); ?>
<?php $component->withName('form.group_lyt3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('contact.email_txt')).'','for' => 'email','error' => ''.e($errors->first('email')).'']); ?>
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['type' => 'email','id' => 'email','name' => 'email','placeholder' => ''.e(__('contact.placeholder.email_txt')).'','value' => ''.e(\Auth::check() ? \Auth::user()->email : old('email')).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'email','id' => 'email','name' => 'email','placeholder' => ''.e(__('contact.placeholder.email_txt')).'','value' => ''.e(\Auth::check() ? \Auth::user()->email : old('email')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt3','data' => ['label' => ''.e(__('contact.mobile_txt')).'','for' => 'mobile','error' => ''.e($errors->first('mobile')).'']]); ?>
<?php $component->withName('form.group_lyt3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('contact.mobile_txt')).'','for' => 'mobile','error' => ''.e($errors->first('mobile')).'']); ?>
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['type' => 'tel','id' => 'mobile','name' => 'mobile','placeholder' => ''.e(__('contact.placeholder.mobile_txt')).'','value' => ''.e(\Auth::check() ? \Auth::user()->mobile : old('mobile')).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'tel','id' => 'mobile','name' => 'mobile','placeholder' => ''.e(__('contact.placeholder.mobile_txt')).'','value' => ''.e(\Auth::check() ? \Auth::user()->mobile : old('mobile')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt3','data' => ['label' => ''.e(__('contact.message_txt')).'','for' => 'message','error' => ''.e($errors->first('message')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('contact.message_txt')).'','for' => 'message','error' => ''.e($errors->first('message')).'','required' => 'true']); ?>
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.textarea','data' => ['id' => 'message','name' => 'message','rows' => '2','placeholder' => ''.e(__('contact.placeholder.message_txt')).'','value' => ''.old('message').'']]); ?>
<?php $component->withName('form.field.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'message','name' => 'message','rows' => '2','placeholder' => ''.e(__('contact.placeholder.message_txt')).'','value' => ''.old('message').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <div class="form-field-row">
              <div class="form-field text-right">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button3','data' => ['type' => 'button','id' => 'sendCntctFrm','name' => 'sendCntctFrm','text' => ''.e($defDataArr['web_lang']['submit_query_txt']).'']]); ?>
<?php $component->withName('form.field.button3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'button','id' => 'sendCntctFrm','name' => 'sendCntctFrm','text' => ''.e($defDataArr['web_lang']['submit_query_txt']).'']); ?>
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
        </div>
      </div>
    </div>
  </div>
</div>

<div class="connect-gmap">
  <div class="container">
    <?php if(isset($dataArr['custom_fields']['textarea_28'])): ?>
    <div class="gmap-wrap box-shadow">
      <?php echo nl2br($dataArr['custom_fields']['textarea_28']['value']); ?>

    </div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
  $(function() {
    $("#cntctFrm").validate({
        rules: {
          name: {
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
          name: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('contact.name_txt'))); ?>",
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
                // alert($("#recaptcha_v3").val());
                var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  name: $("#name").val(),
                  email: $("#email").val(),
                  mobile: $("#mobile").val(),
                  message: $("#message").val(),
                  recaptcha_v3: $("#recaptcha_v3").val()
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
                    $("#msg_id").html(data['msg']);
                    if (data['url'] != '') {
                      window.location.href = data['url'];
                    }
                  },
                  error: function(e) {
                    console.log(e);
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
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/contact.blade.php ENDPATH**/ ?>