<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12 dshbrd">
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
    </div>
</div>

<div class="row dshbrd-qck-bx">
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="<?php echo e($moduleAtrArr['target']); ?>" href="<?php echo e($totalBoxes[0]['url']); ?>" title="<?php echo e($moduleAtrArr['list_txt']); ?>">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-envelope f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><?php echo e($totalBoxes[0]['title']); ?></h6>
                            <h2 class="m-b-0"><?php echo e($totalBoxes[0]['total']); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="<?php echo e($moduleAtrArr['target']); ?>" href="<?php echo e($totalBoxes[1]['url']); ?>" title="<?php echo e($moduleAtrArr['list_txt']); ?>">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-question-circle f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><?php echo e($totalBoxes[1]['title']); ?></h6>
                            <h2 class="m-b-0"><?php echo e($totalBoxes[1]['total']); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="<?php echo e($moduleAtrArr['target']); ?>" href="<?php echo e($totalBoxes[2]['url']); ?>" title="<?php echo e($moduleAtrArr['list_txt']); ?>">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-users f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><?php echo e($totalBoxes[2]['title']); ?></h6>
                            <h2 class="m-b-0"><?php echo e($totalBoxes[2]['total']); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="<?php echo e($moduleAtrArr['target']); ?>" href="<?php echo e($totalBoxes[3]['url']); ?>" title="<?php echo e($moduleAtrArr['list_txt']); ?>">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-send f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><?php echo e($totalBoxes[3]['title']); ?></h6>
                            <h2 class="m-b-0"><?php echo e($totalBoxes[3]['total']); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="<?php echo e($moduleAtrArr['target']); ?>" href="<?php echo e($totalBoxes[4]['url']); ?>" title="<?php echo e($moduleAtrArr['list_txt']); ?>">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-money f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><?php echo e($totalBoxes[4]['title']); ?></h6>
                            <h2 class="m-b-0"><?php echo e($totalBoxes[4]['total']); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="<?php echo e($moduleAtrArr['target']); ?>" href="<?php echo e($totalBoxes[5]['url']); ?>" title="<?php echo e($moduleAtrArr['list_txt']); ?>">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-line-chart f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><?php echo e($totalBoxes[5]['title']); ?></h6>
                            <h2 class="m-b-0"><?php echo e($totalBoxes[5]['total']); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="<?php echo e($moduleAtrArr['target']); ?>" href="<?php echo e($totalBoxes[6]['url']); ?>" title="<?php echo e($moduleAtrArr['list_txt']); ?>">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-money f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><?php echo e($totalBoxes[6]['title']); ?></h6>
                            <h2 class="m-b-0"><?php echo e($totalBoxes[6]['total']); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row dshbrd-qck-bx">
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="<?php echo e($moduleAtrArr['target']); ?>" href="<?php echo e($slBoxes[1]['url']); ?>" title="<?php echo e($moduleAtrArr['list_txt']); ?>">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-line-chart f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><?php echo e($slBoxes[1]['title']); ?></h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a href="<?php echo e($slBoxes[2]['url']); ?>" title="<?php echo e($slBoxes[2]['title']); ?>" onclick="return confirm('<?php echo e(__('admin.confirm.clear_cache')); ?>');">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-refresh f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><?php echo e($slBoxes[2]['title']); ?></h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 p-r-0">
        <div class="card feed-card">
            <div class="card-header">
                <h5><?php echo e($recentBoxesAtr['box1_title']); ?></h5>
            </div>
            <div class="card-block">
                <?php if(count($nwsRcntList) > 0): ?>
                <?php $__currentLoopData = $nwsRcntList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row m-b-20">
                    <div class="col">
                        <h5 class="m-b-10">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.news.edit', $record->n_id)).'','title' => ''.e($moduleAtrArr['edit_txt']).'','target' => ''.e($moduleAtrArr['target']).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.news.edit', $record->n_id)).'','title' => ''.e($moduleAtrArr['edit_txt']).'','target' => ''.e($moduleAtrArr['target']).'']); ?><?php echo e($record->title); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </h5>
                        <p class="m-b-0 gray-col">
                            <?php echo e($moduleAtrArr['added_date_txt'] .' : ' .date($moduleAtrArr['mdfy_dt_frmt'], strtotime($record->created_at))); ?>

                        </p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="text-right">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('admin.news.index')).'','target' => ''.e($moduleAtrArr['target']).'','class' => 'b-b-primary text-primary']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.news.index')).'','target' => ''.e($moduleAtrArr['target']).'','class' => 'b-b-primary text-primary']); ?>
                        <?php echo e($moduleAtrArr['see_all']); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <?php else: ?>
                <?php echo e($moduleAtrArr['data_not_available']); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 p-r-0">
        <div class="card feed-card">
            <div class="card-header">
                <h5><?php echo e($recentBoxesAtr['box2_title']); ?></h5>
            </div>
            <div class="card-block">
                <?php if(count($aeqRcntList) > 0): ?>
                <?php $__currentLoopData = $aeqRcntList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row m-b-20">
                    <div class="col">
                        <h5 class="m-b-10">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.question.edit', $record->aeq_id)).'','title' => ''.e($moduleAtrArr['edit_txt']).'','target' => ''.e($moduleAtrArr['target']).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.question.edit', $record->aeq_id)).'','title' => ''.e($moduleAtrArr['edit_txt']).'','target' => ''.e($moduleAtrArr['target']).'']); ?><?php echo \App\Lib\Core\Useful::getShortContent( strip_tags($record->question), 70); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </h5>
                        <p class="m-b-0 gray-col">
                            <?php echo e($moduleAtrArr['added_date_txt'] .' : ' .date($moduleAtrArr['mdfy_dt_frmt'], strtotime($record->created_at))); ?>

                        </p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="text-right">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($totalBoxes[1]['url']).'','target' => ''.e($moduleAtrArr['target']).'','class' => 'b-b-primary text-primary']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($totalBoxes[1]['url']).'','target' => ''.e($moduleAtrArr['target']).'','class' => 'b-b-primary text-primary']); ?>
                        <?php echo e($moduleAtrArr['see_all']); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <?php else: ?>
                <?php echo e($moduleAtrArr['data_not_available']); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card feed-card">
            <div class="card-header">
                <h5><?php echo e($recentBoxesAtr['box3_title']); ?></h5>
            </div>
            <div class="card-block">
                <?php if(count($suRcntList) > 0): ?>
                <?php $__currentLoopData = $suRcntList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row m-b-20">
                    <div class="col">
                        <h5 class="m-b-10">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.subscribeduser.edit', $record->u_id)).'','title' => ''.e($moduleAtrArr['edit_txt']).'','target' => ''.e($moduleAtrArr['target']).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.subscribeduser.edit', $record->u_id)).'','title' => ''.e($moduleAtrArr['edit_txt']).'','target' => ''.e($moduleAtrArr['target']).'']); ?><?php echo e($record->fullname); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </h5>
                        <p class="m-b-0 gray-col">
                            <?php echo e($moduleAtrArr['added_date_txt'] .' : ' .date($moduleAtrArr['mdfy_dt_frmt'], strtotime($record->created_at))); ?>

                        </p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="text-right">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($totalBoxes[2]['url']).'','target' => ''.e($moduleAtrArr['target']).'','class' => 'b-b-primary text-primary']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($totalBoxes[2]['url']).'','target' => ''.e($moduleAtrArr['target']).'','class' => 'b-b-primary text-primary']); ?>
                        <?php echo e($moduleAtrArr['see_all']); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <?php else: ?>
                <?php echo e($moduleAtrArr['data_not_available']); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/themes/backend/pages/dashboard.blade.php ENDPATH**/ ?>