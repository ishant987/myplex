<?php $__env->startSection('moneycontrol'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('select2'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('captcha'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery-validate'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
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
<div class="data-slider">
    <div class="slider-wrapper">
        <?php if(count($bnrMdl) > 0): ?>
        <div id="carouselControls" class="main-slider carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                <?php $__currentLoopData = $bnrMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="carousel-item<?php echo e($key == 0 ? ' active' : ''); ?>">
                    <?php if($record->media != null): ?>
                    <?php if($record->media['path']): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $record->media->path).'','class' => 'd-block w-100','alt' => ''.e($record->media->alt).'','title' => ''.e($record->media->title).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $record->media->path).'','class' => 'd-block w-100','alt' => ''.e($record->media->alt).'','title' => ''.e($record->media->title).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <div class="slider-c-wrapper">
                        <div class="container">
                            <div class="s-c-lft">
                                <h3><?php echo e($record->title); ?></h3>
                                <?php echo $record->descp; ?>

                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 sc-btn-1">
                                        <?php if($record->link): ?>
                                        <a <?php if($record->link_target): ?> target="<?php echo e($record->link_target); ?>" <?php endif; ?>
                                            href="<?php echo e($record->link); ?>"
                                            class="explore-s"><?php echo e($record->link_text); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <?php endif; ?>
        <div class="market-updates-slider">
            <div class="container p-0 mr-0">
                <?php if(isset($dataArr['custom_fields']['text_1'])): ?>
                <h3><?php echo e($dataArr['custom_fields']['text_1']['value']); ?></h3>
                <?php endif; ?>
                <?php if($nwsApiData): ?>
                <div class="verticalCarousel">
                    <div class="verticalCarouselHeader">
                        <a href="#" class="vc_goDown">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/select-arrow.png')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/select-arrow.png')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </a>
                        <a href="#" class="vc_goUp">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/select-arrow.png')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/select-arrow.png')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </a>
                    </div>
                    <ul class="verticalCarouselGroup vc_list">
                        <?php echo $nwsApiData; ?>

                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="live-market-data">
    <div class="container">
        <div class="live-market-wrap">
            <div id="marketRadar" style="display:none">
                <input type="hidden" value="0" id="pricevalcntr">
                <div class="tpSec clearfix">
                    <div class="stockDsl">
                        <div class="mrdBox item" id="elm1"></div>
                        <div class="mrdBox item" id="elm2"></div>
                        <div class="mrdBox item" id="elm3"></div>
                        <div class="mrdBox item" id="elm4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="g-ads-sec">
    <div class="container">
        <div class="ads-continer">
            <?php if(isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_54'])): ?>
            <?php if(isset($dataArr['custom_fields']['text_55'])): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($dataArr['custom_fields']['text_55']['value']).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($dataArr['custom_fields']['text_55']['value']).'','target' => '_blank']); ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_54']['value']).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_54']['value']).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_54']['value']).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_54']['value']).'']); ?>
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

<div class="home-select-service select2-styles" id="vue-app-selections-home">
    <selections-home></selections-home>
</div>

<div class="advisor-slider">
    <div class="container">
        <div id="advisor-slides" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="adv-slides d-flex">
                        <div class="adv-s-image float-left">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/financial-advisor.jpg')).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/financial-advisor.jpg')).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        <div class="adv-s-content float-right">
                            <h3>Are You A Financial Advisor?</h3>
                            <h4 class="text-green">Claim Your 90 Days Access!</h4>
                            <p>Professional service uses specialised, <br />
                                project management techniques to oversee the... <br>
                                service uses specialised,
                            </p>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.login')).'','class' => 'explore-btn']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.login')).'','class' => 'explore-btn']); ?>ADVISOR LOGIN <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="compare-scemes-sec select2-styles" id="vue-app-compare-scheme-home">
    <div class="container">
        <div class="compare-block">
            <?php if(isset($dataArr['custom_fields']['text_5'])): ?>
            <h3 class="text-center"><?php echo e($dataArr['custom_fields']['text_5']['value']); ?></h3>
            <?php endif; ?>
            <?php if(isset($dataArr['custom_fields']['textarea_6'])): ?>
            <p class="text-center"><?php echo nl2br($dataArr['custom_fields']['textarea_6']['value']); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <compare-scheme-home></compare-scheme-home>
</div>

