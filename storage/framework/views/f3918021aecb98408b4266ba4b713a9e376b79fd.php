<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('captcha'); ?> <?php $__env->stopSection(); ?>
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
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4><?php echo e($dataArr['title']); ?></h4>
                </div>
            </div>
        </div>
    </div>
</section> 
<section  class="info_monitor_sec fund_watch_setion_home nfo_monitor_home_section section">
    <div class="container">
        <?php if(count($dataListModel) == 0): ?>
            <p><?php echo e(__('message.data_not_available')); ?></p>
        <?php else: ?>
            <?php if($reqYear > 0): ?>
                <div class="pentatech_filter_title m-3">
					<h4><?php echo e($singleArchieve[0]->year.' ('.$singleArchieve[0]->tot.')'); ?></h4>
                </div>
                <div class="archive-wrapper">
                    <div class="archives-posts ">
                        <div class="row m-0 archive-row ">
                            <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="archive-block col-md-6 col-lg-4">
                                    <div class="blog-sidebar-links blog-sidebar-block archieves-de br-5 box-shadow2">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.nfomonitor', $record['no_id'])).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.nfomonitor', $record['no_id'])).'']); ?><?php echo e($record['fund_name']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php if($record['objective'] != ''): ?>
                                            <p><?php echo \App\Lib\Core\Useful::getShortContent(strip_tags($record['objective']), 80); ?></p>
                                        <?php endif; ?>
                                        <h6>Posted On <span class="archive-post-date"><?php echo e(date($dateFormat, strtotime($record['post_date']))); ?></span></h6>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="archive-wrapper">
                    <div class="row m-0 justify-content-between align-items-center">
                        <div class="archive-title"><h3><?php echo e($key == 0 ? 'Recent NFO' : 'Archives From '.$record['archive']['year']); ?> <span class="posts-count">(<?php echo e($record['archive']['tot']); ?>)</span></h3></div>
                        <div class="archive-view-all">
                            
                        </div>
                    </div>
                    <div class="archives-posts">
                        <div class="row m-0 archive-row">
                            <?php if(count($record['items']) == 0): ?>
                                <p><?php echo e(__('message.data_not_available')); ?></p>
                            <?php else: ?>
                           
                                <?php $__currentLoopData = $record['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="single_blog">
                                        <div class="blog_content">
                                            <h4><a href="<?php echo e(route('web.nfomonitor', $record2['no_id'])); ?>"><?php echo e($record2['fund_name']); ?></a></h4>
                                            <?php if($record2['objective'] != ''): ?>
                                            <p><?php echo \App\Lib\Core\Useful::getShortContent(strip_tags($record2['objective']), 150); ?></p>
                                        <?php endif; ?>
                                            <div class="post_author d-flex align-items-enter">
                                                <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i> <?php echo e($record2['fund_manager'] ? $record2['fund_manager'] : ''); ?></div>
                                                <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> <?php echo e(date($dateFormat, strtotime($record2['post_date']))); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/nfo/list.blade.php ENDPATH**/ ?>