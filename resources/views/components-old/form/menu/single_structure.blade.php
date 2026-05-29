<div class="accordion-group {{ $dataIsSubMenu }}">
   <div class="accordion-heading">
      <a class="accordion-toggle btn-primary" data-toggle="collapse" data-parent="#accordion3" href="#collapseTgree_{{ $dataMenuId }}">{!! $dataLabel !!}</a>
   </div>
   <div id="collapseTgree_{{ $dataMenuId }}" class="accordion-body collapse">
      <div class="accordion-inner">
         <div class="form-group">
            <label>Menu Title</label>
            <input type="text" name="menu_item[{{ $dataMenuId }}][label]" id="menu_item_title_{{ $dataMenuId }}" class="form-control" value="{!! $dataLabel !!}">
         </div>
         <div class="form-group border-checkbox-section form-inline justify-content-between">
            <div class="checkbox-fade has-primary fade-in-default">
               <label>
               <input type="checkbox" name="menu_item[{{ $dataMenuId }}][target]" id="menu_item_target_{{ $dataMenuId }}" value="_blank" @if($dataLinkTarget) checked="checked" @endif>
               <span class="cr">
               <i class="cr-icon icofont icofont-ui-check txt-default"></i>
               </span>
               <span>Open link in a new window / tab</span>
               </label>                   
            </div>
            <div class="form-inline">
               <label>Order</label>
               <input type="text" name="menu_item[{{ $dataMenuId }}][c_order]" id="menu_order_{{ $dataMenuId }}" class="form-control m-l-10" value="{{ $dataOrder }}">
            </div>
         </div>
         <div class="form-group">
            <label>Image URL</label>
            <input type="text" name="menu_item[{{ $dataMenuId }}][image_url]" id="menu_img_url_{{ $dataMenuId }}" class="form-control" value="{{ $dataImageUrl }}">
         </div>
         <div class="form-group has-primary">
           

            @if($dataIsLink && $dataExternalLink)
             <label>URL </label> 
               <input type="text" name="menu_item[{{ $dataMenuId }}][external_link]" id="menu_external_link_{{ $dataMenuId }}" class="form-control m-l-9" value="{{ $dataExternalLink }}">
               <div class="col-form-label info">URL cannot be blank.</div>
            @else 
             <label>Page Link </label> 
               <a href="{{ $dataModulePageName }}" class="f-w-600 text-primary b-b-primary" target="_blank"><b>{!! $dataLabel !!}</b></a> 
            @endif

         </div>
         <div class="form-group border-checkbox-section form-inline">
            <div class="col-md-6 col-xs-12 p-l-0">
               <div class="checkbox-fade has-primary fade-in-default">
                  <label>
                  <input type="checkbox" name="is_menu_{{ $dataMenuId }}" id="is_menu_{{ $dataMenuId }}" value="1" checked="checked" disabled="disabled">
                  <span class="cr">
                  <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                  </span>
                  <span>Menu</span>
                  </label>  
               </div>
               <div class="checkbox-fade has-primary fade-in-default {{ $subMenuClass }}">
                  <label>
                  <input type="checkbox" name="is_submenu_{{ $dataMenuId }}" id="is_submenu_{{ $dataMenuId }}" value="1" onclick="isMenuSubmenu('{{ $dataMenuId }}');">
                  <span class="cr">
                  <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                  </span>
                  <span>Submenu</span>
                  </label>   
               </div>
            </div>
            <div class="col-md-6 col-xs-12 p-r-0">
               <div class="form-inline f-right">
                  <label>Css</label><input type="text" name="menu_item[{{ $dataMenuId }}][menu_class]" id="menu_class_{{ $dataMenuId }}" class="form-control m-l-10" value="{{ $dataMenuClass }}">    
               </div>
            </div>
         </div>
         <div class="form-inline" id="parent_menu_area_{{ $dataMenuId }}" style="display: none;">
            <label>Parent Menu</label>
            {{ $slot }}
         </div>
         <div class="form-group f-m-b-0">
            <label>
               <a href="{{ route('admin.menu.destroy.custom',$dataMenuId) }}" class="btn waves-effect waves-light btn-sm btn-danger f-right m-r-5 delLink" title="Remove {!! $dataLabel !!} from menu"><i class="icofont icofont-ui-delete"></i></a>
            </label>  
         </div>
         <!-- <input type="hidden" name="hid_menu_id[{{ $dataMenuId }}]" value="{{ $dataMenuId }}"> -->
      </div>
   </div>
</div>