<div class="compare-scemes-sec investing-tools select2-styles home-calculators">
    <div class="container">
        <div class="compare-block">
            <?php if(isset($dataArr['custom_fields']['editor_7'])): ?>
            <h3 class="text-center"><?php echo $dataArr['custom_fields']['editor_7']['value']; ?></h3>
            <?php endif; ?>
        </div>
        <ul class="nav nav-tabs justify-content-center border-0">
            <li>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.calculators')).'?tab=sip-planner']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.calculators')).'?tab=sip-planner']); ?>SIP Planner <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </li>
            <li>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.calculators')).'?tab=sip-p-calc']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.calculators')).'?tab=sip-p-calc']); ?>SIP Performance Calculator <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </li>
            <li>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.calculators')).'?tab=inf-calc']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.calculators')).'?tab=inf-calc']); ?>Inflation Calculator <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </li>
            <li>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.calculators')).'?tab=retire-calc']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.calculators')).'?tab=retire-calc']); ?>Retirement Calculator <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </li>
            <li>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.calculators')).'?tab=risk-tol-eval']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.calculators')).'?tab=risk-tol-eval']); ?>Risk Tolerance Evaluator <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </li>
        </ul>
    </div>
</div>

<div class="blogs-sec">
    <div class="container">
        <?php if(isset($dataArr['custom_fields']['text_2'])): ?>
        <h3><?php echo e($dataArr['custom_fields']['text_2']['value']); ?></h3>
        <?php endif; ?>
        <div class="row">
            <?php if(count($blogPosts) > 0): ?>
            <?php $__currentLoopData = $blogPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $recordBlog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 b-block">
                <div class="wrap">
                    <div class="block-lft float-left">
                        <?php if(isset($recordBlog['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium']['source_url'])): ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($recordBlog['link']).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($recordBlog['link']).'','target' => '_blank']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($recordBlog['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium']['source_url']).'','alt' => ''.$recordBlog['_embedded']['wp:featuredmedia'][0]['alt_text'].'','title' => ''.$recordBlog['_embedded']['wp:featuredmedia'][0]['title']['rendered'].'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($recordBlog['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium']['source_url']).'','alt' => ''.$recordBlog['_embedded']['wp:featuredmedia'][0]['alt_text'].'','title' => ''.$recordBlog['_embedded']['wp:featuredmedia'][0]['title']['rendered'].'','class' => 'img-fluid']); ?>
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
                    <div class="block-rgt float-right">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($recordBlog['link']).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($recordBlog['link']).'','target' => '_blank']); ?><?php echo \App\Lib\Core\Useful::getShortContent(strip_tags($recordBlog['title']['rendered']), 50); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <!-- <?php echo $recordBlog['excerpt']['rendered']; ?> -->
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="g-ads-sec g-ads-sec-2">
    <div class="container">
        <div class="ads-continer">
            <?php if(isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_56'])): ?>
            <?php if(isset($dataArr['custom_fields']['text_57'])): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($dataArr['custom_fields']['text_57']['value']).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($dataArr['custom_fields']['text_57']['value']).'','target' => '_blank']); ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_56']['value']).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_56']['value']).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_56']['value']).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_56']['value']).'']); ?>
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

