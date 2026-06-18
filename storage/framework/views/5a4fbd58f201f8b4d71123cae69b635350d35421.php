<?php $__env->startSection('content'); ?>
<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                    <li>White Label Branding</li>
                </ul>
            </div>

            <div class="perform_head">
                <h2>White Label Branding</h2>
            </div>

            <div class="light_green_bg" style="padding: 30px; border-radius: 18px;">
                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div><?php echo e($error); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <div class="row" style="align-items: stretch;">
                    <div class="col-lg-7">
                        <form method="POST" action="<?php echo e(route('user.white_label.branding.update')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="form_group" style="margin-bottom: 20px;">
                                <label for="wl_company_name" style="display: block; font-weight: 600; margin-bottom: 8px;">Brand name</label>
                                <input
                                    id="wl_company_name"
                                    type="text"
                                    name="wl_company_name"
                                    value="<?php echo e(old('wl_company_name', $branding['company_name'])); ?>"
                                    placeholder="Enter your company name"
                                    style="width: 100%; border: 1px solid #d8e6d0; border-radius: 12px; padding: 14px 16px;"
                                    required
                                >
                            </div>

                            <div class="form_group" style="margin-bottom: 24px;">
                                <label for="wl_logo" style="display: block; font-weight: 600; margin-bottom: 8px;">Brand logo</label>
                                <input
                                    id="wl_logo"
                                    type="file"
                                    name="wl_logo"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    style="width: 100%; border: 1px solid #d8e6d0; border-radius: 12px; padding: 12px 16px; background: #fff;"
                                >
                                <small style="display: block; margin-top: 8px; color: #5d6d57;">Recommended format: PNG with transparent background.</small>
                                <small style="display: block; margin-top: 6px; color: #5d6d57;">Recommended size: 220px width x 90px height. Maximum file size: 2MB.</small>
                            </div>

                            <button type="submit" class="btn btn-success" style="border-radius: 999px; padding: 12px 26px;">Save Branding</button>
                        </form>
                    </div>

                    <div class="col-lg-5" style="margin-top: 20px;">
                        <div style="background: #fff; border-radius: 18px; padding: 24px; height: 100%; box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08);">
                            <p style="font-size: 12px; letter-spacing: 0.08em; text-transform: uppercase; color: #6ab130; margin-bottom: 12px;">Preview</p>
                            <div style="border: 1px dashed #d8e6d0; border-radius: 16px; padding: 24px; text-align: center; min-height: 230px; display: flex; flex-direction: column; justify-content: center;">
                                <?php if(!empty($branding['has_custom_logo']) && !empty($branding['logo_url'])): ?>
                                    <img src="<?php echo e($branding['logo_url']); ?>" alt="<?php echo e($branding['company_name'] ?: 'White label logo'); ?>" style="max-width: 220px; max-height: 90px; object-fit: contain; margin: 0 auto 18px;">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/small_logo.png')); ?>" alt="Default myplexus logo" style="max-width: 220px; max-height: 90px; object-fit: contain; margin: 0 auto 18px;">
                                <?php endif; ?>

                                <h4 style="margin-bottom: 8px;"><?php echo e($branding['company_name'] ?: 'Your brand name will appear in PDFs'); ?></h4>
                                <p style="margin: 0; color: #5d6d57;">This branding will replace the default logo in the member header and PDF exports.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/white_label/branding.blade.php ENDPATH**/ ?>