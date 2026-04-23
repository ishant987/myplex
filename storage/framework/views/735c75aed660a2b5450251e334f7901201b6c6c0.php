<?php $__env->startSection('select2'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('like-unlike'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('ans-like-unlike'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('owl-carousel'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('fancybox'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('login-redirect'); ?> <?php $__env->stopSection(); ?>
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
<div class="custom-banner no-bg ask-question-banner">
	<div class="container">
		<?php if($dataArr['descp']): ?>
		<h1 class="f-b"><?php echo $dataArr['descp']; ?></h1>
		<?php endif; ?>
	</div>
</div>

<div class="ask-expert-qna">
	<div class="container">

		<div class="ask-expert-qna-top">
			<h3><?php echo $dataArr['title']; ?></h3>
		</div>

		<div class="ask-expert-search">
			<div class="row ask-expert-wrapper">
				<div class="col-lg-4 col-md-4 col-sm-12 search-cm ask-expert-search-1">
					<form action="#" id="m_search_form" method="get">
						<input type="text" id="m_search_text" autocomplete="off" name="ms" placeholder="<?php echo e(__('web.search_txt')); ?>" value="<?php echo e((isset($_GET['ms']))?$_GET['ms']:''); ?>">
						<span class="expert-select"><input type="submit" /></span>
					</form>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 search-cm ask-expert-search-2 select2-styles">
					<select class="js-example-placeholder-single js-states form-control" name="topic" id="topic">
						<option value="<?php echo e(route('web.ask-expert')); ?>"><?php echo e($defDataArr['askexpert_lang']['search_by_topic_txt']); ?></option>
						<?php $__currentLoopData = $topicsModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e(route('web.ask-expert.topic', $value->slug)); ?>" <?php echo e(( ( isset($dataArr['req_slug']) && $dataArr['req_slug'] == $value->slug ) || ( $dataArr['aet_id'] == $defDataArr['other_topic_id'] ) || ( $dataArr['parent'] == $defDataArr['other_topic_id'] ) )?'selected':''); ?>><?php echo e($value->title); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 search-cm ask-expert-search-3">
					<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.ask-question')).'','class' => 'ask-btn']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.ask-question')).'','class' => 'ask-btn']); ?><?php echo e($defDataArr['askexpert_lang']['ask_question_txt']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="qna-main">

			<div class="questions-wrapper">
				<h6 id="question-sort" class="text-d-green">
					<?php if(\Request::route()->getName() == 'web.ask-expert.topic'): ?>
					<?php echo e($dataArr['title']); ?>

					<?php else: ?>
					<?php echo e(__('common.all_txt')); ?>

					<?php endif; ?>
				</h6>
				<div class="question-blocks-wrap">
					<?php if(count($dataList) == 0): ?>
					<p><?php echo e(__('message.data_not_available')); ?></p>
					<?php else: ?>
					<?php $__currentLoopData = $dataList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="question-block">
						<div class="row">
							<div class="col-lg-2 col-md-3 col-sm-3">
								<div class="profile user-profile">
									<?php if($record->user != null): ?>
									<?php if($record->user->p_picture): ?>
									<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(url('storage', [$record->user->p_picture, $defDataArr['user_media_folder'], 125, 125, 100])).'','alt' => ''.e($record->user->f_name??'').'','title' => ''.e($record->user->f_name??'').'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(url('storage', [$record->user->p_picture, $defDataArr['user_media_folder'], 125, 125, 100])).'','alt' => ''.e($record->user->f_name??'').'','title' => ''.e($record->user->f_name??'').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
									<?php else: ?>
									<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('img/user-def-grey-bg.png')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('img/user-def-grey-bg.png')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
									<?php endif; ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-lg-10 col-md-9 col-sm-9">
								<div class="user-question">
									<h6 onclick="toggleAnswer(<?php echo e($record->aeq_id); ?>)"><?php echo \App\Lib\Core\Useful::getShortContent( strip_tags($record->question), $defDataArr['askexpert_lang']['title_char_limit']); ?></h6>
								</div>
								<div class="user-data">
									<div class="row mx-0">
										<div><span class="user-name"><?php echo e($record->user->f_name . " " . $record->user->l_name); ?></span>|</div>
										<div><span class="posted-date"><?php echo e(\Carbon\Carbon::createFromTimeStamp(strtotime($record->created_at))->diffForHumans()); ?></span></div>
										<?php if(\Request::route()->getName() == 'web.ask-expert'): ?>
										<div>|&nbsp;<span class="post-type">
												<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.ask-expert.topic', $record->topic->slug)).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.ask-expert.topic', $record->topic->slug)).'']); ?><span class="postTag blue-text"><?php echo e($record->topic->title); ?></span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
											</span></div>
										<?php endif; ?>
									</div>
								</div>
								<div class="question-data">
									<div class="row mx-0">
										<div class="col-lg-9 col-md-9 col-sm-12">
											<div class="row max-0 comment-data">
												<div class="col-lg-2 co-md-2 pl-0">
													<span class="answer-data"><?php echo e($record->totalAnswers()['normal']); ?><span class="inner-title"><?php echo e($defDataArr['askexpert_lang']['answer_txt']); ?></span></span>
												</div>
												<div class="col-lg-2 co-md-2">
													<span class="expert-data"><?php echo e($record->totalAnswers()['expert']); ?><span class="inner-title"><?php echo e($defDataArr['askexpert_lang']['expert_txt']); ?></span></span>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="comment-action">
												<div class="row align-items-center mx-0">
													<span class="cmt">
														<?php if(\Auth::check()): ?>
														<a data-fancybox data-type="iframe" data-src="<?php echo e(route('web.add-answer', $record->aeq_id)); ?>" href="javascript:;" class="edit" title="<?php echo e($defDataArr['askexpert_lang']['add_answer']); ?>">
															<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/comment-icon.png')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/comment-icon.png')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
														</a>
														<?php else: ?>
														<a href="<?php echo e(route('web.login')); ?>" class="edit" title="<?php echo e($defDataArr['askexpert_lang']['add_answer']); ?>">
															<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/comment-icon.png')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/comment-icon.png')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
														</a>
														<?php endif; ?>
													</span>
													<span class="like">
														<?php if($record->isLike()): ?>
														<a href="javascript:void(0);" class="liked like-unlike" data-id="<?php echo e($record->aeq_id); ?>" data-type="<?php echo e($defDataArr['q_like_type']); ?>">
															<sup class="like-counter"><?php echo e($record->getLikes()); ?></sup>
														</a>
														<?php else: ?>
														<a href="javascript:void(0);" class="like like-unlike" data-id="<?php echo e($record->aeq_id); ?>" data-type="<?php echo e($defDataArr['q_like_type']); ?>">
															<sup class="like-counter"><?php echo e($record->getLikes()); ?></sup>
														</a>
														<?php endif; ?>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="comment-replies-wrap box-shadow postsReply" id="postsReply<?php echo e($record->aeq_id); ?>">
								<div class="question-block">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="user-answer">
												<?php if($record->question): ?>
												<p><?php echo $record->question; ?></p>
												<?php endif; ?>
												<?php if($record->image1): ?>
												<figure class="postImage m-b-15">
													<a href="<?php echo e($defDataArr['media_folder'].$record->image1); ?>" data-fancybox="images<?php echo e($record->aeq_id); ?>" data-caption="" class="adsImg wow fadeIn" data-wow-duration="500ms" data-wow-delay="900ms">
														<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'].$record->image1).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'].$record->image1).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
													</a>
												</figure>
												<?php endif; ?>
												<?php if($record->image2): ?>
												<figure class="postImage m-b-15">
													<a href="<?php echo e($defDataArr['media_folder'].$record->image2); ?>" data-fancybox="images<?php echo e($record->aeq_id); ?>" data-caption="" class="adsImg wow fadeIn" data-wow-duration="500ms" data-wow-delay="900ms">
														<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'].$record->image2).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'].$record->image2).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
													</a>
												</figure>
												<?php endif; ?>
												<?php if($record->image3): ?>
												<figure class="postImage m-b-15">
													<a href="<?php echo e($defDataArr['media_folder'].$record->image3); ?>" data-fancybox="images<?php echo e($record->aeq_id); ?>" data-caption="" class="adsImg wow fadeIn" data-wow-duration="500ms" data-wow-delay="900ms">
														<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'].$record->image3).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'].$record->image3).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
													</a>
												</figure>
												<?php endif; ?>
												<?php if($record->video_from && $record->video_data): ?>
												<div class="postVideo">
													<?php switch($record->video_from):
													case ($defDataArr['video_type']['0']): ?>
													<div class="localVideo">
														<?php echo e(\App\Lib\Core\Core::htmlVideoPlayer($defDataArr['media_folder'].$record->video_data)); ?>

													</div>
													<?php break; ?>
													<?php case ($defDataArr['video_type']['1']): ?>
													<div class="ytubeVideo">
														<?php echo e(\App\Lib\Core\Core::ytubePlayer($defDataArr['media_folder'].$record->video_data)); ?>

													</div>
													<?php break; ?>
													<?php endswitch; ?>
												</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
									<?php if(count($record->answersFront) > 0): ?>
									<?php $__currentLoopData = $record->answersFront; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-3">
											<div class="profile user-profile">
												<?php if($record2->user->p_picture): ?>
												<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(url('storage', [$record2->user->p_picture, $defDataArr['user_media_folder'], 90, 90, 100])).'','alt' => ''.e($record2->user->f_name??'').'','title' => ''.e($record2->user->f_name??'').'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(url('storage', [$record2->user->p_picture, $defDataArr['user_media_folder'], 90, 90, 100])).'','alt' => ''.e($record2->user->f_name??'').'','title' => ''.e($record2->user->f_name??'').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
												<?php else: ?>
												<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('img/user-def-grey-bg.png')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('img/user-def-grey-bg.png')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
												<?php endif; ?>
												<?php if( $record2->isUserExpert($record2->user->u_id) == true): ?>
												<span class="postImgIco"></span>
												<?php endif; ?>
											</div>
										</div>
										<div class="col-lg-10 col-md-9 col-sm-9">
											<div class="posts">
												<p><?php echo $record2->answer; ?></p>
												<div class="user-data">
													<div class="row mx-0">
														<div><span class="user-name"><?php echo e($record2->user->f_name ." ". $record2->user->l_name); ?></span> | </div>
														<div><span class="posted-date"><?php echo e(\Carbon\Carbon::createFromTimeStamp(strtotime($record2->created_at))->diffForHumans()); ?></span></div>
													</div>
												</div>
												<div class="question-data">
													<div class="row mx-0">
														<div class="col-12 px-0">
															<div class="comment-action">
																<div class="row mx-0">
																	<?php if($record2->isLike()): ?>
																	<span class="like"><a href="javascript:void(0);" class="liked re-like-unlike replylike" data-id="<?php echo e($record2->aeqa_id); ?>" data-type="<?php echo e($defDataArr['a_like_type']); ?>">
																			<sup class="like-counter"><?php echo e($record2->getLikes()); ?></sup>
																		</a></span>
																	<?php else: ?>
																	<span class="like"><a href="javascript:void(0);" class="like re-like-unlike replylike" data-id="<?php echo e($record2->aeqa_id); ?>" data-type="<?php echo e($defDataArr['a_like_type']); ?>">
																			<sup class="like-counter"><?php echo e($record2->getLikes()); ?></sup>
																		</a></span>
																	<?php endif; ?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
					<div class="col-md-12">
						<?php echo e($dataList->links()); ?>

					</div>
				</div>
			</div>

			<div class="experts-totals">

				<div class="experts-total-wrap">
					<div class="row">
						<div class="col-lg-4 col-md-4 sm-12">
							<span class="expert-answered"><?php echo e($countArr['expert_answer_count']); ?></span>
							<img src="<?php echo e(asset('themes/frontend/assets/images/expert-icon.png')); ?>" alt="expert-icon">
							<h6><?php echo e($defDataArr['askexpert_lang']['total_expert_ans_txt']); ?></h6>
						</div>
						<div class="col-lg-4 col-md-4 sm-12">
							<span class="expert-answered"><?php echo e($countArr['normal_answer_count']); ?></span>
							<img src="<?php echo e(asset('themes/frontend/assets/images/answered-icon.png')); ?>" alt="answered-icon">
							<h6><?php echo e($defDataArr['askexpert_lang']['total_ans_txt']); ?></h6>
						</div>
						<div class="col-lg-4 col-md-4 sm-12">
							<span class="expert-answered"><?php echo e($countArr['total_likes_count']); ?></span>
							<img src="<?php echo e(asset('themes/frontend/assets/images/like-icon.png')); ?>" alt="like-icon">
							<h6><?php echo e($defDataArr['askexpert_lang']['total_liked_txt']); ?></h6>
						</div>
					</div>
				</div>
				<?php if(count($expertUsersArr) > 0): ?>
				<div class="experts-slider">
					<h5><?php echo e($defDataArr['askexpert_lang']['pnl_of_exprts_txt']); ?></h5>
					<div class="experts-slider-wrap">
						<div id="expert-sliders" class="owl-carousel owl-theme">
							<?php $__currentLoopData = $expertUsersArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="item">
								<div class="s-block">
									<?php if($user->p_picture): ?>
									<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 400, 400, 100])).'','alt' => ''.e($user->f_name??'').'','title' => ''.e($user->f_name??'').'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 400, 400, 100])).'','alt' => ''.e($user->f_name??'').'','title' => ''.e($user->f_name??'').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
									<?php else: ?>
									<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('img/blank-profile-picture.png')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('img/blank-profile-picture.png')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
									<?php endif; ?>
									<span class="name"><?php echo e($user->f_name??''); ?> <?php echo e($user->l_name??''); ?></span>
									<?php if($user->about != ""): ?>
									<span class="position"><?php echo e($user->about); ?></span>
									<?php endif; ?>
								</div>
								<?php if($user->profile != ""): ?>
								<div class="cont">
									<p class="text-center w-100">
										<?php echo e($user->profile); ?>

									</p>
								</div>
								<?php endif; ?>
							</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('themes/frontend/assets/js/ask-experts.js')); ?>"></script>
<script>
	var owl = $('#expert-sliders');
	owl.owlCarousel({
		items: 1,
		loop: true,
		nav: true,
		dots: false,
		margin: 0,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
	});
	// 
	$("#topic").change(function() {
		window.location = this.value;
	});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/ask-expert.blade.php ENDPATH**/ ?>