<div class="fund-expert-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 fund-expert">
                <?php if(count($fundManMdl) > 0): ?>
                <?php if(isset($dataArr['custom_fields']['text_8'])): ?>
                <h3><?php echo e($dataArr['custom_fields']['text_8']['value']); ?></h3>
                <?php endif; ?>
                <div class="fe-profile">
                    <?php if($fundManMdl[0]->media != null): ?>
                    <?php if($fundManMdl[0]->media['path']): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.fundman', $fundManMdl[0]->slug)).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.fundman', $fundManMdl[0]->slug)).'']); ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $fundManMdl[0]->media->path).'','alt' => ''.e($fundManMdl[0]->media->alt).'','title' => ''.e($fundManMdl[0]->media->title).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $fundManMdl[0]->media->path).'','alt' => ''.e($fundManMdl[0]->media->alt).'','title' => ''.e($fundManMdl[0]->media->title).'']); ?>
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
                    <?php endif; ?>
                </div>
                <div class="fe-info">
                    <div class="fe-person">
                        <div class="fe-title float-left">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.fundman', $fundManMdl[0]->slug)).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.fundman', $fundManMdl[0]->slug)).'']); ?>
                                <h6><?php echo e($fundManMdl[0]->name); ?></h6>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if($fundManMdl[0]->designation): ?>
                            <span class="desig"><?php echo e($fundManMdl[0]->designation); ?></span>
                            <?php endif; ?>
                            <?php if($fundManMdl[0]->company_name): ?>
                            <span class="desig"><?php echo e($fundManMdl[0]->company_name); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="clear"></div>
                        <?php if($fundManMdl[0]->synopsis): ?>
                        <p class="bio"><?php echo \App\Lib\Core\Useful::getShortContent( strip_tags($fundManMdl[0]->synopsis), 240); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="clear"></div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 faq-sec">
                <?php if(isset($dataArr['custom_fields']['text_9'])): ?>
                <h3><?php echo e($dataArr['custom_fields']['text_9']['value']); ?></h3>
                <?php endif; ?>
                <?php if(count($faqMdl) > 0): ?>
                <div id="accordion" class="faq-ac">
                    <?php $__currentLoopData = $faqMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faqKey => $faqRecord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card">
                        <div class="card-header" id="heading_<?php echo e($faqRecord->faq_id); ?>">
                            <h5 class="mb-0">
                                <button class="btn btn-link<?php echo e($faqKey == 0 ? '' : ' collapsed'); ?>" data-toggle="collapse" data-target="#collapse_<?php echo e($faqRecord->faq_id); ?>" aria-expanded="<?php echo e($faqKey == 0 ? 'true' : 'false'); ?>" aria-controls="collapse_<?php echo e($faqRecord->faq_id); ?>">
                                    <?php echo e($faqRecord->title); ?>

                                </button>
                            </h5>
                        </div>
                        <div id="collapse_<?php echo e($faqRecord->faq_id); ?>" class="collapse<?php echo e($faqKey == 0 ? ' show' : ''); ?>" aria-labelledby="heading_<?php echo e($faqRecord->faq_id); ?>" data-parent="#accordion">
                            <div class="card-body">
                                <?php if($faqRecord->descp): ?>
                                <p><?php echo nl2br($faqRecord->descp); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="patshala-new">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
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
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h3>Fund Watch</h3>
                <div class="patshala-new-rgt">
                    <div class="patshala-box-1">
                        <?php if(count($fndWtchMdl) > 0): ?>
                        <h5><?php echo e($fndWtchMdl[0]->title); ?></h5>
                        <?php if($fndWtchMdl[0]->description): ?>
                        <p><?php echo \App\Lib\Core\Useful::getShortContent( strip_tags($fndWtchMdl[0]->description), 260); ?></p>
                        <?php endif; ?>
                        <div class="home-fw-btn">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.fundwatch', $fndWtchMdl[0]->fw_id)).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.fundwatch', $fndWtchMdl[0]->fw_id)).'']); ?>View Details <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="patshala-box-2">
                        <?php if(count($nfoMdl) > 0): ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.nfomonitor', $nfoMdl[0]->no_id)).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.nfomonitor', $nfoMdl[0]->no_id)).'']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/new-fund-offer.jpg')).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/new-fund-offer.jpg')).'','class' => 'img-fluid']); ?>
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
                </div>
            </div>
        </div>
    </div>
</div>

