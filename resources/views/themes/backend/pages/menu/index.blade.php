@extends('themes.backend.layouts.app')
@section('dataTables') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('menu.index')  }} 
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('admin.menu.all_txt') }}</h5>
        @if($roleRights['add'])
          <!-- Add New -->
          <x-link_add_new url="{{ route('admin.menutype.create') }}" />
        @endif
      </div>
      <div class="card-block">
       <!-- Show message. -->
       <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

        <div class="row align-items-center">
           <div class="col-md-12">
                 <div class="z_form-row align-items-center">
                  <x-form.group_lyt1_3_7_2 label="{{ __('admin.menutype.menu_select_txt') }}" for="menu_type_id" 
                    error="{{ $errors->first('menu_type_id') }}" required="true">
                    <select id="menu_type_id" class="form-control" name="menu_type_id" style="float:left;width:85%;margin-right: 20px;">
                      <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
                      @foreach( $menuTypeAssoc as $key => $mname )
                        <option value="{{ $mname['menu_type_id'] }}" {{ ( $mtid == $mname['menu_type_id'] ) ? 'selected' : '' }}>{{ $mname['label'] }} ( {{ $menuforAssoc[$mname['menu_for']] }} )</option>
                      @endforeach
                    </select>
                    <div class="f-left">
                      <a href="{{ route('admin.menutype.edit',$mtid) }}" class="btn waves-effect waves-light btn-sm btn-primary f-right m-r-5"><b><i class="icofont icofont-ui-edit"></i> <!-- <i class="icofont icofont-refresh"></i> <i class="icofont icofont-save"></i> --> </b></a>
                    </div>
                  </x-form.group_lyt1_3_7_2>
                 </div>
           </div>
        </div>

        <!-- Select a menu to edit section end -->
        <div class="row m-b-20">
          
          <!-- Add to menu left section start -->
          <div class="col-md-4 col-sm-12">
            <form name="add_menu_frm" action="{{ route('admin.menu.store') }}" method="post">
                {{ csrf_field() }}
              <div class="menu-accordion-wrapper">
                <div class="accordion" id="accordion2">
                    <!-- Pages "Add to menu" module start -->
                    <div class="accordion-group">
                      <div class="accordion-heading">
                        <a class="accordion-toggle btn-primary" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">{{ __('admin.page.menu_label_txt') }}</a>
                      </div>
                      <div id="collapseOne" class="accordion-body collapse show">
                        <div class="accordion-inner">
                          <div class="menu_item_scroll border-checkbox-section">
                           @foreach( $pagesListModel as $module_class => $pageListModel )
                             @foreach( $pageListModel as $key => $pageModel )
                              <x-form.menu.single_checkbox label="{!! $pageModel->title !!}" for="{{ $pageModel->page_id }}" 
                              dataModuleClass="{{ $module_class }}" 
                              dataId="{{ $pageModel->page_id }}" 
                              dataLabel="{{ $pageModel->title }}"
                              ></x-form.menu.single_checkbox>
                             @endforeach
                           @endforeach
                          </div>
                          <x-form.group_lyt1_12 class="m-t-10 m-b-0-i">
                          <x-form.field.button id="submit" name="add_page_menu_btn" id="add_page_menu_btn" class="btn-primary btn-sm" text="{{ __('admin.menu.add_to_menu_txt') }}" />
                          <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" class="btn-danger btn-sm" text="{{ __('admin.cancel_txt') }}"/>
                          </x-form.group_lyt1_12>
                        </div>
                      </div>
                    </div>
                    <!-- Pages "Add to menu" module end -->

                    <!-- Links "Add to menu" module start -->
                    <div class="accordion-group">
                      <div class="accordion-heading">
                         <a class="accordion-toggle btn-primary" data-toggle="collapse" data-parent="#accordion2" href="#collapseLink">
                         {{ __('admin.link.menu_label_txt') }}</a>
                      </div>
                      <div id="collapseLink" class="accordion-body collapse @if(old('add_custom_menu_btn')=='add_custom_menu_btn'){ show } @endif">
                         <div class="accordion-inner">
                            <div class="custom_menu_link">
                                <x-form.group_lyt1_12 label="{{ __('admin.link.menu_url_txt') }}" for="link_url" 
                                error="{{ $errors->first('link_url') }}">
                                <x-form.field.text id="link_url" placeholder="http:// or https://" name="link_url" value="{{ old('link_url') }}" />
                                </x-form.group_lyt1_12>
                                <x-form.group_lyt1_12 label="{{ __('admin.link.menu_link_txt') }}" for="link_text" 
                                error="{{ $errors->first('link_text') }}">
                                <x-form.field.text id="link_text" name="link_text" value="{{ old('link_text') }}" />
                                </x-form.group_lyt1_12>
                            </div>
                            <x-form.group_lyt1_12 class="m-t-10 m-b-0-i">
                            <x-form.field.text id="menu_type_id" name="menu_type_id" type="hidden" value="{{ $mtid }}"/>
                            <x-form.field.button id="submit" name="add_custom_menu_btn" id="add_custom_menu_btn" class="btn-primary btn-sm" text="{{ __('admin.menu.add_to_menu_txt') }}" value="add_custom_menu_btn"/>
                            <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" class="btn-danger btn-sm" text="{{ __('admin.cancel_txt') }}"/>
                            </x-form.group_lyt1_12>
                         </div>
                      </div>
                   </div>
                    <!-- Links "Add to menu" module end -->
                </div>
              </div>
            </form>
          </div>
          <!-- Add to menu left section end -->

          <!-- Menu Structure right section start -->
          <div class="col-md-8 col-xs-12">
            <div class="menu_area">
              
              @if( $dataListModel ) 
              <form name="menuformsubmit" id="menuformsubmit" method="POST" action="{{ route('admin.menu.update', $mtid) }}">
               {{ csrf_field() }}
               {{ method_field('PATCH') }}

                <div class="form_row">
                  <h6>Menu Structure</h6>
                  <p>Click the arrow on the left of the item to reveal additional configuration options.</p>
                  <div class="menu-accordion-wrapper">
                    <div class="accordion" id="accordion3">
                    @foreach( $dataListModel as $key => $menuModel )                      
                        <x-form.menu.single_structure label="{!! $menuModel->label !!}" for="{{ $menuModel->menu_id }}" 
                        dataMenuId="{{ $menuModel->menu_id }}" 
                        dataId="{{ $menuModel->data_id }}" 
                        dataLabel="{{ $menuModel->label }}" 
                        dataOrder="{{ $menuModel->c_order }}" 
                        dataImageUrl="{{ $menuModel->image_url }}"
                        dataIsLink="{{ $menuModel->is_link }}"
                        dataExternalLink="{{ $menuModel->external_link }}"
                        dataLinkTarget="{{ $menuModel->link_target }}"
                        dataMenuClass="{{ $menuModel->menu_class }}"
                        dataModulePageName="{{ $menuModel->getModulePageName() }}"
                        dataIsSubMenu=""
                        subMenuClass=""
                        >
                          <select name="menu_item[{{ $menuModel->menu_id }}][parent_menu_id]" id="parent_menu_{{ $menuModel->menu_id }}" class="form-control my-1">
                             <option value="">--please select--</option>
                             @foreach($menuModel->getSubMenuAssoc() as $subMenuModel)
                             <option value="{{ $subMenuModel->menu_id }}">{{ $subMenuModel->label }}</option>
                             @endforeach
                          </select>
                        </x-form.mnu.single_structure>
                        @if(isset($menuModel->menuchildren) && $menuModel->menuchildren->count()>0)
                          @foreach( $menuModel->menuchildren as $key => $cmModel )   
                            <x-form.menu.single_structure label="{!! $cmModel->label !!}" for="{{ $cmModel->menu_id }}" 
                            dataMenuId="{{ $cmModel->menu_id }}" 
                            dataId="{{ $cmModel->data_id }}" 
                            dataLabel="{{ $cmModel->label }}" 
                            dataOrder="{{ $cmModel->c_order }}" 
                            dataImageUrl="{{ $cmModel->image_url }}"
                            dataIsLink="{{ $cmModel->is_link }}"
                            dataExternalLink="{{ $cmModel->external_link }}"
                            dataLinkTarget="{{ $cmModel->link_target }}"
                            dataMenuClass="{{ $cmModel->menu_class }}"
                            dataModulePageName="{{ $cmModel->getModulePageName() }}"
                            dataIsSubMenu="sub-titel"
                            subMenuClass=""
                            >
                              <select name="menu_item[{{ $cmModel->menu_id }}][parent_menu_id]" id="parent_menu_{{ $cmModel->menu_id }}" class="form-control my-1">
                                 <option value="">--please select--</option>
                                 @foreach($cmModel->getSubMenuAssoc() as $subMenuModel)
                                 <option value="{{ $subMenuModel->menu_id }}">{{ $subMenuModel->label }}</option>
                                 @endforeach
                              </select>
                            </x-form.mnu.single_structure>

                            @if(isset($cmModel->menuchildren) && $cmModel->menuchildren->count()>0)
                              @foreach( $cmModel->menuchildren as $key => $gcmModel )   
                                <x-form.menu.single_structure label="{!! $gcmModel->label !!}" for="{{ $gcmModel->menu_id }}" 
                                dataMenuId="{{ $gcmModel->menu_id }}" 
                                dataId="{{ $gcmModel->data_id }}" 
                                dataLabel="{{ $gcmModel->label }}" 
                                dataOrder="{{ $gcmModel->c_order }}" 
                                dataImageUrl="{{ $gcmModel->image_url }}"
                                dataIsLink="{{ $gcmModel->is_link }}"
                                dataExternalLink="{{ $gcmModel->external_link }}"
                                dataLinkTarget="{{ $gcmModel->link_target }}"
                                dataMenuClass="{{ $gcmModel->menu_class }}"
                                dataModulePageName="{{ $gcmModel->getModulePageName() }}"
                                dataIsSubMenu="sub-titel2"
                                subMenuClass="d-none"
                                >
                                  <!-- <select name="menu_item[{{ $gcmModel->menu_id }}][parent_menu_id]" id="parent_menu_{{ $gcmModel->menu_id }}" class="form-control my-1">
                                     <option value="">--please select--</option>
                                     @foreach($gcmModel->getSubMenuAssoc() as $subMenuModel)
                                     <option value="{{ $subMenuModel->menu_id }}">{{ $subMenuModel->label }}</option>
                                     @endforeach
                                  </select> -->
                                </x-form.mnu.single_structure>
                              @endforeach
                            @endif
                          @endforeach                           
                        @endif
                    @endforeach
                    </div>
                  </div>   
                  <!-- Action buttons -->             
                  <div class="form-group">
                    <div class="f-left">
                      <x-form.field.button id="submit" name="submit" />
                      <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}"/>
                    </div>
                    @if($roleRights['delete'])
                    <div class="f-right">
                      <x-link url="{{ route('admin.menutype.destroy.custom',$mtid) }}" class="btn waves-effect waves-light btn-sm btn-danger f-right m-r-5 delLink"><i class="icofont icofont-ui-delete"></i></x-link>
                    </div>
                    @endif
                  </div>

                </div>
              </form>
              @endif

            </div>
          </div>
          <!-- Menu Structure right section end -->
        </div>
     </div>
   </div>
 </div>
</div>
@stop
@push('scripts') 
  <script>
  $('#menu_type_id').bind('change', function() {
    var menu_type_id = $(this).val();
    var url = '';
    if(menu_type_id > 0){
      url = '{{ route("admin.menu.index.custom") }}'+'/'+menu_type_id;  
      // alert(url);    
      // url = url.replace('menu_type_id', menu_type_id);
    }
    else{
      url = '{{ route("admin.menu.index.custom") }}';
    }
    window.location.href = url;
  });
  </script>
@endpush