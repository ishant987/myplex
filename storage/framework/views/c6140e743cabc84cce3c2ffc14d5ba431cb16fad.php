<?php $__env->startSection('dataTables'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('datetimeRangePicker'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('select2'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('missingindices.index')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5><?php echo e(__('admin.indices.missing.label_txt')); ?></h5>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_add_new','data' => ['url' => ''.e(route('admin.missing-indices.create')).'','target' => '_blank']]); ?>
<?php $component->withName('link_add_new'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.missing-indices.create')).'','target' => '_blank']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if( count( $dataListModel ) > 0 ): ?>
            <!-- Export -->
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.route('admin.missing-indices.export',$exportDataArr).'','class' => 'btn waves-effect waves-light btn-sm f-right btn-success','title' => ''.e(__('admin.export_txt')).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.route('admin.missing-indices.export',$exportDataArr).'','class' => 'btn waves-effect waves-light btn-sm f-right btn-success','title' => ''.e(__('admin.export_txt')).'']); ?>
              <i class="fa fa-file-excel-o"></i>
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
        <form id="listDataForm" name="listDataForm" method="post" action="<?php echo e(route('admin.missing-indices.index')); ?>">
          <?php echo e(csrf_field()); ?>


          <div class="row">
            <div class="col-sm-3">
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_3_7_2','data' => ['label' => ''.e(__('admin.period_txt')).'','for' => 'fmd','error' => ''.e($errors->first('fmd')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt1_3_7_2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.period_txt')).'','for' => 'fmd','error' => ''.e($errors->first('fmd')).'','required' => 'true']); ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fmd','name' => 'fmd','value' => ''.e($fltrDataArr['missing_date'] ?? '').'','class' => 'period-saved']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fmd','name' => 'fmd','value' => ''.e($fltrDataArr['missing_date'] ?? '').'','class' => 'period-saved']); ?>
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
            </div>
            <div class="col-sm-5">
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_3_7_2','data' => ['label' => ''.e(__('admin.indices.label_txt')).'','for' => 'fic','error' => ''.e($errors->first('fic')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt1_3_7_2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.indices.label_txt')).'','for' => 'fic','error' => ''.e($errors->first('fic')).'','required' => 'true']); ?>
                <select name="fic" id="fic" class="form-control js-example-basic-single">
                  <option value=""><?php echo e(__('admin.def_drop_optn_styl2_txt')); ?></option>
                  <?php $__currentLoopData = $indicesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($value->corelation); ?>" <?php if( $value->corelation==old('fic') ): ?> <?php echo e('selected'); ?> <?php elseif( $value->corelation==$fltrDataArr['indices'] ): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($value->name); ?>

                  </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
          </div>

          <div class="table-responsive dt-responsive">
            <table id="dom-jqry" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th class="cc-w-150"><?php echo e(__('admin.missing_date_txt')); ?></th>
                  <th><?php echo e(__('admin.indices.name_txt')); ?></th>
                  <th><?php echo e(__('admin.indices.corelation_txt')); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if( count($dataListModel) > 0 ): ?>
                <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row">
                  <td><?php echo e($record->missing_date); ?></td>
                  <td><?php echo e($indicesName); ?></td>
                  <td><?php echo e($record->indices); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <tr>
                  <td colspan="3">
                    <?php if(isset($defMsg)): ?>
                    <?php echo e($defMsg); ?>

                    <?php else: ?>
                    <?php echo e(__('message.data_not_available')); ?>

                    <?php endif; ?>
                  </td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
  $(function() {
    // Period(Start and End Date)
    $('.period-saved').daterangepicker({
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD'
      },
      /*startDate: "",*/
      maxDate: "<?php echo e($lastSavedDate); ?>"
    });
    $('.period-saved').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('.period-saved').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });
  });
  /*Filter*/
  function filter() {
    var searchPagiData = "";
    var ftrFicVlu = document.getElementById("fic").value;
    if (ftrFicVlu != "") {
      searchPagiData = searchPagiData + "&fic=" + ftrFicVlu;
    }
    var ftrFmdVlu = document.getElementById("fmd").value;
    if (ftrFmdVlu != "") {
      searchPagiData = searchPagiData + "&fmd=" + ftrFmdVlu;
    }
    /*alert(searchPagiData);*/
    window.location.href = "<?php echo e(route('admin.missing-indices.index')); ?>" + "?type=filter" + searchPagiData;
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "<?php echo e(route('admin.missing-indices.index')); ?>";
  }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/indices/missing-list.blade.php ENDPATH**/ ?>