<div class="customer-speaks">
    <div class="container">
        <?php if(isset($dataArr['custom_fields']['text_10'])): ?>
        <h3 class="text-center"><?php echo e($dataArr['custom_fields']['text_10']['value']); ?></h3>
        <?php endif; ?>
        <div class="row">
            <?php if(count($tstmnlMdl) > 0): ?>
            <div id="testimonials" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner text-center">
                    <?php $__currentLoopData = $tstmnlMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tstmnlRecord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="carousel-item<?php echo e($key == 0 ? ' active' : ''); ?>">
                        <div class="c-content">
                            <?php echo nl2br($tstmnlRecord->descp); ?>

                            <div class="profile">
                                <div class="profile-pic">
                                    <?php if($tstmnlRecord->media != null): ?>
                                    <?php if($tstmnlRecord->media['path']): ?>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $tstmnlRecord->media->path).'','alt' => ''.e($tstmnlRecord->media->alt).'','title' => ''.e($tstmnlRecord->media->title).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $tstmnlRecord->media->path).'','alt' => ''.e($tstmnlRecord->media->alt).'','title' => ''.e($tstmnlRecord->media->title).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="info">
                                    <h6><?php echo e($tstmnlRecord->name); ?></h6>
                                    <?php if($tstmnlRecord->designation): ?>
                                    <span><?php echo e($tstmnlRecord->designation); ?></span>
                                    <?php endif; ?>
                                    <?php if($tstmnlRecord->company): ?>
                                    <span><?php echo e($tstmnlRecord->company); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <a class="carousel-control-prev" href="#testimonials" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#testimonials" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="patshala-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 patshala">
                <h3>Ask An Expert</h3>
                <div class="patshala-lft-wrap d-flex">
                    <?php if(count($aeQuesMdl) > 0): ?>
                    <div class="expert-says border-s box-shadow bg-gry br-5">
                        <div class="expert-para">
                            <p><span class="quote-1">"</span><?php echo \App\Lib\Core\Useful::getShortContent( strip_tags($aeQuesMdl[0]->question), 190); ?><span class="quote-2">"</span></p>
                        </div>
                        <div class="expert-data">
                            <div class="exp-profile">
                                <?php if($aeQuesMdl[0]->user != null): ?>
                                <?php if($aeQuesMdl[0]->user->p_picture): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(url('storage', [$aeQuesMdl[0]->user->p_picture, $defDataArr['user_media_folder'], 78, 78, 100])).'','alt' => ''.e($aeQuesMdl[0]->user->f_name??'').'','title' => ''.e($aeQuesMdl[0]->user->f_name??'').'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(url('storage', [$aeQuesMdl[0]->user->p_picture, $defDataArr['user_media_folder'], 78, 78, 100])).'','alt' => ''.e($aeQuesMdl[0]->user->f_name??'').'','title' => ''.e($aeQuesMdl[0]->user->f_name??'').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php else: ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/expert-profile.png')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/expert-profile.png')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($aeQuesMdl[0]->addedbyuser != null): ?>
                                <span class="qName"><?php echo e($aeQuesMdl[0]->addedbyuser->f_name); ?><?php if($aeQuesMdl[0]->addedbyuser->l_name): ?><?php echo e(' '.$aeQuesMdl[0]->addedbyuser->l_name); ?> <?php endif; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="exp-btn">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.ask-expert')).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.ask-expert')).'']); ?>View All <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
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
<?php if(count($nwsListMdl) > 0): ?>
<div class="press-release">
    <div class="container">
        <div class="row justify-content-center align-items-center press-header">
            <div class="col press-lft">
                <h3>In The News</h3>
            </div>
            <div class="col press-rgt">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.news')).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.news')).'']); ?>View All <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
        </div>
        <div class="row news-blocks">
            <?php $__currentLoopData = $nwsListMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $nwsRecord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-md-4 col-sm-12">
                <div class="news-inner-block">
                    <?php if($nwsRecord->news_source_link != ''): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($nwsRecord->news_source_link).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($nwsRecord->news_source_link).'','target' => '_blank']); ?>
                        <?php endif; ?>
                        <?php if($nwsRecord->media_type != ''): ?>
                        <?php switch($nwsRecord->media_type):
                        case ('i'): ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['news_folder'] . $nwsRecord->image).'','alt' => ''.e($nwsRecord->title).'','title' => ''.e($nwsRecord->title).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['news_folder'] . $nwsRecord->image).'','alt' => ''.e($nwsRecord->title).'','title' => ''.e($nwsRecord->title).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php break; ?>
                        <?php case ('v'): ?>
                        <?php switch($nwsRecord->video_from):
                        case ('l'): ?>
                        <?php echo e(\App\Lib\Core\Core::htmlVideoPlayer($defDataArr['news_folder'].$nwsRecord->video_data)); ?>

                        <?php break; ?>
                        <?php case ('y'): ?>
                        <?php if($nwsRecord->video_image != ''): ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['news_folder'] . $nwsRecord->video_image).'','alt' => ''.e($nwsRecord->title).'','title' => ''.e($nwsRecord->title).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['news_folder'] . $nwsRecord->video_image).'','alt' => ''.e($nwsRecord->title).'','title' => ''.e($nwsRecord->title).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php endif; ?>
                        <?php break; ?>
                        <?php endswitch; ?>
                        <?php break; ?>
                        <?php endswitch; ?>
                        <?php endif; ?>
                        <span><?php echo e($nwsRecord->title); ?></span>
                        <?php if($nwsRecord->news_source_link != ''): ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('themes/frontend/assets/js/vertical-slider/jQueryVerticalCarousel.js')); ?>"></script>
<script>
    $(".verticalCarousel").verticalCarousel({
        currentItem: 1,
        showItems: 6,
    });
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/index.blade.php ENDPATH**/ ?>