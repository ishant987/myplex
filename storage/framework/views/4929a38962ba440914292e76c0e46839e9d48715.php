<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>Calculator Logins</h5>
        <div class="c-f-btns">
          <div class="c-f-b-f">
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
        </div>
      </div>
      <div class="card-block">
        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
          <form id="filterForm" name="filterForm" method="get" action="<?php echo e(route('admin.calculatorlogin.list')); ?>">
            <div class="row align-items-center">
              <div class="col-md-3">
                <div class="sw-entry">
                  <label>
                    <?php echo e(__('admin.sw_entry.show_txt')); ?>

                    <select name="ppage" aria-controls="example" class="form-control" onchange="form.submit();">
                      <?php $__currentLoopData = $showEntryArr['value']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($option); ?>" <?php echo e((string) $option === (string) $perPage ? 'selected' : ''); ?>><?php echo e($showEntryArr['text'][$key]); ?></option>
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
                          <?php $__currentLoopData = $availableSorts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($key); ?>" <?php echo e($sortBy === $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
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
                          <?php $__currentLoopData = $orderbyArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($key); ?>" <?php echo e(strtolower($orderBy) === $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
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

        <div class="table-responsive dt-responsive">
          <table class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <?php if(in_array('id', $columns, true)): ?>
                <th>ID</th>
                <?php endif; ?>
                <?php if(in_array('username', $columns, true)): ?>
                <th>Username</th>
                <?php endif; ?>
                <?php if(in_array('email', $columns, true)): ?>
                <th>Email</th>
                <?php endif; ?>
                <?php if(in_array('platform', $columns, true)): ?>
                <th>Platform</th>
                <?php endif; ?>
                <?php if(in_array('created_at', $columns, true)): ?>
                <th class="cc-w-150">Created At</th>
                <?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php if(in_array('id', $columns, true)): ?>
                <td></td>
                <?php endif; ?>
                <?php if(in_array('username', $columns, true)): ?>
                <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fun','name' => 'fun','value' => ''.e($fltrDataArr['username']).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fun','name' => 'fun','value' => ''.e($fltrDataArr['username']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                <?php endif; ?>
                <?php if(in_array('email', $columns, true)): ?>
                <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fel','name' => 'fel','value' => ''.e($fltrDataArr['email']).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fel','name' => 'fel','value' => ''.e($fltrDataArr['email']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                <?php endif; ?>
                <?php if(in_array('platform', $columns, true)): ?>
                <td>
                  <select id="fpl" name="fpl" class="form-control" onchange="filter();">
                    <?php $__currentLoopData = $platformOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>" <?php echo e((string) $fltrDataArr['platform'] === (string) $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </td>
                <?php endif; ?>
                <?php if(in_array('created_at', $columns, true)): ?>
                <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fad','name' => 'fad','value' => ''.e($fltrDataArr['created_at']).'','class' => 'period']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fad','name' => 'fad','value' => ''.e($fltrDataArr['created_at']).'','class' => 'period']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                <?php endif; ?>
              </tr>

              <?php if(!empty($columns) && count($dataListModel) > 0): ?>
              <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <?php if(in_array('id', $columns, true)): ?>
                <td><?php echo e($record->id); ?></td>
                <?php endif; ?>
                <?php if(in_array('username', $columns, true)): ?>
                <td><?php echo e($record->username ?? $listDataAtrArr['na_txt']); ?></td>
                <?php endif; ?>
                <?php if(in_array('email', $columns, true)): ?>
                <td><?php echo e($record->email ?? $listDataAtrArr['na_txt']); ?></td>
                <?php endif; ?>
                <?php if(in_array('platform', $columns, true)): ?>
                <td>
                  <?php if((string) ($record->platform ?? '') === '1'): ?>
                  Google
                  <?php elseif((string) ($record->platform ?? '') === '2'): ?>
                  Facebook
                  <?php else: ?>
                  <?php echo e($listDataAtrArr['na_txt']); ?>

                  <?php endif; ?>
                </td>
                <?php endif; ?>
                <?php if(in_array('created_at', $columns, true)): ?>
                <td><?php echo e($record->created_at ? date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->created_at)) : $listDataAtrArr['na_txt']); ?></td>
                <?php endif; ?>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>
              <tr>
                <td colspan="<?php echo e(max(count($columns), 1)); ?>"><?php echo e(empty($columns) ? 'Calculator login table is not available.' : __('message.data_not_available')); ?></td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <?php if(!empty($columns) && method_exists($dataListModel, 'appends')): ?>
        <?php echo e($dataListModel->appends($data)->links('vendor.pagination.app-admin')); ?>

        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  function filter() {
    var searchPagiData = "";
    var ftrFunVlu = document.getElementById("fun");
    if (ftrFunVlu && ftrFunVlu.value !== "") {
      searchPagiData = searchPagiData + "&fun=" + ftrFunVlu.value;
    }
    var ftrFelVlu = document.getElementById("fel");
    if (ftrFelVlu && ftrFelVlu.value !== "") {
      searchPagiData = searchPagiData + "&fel=" + ftrFelVlu.value;
    }
    var ftrFplVlu = document.getElementById("fpl");
    if (ftrFplVlu && ftrFplVlu.value !== "") {
      searchPagiData = searchPagiData + "&fpl=" + ftrFplVlu.value;
    }
    var ftrFadVlu = document.getElementById("fad");
    if (ftrFadVlu && ftrFadVlu.value !== "") {
      searchPagiData = searchPagiData + "&fad=" + ftrFadVlu.value;
    }
    var ftrSbyVlu = document.getElementById("sby");
    if (ftrSbyVlu && ftrSbyVlu.value !== "") {
      searchPagiData = searchPagiData + "&sby=" + ftrSbyVlu.value;
    }
    var ftrObyVlu = document.getElementById("oby");
    if (ftrObyVlu && ftrObyVlu.value !== "") {
      searchPagiData = searchPagiData + "&oby=" + ftrObyVlu.value;
    }

    window.location.href = "<?php echo e(route('admin.calculatorlogin.list')); ?>" + "?page=0" + searchPagiData + "&ppage=" + "<?php echo e($perPage); ?>";
    return false;
  }

  function resetfilter() {
    window.location.href = "<?php echo e(route('admin.calculatorlogin.list')); ?>";
  }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/calculatorlogin/index.blade.php ENDPATH**/ ?>