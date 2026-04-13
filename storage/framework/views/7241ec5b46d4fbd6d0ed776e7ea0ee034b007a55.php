<?php $__env->startSection('content'); ?>

<div class="banner" style="background: url(https://myplexus.com/themes/frontend/assets/v1/img/inner_banner.png)">
    <div class="container">
        <h1>Fund watch</h1>
        <h4>All funds list</h4>
    </div>
</div>

    <div class="body_main">
        <div class="container">
            <div class="body_content">
                <div class="content_left">
                    <div class="new_fund">
                        <?php $__currentLoopData = $fundWatch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="new_fund_single">
                            <img src="<?php echo e(env('ADMIN_SITE')); ?>/assets/images/<?php echo e($funds->logo); ?>" alt="">
                            <h3><?php echo e(!empty($funds->fundDetails)?$funds->fundDetails->fund_name:'N/A'); ?></h3>
                            <p><?php echo e($funds->preamble); ?></p>
                            <?php $fund_code_viewMore = base64_encode($funds->fundDetails->fund_code);  ?>
                            <a href="<?php echo e(url('new-fundwatch')); ?>/<?php echo e($fund_code_viewMore); ?>" target="_blank">View More</a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <!-- <div class="content_right">
                    <h2 class="arc">Recent Posts</h2>

                    <div class="m_fund">
                    <ul>
                        <li>
                            <a href="#">BARODA BNP PARIBAS Mid Cap</a>
                            <figure>
                                <a href="#"><img src="https://myplexus.com/themes/frontend/assets/v1/img/fund.png" alt=""></a>
                            </figure>
                        </li>
                        <li>
                            <a href="#">BARODA BNP PARIBAS Mid Cap</a>
                            <figure>
                                <a href="#"><img src="https://myplexus.com/themes/frontend/assets/v1/img/fund.png" alt=""></a>
                            </figure>
                        </li>
                    </ul>
                </div>

                <h2 class="arc arc_new">Archives</h2>

                <div class="m_fund arc_yr">
                    <a href="#">2022 <span>(6)</span></a>
                    <a href="#">2024 <span>(2)</span></a>
                </div>
                </div> -->

                <div class="content_right">
                <h2 class="arc">Recent Posts</h2>
                <div class="m_fund">
                    <ul>
                        <?php $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recentPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                        <?php $fund_code_encoded = base64_encode($recentPost->fundDetails->fund_code);  ?>
                        <a href="<?php echo e(url('new-fundwatch')); ?>/<?php echo e($fund_code_encoded); ?>" target="_blank">
                            <?php echo e($recentPost->fundDetails->fund_name); ?>

                        </a>

                            <figure>
                            <a href="<?php echo e(url('new-fundwatch')); ?>/<?php echo e($fund_code_encoded); ?>" target="_blank"><img src="<?php echo e(env('ADMIN_SITE')); ?>/assets/images/<?php echo e($recentPost->logo); ?>" alt=""></a>
                            </figure>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <h2 class="arc arc_new">Archives</h2>
                <div class="m_fund arc_yr">
                    <?php $__currentLoopData = $archiveData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="#"><?php echo e($archive->creation_year); ?> <span>(<?php echo e($archive->record_count); ?>)</span></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                </div>
                </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/new-fundwatch-list.blade.php ENDPATH**/ ?>