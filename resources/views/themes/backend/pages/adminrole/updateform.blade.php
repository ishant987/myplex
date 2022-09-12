@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('adminrole.edit',$userrole)  }} 
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ __('admin.edit_admnrole_user_txt') }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            
            <form name="aeUsrFrm" id="aeUsrFrm" action="{{ route('admin.adminrole.update', $userrole->role_id) }}" method="POST">
               {{ csrf_field() }}
               {{ method_field('PATCH') }}

               <x-form.group_lyt1_2_10 label="{{ __('admin.rolename_txt') }}" for="title" 
                  error="{{ $errors->first('title') }}" required="true">
                  <x-form.field.text id="title" name="title" value="{{ $userrole->title }}" />
              </x-form.group_lyt1_2_10>
            @if( $userrole->role_id > 1)
            <div class="form-group row">
               <label class="col-sm-2 col-form-label">Modules Access<span class="required">*</span></label>
               <div class="col-sm-10">
                 <div class="table-responsive dt-responsive">
                    <table class="table table-bordered m-b-0 user-role-table">
                       <thead>
                          <tr>
                             <td>Module</td>
                             <td colspan=5>
                                <div class="checkbox-fade has-primary fade-in-default pull-left" style="margin-right: 10px">
                                <label>
                                  <input type="checkbox" id="checkAll">
                                <span class="cr dcr" >
                                  <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                </span>
                                <span class="text-inverse m-l-5 cell-breakWord">
                                Check All Pages
                                </span>
                                </label></div>
                             </td>
                          </tr>
                       </thead>
                       <tbody>
                        @foreach($modules as $key=>$module)  
                          @if($module->getModuleMethods($userrole->role_id) && count($module->getModuleMethods($userrole->role_id))>0)
                           <tr class="{{ $maxTdCnt }}">
                              <td>
                                <div class="checkbox-fade has-primary fade-in-default @if($module->parent_module_id==0) is_parent @endif">
                                   <label>
                                   <span class="text-inverse m-l-5 font-12"><strong>{{ $module->title }}</strong></span>
                                   </label>
                                </div>
                             </td>
                              @foreach($module->getModuleMethods($userrole->role_id) as $key2=>$method)
                              <td @if( $maxTdCnt !=count($module->getModuleMethods($userrole->role_id)) && $key2==count($module->getModuleMethods($userrole->role_id))-1 ) colspan="{{ $maxTdCnt-$key2 }}" @endif class="user-method-perm ">
                                <input type="hidden" name="hid_method_id" value="{{ $method->method_id }}">
                                <div class="checkbox-fade has-primary fade-in-default">
                                   <label>
                                    @if($method->default_present == 0)
                                      <input type="checkbox" name="method[]" value="{{ $method->method_id }}" @if(in_array($method->method_id,$selectedMethodIDArr)) checked="checked" @endif>
                                      <span class="cr">
                                      <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                     </span>
                                    @else
                                    <input type="checkbox" name="method[]" value="{{ $method->method_id }}" checked="checked" disabled="disabled">
                                    <input type="hidden" name="method[]" value="{{ $method->method_id }}">
                                      <span class="cr dcr"  title="Disabled as it must present to all users">
                                      <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                     </span>
                                    @endif
                                   
                                   <span class="text-inverse m-l-5 cell-breakWord">
                                    @if($method->is_left_nav>0)
                                    <i class="fa fa-plus m-r-5 text-c-red"></i>
                                    @endif
                                    {{ $method->title }}
                                    </span>
                                   </label>
                                </div>
                              </td>
                              @endforeach
                             @endif
                           </tr>
                        @endforeach

                       </tbody>
                    </table>
                 </div>
                    <div class="info">
                      <strong> NOTE:</strong>
                      <div class="is_parent"><span class="text-inverse italic">Parent module(colored red) & page with [<i class="fa fa-plus text-c-red"></i>] must ticked (if sub-module is ticked) to appear in left menu</span></div>
                    </div>
               </div>
            </div>
            @endif



               <div class="row">
                  <div class="col-sm-12">
                     <x-form.group_lyt1_2_10 class=m-t-10>
                        <x-form.field.button id="submit" name="submit" />
                        <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}" />
                     </x-form.group_lyt1_2_10>
                  </div>
               </div>
            </form>
         </div>
         <!-- end of card-block -->
      </div>
   </div>
</div>
@stop
@push('scripts') 
<script>
  $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });
</script>
@endpush