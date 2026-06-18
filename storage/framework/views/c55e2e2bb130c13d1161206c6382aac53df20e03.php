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
<div class="container">
	<div class="row">
		<div class="col-md-4 col-lg-3 col-12">
			<?php echo $__env->make('themes.frontend.includes.user-left-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<!-- -->
		<div class="col-md-8 col-lg-9 col-12">
			<div class="content-form bg-lightblue">
				<div class="">
					<p class="lead"><?php echo $dataArr['title']; ?></p>
				</div>
				<form action="<?php echo e(route('web.edit.profile.save')); ?>" method="post" id="profileForm" name="profileForm" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>


					<div class="form-group row align-items-center<?php echo e($errors->first('file')?' has-danger':''); ?>">
						<label class="col-sm-auto col-md-4 col-lg-auto col-xl-2 mb-sm-0">
							<?php if($user->p_picture): ?>
							<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 110, 110, 100])).'','alt' => ''.e($user->f_name).' '.e($user->l_name).'','title' => ''.e($user->f_name).' '.e($user->l_name).'','id' => 'preview_img','width' => '110','height' => '110','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 110, 110, 100])).'','alt' => ''.e($user->f_name).' '.e($user->l_name).'','title' => ''.e($user->f_name).' '.e($user->l_name).'','id' => 'preview_img','width' => '110','height' => '110','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
							<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.hidden','data' => ['name' => 'hid_file_src','id' => 'hid_file_src','value' => ''.e(url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 110, 110, 100])).'']]); ?>
<?php $component->withName('form.field.hidden'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'hid_file_src','id' => 'hid_file_src','value' => ''.e(url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 110, 110, 100])).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
							<?php else: ?>
							<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/profile-photo.png')).'','id' => 'preview_img','width' => '110','height' => '110','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/profile-photo.png')).'','id' => 'preview_img','width' => '110','height' => '110','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
							<?php endif; ?>
						</label>
						<div class="col-sm-4 col-md-8 col-lg-5 col-xl-10">
							<div class="custom-file">
								<input type="file" class="custom-file-input remove-file" id="file" name="file">
								<label class="custom-file-label" id="label_file" for="file"><?php echo e(__('subscribeduser.upload_photo_txt')); ?></label>
								<small class="form-text text-muted"><?php echo __('subscribeduser.info.image'); ?></small>
								<a class="red-text hide remove" id="removeFile" href="JavaScript:void(0);"><?php echo e($defDataArr['web_lang']['remove_attachment_txt']); ?></a>
							</div>
							<!-- /.custom-file -->
						</div>
						<!--  -->
					</div>
					<!-- /.form-group -->

					<div class="form-group row align-items-center">
						<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => ''.e(__('common.f_name_txt')).'','for' => 'f_name','error' => ''.e($errors->first('f_name')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('common.f_name_txt')).'','for' => 'f_name','error' => ''.e($errors->first('f_name')).'','required' => 'true']); ?>
							<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'f_name','name' => 'f_name','value' => ''.e((old('f_name'))?old('f_name'):$user->f_name).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'f_name','name' => 'f_name','value' => ''.e((old('f_name'))?old('f_name'):$user->f_name).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'l_name','name' => 'l_name','value' => ''.e((old('l_name'))?old('l_name'):$user->l_name).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'l_name','name' => 'l_name','value' => ''.e((old('l_name'))?old('l_name'):$user->l_name).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'email','name' => 'email','value' => ''.e((old('email'))?old('email'):$user->email).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'email','name' => 'email','value' => ''.e((old('email'))?old('email'):$user->email).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => ''.e(__('subscribeduser.mobile_txt')).'','for' => 'mobile','error' => ''.e($errors->first('mobile')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('subscribeduser.mobile_txt')).'','for' => 'mobile','error' => ''.e($errors->first('mobile')).'','required' => 'true']); ?>
							<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'mobile','name' => 'mobile','value' => ''.e((old('mobile'))?old('mobile'):$user->mobile).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'mobile','name' => 'mobile','value' => ''.e((old('mobile'))?old('mobile'):$user->mobile).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => ''.e(__('subscribeduser.brthdy_txt')).'']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('subscribeduser.brthdy_txt')).'']); ?>
							<div class="input-group">
								<select name="birthday_year" id="birthday_year" class="custom-select placeholder">
									<option value=""><?php echo e(__('subscribeduser.brthdy_year_def_opt_txt')); ?></option>
									<?php if(!empty($yearArr)): ?>
									<?php $__currentLoopData = $yearArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($yValue); ?>" <?php if( $yValue==old('birthday_year') ): ?> <?php echo e('selected'); ?> <?php elseif( $yValue==$birthdayArr[0] ): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($yValue); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<select name="birthday_month" id="birthday_month" class="custom-select placeholder">
									<option value=""><?php echo e(__('subscribeduser.brthdy_month_def_opt_txt')); ?></option>
									<?php if(!empty($monthsArr)): ?>
									<?php $__currentLoopData = $monthsArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($key); ?>" <?php if( $key==old('birthday_month') ): ?> <?php echo e('selected'); ?> <?php elseif( $key==$birthdayArr[1] ): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($mValue); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<select name="birthday_day" id="birthday_day" class="custom-select placeholder">
									<option value=""><?php echo e(__('subscribeduser.brthdy_day_def_opt_txt')); ?></option>
									<?php if(!empty($daysArr)): ?>
									<?php $__currentLoopData = $daysArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($value); ?>" <?php if( $value==old('birthday_day') ): ?> <?php echo e('selected'); ?> <?php elseif( $value==$birthdayArr[2] ): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($value); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
							</div>
						 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

						<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => ''.e(__('subscribeduser.neet_aprng_yr_txt')).'','for' => 'neet_appearing_year','error' => ''.e($errors->first('neet_appearing_year')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('subscribeduser.neet_aprng_yr_txt')).'','for' => 'neet_appearing_year','error' => ''.e($errors->first('neet_appearing_year')).'','required' => 'true']); ?>
							<select name="neet_appearing_year" id="neet_appearing_year" class="custom-select placeholder">
								<option value=""><?php echo e($defDataArr['web_lang']['def_drop_optn_txt']); ?></option>
								<?php if(!empty($nayArr)): ?>
								<?php $__currentLoopData = $nayArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($nyValue); ?>" <?php if( $nyValue==old('neet_appearing_year') ): ?> <?php echo e('selected'); ?> <?php elseif( $nyValue==$user->neet_apear_year ): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($nyValue); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
						 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

						<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt6','data' => ['label' => ''.e(__('subscribeduser.class_txt')).'','for' => 'class','error' => ''.e($errors->first('class')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt6'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('subscribeduser.class_txt')).'','for' => 'class','error' => ''.e($errors->first('class')).'','required' => 'true']); ?>
							<select name="class" id="class" class="custom-select placeholder">
								<option value=""><?php echo e($defDataArr['web_lang']['def_drop_optn_txt']); ?></option>
								<?php if(!empty($defDataArr['user_class_type'])): ?>
								<?php $__currentLoopData = $defDataArr['user_class_type']['value']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $class_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($class_type); ?>" <?php if( $class_type==old('class') ): ?> <?php echo e('selected'); ?> <?php elseif( $class_type==$user->class ): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($defDataArr['user_class_type']['text'][$class_type]); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
						 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
					</div>
					<!-- -->

					<div class="form-group row justify-content-center space-p-top">
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
						<!-- /.col-auto -->
						<div class="col-md-auto col-6 text-center">
							<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button3','data' => ['type' => 'reset','class' => 'btn btn-primary','text' => ''.e($defDataArr['web_lang']['cancel_txt']).'']]); ?>
