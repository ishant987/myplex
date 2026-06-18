<?php $__env->startSection('content'); ?>
  <div data-id="<?php echo e($dataModel->media_id); ?>" class="attachment-details">
      <h3 class="f-14">Attachment Details</h3>
      <div class="attachment-info">
         <div class="thumbnail-image">
            <img class="img-thumbnail" draggable="false" src="<?php echo e($imgSrc); ?>" width="100">
            <input type="hidden" id="media_full_url" value="<?php echo e($moduleAtrArr['media_folder'].$dataModel->path); ?>">
         </div>
         <div class="details">
            <div class="filename"><?php echo e($dataModel->path); ?></div>
            <div class="uploaded"><?php echo e($dataModel->created_at); ?></div>
            <div class="file-size"><?php echo e($mediaInfoArr->size); ?></div>
            <?php echo $dimension; ?>

            <?php if($roleRights['edit']): ?>
              <a target="_blank" href="<?php echo e(route('admin.media.edit',$dataModel->media_id)); ?>" class="text-primary f-left">Edit</a>
            <?php endif; ?>
            <?php if($roleRights['delete']): ?>
              <a href="javascript:void(0)" class="text-danger delete-attachment f-right" data-id="<?php echo e($dataModel->media_id); ?>" data-url="<?php echo e(route('admin.media.ajaxdelete',$dataModel->media_id)); ?>">Delete</a>
            <?php endif; ?>
         </div>
      </div>
      <form name="saveSingleMedia" method="post" id="saveSingleMedia" action="<?php echo e(route('admin.media.ajaxupdate')); ?>">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('POST')); ?>

        <div class="form-group">
          <label>Full Path</label>
          <input type="text" class="form-control" readonly="readonly" value="<?php echo $moduleAtrArr['media_folder'].$dataModel->path; ?>">
        </div>
        <?php if($roleRights['edit']): ?>
           <div class="form-group">
              <label>Title</label>
              <input type="text" class="form-control" name="title" value="<?php echo $dataModel->title; ?>">
           </div>
           <?php echo $altAttr; ?>

        <?php endif; ?>
        <input type="hidden" value="<?php echo e($dataModel->media_id); ?>" name="hidMediaId" id="hidMediaId">
      </form>
   </div>
   <div id="respMsg"></div>
   <div class="btn-area">
      <button type="button" class="btn btn-primary btn-mini waves-effect waves-light media-button-select" onclick="setImageID();" data-dismiss="modal">Insert Media</button>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?> 
<script>
$(document).ready(function () {
        $("a.delete-attachment").click(function (e) {
            e.preventDefault();
            var cnf = confirm("want to remove?");
            if (cnf == true) {
                var dataId = $(this).data("id");
                var url = $(this).data("url");
                if (dataId > 0 && url) {
                    $.ajax({
                        url: url,
                        cache: false
                    })
                    .done(function (response) {
                        if (response == 1) {
                            //ajaxMediaPopupListPagi(1, "<?php echo e(route('admin.login')); ?>");
                            $("#media_pop_feat_list #media_"+dataId).addClass('d-none');
                            $("#mediaDetail").empty();
                            $("#mediaDetail").html('<span class="text-success f-12 m-l-10"> Successfully deleted</span>');
                        } else {
                            $("#respMsg").html('<span class="text-danger f-12 m-l-10"> Fail message</span>');
                        }
                    });
                }
            }
        });
        $("#saveSingleMedia").change(function () {
          var form = $(this);
          var method = form.find('input[name="_method"]').val() || 'POST';

            $.ajax({
                type: method,
                url: form.prop('action'),
                data: form.serialize(),
                beforeSend: function () {
                    $('#respMsg').append('<span class="waiting">&nbsp;<img src="<?php echo e(asset('themes/backend/images/ajax-loader-small.gif')); ?>" alt="" /></span>');
                },
                complete: function () {
                    $('.waiting').remove();
                },
                success: function (data) {
                    $("#respMsg").html(data);
                    setTimeout(function () {
                        $('#respMsg span').fadeOut();
                    }, 8000);
                }
            });

        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/media/mediainfo.blade.php ENDPATH**/ ?>