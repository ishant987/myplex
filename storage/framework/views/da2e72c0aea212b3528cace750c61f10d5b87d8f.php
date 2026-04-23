<?php $__env->startSection('preloader'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?> 
<link href="<?php echo e(asset('themes/backend/files/assets/pages/jquery.filer/css/jquery.filer.css')); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo e(asset('themes/backend/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')); ?>" type="text/css" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
  <div class="card">
        <div class="card-header">
            <h5>Set Featured Media</h5>
        </div>
        <div class="card-block">
            <!-- Row start -->
            <div class="row">
                <div class="col-lg-12 col-xl-6">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tabs" role="tablist">
                      <?php if($roleRights['add']): ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab1" role="tab" aria-selected="false">Upload Files</a>
                        </li>
                      <?php endif; ?>
                      <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#tab2" role="tab" aria-selected="false">Media Library</a>
                      </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs card-block p-l-0 p-r-0">
                        <div class="tab-pane" id="tab1" role="tabpanel">
                           <form name="mdaForm" id="mdaForm" action="<?php echo e(route('admin.media.ajaxupload')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo e(csrf_field()); ?>

                               <input type="file" name="files[]"  id="filer_input1" multiple="multiple">
                               <div class="col-form-label info">
                                  <ul>
                                     <li><i class="fa fa-info"></i> Upload only JPEG, PNG, GIF, PDF, DOC, XLS and PPT files.</li>
                                     <li><i class="fa fa-info"></i> Only 10 files are allowed to be uploaded at a time.</li>
                                     <li><i class="fa fa-info"></i> Max File uploads limit 30 MB.</li>
                                  </ul>
                               </div>
                            </form>
                        </div>
                        <div class="tab-pane active" id="tab2" role="tabpanel">
                            <div id="dataWithPagin" class="media-list-data">
                               <div class="searchWrap">
                                <form id="filterForm" name="filterForm" method="get" action="<?php echo e(route('admin.media.gallery',$typeid)); ?>">
                                    <div class="form-group has-primary row  ">
                                       <label for="title" class="col-sm-2 col-form-label">
                                        Search </label>
                                       <div class="col-sm-6">
                                            <input class="form-control" id="searchmedia" name="searchKey" value="<?php echo e($searchKey); ?>" type="text"> 
                                        </div>
                                        <div class="col-sm-4">                                  
                                           <div class="c-f-b-f">
                                            <!-- Filter -->
                                             <button id="tp_fltr_btn" class="btn waves-effect waves-light btn-sm btn-c-p btn-info" type="submit" name="tp_fltr_btn" data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="Filter" onclick="return filter();">Filter</button>  
                                            <!-- Reset -->
                                             <a href="<?php echo e($dataListModel->path()); ?>" id="tp_rst_btn" class="btn waves-effect waves-light btn-sm btn-c-p btn-warning" type="submit" name="tp_rst_btn" data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="Reset">Reset</a>
                                          </div>                                      
                                        </div>
                                    </div>
                                </form>
                               </div> 
                              <div class="media_pop_feat_list" id="media_pop_feat_list">
                                 <div class="media_img">
                                    <?php if( count($dataListModel) > 0 ): ?>
                                    <ul class="attachments ui-sortable ui-sortable-disabled flexItem">
                                      <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li onclick="setMediaAtrbts('<?php echo e($record->media_id); ?>','<?php echo e(route('admin.media.info',$record->media_id)); ?>');" tabindex="<?php echo e($key); ?>" role="checkbox" aria-label="wysiwyg" id="media_<?php echo e($record->media_id); ?>" aria-checked="true" class="attachment save-ready">
                                          <div class="attachment-preview type-image subtype-jpeg landscape">
                                             <div class="thumbnail">
                                                <div class="centered">
                                                    <?php if( in_array($record->mime_type, $imagesTypeAry)): ?>
                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.$moduleAtrArr['media_folder'].$record->path.'','width' => ''.e($moduleAtrArr['img_width']['small']).'','class' => 'img-thumbnail']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.$moduleAtrArr['media_folder'].$record->path.'','width' => ''.e($moduleAtrArr['img_width']['small']).'','class' => 'img-thumbnail']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                    <?php else: ?>
                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/backend/images/default-file.jpg')).'','width' => ''.e($moduleAtrArr['img_width']['small']).'','class' => 'img-thumbnail']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/backend/images/default-file.jpg')).'','width' => ''.e($moduleAtrArr['img_width']['small']).'','class' => 'img-thumbnail']); ?>
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
                                       </li>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                      
                                    </ul>
                                    <?php else: ?>
                                      <?php echo e(__('message.data_not_available')); ?>

                                    <?php endif; ?>
                                 </div>
                              </div>
                            <?php echo $dataListModel->appends($data)->links(); ?>

                            </div>
                            <div id="mediaDetail" class="media_detail"></div>
                            <input type="hidden" name="media_id" id="media_id" value="<?php echo e($typeid); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?> 

<!-- jquery file upload js -->
<script src="<?php echo e(asset('themes/backend/files/assets/pages/jquery.filer/js/jquery.filer.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/backend/files/assets/pages/filer/jquery.fileuploads.init.js')); ?>"></script>
<script>

function deleteMediaError() 
{
    $(".media_error_div").on('click',function(){
        $(this).remove();
    });
}

function setMediaAtrbts(mediaId,url){
    var mediaLiId = "media_"+mediaId;
    if ($("#"+mediaLiId).hasClass('active')) {
        // Deselect currently selected image
        $("#"+mediaLiId).removeClass('active');
        $(".media-button-select").attr("disabled", "disabled");
    } else {
        // Deselect others and select this one
        $('.media_pop_feat_list .media_img > ul li').removeClass('active');
        $("#"+mediaLiId).addClass('active');
        $(".media-button-select").removeAttr("disabled");
        if (mediaId > 0) {
            $.ajax({
                url: url,
                cache: false
            })
            .done(function (html) {
                $("#mediaDetail").html(html);
                $(".media-button-select").removeAttr("disabled");
            });
        }
    }
}


//Finally inserted selected media.
function setImageID() {
    var ImgClickId = $("#media_id").val();
    var ImgDataId = $("#hidMediaId").val();
    var ImgThumgSrc = $("#media_full_url").val();
    var img = $('<img />', {
        class: 'display-media',
        'data-id': ImgDataId,
        src: ImgThumgSrc,
        width: '100%',
        height: 'auto',
        alt: 'media-image'
    });
    parent.$("a#featuredImg-"+ImgClickId).html(img);
    parent.$("#featuredImgVal-"+ImgClickId).val(ImgDataId);
    // parent.$("#featuredImgRemov-"+ImgClickId).css('display', 'block');
    parent.$("#featuredImgRemov-"+ImgClickId).removeClass('d-none');
    parent.$.fancybox.close();
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/media/modalgallery.blade.php ENDPATH**/ ?>