<?php $component->withName('form.field.button3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'reset','class' => 'btn btn-primary','text' => ''.e($defDataArr['web_lang']['cancel_txt']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
						</div>
						<!-- /.col-auto -->
					</div>
					<!-- /.form-group -->

					
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
					
				</form>
			</div>
			<!-- /.content-form -->
		</div>
		<!-- -->
	</div>
	<!-- /.row -->
</div>
<!-- /.container -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
	$(function() {
		$("#profileForm").validate({
			rules: {
				file: {
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
					required: true,
					number: true,
					minlength: 10,
					maxlength: 10
				},
				neet_appearing_year: {
					required: true
				},
				class: {
					required: true
				}
			},
			messages: {
				file: {
					required: "<?php echo e($defDataArr['web_lang']['please_txt']); ?> <?php echo e(strtolower(__('subscribeduser.upload_photo_txt'))); ?>",
					extension: "<?php echo e($defDataArr['web_lang']['jq_validate']['upload_extension_txt']); ?>"
				},
				f_name: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.f_name_txt'))); ?>",
				email: {
					required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt'))); ?>",
					email: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt'))); ?>"
				},
				mobile: {
					required: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('subscribeduser.mobile_txt'))); ?>",
					number: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('subscribeduser.mobile_txt'))); ?>",
					minlength: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('subscribeduser.mobile_txt'))); ?>",
					maxlength: "<?php echo e($defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('subscribeduser.mobile_txt'))); ?>"
				},
				neet_appearing_year: "<?php echo e($defDataArr['web_lang']['jq_validate']['select_a_txt'].strtolower(__('subscribeduser.neet_aprng_yr_txt'))); ?>",
				class: "<?php echo e($defDataArr['web_lang']['jq_validate']['select_a_txt'].strtolower(__('subscribeduser.class_txt'))); ?>"
			}
		});
		/*Remove file*/
		$("#file").change(function() {
			if ($('#file').hasClass('remove-file')) {
				var val = $(this).val().toLowerCase(),
					regex = new RegExp("(.*?)\.(jpg|jpeg|png)$");
				if ((regex.test(val))) {
					var oFReader = new FileReader();
					oFReader.readAsDataURL(document.getElementById("file").files[0]);
					oFReader.onload = function(oFREvent) {
						document.getElementById("preview_img").src = oFREvent.target.result;
					};
					$("#removeFile").show();
				}
			}
		});
		$("#removeFile").click(function() {
			if (confirm('Are you sure ?')) {
				$("#file").val('');
				$("#label_file").text('Upload Photo');
				$("#removeFile").hide();
				var file_src = "<?php echo e(asset('themes/frontend/assets/images/profile-photo.png')); ?>";
				var old_file = $("#hid_file_src").val();
				if (old_file != '' && old_file !== undefined) {
					file_src = old_file;
				}
				document.getElementById("preview_img").src = file_src;
			}
		});
		/**/
	});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/edit-profile.blade.php ENDPATH**/ ?>