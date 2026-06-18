<?php $__env->startSection('datetimeRangePicker'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('scrips.index')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5><?php echo e(__('admin.scrip.all_txt')); ?></h5>
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
            <?php if($roleRights['add']): ?>
            <!-- Add New -->
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_add_new','data' => ['url' => ''.e(route('admin.scrips.create')).'']]); ?>
<?php $component->withName('link_add_new'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.scrips.create')).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.btn_multi_delete','data' => []]); ?>
<?php $component->withName('form.btn_multi_delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
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
          <form id="filterForm" name="filterForm" method="get" action="<?php echo e(route('admin.scrips.index')); ?>">
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

                        <select name="sby" id="sby" aria-controls="example" class="form-control" onchange="filter();">
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

                        <select name="oby" id="oby" aria-controls="example" class="form-control" onchange="filter();">
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
        <form id="listDataForm" name="listDataForm" method="post" action="<?php echo e(route('admin.scrips.delete')); ?>">
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
                  <th><?php echo e($sortbyArr['scrip_name']); ?></th>
                  <th class="cc-w-125"><?php echo e($sortbyArr['type']); ?></th>
                  <th class="cc-w-125"><?php echo e($sortbyArr['industry']); ?></th>
                  <th><?php echo e($sortbyArr['actual_scrip']); ?></th>
                  <th class="cc-w-150"><?php echo e($sortbyArr['updated_at']); ?></th>
                  <th class="cc-w-95 no-sort"><?php echo e(__('admin.mdfy_by_txt')); ?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php if($roleRights['delete']): ?>
                  <td></td>
                  <?php endif; ?>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fsn','name' => 'fsn','value' => ''.e($fltrDataArr['scrip_name'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fsn','name' => 'fsn','value' => ''.e($fltrDataArr['scrip_name'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fte','name' => 'fte','value' => ''.e($fltrDataArr['type'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fte','name' => 'fte','value' => ''.e($fltrDataArr['type'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fiy','name' => 'fiy','value' => ''.e($fltrDataArr['industry'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fiy','name' => 'fiy','value' => ''.e($fltrDataArr['industry'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fas','name' => 'fas','value' => ''.e($fltrDataArr['actual_scrip'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fas','name' => 'fas','value' => ''.e($fltrDataArr['actual_scrip'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
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
                </tr>
                <?php if( count($dataListModel) > 0 ): ?>
                <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row" class="">
                  <?php if($roleRights['delete']): ?>
                  <td class="sorting_{{$key}">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->scrp_id).'','fldclass' => 'del-chkbx']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->scrp_id).'','fldclass' => 'del-chkbx']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.scrips.edit', $record->scrp_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.scrips.edit', $record->scrp_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'']); ?>
                      <?php echo e($record->scrip_name); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php else: ?>
                    <?php echo e($record->scrip_name); ?>

                    <?php endif; ?>
                  </td>
                  <td><?php echo e($record->type); ?></td>
                  <td><?php echo e($record->industry); ?></td>
                  <td><?php echo e($record->actual_scrip); ?></td>
                  <td><?php echo e(date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at))); ?></td>
                  <td><?php echo e($record->updatedby->display_name ?? $listDataAtrArr['unknown_txt']); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <tr>
                  <td colspan="8"><?php echo e(__('message.data_not_available')); ?></td>
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
    var ftrFsnVlu = document.getElementById("fsn").value;
    if (ftrFsnVlu != "") {
      searchPagiData = searchPagiData + "&fsn=" + ftrFsnVlu.replace("&", "_");
    }
    var ftrFteVlu = document.getElementById("fte").value;
    if (ftrFteVlu != "") {
      searchPagiData = searchPagiData + "&fte=" + ftrFteVlu;
    }
    var ftrFiyVlu = document.getElementById("fiy").value;
    if (ftrFiyVlu != "") {
      searchPagiData = searchPagiData + "&fiy=" + ftrFiyVlu;
    }
    var ftrFasVlu = document.getElementById("fas").value;
    if (ftrFasVlu != "") {
      searchPagiData = searchPagiData + "&fas=" + ftrFasVlu.replace("&", "_");
    }
    var ftrFmdVlu = document.getElementById("fmd").value;
    if (ftrFmdVlu != "") {
      searchPagiData = searchPagiData + "&fmd=" + ftrFmdVlu;
    }
    var ftrSbyVlu = document.getElementById("sby").value;
    if (ftrSbyVlu != "") {
      searchPagiData = searchPagiData + "&sby=" + ftrSbyVlu;
    }
    var ftrObyVlu = document.getElementById("oby").value;
    if (ftrObyVlu != "") {
      searchPagiData = searchPagiData + "&oby=" + ftrObyVlu;
    }
    /*alert(searchPagiData);*/
    window.location.href = "<?php echo e(route('admin.scrips.index')); ?>" + "?page=0" + searchPagiData + "&ppage=" + "<?php echo e($perPage); ?>";
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "<?php echo e(route('admin.scrips.index')); ?>";
  }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/scrip/index.blade.php ENDPATH**/ ?>