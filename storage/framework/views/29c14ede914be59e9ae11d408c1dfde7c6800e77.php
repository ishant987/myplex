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
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>Ask An Experts</h4>
                    <p>The mutual fund industry is fast becoming the preferred savings and investment vehicle for most of us.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section ask_question_section">
    <div class="container">
        <div class="row">
           <div class="col-md-8">
                <div class="vision_title mb-5">
                    <h4 data-aos="fade-down" data-aos-duration="1000">Get The Best Advice From MyPlexus Team!</h4>
                    <p data-aos="fade-down" data-aos-duration="1500">A plexus (from the Latin for "braid") is a branching network of vessels or nerves.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-7">
                <div class="question_listing_sec pe-5">                       
                    <div class="question_search_panel">
                        <form action="#" id="m_search_form" method="get">
                            <input type="text" id="m_search_text" autocomplete="off" name="ms" placeholder="<?php echo e(__('web.search_txt')); ?>" value="<?php echo e((isset($_GET['ms']))?$_GET['ms']:''); ?>"/>
                            <i class="ph-magnifying-glass-bold"></i>
                            
                        </form>
                    </div>
                    <div class="question_wrapper mt-4">
                        <?php $__currentLoopData = $dataList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="single_question mb-4">
                            <p  onclick="toggleAnswer(<?php echo e($record->aeq_id); ?>)"> <?php echo \App\Lib\Core\Useful::getShortContent( strip_tags($record->question), $defDataArr['askexpert_lang']['title_char_limit']); ?></p>
                            <small><?php echo e($record->user->f_name . " " . $record->user->l_name); ?> | <?php echo e(\Carbon\Carbon::createFromTimeStamp(strtotime($record->created_at))->diffForHumans()); ?></small>
                            <div class="d-flex align-items-center mt-3">
                                <div class="answer_count me-5">
                                    <span><?php echo e($record->totalAnswers()['normal']); ?></span>
                                    <span><?php echo e($defDataArr['askexpert_lang']['answer_txt']); ?></span>
                                </div>
                                <div class="answer_count">
                                    <span><?php echo e($record->totalAnswers()['expert']); ?></span>
                                    <span><?php echo e($defDataArr['askexpert_lang']['expert_txt']); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="comment-replies-wrap box-shadow postsReply mb-2" id="postsReply<?php echo e($record->aeq_id); ?>">
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
                                    <div class="col-lg-10 col-md-9 col-sm-9">
                                        <div class="posts">
                                            <p><?php echo $record2->answer; ?></p>
                                            <div class="user-data">
                                                <div class="row mx-0">
                                                    <small><?php echo e($record2->user->f_name . " " . $record2->user->l_name); ?> | <?php echo e(\Carbon\Carbon::createFromTimeStamp(strtotime($record2->created_at))->diffForHumans()); ?></small>
                                                </div>
                                            </div>
                                            <div class="question-data">
                                                <div class="row mx-0">
                                                    <div class="col-12 px-0">
                                                        <div class="comment-action">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div class="ask_question_form">
                    <h4>Ask Question</h4>
                    <p>Share your thoughts with us..</p>
                    <form name="quesForm" id="quesForm" action="<?php echo e(route('web.ask-question.save')); ?>" method="post" class="quesForm" enctype="multipart/form-data">
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
                        <input type="text" placeholder="Enter Your Name"/>
                        <textarea placeholder="Ask An Question"></textarea>
                        <button class="compare_scheme_btn mt-1">Submit Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="abt_meet_our_section section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="vision_title mb-5">
                    <h4 data-aos="fade-down" data-aos-duration="1000"><?php echo e($defDataArr['askexpert_lang']['pnl_of_exprts_txt']); ?></h4>
                    <p data-aos="fade-down" data-aos-duration="1500">We, at myplexus.com believe the financial intermediation and personal finance industry in India is going through the fastest evolutionary stage.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="meet_team_slider">
                    <?php $__currentLoopData = $expertUsersArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="single_team">
                            <div class="single_team_wrapper">
                                <div class="single_team_img">
                                    <?php if($user->p_picture): ?>
                                    <img src="<?php echo e(url('storage/user', [$user->p_picture])); ?>" alt="<?php echo e($user->f_name??''); ?>"/>
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
                                </div>
                                <ul>
                                    <li><a href="#"><i class="ph-facebook-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-twitter-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-instagram-logo"></i></a></li>
                                </ul>
                            </div>
                            <div class="single_team_content">
                                <h4><?php echo e($user->f_name??''); ?> <?php echo e($user->l_name??''); ?></h4>
                                <?php if($user->about != ""): ?>
                                    <p><?php echo e($user->about); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('themes/frontend/assets/js/ask-experts.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('style'); ?>
<style>
    .ask_question_section .comment-replies-wrap {
    background: #fff;
    border-radius: 5px;
    padding: 40px 30px;
    /* margin-left: 160px; */
    margin-top: 40px;
    display: none;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/ask-expert.blade.php ENDPATH**/ ?>