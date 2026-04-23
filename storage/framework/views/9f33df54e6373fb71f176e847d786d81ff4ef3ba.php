<?php $__env->startSection('owl-carousel'); ?> <?php $__env->stopSection(); ?>
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
<?php if(isset($dataArr['custom_fields']['image_44'])): ?>
<?php $__env->startPush('styles'); ?>
<style>
    .about-us-goals .goals-wrapper {
        background-image: url('<?php echo e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_44']['value']); ?>');
    }
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
<div class="custom-banner no-bg about-us-banner">
    <div class="container">
        <?php if(isset($dataArr['custom_fields']['textarea_29'])): ?>
        <h1 class="f-b"><?php echo nl2br($dataArr['custom_fields']['textarea_29']['value']); ?></h1>
        <?php endif; ?>
    </div>
</div>

<div class="about-us-main">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6 col-md-6 col-sm-12 about-us-lft">
                <?php if(isset($dataArr['custom_fields']['textarea_30'])): ?>
                <h3><?php echo nl2br($dataArr['custom_fields']['textarea_30']['value']); ?></h3>
                <?php endif; ?>
                <?php if(isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_31'])): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_31']['value']).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_31']['value']).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>
                <?php echo $dataArr['descp']; ?>

            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 about-us-rgt">
                <?php if(isset($dataArr['custom_fields']['textarea_33'])): ?>
                <h3><?php echo nl2br($dataArr['custom_fields']['textarea_33']['value']); ?></h3>
                <?php endif; ?>
                <?php if(isset($dataArr['custom_fields']['editor_34'])): ?>
                <?php echo $dataArr['custom_fields']['editor_34']['value']; ?>

                <?php endif; ?>
                <div class="timeline-wrap">
                    <div class="timeline-block timeline-block-1">
                        <?php if(isset($dataArr['custom_fields']['text_35'])): ?>
                        <h3><?php echo e($dataArr['custom_fields']['text_35']['value']); ?></h3>
                        <?php endif; ?>
                        <?php if(isset($dataArr['custom_fields']['textarea_36'])): ?>
                        <p><?php echo nl2br($dataArr['custom_fields']['textarea_36']['value']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="timeline-block timeline-block-2">
                        <?php if(isset($dataArr['custom_fields']['text_37'])): ?>
                        <h3><?php echo e($dataArr['custom_fields']['text_37']['value']); ?></h3>
                        <?php endif; ?>
                        <?php if(isset($dataArr['custom_fields']['textarea_38'])): ?>
                        <p><?php echo nl2br($dataArr['custom_fields']['textarea_38']['value']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="timeline-block timeline-block-3">
                        <?php if(isset($dataArr['custom_fields']['text_39'])): ?>
                        <h3><?php echo e($dataArr['custom_fields']['text_39']['value']); ?></h3>
                        <?php endif; ?>
                        <?php if(isset($dataArr['custom_fields']['textarea_40'])): ?>
                        <p><?php echo nl2br($dataArr['custom_fields']['textarea_40']['value']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="timeline-block timeline-block-4">
                        <?php if(isset($dataArr['custom_fields']['text_41'])): ?>
                        <span><?php echo e($dataArr['custom_fields']['text_41']['value']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="g-ads-sec g-ads-sec-3">
    <div class="container">
        <div class="ads-continer">
            <?php if(isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_58'])): ?>
            <?php if(isset($dataArr['custom_fields']['text_59'])): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($dataArr['custom_fields']['text_59']['value']).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($dataArr['custom_fields']['text_59']['value']).'','target' => '_blank']); ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_58']['value']).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_58']['value']).'']); ?>
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
            <?php else: ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_58']['value']).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_58']['value']).'']); ?>
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
</div>

<div class="about-us-commitment bg-gry">
    <div class="container">
        <div class="row justify-content-between">
            <div class="commit-lft">
                <?php if(isset($dataArr['custom_fields']['textarea_42'])): ?>
                <h3><?php echo nl2br($dataArr['custom_fields']['textarea_42']['value']); ?></h3>
                <?php endif; ?>
            </div>
            <div class="commit-rgt">
                <?php if(isset($dataArr['custom_fields']['editor_43'])): ?>
                <?php echo $dataArr['custom_fields']['editor_43']['value']; ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="about-us-goals">
    <div class="container">
        <div class="goals-wrapper no-bg br-5">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?php if(isset($dataArr['custom_fields']['text_45'])): ?>
                    <h3><?php echo e($dataArr['custom_fields']['text_45']['value']); ?></h3>
                    <?php endif; ?>
                    <?php if(isset($dataArr['custom_fields']['editor_46'])): ?>
                    <?php echo $dataArr['custom_fields']['editor_46']['value']; ?>

                    <?php endif; ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?php if(isset($dataArr['custom_fields']['text_47'])): ?>
                    <h3><?php echo e($dataArr['custom_fields']['text_47']['value']); ?></h3>
                    <?php endif; ?>
                    <?php if(isset($dataArr['custom_fields']['editor_48'])): ?>
                    <?php echo $dataArr['custom_fields']['editor_48']['value']; ?>

                    <?php endif; ?>
                    <?php if(isset($dataArr['custom_fields']['textarea_49'])): ?>
                    <span class="title"><?php echo nl2br($dataArr['custom_fields']['textarea_49']['value']); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="our-team-slider">
    <div class="container">
        <?php if(isset($dataArr['custom_fields']['text_50'])): ?>
        <h3 class="text-center text-green"><?php echo e($dataArr['custom_fields']['text_50']['value']); ?></h3>
        <?php endif; ?>
        <div class="our-team-para text-center m-auto">
            <?php if(isset($dataArr['custom_fields']['textarea_51'])): ?>
            <p><?php echo e($dataArr['custom_fields']['textarea_51']['value']); ?></p>
            <?php endif; ?>
        </div>
        <?php if(count($teamMdl) > 0): ?>
        <div class="our-team-carousel">
            <div class="owl-carousel owl-theme">
                <?php $__currentLoopData = $teamMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item">
                    <div class="team-c-col">
                        <div class="team-c-img">
                            <?php if($record->media != null): ?>
                            <?php if($record->media['path']): ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $record->media->path).'','alt' => ''.e($record->media->alt).'','title' => ''.e($record->media->title).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $record->media->path).'','alt' => ''.e($record->media->alt).'','title' => ''.e($record->media->title).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="team-c-cnt">
                            <div class="team-c-bio">
                                <span class="team-name"><?php echo e($record->name); ?></span>
                                <?php if($record->designation): ?>
                                <span class="team-position"><?php echo e($record->designation); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="team-c-connect">
                                <?php if($record->linkedin_link): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($record->linkedin_link).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($record->linkedin_link).'','target' => '_blank']); ?>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/linkedin-icon-4.jpg')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/linkedin-icon-4.jpg')).'']); ?>
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
                                <?php endif; ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    dots: false,
                    margin: 20
                },
                600: {
                    items: 4,
                    nav: false,
                    dots: false,
                    margin: 30
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    dots: false,
                    margin: 40
                }
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/about.blade.php ENDPATH**/ ?>