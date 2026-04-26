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
    .edit-profile-shell {
        padding: 28px 0 48px;
    }

    .account-nav-card,
    .profile-edit-card,
    .profile-section-card {
        border: 0;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .account-nav-card {
        padding: 0;
    }

    .account-nav-head {
        padding: 24px 24px 18px;
        background: linear-gradient(145deg, #133b64, #0f9d58);
        color: #fff;
    }

    .account-nav-head p {
        margin: 0 0 6px;
        font-size: 12px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        opacity: 0.82;
    }

    .account-nav-head h4 {
        margin: 0;
        font-size: 26px;
        line-height: 1.1;
    }

    .account-nav-list {
        padding: 14px;
        gap: 8px;
    }

    .account-nav-list .list-group-item {
        border: 0;
        border-radius: 16px;
        padding: 14px 16px;
        font-weight: 600;
        color: #1f2937;
        background: #f5f8fb;
        transition: all 0.2s ease;
    }

    .account-nav-list .list-group-item:hover,
    .account-nav-list .list-group-item.active {
        background: linear-gradient(145deg, #0f9d58, #69b53f);
        color: #fff;
    }

    .profile-edit-card {
        padding: 0;
    }

    .profile-edit-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(280px, 0.9fr);
        gap: 24px;
        padding: 28px;
        background:
            radial-gradient(circle at top left, rgba(105, 181, 63, 0.22), transparent 34%),
            linear-gradient(145deg, #ffffff, #f4f8fc);
        border-bottom: 1px solid #e8edf3;
    }

    .profile-edit-title p {
        margin: 0 0 8px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #0f9d58;
        font-weight: 700;
    }

    .profile-edit-title h1 {
        margin: 0 0 10px;
        color: #10243c;
        font-size: 34px;
        line-height: 1.05;
    }

    .profile-edit-title .lead {
        margin: 0;
        color: #64748b;
        font-size: 16px;
    }

    .profile-photo-card {
        background: #fff;
        border: 1px solid #e7edf5;
        border-radius: 22px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 14px;
    }

    .profile-photo-frame {
        width: 124px;
        height: 124px;
        border-radius: 28px;
        overflow: hidden;
        background: #edf3f8;
        box-shadow: inset 0 0 0 1px #dbe4ee;
    }

    .profile-photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-photo-copy h5 {
        margin: 0 0 6px;
        color: #10243c;
        font-size: 18px;
    }

    .profile-photo-copy p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.5;
    }

    .profile-edit-form {
        padding: 28px;
    }

    .profile-section-card {
        padding: 24px;
        margin-bottom: 22px;
        box-shadow: none;
        border: 1px solid #e8edf3;
    }

    .profile-section-card:last-of-type {
        margin-bottom: 0;
    }

    .profile-section-head {
        margin-bottom: 20px;
    }

    .profile-section-head h5 {
        margin: 0 0 6px;
        color: #10243c;
        font-size: 22px;
    }

    .profile-section-head p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .profile-edit-form .form-group.row.align-items-center {
        margin-left: -10px;
        margin-right: -10px;
    }

    .profile-edit-form .form-group.row.align-items-center > [class*="col-"] {
        padding-left: 10px;
        padding-right: 10px;
    }

    .profile-edit-form .form-control,
    .profile-edit-form .custom-select,
    .profile-edit-form .custom-file-label {
        border-radius: 14px;
        border: 1px solid #d9e3ee;
        min-height: 48px;
        padding: 11px 14px;
        box-shadow: none;
    }

    .profile-edit-form textarea.form-control {
        min-height: 118px;
        resize: vertical;
    }

    .profile-edit-form .custom-file {
        width: 100%;
    }

    .profile-edit-form .custom-file-label::after {
        height: 46px;
        border-radius: 0 14px 14px 0;
        background: #10243c;
        color: #fff;
    }

    .profile-edit-form .input-group {
        gap: 10px;
    }

    .profile-edit-form .input-group .custom-select {
        border-radius: 14px;
    }

    .profile-edit-actions {
        padding-top: 8px;
    }

    .profile-edit-actions .btn {
        min-width: 160px;
        border-radius: 999px;
        padding: 12px 24px;
        font-weight: 700;
        border: 0;
    }

    .profile-edit-actions .btn-primary {
        background: linear-gradient(145deg, #0f9d58, #69b53f);
    }

    .profile-edit-actions .btn-secondary {
        background: #e8eef5;
        color: #10243c;
    }

    @media (max-width: 991px) {
        .profile-edit-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .edit-profile-shell {
            padding: 20px 0 36px;
        }

        .profile-edit-hero,
        .profile-edit-form,
        .profile-section-card {
            padding: 20px;
        }

        .profile-edit-title h1 {
            font-size: 28px;
        }

        .profile-edit-form .input-group {
            flex-direction: column;
        }

        .profile-edit-actions .btn {
            min-width: 100%;
        }
    }
</style>
<div class="container">
    <div class="row edit-profile-shell">
        <div class="col-md-4 col-lg-3 col-12">
            <?php echo $__env->make('themes.frontend.includes.user-left-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-8 col-lg-9 col-12">
            <div class="content-form bg-lightblue profile-edit-card">
                <div class="profile-edit-hero">
                    <div class="profile-edit-title">
                        <p>Account Settings</p>
                        <h1>Edit Profile</h1>
                        <div class="lead">Update your personal, contact, and banking details from one clean dashboard.</div>
                    </div>
                    <div class="profile-photo-card">
                        <div class="profile-photo-frame">
                            <?php if($user->p_picture): ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 124, 124, 100])).'','alt' => ''.e($user->f_name).' '.e($user->l_name).'','title' => ''.e($user->f_name).' '.e($user->l_name).'','id' => 'preview_img','width' => '124','height' => '124','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 124, 124, 100])).'','alt' => ''.e($user->f_name).' '.e($user->l_name).'','title' => ''.e($user->f_name).' '.e($user->l_name).'','id' => 'preview_img','width' => '124','height' => '124','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.hidden','data' => ['name' => 'hid_file_src','id' => 'hid_file_src','value' => ''.e(url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 124, 124, 100])).'']]); ?>
<?php $component->withName('form.field.hidden'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'hid_file_src','id' => 'hid_file_src','value' => ''.e(url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 124, 124, 100])).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php else: ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/profile-photo.png')).'','id' => 'preview_img','width' => '124','height' => '124','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/profile-photo.png')).'','id' => 'preview_img','width' => '124','height' => '124','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="profile-photo-copy">
                            <h5><?php echo e(trim($user->f_name . ' ' . $user->l_name) ?: 'User Profile'); ?></h5>
                            <p>Add a clear profile image so your account feels complete and easier to recognize.</p>
                        </div>
                    </div>
                </div>

                <form action="<?php echo e(route('web.edit.profile.save')); ?>" method="post" id="profileForm" name="profileForm" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="profile-edit-form">
                    <div class="profile-section-card">
                    <div class="profile-section-head">
                        <h5>Profile Image</h5>
                        <p>Upload a JPG or PNG photo to personalize your account.</p>
                    </div>

                    <div class="form-group row align-items-center<?php echo e($errors->first('p_picture') ? ' has-danger' : ''); ?>">
                        <div class="col-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input remove-file" id="p_picture" name="p_picture">
                                <label class="custom-file-label" id="label_p_picture" for="p_picture"><?php echo e(__('subscribeduser.upload_photo_txt')); ?></label>
                                <small class="form-text text-muted"><?php echo __('subscribeduser.info.image'); ?></small>
                                <a class="red-text hide remove" id="removeFile" href="JavaScript:void(0);"><?php echo e($defDataArr['web_lang']['remove_attachment_txt']); ?></a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="profile-section-card">
                    <div class="profile-section-head">
                        <h5>Personal Details</h5>
                        <p>Keep your identity and primary contact basics up to date.</p>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-12 mb-1">
                        </div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => ''.e(__('common.f_name_txt')).'','for' => 'f_name','error' => ''.e($errors->first('f_name')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('common.f_name_txt')).'','for' => 'f_name','error' => ''.e($errors->first('f_name')).'','required' => 'true']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'f_name','name' => 'f_name','value' => ''.e(old('f_name', $user->f_name)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'f_name','name' => 'f_name','value' => ''.e(old('f_name', $user->f_name)).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => ''.e(__('common.l_name_txt')).'','for' => 'l_name','error' => ''.e($errors->first('l_name')).'','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('common.l_name_txt')).'','for' => 'l_name','error' => ''.e($errors->first('l_name')).'','required' => 'false']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'l_name','name' => 'l_name','value' => ''.e(old('l_name', $user->l_name)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'l_name','name' => 'l_name','value' => ''.e(old('l_name', $user->l_name)).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => ''.e(__('common.email_txt')).'','for' => 'email','error' => ''.e($errors->first('email')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('common.email_txt')).'','for' => 'email','error' => ''.e($errors->first('email')).'','required' => 'true']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'email','name' => 'email','value' => ''.e(old('email', $user->email)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'email','name' => 'email','value' => ''.e(old('email', $user->email)).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => ''.e(__('subscribeduser.mobile_txt')).'','for' => 'mobile','error' => ''.e($errors->first('mobile')).'','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('subscribeduser.mobile_txt')).'','for' => 'mobile','error' => ''.e($errors->first('mobile')).'','required' => 'false']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'mobile','name' => 'mobile','value' => ''.e(old('mobile', $user->mobile)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'mobile','name' => 'mobile','value' => ''.e(old('mobile', $user->mobile)).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => 'Pincode','for' => 'pincode','error' => ''.e($errors->first('pincode')).'','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Pincode','for' => 'pincode','error' => ''.e($errors->first('pincode')).'','required' => 'false']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'pincode','name' => 'pincode','value' => ''.e(old('pincode', $user->pincode)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'pincode','name' => 'pincode','value' => ''.e(old('pincode', $user->pincode)).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => 'Birthday','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Birthday','required' => 'false']); ?>
                            <div class="input-group">
                                <select name="birthday_year" id="birthday_year" class="custom-select placeholder">
                                    <option value=""><?php echo e(__('subscribeduser.brthdy_year_def_opt_txt')); ?></option>
                                    <?php $__currentLoopData = $yearArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($yValue); ?>" <?php if((string) old('birthday_year', $birthdayArr[0] ?? '') === (string) $yValue): ?> selected <?php endif; ?>><?php echo e($yValue); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <select name="birthday_month" id="birthday_month" class="custom-select placeholder">
                                    <option value=""><?php echo e(__('subscribeduser.brthdy_month_def_opt_txt')); ?></option>
                                    <?php $__currentLoopData = $monthsArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php if((string) old('birthday_month', $birthdayArr[1] ?? '') === (string) $key): ?> selected <?php endif; ?>><?php echo e($mValue); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <select name="birthday_day" id="birthday_day" class="custom-select placeholder">
                                    <option value=""><?php echo e(__('subscribeduser.brthdy_day_def_opt_txt')); ?></option>
                                    <?php $__currentLoopData = $daysArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if((string) old('birthday_day', $birthdayArr[2] ?? '') === (string) $value): ?> selected <?php endif; ?>><?php echo e($value); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => 'Address','for' => 'address','error' => ''.e($errors->first('address')).'','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Address','for' => 'address','error' => ''.e($errors->first('address')).'','required' => 'false']); ?>
                            <textarea id="address" name="address" class="form-control"><?php echo e(old('address', $user->address)); ?></textarea>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    </div>

                    <div class="profile-section-card">
                    <div class="profile-section-head">
                        <h5>Contact Details</h5>
                        <p>These details help keep your communication and location info current.</p>
                    </div>
                    <div class="form-group row align-items-center">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => 'City','for' => 'city','error' => ''.e($errors->first('city')).'','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'City','for' => 'city','error' => ''.e($errors->first('city')).'','required' => 'false']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'city','name' => 'city','value' => ''.e(old('city', optional($user->sensitiveDetails)->city ?: $user->city)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'city','name' => 'city','value' => ''.e(old('city', optional($user->sensitiveDetails)->city ?: $user->city)).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => 'State','for' => 'state','error' => ''.e($errors->first('state')).'','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'State','for' => 'state','error' => ''.e($errors->first('state')).'','required' => 'false']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'state','name' => 'state','value' => ''.e(old('state', optional($user->sensitiveDetails)->state ?: $user->state)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'state','name' => 'state','value' => ''.e(old('state', optional($user->sensitiveDetails)->state ?: $user->state)).'']); ?>
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
                    </div>

                    <div class="profile-section-card">
                    <div class="profile-section-head">
                        <h5>Banking Details</h5>
                        <p>Store payout and verification information in one place.</p>
                    </div>
                    <div class="form-group row align-items-center">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => 'Bank Name','for' => 'bank_name','error' => ''.e($errors->first('bank_name')).'','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Bank Name','for' => 'bank_name','error' => ''.e($errors->first('bank_name')).'','required' => 'false']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'bank_name','name' => 'bank_name','value' => ''.e(old('bank_name', optional($user->sensitiveDetails)->bank_name)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'bank_name','name' => 'bank_name','value' => ''.e(old('bank_name', optional($user->sensitiveDetails)->bank_name)).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => 'Account Holder Name','for' => 'account_holder_name','error' => ''.e($errors->first('account_holder_name')).'','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Account Holder Name','for' => 'account_holder_name','error' => ''.e($errors->first('account_holder_name')).'','required' => 'false']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'account_holder_name','name' => 'account_holder_name','value' => ''.e(old('account_holder_name', optional($user->sensitiveDetails)->account_holder_name)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'account_holder_name','name' => 'account_holder_name','value' => ''.e(old('account_holder_name', optional($user->sensitiveDetails)->account_holder_name)).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => 'Account Number','for' => 'account_number','error' => ''.e($errors->first('account_number')).'','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Account Number','for' => 'account_number','error' => ''.e($errors->first('account_number')).'','required' => 'false']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'account_number','name' => 'account_number','value' => ''.e(old('account_number', optional($user->sensitiveDetails)->account_number)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'account_number','name' => 'account_number','value' => ''.e(old('account_number', optional($user->sensitiveDetails)->account_number)).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => 'IFSC Code','for' => 'ifsc_code','error' => ''.e($errors->first('ifsc_code')).'','required' => 'false']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'IFSC Code','for' => 'ifsc_code','error' => ''.e($errors->first('ifsc_code')).'','required' => 'false']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'ifsc_code','name' => 'ifsc_code','value' => ''.e(old('ifsc_code', optional($user->sensitiveDetails)->ifsc_code)).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'ifsc_code','name' => 'ifsc_code','value' => ''.e(old('ifsc_code', optional($user->sensitiveDetails)->ifsc_code)).'']); ?>
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
                    </div>

                    <div class="form-group row justify-content-center space-p-top profile-edit-actions">
                        <div class="col-md-auto col-6 text-center">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button3','data' => ['id' => 'send','name' => 'send','type' => 'submit','class' => 'btn btn-primary','text' => ''.e($defDataArr['web_lang']['save_txt']).'']]); ?>
