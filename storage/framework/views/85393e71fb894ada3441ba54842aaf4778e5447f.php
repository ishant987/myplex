<footer class="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-sm-9 col-sm-12">
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 f-col-cn f-col-1">
              <?php if(isset($optsDbArr['quick_link_1'])): ?>
              <h6><?php echo e($optsDbArr['quick_link_1']); ?></h6>
              <?php endif; ?>
              <?php echo $webfootermenu; ?>

            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 f-col-cn f-col-2">
              <?php if(isset($optsDbArr['quick_link_2'])): ?>
              <h6><?php echo e($optsDbArr['quick_link_2']); ?></h6>
              <?php endif; ?>
              <?php echo $webfooterquicklinkmenu; ?>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 f-col-cn f-col-3">
              <?php if(isset($optsDbArr['quick_contact_label'])): ?>
              <h6><?php echo e($optsDbArr['quick_contact_label']); ?></h6>
              <?php endif; ?>
              <div class="col-12 p-0 f-dd">
                <?php if(isset($optsDbArr['address'])): ?>
                <div class="f-icon"><img src="<?php echo e(asset('themes/frontend/assets/images/location-icon.png')); ?>" alt="location"></div>
                <div class="f-content">
                  <p><?php echo nl2br($optsDbArr['address']); ?></p>
                </div>
                <div class="clear"></div>
                <?php endif; ?>
              </div>
              <div class="col-12 p-0 f-dd">
                <?php if( isset($optsDbArr['contact1']) || isset($optsDbArr['contact2']) ): ?>
                <div class="f-icon"><img src="<?php echo e(asset('themes/frontend/assets/images/call-icon.png')); ?>" alt="call-icon"></div>
                <div class="f-content">
                  <?php if( isset($optsDbArr['contact1']) ): ?>
                  <p><?php echo $optsDbArr['contact1']; ?></p>
                  <?php endif; ?>
                  <?php if( isset($optsDbArr['contact2']) ): ?>
                  <p><?php echo $optsDbArr['contact2']; ?></p>
                  <?php endif; ?>
                </div>
                <div class="clear"></div>
                <?php endif; ?>
              </div>
              <div class="col-12 p-0 f-dd">
                <div class="f-icon"><img src="<?php echo e(asset('themes/frontend/assets/images/web-icon.png')); ?>" alt="web-icon"></div>
                <div class="f-content">
                  <p><?php echo e(__('web.ftr_email_txt')); ?>

                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => 'mailto:'.e($optsDbArr['to_email']).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => 'mailto:'.e($optsDbArr['to_email']).'']); ?><?php echo e($optsDbArr['to_email']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </p>
                  <p><?php echo e(__('web.ftr_web_txt')); ?>

                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(config('app.url')).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(config('app.url')).'']); ?><?php echo e(str_replace(['http://', 'https://'], '', config('app.url'))); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </p>
                </div>
                <div class="clear"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 footer-last">
          <div class="col-12 f-col-logo p-0 text-right">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => '/','class' => 'img-fluid']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => '/','class' => 'img-fluid']); ?>
              <?php if(isset($optsDbArr['media_folder']) && isset($optsDbArr['logo'])): ?>
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($optsDbArr['media_folder'].$optsDbArr['logo']).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($optsDbArr['media_folder'].$optsDbArr['logo']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
              <?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
          </div>
          <div class="col-12 f-col-social p-0">
            <?php if( isset( $optsDbArr['facebook'] ) || isset( $optsDbArr['twitter'] ) || isset( $optsDbArr['linkedin'] ) ): ?>
            <div class="d-flex justify-content-end">
              <?php if( isset( $optsDbArr['facebook'] ) ): ?>
              <div class="social-div">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($optsDbArr['facebook']).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($optsDbArr['facebook']).'','target' => '_blank']); ?>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/facebook-icon.png')).'','alt' => 'facebook']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/facebook-icon.png')).'','alt' => 'facebook']); ?>
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
              </div>
              <?php endif; ?>
              <?php if( isset( $optsDbArr['twitter'] ) ): ?>
              <div class="social-div">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($optsDbArr['twitter']).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($optsDbArr['twitter']).'','target' => '_blank']); ?>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/twiiter-icon.png')).'','alt' => 'twitter']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/twiiter-icon.png')).'','alt' => 'twitter']); ?>
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
              </div>
              <?php endif; ?>
              <?php if( isset( $optsDbArr['linkedin'] ) ): ?>
              <div class="social-div">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($optsDbArr['linkedin']).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($optsDbArr['linkedin']).'','target' => '_blank']); ?>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/linkedin-icon.png')).'','alt' => 'linkedin']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/linkedin-icon.png')).'','alt' => 'linkedin']); ?>
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
              </div>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom bg-b">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6 co-sm-12 f-b-lft">
          <p><?php echo e(__('common.copyright_txt')); ?> <?php echo e(date('Y')); ?> <?php echo e(__('common.right_resrv_txt')); ?></p>
        </div>
        <div class="col-lg-6 col-md-6 co-sm-12 f-b-rgt">
          <?php echo $webfooterlegallinkmenu; ?>

        </div>
      </div>
    </div>
  </div>
</footer><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/themes/frontend/includes/footer.blade.php ENDPATH**/ ?>