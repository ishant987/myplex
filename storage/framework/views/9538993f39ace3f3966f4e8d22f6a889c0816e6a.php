<?php $__env->startSection('datetimeRangePicker'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('media.index')); ?> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5><?php echo e(__('media.all_txt')); ?></h5>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_add_new','data' => ['url' => ''.e(route('admin.media.create')).'']]); ?>
<?php $component->withName('link_add_new'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.media.create')).'']); ?>
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
        <form id="filterForm" name="filterForm" method="get" action="<?php echo e(route('admin.media.index')); ?>">
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
       <form id="listDataForm" name="listDataForm" method="post" action="<?php echo e(route('admin.deletemedia')); ?>">
        <?php echo e(csrf_field()); ?>

        <div class="table-responsive dt-responsive">
          <table class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <?php if($roleRights['delete']): ?>
                  <?php if( count( $dataListModel ) > 0 ): ?>
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
                <?php endif; ?>
                <th class="cc-w-150"><?php echo e(__('media.media_file_txt')); ?></th>
                <th><?php echo e($sortbyArr['title']); ?></th>
                <th><?php echo e($sortbyArr['alt']); ?></th>
                <th class="cc-w-150"><?php echo e($sortbyArr['updated_at']); ?></th>
                <th><?php echo e(__('admin.mdfy_by_txt')); ?></th>
                <?php if($roleRights['edit']): ?>
                  <th class="cc-w-35"><?php echo e(__('admin.action_txt')); ?></th>
                <?php endif; ?>
              </tr>
            </thead>
            <tbody>
            <tr>
                <?php if($roleRights['delete']): ?>
                  <?php if( count( $dataListModel ) > 0 ): ?>
                    <td></td>
                  <?php endif; ?>
                <?php endif; ?>
                  <td></td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'ftl','name' => 'ftl','value' => ''.e($fltrDataArr['title'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'ftl','name' => 'ftl','value' => ''.e($fltrDataArr['title'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fat','name' => 'fat','value' => ''.e($fltrDataArr['alt'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fat','name' => 'fat','value' => ''.e($fltrDataArr['alt'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fud','name' => 'fud','value' => ''.e($fltrDataArr['updated_at'] ?? '').'','class' => 'period']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fud','name' => 'fud','value' => ''.e($fltrDataArr['updated_at'] ?? '').'','class' => 'period']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fuu','name' => 'fuu','value' => ''.e($fltrDataArr['updated_by_name'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fuu','name' => 'fuu','value' => ''.e($fltrDataArr['updated_by_name'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <?php if($roleRights['edit']): ?>
                    <td></td>
                  <?php endif; ?>
                </tr>    
              <?php if( count($dataListModel) > 0 ): ?>       
              <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr role="row" class="">
                <?php if($roleRights['delete']): ?>
                  <td class="sorting_<?php echo e($record->media_id); ?>">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->media_id).'','fldclass' => 'del-chkbx']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->media_id).'','fldclass' => 'del-chkbx']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                <?php endif; ?>
              <td>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.$moduleAtrArr['media_folder'].$record->path.'','title' => ''.e($moduleAtrArr['view_txt']).'','target' => ''.e($moduleAtrArr['target']).'','placement' => 'right']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.$moduleAtrArr['media_folder'].$record->path.'','title' => ''.e($moduleAtrArr['view_txt']).'','target' => ''.e($moduleAtrArr['target']).'','placement' => 'right']); ?>
                  <?php if('displayimage' == \App\Lib\Core\Core::getFaIconByMimeType($record->mime_type)): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.$moduleAtrArr['media_folder'].$record->path.'','width' => ''.e($moduleAtrArr['img_width']['big']).'','class' => 'img-fluid img-thumbnail cc-w-150']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.$moduleAtrArr['media_folder'].$record->path.'','width' => ''.e($moduleAtrArr['img_width']['big']).'','class' => 'img-fluid img-thumbnail cc-w-150']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  <?php else: ?>                    
                      <i class="fa <?php echo e(\App\Lib\Core\Core::getFaIconByMimeType($record->mime_type)); ?> fa-5x" aria-hidden="true"></i>
                  <?php endif; ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
              </td>
              <td><?php echo $record->title; ?></td>
              <td><?php echo $record->alt; ?></td>
              <td><?php echo e(date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at))); ?></td>
              <td><?php echo e($record->updatedby->display_name ?? $listDataAtrArr['unknown_txt']); ?></td>
                <?php if($roleRights['edit']): ?>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.media.edit', $record->media_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'','class' => 'f-20','placement' => 'left']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.media.edit', $record->media_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'','class' => 'f-20','placement' => 'left']); ?>
                      <i class="fa fa-edit"></i>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td> 
                <?php endif; ?>
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
               <?php else: ?>
                <tr><td colspan="6"><?php echo e(__('message.data_not_available')); ?></td></tr>
                <?php endif; ?>            
             </tbody>
           </table>
         </div>
       </form>
       <?php echo e($dataListModel->links('vendor.pagination.app-admin')); ?>

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
    var ftrFtlVlu = document.getElementById("ftl").value;
    if (ftrFtlVlu != "") {
      searchPagiData = searchPagiData + "&ftl=" + ftrFtlVlu;
    }
    var ftrFatVlu = document.getElementById("fat").value;
    if (ftrFatVlu != "") {
      searchPagiData = searchPagiData + "&fat=" + ftrFatVlu;
    }
    var ftrFudVlu = document.getElementById("fud").value;
    if (ftrFudVlu != "") {
      searchPagiData = searchPagiData + "&fud=" + ftrFudVlu;
    }
    var ftrFuuVlu = document.getElementById("fuu").value;
    if (ftrFuuVlu != "") {
      searchPagiData = searchPagiData + "&fuu=" + ftrFuuVlu;
    }
    /*alert(searchPagiData);*/
    window.location.href = "<?php echo e(route('admin.media.index')); ?>"+"?page=0"+searchPagiData+"&ppage="+"<?php echo e($perPage); ?>";
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "<?php echo e(route('admin.media.index')); ?>";
  }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/media/index.blade.php ENDPATH**/ ?>