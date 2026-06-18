<div class="accordion-group <?php echo e($dataIsSubMenu); ?>">
   <div class="accordion-heading">
      <a class="accordion-toggle btn-primary" data-toggle="collapse" data-parent="#accordion3" href="#collapseTgree_<?php echo e($dataMenuId); ?>"><?php echo $dataLabel; ?></a>
   </div>
   <div id="collapseTgree_<?php echo e($dataMenuId); ?>" class="accordion-body collapse">
      <div class="accordion-inner">
         <div class="form-group">
            <label>Menu Title</label>
            <input type="text" name="menu_item[<?php echo e($dataMenuId); ?>][label]" id="menu_item_title_<?php echo e($dataMenuId); ?>" class="form-control" value="<?php echo $dataLabel; ?>">
         </div>
         <div class="form-group border-checkbox-section form-inline justify-content-between">
            <div class="checkbox-fade has-primary fade-in-default">
               <label>
               <input type="checkbox" name="menu_item[<?php echo e($dataMenuId); ?>][target]" id="menu_item_target_<?php echo e($dataMenuId); ?>" value="_blank" <?php if($dataLinkTarget): ?> checked="checked" <?php endif; ?>>
               <span class="cr">
               <i class="cr-icon icofont icofont-ui-check txt-default"></i>
               </span>
               <span>Open link in a new window / tab</span>
               </label>                   
            </div>
            <div class="form-inline">
               <label>Order</label>
               <input type="text" name="menu_item[<?php echo e($dataMenuId); ?>][c_order]" id="menu_order_<?php echo e($dataMenuId); ?>" class="form-control m-l-10" value="<?php echo e($dataOrder); ?>">
            </div>
         </div>
         <div class="form-group">
            <label>Image URL</label>
            <input type="text" name="menu_item[<?php echo e($dataMenuId); ?>][image_url]" id="menu_img_url_<?php echo e($dataMenuId); ?>" class="form-control" value="<?php echo e($dataImageUrl); ?>">
         </div>
         <div class="form-group has-primary">
           

            <?php if($dataIsLink && $dataExternalLink): ?>
             <label>URL </label> 
               <input type="text" name="menu_item[<?php echo e($dataMenuId); ?>][external_link]" id="menu_external_link_<?php echo e($dataMenuId); ?>" class="form-control m-l-9" value="<?php echo e($dataExternalLink); ?>">
               <div class="col-form-label info">URL cannot be blank.</div>
            <?php else: ?> 
             <label>Page Link </label> 
               <a href="<?php echo e($dataModulePageName); ?>" class="f-w-600 text-primary b-b-primary" target="_blank"><b><?php echo $dataLabel; ?></b></a> 
            <?php endif; ?>

         </div>
         <div class="form-group border-checkbox-section form-inline">
            <div class="col-md-6 col-xs-12 p-l-0">
               <div class="checkbox-fade has-primary fade-in-default">
                  <label>
                  <input type="checkbox" name="is_menu_<?php echo e($dataMenuId); ?>" id="is_menu_<?php echo e($dataMenuId); ?>" value="1" checked="checked" disabled="disabled">
                  <span class="cr">
                  <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                  </span>
                  <span>Menu</span>
                  </label>  
               </div>
               <div class="checkbox-fade has-primary fade-in-default <?php echo e($subMenuClass); ?>">
                  <label>
                  <input type="checkbox" name="is_submenu_<?php echo e($dataMenuId); ?>" id="is_submenu_<?php echo e($dataMenuId); ?>" value="1" onclick="isMenuSubmenu('<?php echo e($dataMenuId); ?>');">
                  <span class="cr">
                  <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                  </span>
                  <span>Submenu</span>
                  </label>   
               </div>
            </div>
            <div class="col-md-6 col-xs-12 p-r-0">
               <div class="form-inline f-right">
                  <label>Css</label><input type="text" name="menu_item[<?php echo e($dataMenuId); ?>][menu_class]" id="menu_class_<?php echo e($dataMenuId); ?>" class="form-control m-l-10" value="<?php echo e($dataMenuClass); ?>">    
               </div>
            </div>
         </div>
         <div class="form-inline" id="parent_menu_area_<?php echo e($dataMenuId); ?>" style="display: none;">
            <label>Parent Menu</label>
            <?php echo e($slot); ?>

         </div>
         <div class="form-group f-m-b-0">
            <label>
               <a href="<?php echo e(route('admin.menu.destroy.custom',$dataMenuId)); ?>" class="btn waves-effect waves-light btn-sm btn-danger f-right m-r-5 delLink" title="Remove <?php echo $dataLabel; ?> from menu"><i class="icofont icofont-ui-delete"></i></a>
            </label>  
         </div>
         <!-- <input type="hidden" name="hid_menu_id[<?php echo e($dataMenuId); ?>]" value="<?php echo e($dataMenuId); ?>"> -->
      </div>
   </div>
</div><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/menu/single_structure.blade.php ENDPATH**/ ?>