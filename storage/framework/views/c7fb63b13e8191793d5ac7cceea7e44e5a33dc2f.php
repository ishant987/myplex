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

<?php echo $__env->make('web.pages.blog.latest_blogs',['heading'=>'','sub_heading'=>'Highlighted Posts'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(!empty($data['editors_pick'])): ?>
<section class="editor_pics_blog section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="blog_title">
                    <h4>Editors Picks</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <?php $__currentLoopData = $data['editors_pick']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4">
                <div class="single_blog">
                    <div class="single_blog_img">
                        <img src="<?php echo e($ImagePath.$value['image_thumb']); ?>" class="img-fluid" />
                    </div>
                    <div class="blog_content single_highlight_post1">
                        <h4>
                            <a href="<?php echo e(url('money_seriously').'/'.$value['unique_url']); ?>">
                                <?php echo e($value['heading']); ?>

                            </a>
                        </h4>
                        <p><?php echo e($value['sub_heading']); ?></p>
                        <div class="post_author d-flex align-items-enter">
                            <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i><?php echo e($value['author']); ?></div>
                            <?php
                            $date = explode("-",explode("T", $value['created_at'])[0]);
                            ?>
                            <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> <?php echo e($date[2].'.'.$date[1].'.'.$date[0]); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if(!empty($data['must_read'])): ?>
<?php echo $__env->make('web.pages.blog.must_read_blogs',['heading'=>'Must Read'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/blog/index.blade.php ENDPATH**/ ?>