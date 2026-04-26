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
<style>
    .reset-shell {
        padding: 28px 0 48px;
    }

    .reset-card {
        border: 0;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .reset-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(260px, 0.85fr);
        gap: 24px;
        padding: 28px;
        background:
            radial-gradient(circle at top left, rgba(15, 157, 88, 0.18), transparent 34%),
            linear-gradient(145deg, #ffffff, #f4f8fc);
        border-bottom: 1px solid #e8edf3;
    }

    .reset-title p {
        margin: 0 0 8px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #0f9d58;
        font-weight: 700;
    }

    .reset-title h1 {
        margin: 0 0 10px;
        color: #10243c;
        font-size: 34px;
        line-height: 1.05;
    }

    .reset-title .lead {
        margin: 0;
        color: #64748b;
        font-size: 16px;
    }

    .reset-info-card {
        background: #10243c;
        color: #fff;
        border-radius: 22px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
    }

    .reset-info-card h5 {
        margin: 0;
        font-size: 18px;
        color: #fff;
    }

    .reset-info-card p {
        margin: 0;
        color: #fff;
        line-height: 1.6;
        font-size: 14px;
    }

    .reset-form-wrap {
        padding: 28px;
    }

    .reset-form-card {
        border: 1px solid #e8edf3;
        border-radius: 24px;
        padding: 24px;
        background: #fff;
    }

    .reset-form-head {
        margin-bottom: 20px;
    }

    .reset-form-head h5 {
        margin: 0 0 6px;
        color: #10243c;
        font-size: 22px;
    }

    .reset-form-head p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .reset-form-wrap .form-control {
        border-radius: 14px;
        border: 1px solid #d9e3ee;
        min-height: 48px;
        padding: 11px 14px;
        box-shadow: none;
    }

    .reset-form-wrap .field-icon {
        right: 16px;
        top: 16px;
    }

    .reset-actions {
        padding-top: 10px;
    }

    .reset-actions .btn {
        min-width: 190px;
        border-radius: 999px;
        padding: 12px 24px;
        font-weight: 700;
        border: 0;
    }

    .reset-actions .btn-primary {
        background: linear-gradient(145deg, #0f9d58, #69b53f);
    }

    @media (max-width: 991px) {
        .reset-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .reset-shell {
            padding: 20px 0 36px;
        }

        .reset-hero,
        .reset-form-wrap,
        .reset-form-card {
            padding: 20px;
        }

        .reset-title h1 {
            font-size: 28px;
        }

        .reset-actions .btn {
            min-width: 100%;
        }
    }
</style>
<div class="container">
    <div class="row reset-shell">
        <div class="col-md-4 col-lg-3 col-12">
            <?php echo $__env->make('themes.frontend.includes.user-left-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-8 col-lg-9 col-12">
            <div class="content-form bg-lightblue reset-card">
                <div class="reset-hero">
                    <div class="reset-title">
                        <p>Account Security</p>
                        <h1>Reset Password</h1>
                        <div class="lead">Choose a strong new password to keep your account protected and your sessions secure.</div>
                    </div>
                    <div class="reset-info-card">
                        <h5>Password tips</h5>
                        <p>Use at least 6 characters and avoid reusing your current password. After a successful reset, you’ll be signed out and asked to log in again.</p>
                    </div>
                </div>

                <form action="<?php echo e(route('web.reset.password.save')); ?>" method="post" id="resetPasswordForm">
                    <?php echo e(csrf_field()); ?>

                    <div class="reset-form-wrap">
                        <div class="reset-form-card">
                            <div class="reset-form-head">
                                <h5>Change Your Password</h5>
                                <p>Enter your current password first, then confirm the new one below.</p>
                            </div>

                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt4','data' => ['label' => ''.e(__('subscribeduser.cr_password_txt')).'','for' => 'current_password','error' => ''.e($errors->first('current_password')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt4'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('subscribeduser.cr_password_txt')).'','for' => 'current_password','error' => ''.e($errors->first('current_password')).'','required' => 'true']); ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['type' => 'password','id' => 'current_password','name' => 'current_password','value' => '']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'password','id' => 'current_password','name' => 'current_password','value' => '']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt4','data' => ['label' => ''.e(__('subscribeduser.n_password_txt')).'','for' => 'new_password','error' => ''.e($errors->first('new_password')).'','info' => ''.e(__('subscribeduser.info.pwd_len_txt')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt4'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('subscribeduser.n_password_txt')).'','for' => 'new_password','error' => ''.e($errors->first('new_password')).'','info' => ''.e(__('subscribeduser.info.pwd_len_txt')).'','required' => 'true']); ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['type' => 'password','id' => 'new_password','name' => 'new_password','value' => '']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'password','id' => 'new_password','name' => 'new_password','value' => '']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt4','data' => ['label' => ''.e(__('common.c_password_txt')).'','for' => 'new_password_confirmation','error' => ''.e($errors->first('new_password_confirmation')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt4'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('common.c_password_txt')).'','for' => 'new_password_confirmation','error' => ''.e($errors->first('new_password_confirmation')).'','required' => 'true']); ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['type' => 'password','id' => 'new_password_confirmation','name' => 'new_password_confirmation','value' => '']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'password','id' => 'new_password_confirmation','name' => 'new_password_confirmation','value' => '']); ?>
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

                            <div class="form-group row justify-content-center space-p-top reset-actions">
                                <div class="col-md-auto col-12 text-center">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button3','data' => ['id' => 'send','name' => 'send','type' => 'submit','class' => 'btn btn-primary','text' => ''.e($defDataArr['web_lang']['reset_now_txt']).'']]); ?>
<?php $component->withName('form.field.button3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'send','name' => 'send','type' => 'submit','class' => 'btn btn-primary','text' => ''.e($defDataArr['web_lang']['reset_now_txt']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                            </div>

                            <?php if(session()->has('alert')): ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.alert','data' => ['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']]); ?>
<?php $component->withName('form.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
	$(function() {
		$("#resetPasswordForm").validate({
			rules: {
				current_password: {
					required: true,
				},
				new_password: {
					required: true,
					minlength: 6
				},
				new_password_confirmation : {
					required: true,
					equalTo : "#new_password"
				}
			},
			messages: {
				current_password: {
					required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('subscribeduser.cr_password_txt'))); ?>",
				},
				new_password: {
					required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('subscribeduser.n_password_txt'))); ?>",
					minlength: "<?php echo e(strtolower(__('subscribeduser.info.pwd_len_txt'))); ?>",
				},
				new_password_confirmation: {
					required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.c_password_txt'))); ?>",
					equalTo: "<?php echo e(__('front.validation.confirm_password_txt')); ?>"
				}
			}
		})
	});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/reset-password.blade.php ENDPATH**/ ?>