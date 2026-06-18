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

<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>Fund Wath</h4>
                    <p>The mutual fund industry is fast becoming the preferred savings and investment vehicle for most of us.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pentatech_section section">
    <div class="container">
        <div class="row">
            <div class="co-md-12">
                <div class="pentatech_inner_wrapper">
                    <div class="pentatech_inner">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="fund_watch_left">
                                    <div class="fundwatch_title">
                                        <h4>Mahindra Manulife Flexi Cap Yojana</h4>
                                    </div>
                                    <div class="fund_watch_left_main">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        <div class="fund_watch_table table-responsive">
                                            <table class="table  table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>3/31/2021</th>
                                                        <th>3/31/2021</th>
                                                        <th>3/31/2021</th>
                                                        <th>3/31/2021</th>
                                                        <th>3/31/2021</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Rank</th>
                                                        <th>Rank</th>
                                                        <th>Rank</th>
                                                        <th>Rank</th>
                                                        <th>Rank</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>15</td>
                                                        <td>12</td>
                                                        <td>13</td>
                                                        <td>1</td>
                                                        <td>05</td>
                                                    </tr>
                                                    <tr>
                                                        <td>15</td>
                                                        <td>12</td>
                                                        <td>13</td>
                                                        <td>1</td>
                                                        <td>05</td>
                                                    </tr>
                                                    <tr>
                                                        <td>15</td>
                                                        <td>12</td>
                                                        <td>13</td>
                                                        <td>1</td>
                                                        <td>05</td>
                                                    </tr>
                                                    <tr>
                                                        <td>15</td>
                                                        <td>12</td>
                                                        <td>13</td>
                                                        <td>1</td>
                                                        <td>05</td>
                                                    </tr>
                                                    <tr>
                                                        <td>15</td>
                                                        <td>12</td>
                                                        <td>13</td>
                                                        <td>1</td>
                                                        <td>05</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="fund_watch_right_sec">
                                    <div class="fund_watch_right_title">
                                        <h4>More Fund Watch</h4>
                                    </div>
                                    <div class="changes_table">
                                        <table class="table table-responsive table-striped">
                                            <tbody>
                                                <?php $__currentLoopData = $rcntDataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $mediad_files_data =$record2->getData(['fw_id' => $record2->fw_id, 'status' => 1]);
                                                ?>
                                                <tr>
                                                    <td><?php echo e($record2->title); ?></td>
                                                    <td>
                                                        <a href="<?php echo e($media_folder.$mediad_files_data->file); ?>" download target="_blank" title="<?php echo e($record2->title); ?>">
                                                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>"alt="download"/>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="archive_fund_watch_sec">
                        <div class="archive_fund_watch_title d-flex justify-content-between align-items-center mb-3">
                            <h4>Archives</h4>
                            <div class="archive_select_year d-flex align-items-center">
                                <p>Select Year</p>
                                <div class="dropdown">
                                    <button class="dropdown-toggle mb-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">

                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="archive_fund_watch_tabl">
                                    <div class="changes_table">
                                        <table class="table table-responsive table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Mahindra Manulife Flexi Cap Yojana</td>
                                                    <td><a href="#"><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Tata Business Cycle Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>PGIM India Small Cap Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>SBI ETF Consumption</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Nippon India Nifty Pharma ETF</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>ICICI Prudential Flexicap Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>HDFC Banking and Financial Services Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Boi Axa Blue Chip Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Axis Quant Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Aditya Birla Sun Life Weight Index Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="archive_fund_watch_tabl">
                                    <div class="changes_table">
                                        <table class="table table-responsive table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Mahindra Manulife Flexi Cap Yojana</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Tata Business Cycle Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>PGIM India Small Cap Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>SBI ETF Consumption</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Nippon India Nifty Pharma ETF</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>ICICI Prudential Flexicap Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>HDFC Banking and Financial Services Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Boi Axa Blue Chip Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Axis Quant Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Aditya Birla Sun Life Weight Index Fund</td>
                                                    <td><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/v1/img/download.png')); ?>" /></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/fund-watch.blade.php ENDPATH**/ ?>