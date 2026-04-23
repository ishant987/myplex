<?php $__env->startSection('datetimeRangePicker'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('fund.index')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5><?php echo e(__('admin.fund.all_txt')); ?></h5>
        <div class="c-f-btns">
          <div class="c-f-b-f">
            <!-- Filter -->
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.btn_filter','data' => []]); ?>
<?php $component->withName('form.btn_filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <!-- Reset -->
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.btn_reset','data' => []]); ?>
<?php $component->withName('form.btn_reset'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
          </div>
          <div class="c-f-b-r">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('admin.fund.nocor')).'','class' => 'b-b-primary text-primary sctn-link-right']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.fund.nocor')).'','class' => 'b-b-primary text-primary sctn-link-right']); ?>
              <?php echo e(__('admin.fund.nocor.label_txt')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php if($roleRights['add']): ?>
            <!-- Add New -->
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_add_new','data' => ['url' => ''.e(route('admin.fund.create')).'']]); ?>
<?php $component->withName('link_add_new'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.fund.create')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php if($roleRights['delete']): ?>
            <?php if( count( $dataListModel ) > 0 ): ?>
            &nbsp;
            <!-- Multi Delete -->
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.btn_multi_delete','data' => ['message' => ''.e(__('message.confirm.del_related_data_too')).'']]); ?>
<?php $component->withName('form.btn_multi_delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['message' => ''.e(__('message.confirm.del_related_data_too')).'']); ?>
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
      <div class="card-block">
        <!-- Show message. -->
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
        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
          <form id="filterForm" name="filterForm" method="get" action="<?php echo e(route('admin.fund.index')); ?>">
            <div class="row align-items-center">
              <div class="col-md-3">
                <div class="sw-entry">
                  <label>
                    <?php echo e(__('admin.sw_entry.show_txt')); ?>

                    <select name="ppage" aria-controls="example" class="form-control" onchange="form.submit();">
                      <?php $__currentLoopData = $showEntryArr['value']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($option); ?>" <?php echo e($option == $perPage ? 'selected' : ''); ?>><?php echo e($showEntryArr['text'][$key]); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php echo e(__('admin.sw_entry.entries_txt')); ?>

                  </label>
                </div>
              </div>
              <div class="col-md-9">
                <div class="row f-right">
                  <div class="col-md-6">
                    <div class="sort-by">
                      <label>
                        <?php echo e(__('admin.sort_txt')); ?>

                        <select name="sby" aria-controls="example" class="form-control" onchange="form.submit();">
                          <?php $__currentLoopData = $sortbyArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sort): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($key); ?>" <?php echo e($sortBy==$key?'selected':''); ?>><?php echo e($sort); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="order-by">
                      <label>
                        <?php echo e(__('admin.order_by_txt')); ?>

                        <select name="oby" aria-controls="example" class="form-control" onchange="form.submit();">
                          <?php $__currentLoopData = $orderbyArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderby): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($key); ?>" <?php echo e(strtolower($orderBy) == $key ? 'selected' : ''); ?>><?php echo e($orderby); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <form id="listDataForm" name="listDataForm" method="post" action="<?php echo e(route('admin.fund.delete')); ?>">
          <?php echo e(csrf_field()); ?>

          <div class="table-responsive dt-responsive">
            <table class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <?php if($roleRights['delete']): ?>
                  <th class="cc-w-35">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'check_all','id' => 'check_all']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'check_all','id' => 'check_all']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </th>
                  <?php endif; ?>
                  <th><?php echo e($sortbyArr['fund_name']); ?></th>
                  <th class="cc-w-95"><?php echo e($sortbyArr['fund_code']); ?></th>
                  <th><?php echo e($sortbyArr['fund_type_id']); ?></th>
                  <th class="cc-w-150"><?php echo e($sortbyArr['fund_term_id']); ?></th>
                  <th class="cc-w-70"><?php echo e($sortbyArr['fund_opened']); ?></th>
                  <th class="cc-w-60 no-sort"><?php echo e(__('admin.status_txt')); ?></th>
                  <th class="cc-w-150"><?php echo e(__('admin.mdfy_date_txt')); ?></th>
                  <th class="cc-w-95 no-sort"><?php echo e(__('admin.mdfy_by_txt')); ?></th>
                  <th class="cc-w-35"><?php echo e(__('admin.action_txt')); ?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php if($roleRights['delete']): ?>
                  <td></td>
                  <?php endif; ?>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'ffn','name' => 'ffn','value' => ''.e($fltrDataArr['fund_name'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'ffn','name' => 'ffn','value' => ''.e($fltrDataArr['fund_name'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'ffc','name' => 'ffc','value' => ''.e($fltrDataArr['fund_code'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'ffc','name' => 'ffc','value' => ''.e($fltrDataArr['fund_code'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <td>
                    <select name="fft" id="fft" aria-controls="example" class="form-control">
                      <option value=""><?php echo e($cFilterArr['all_txt']); ?></option>
                      <?php $__currentLoopData = $moduleAtrArr['fund_type_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $fType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($fType->ft_id); ?>" <?php if( $fType->ft_id==old('fft') ): ?> <?php echo e('selected'); ?> <?php elseif( $fType->ft_id==$fltrDataArr['fund_type_id'] ): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($fType->name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </td>
                  <td>
                    <select name="fftm" id="fftm" aria-controls="example" class="form-control">
                      <option value=""><?php echo e($cFilterArr['all_txt']); ?></option>
                      <?php $__currentLoopData = $moduleAtrArr['fund_term_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $fTerm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($fTerm->ftm_id); ?>" <?php if( $fTerm->ftm_id==old('fftm') ): ?> <?php echo e('selected'); ?> <?php elseif( $fTerm->ftm_id==$fltrDataArr['fund_term_id'] ): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($fTerm->term); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'ffo','name' => 'ffo','value' => ''.e($fltrDataArr['fund_opened'] ?? '').'','class' => 'period']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'ffo','name' => 'ffo','value' => ''.e($fltrDataArr['fund_opened'] ?? '').'','class' => 'period']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <td>
                    <select name="fsts" id="fsts" aria-controls="example" class="form-control">
                      <option value=""><?php echo e($cFilterArr['all_txt']); ?></option>
                      <?php $__currentLoopData = $moduleAtrArr['status_list']['label']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $statusFtxt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($key); ?>" <?php if( $key==old('fsts') ): ?> <?php echo e('selected'); ?> <?php elseif( $key==$fltrDataArr['status'] ): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($statusFtxt); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fmd','name' => 'fmd','value' => ''.e($fltrDataArr['updated_at'] ?? '').'','class' => 'period']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fmd','name' => 'fmd','value' => ''.e($fltrDataArr['updated_at'] ?? '').'','class' => 'period']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <?php if( count($dataListModel) > 0 ): ?>
                <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row" class="">
                  <?php if($roleRights['delete']): ?>
                  <td class="sorting_{{$key}">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->fund_id).'','fldclass' => 'del-chkbx']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->fund_id).'','fldclass' => 'del-chkbx']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <?php endif; ?>
                  <td>
                    <?php if($roleRights['edit']): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.fund.edit', $record->fund_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.fund.edit', $record->fund_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'']); ?>
                      <?php echo e($record->fund_name); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php else: ?>
                    <?php echo e($record->fund_name); ?>

                    <?php endif; ?>
                  </td>
                  <td><?php echo e($record->fund_code); ?></td>
                  <td><?php if( $record->fundtype != null ): ?><?php echo e($record->fundtype->name); ?><?php endif; ?></td>
                  <td><?php if( $record->fundterm != null ): ?><?php echo e($record->fundterm->term); ?><?php endif; ?></td>
                  <td><?php echo e($record->fund_opened); ?></td>
                  <td>
                    <?php if($roleRights['edit']): ?>
                    <label id="change_status<?php echo e($record->fund_id); ?>" onclick="return changeStatus('fund_id', <?php echo e($record->fund_id); ?>, 'fund_master', <?php echo e($record->status); ?>, '<?php echo e($moduleAtrArr['status_list']['status_type']); ?>');" class="label btn-<?php echo e($listDataAtrArr['alert_css'][$record->status]); ?>"><?php echo e($moduleAtrArr['status_list']['label'][$record->status]); ?></label>
                    <?php else: ?>
                    <label class="label btn-<?php echo e($listDataAtrArr['alert_css'][$record->status]); ?> no-drop"><?php echo e($moduleAtrArr['status_list']['label'][$record->status]); ?></label>
                    <?php endif; ?>
                  </td>
                  <td><?php echo e(date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at))); ?></td>
                  <td><?php echo e($record->updatedby->display_name ?? $listDataAtrArr['unknown_txt']); ?></td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('admin.fund.corpus.edit', $record->fund_id)).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.fund.corpus.edit', $record->fund_id)).'']); ?>
                      <label class="label label-info hand"><?php echo e(__('admin.fund.corpus_txt')); ?></label>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <tr>
                  <td colspan="10"><?php echo e(__('message.data_not_available')); ?></td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </form>
        <?php echo e($dataListModel->appends($data)->links('vendor.pagination.app-admin')); ?>

      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
  /*Filter*/
  function filter() {
    var searchPagiData = "";
    var ftrFfnVlu = document.getElementById("ffn").value;
    if (ftrFfnVlu != "") {
      searchPagiData = searchPagiData + "&ffn=" + ftrFfnVlu;
    }
    var ftrFfcVlu = document.getElementById("ffc").value;
    if (ftrFfcVlu != "") {
      searchPagiData = searchPagiData + "&ffc=" + ftrFfcVlu;
    }
    var ftrFftVlu = document.getElementById("fft").value;
    if (ftrFftVlu != "") {
      searchPagiData = searchPagiData + "&fft=" + ftrFftVlu;
    }
    var ftrFftmVlu = document.getElementById("fftm").value;
    if (ftrFftmVlu != "") {
      searchPagiData = searchPagiData + "&fftm=" + ftrFftmVlu;
    }
    var ftrFfoVlu = document.getElementById("ffo").value;
    if (ftrFfoVlu != "") {
      searchPagiData = searchPagiData + "&ffo=" + ftrFfoVlu;
    }
    var ftrFstsVlu = document.getElementById("fsts").value;
    if (ftrFstsVlu != "") {
      searchPagiData = searchPagiData + "&fsts=" + ftrFstsVlu;
    }
    var ftrFmdVlu = document.getElementById("fmd").value;
    if (ftrFmdVlu != "") {
      searchPagiData = searchPagiData + "&fmd=" + ftrFmdVlu;
    }
    /*alert(searchPagiData);*/
    window.location.href = "<?php echo e(route('admin.fund.index')); ?>" + "?page=0" + searchPagiData + "&ppage=" + "<?php echo e($perPage); ?>";
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "<?php echo e(route('admin.fund.index')); ?>";
  }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/fund/index.blade.php ENDPATH**/ ?>