<?php $component->withName('form.field.button3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'send','name' => 'send','type' => 'submit','class' => 'btn btn-primary','text' => ''.e($defDataArr['web_lang']['save_txt']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        <div class="col-md-auto col-6 text-center">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button3','data' => ['type' => 'reset','class' => 'btn btn-secondary','text' => ''.e($defDataArr['web_lang']['cancel_txt']).'']]); ?>
<?php $component->withName('form.field.button3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'reset','class' => 'btn btn-secondary','text' => ''.e($defDataArr['web_lang']['cancel_txt']).'']); ?>
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
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    $(function() {
        $("#profileForm").validate({
            rules: {
                p_picture: {
                    required: false,
                    extension: "jpg|jpeg|png"
                },
                f_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                mobile: {
                    required: false,
                    number: true
                }
            },
            messages: {
                p_picture: {
                    extension: "<?php echo e($defDataArr['web_lang']['jq_validate']['upload_extension_txt']); ?>"
                },
                f_name: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.f_name_txt'))); ?>",
                email: {
                    required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt'))); ?>",
                    email: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt'))); ?>"
                },
                mobile: {
                    number: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('subscribeduser.mobile_txt'))); ?>"
                }
            }
        });

        $("#p_picture").change(function() {
            if ($('#p_picture').hasClass('remove-file')) {
                var val = $(this).val().toLowerCase(),
                    regex = new RegExp("(.*?)\\.(jpg|jpeg|png)$");
                if ((regex.test(val))) {
                    var oFReader = new FileReader();
                    oFReader.readAsDataURL(document.getElementById("p_picture").files[0]);
                    oFReader.onload = function(oFREvent) {
                        document.getElementById("preview_img").src = oFREvent.target.result;
                    };
                    $("#label_p_picture").text(document.getElementById("p_picture").files[0].name);
                    $("#removeFile").show();
                }
            }
        });

        $("#removeFile").click(function() {
            if (confirm('Are you sure ?')) {
                $("#p_picture").val('');
                $("#label_p_picture").text('Upload Photo');
                $("#removeFile").hide();
                var file_src = "<?php echo e(asset('themes/frontend/assets/images/profile-photo.png')); ?>";
                var old_file = $("#hid_file_src").val();
                if (old_file != '' && old_file !== undefined) {
                    file_src = old_file;
                }
                document.getElementById("preview_img").src = file_src;
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/edit-profile.blade.php ENDPATH**/ ?>