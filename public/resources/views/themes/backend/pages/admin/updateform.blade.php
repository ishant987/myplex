@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['route'], $dataArr) }}
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ $editDataAtrArr['title'] }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

            <form name="aeUsrFrm" id="aeUsrFrm" action="{{ route($editDataAtrArr['postroute'], $dataArr->admin_id) }}" method="POST">
               {{ csrf_field() }}
               @if($editDataAtrArr['login_admin_id'])
               {{ method_field('PATCH') }}
               @endif

               @if( ( $editDataAtrArr['login_admin_id'] > 0 ) && ( $editDataAtrArr['login_admin_id'] != $dataArr->admin_id ) )
               <x-form.group_lyt1_2_10 label="{{ __('admin.role_txt') }}" for="role" error="{{ $errors->first('role_id') }}" required="true">
                  <select name="role_id" id="role_id" class="form-control">
                     <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
                     @foreach( $roles as $role_id => $role )
                     <option value="{{ $role_id }}" @if( old('role_id')==$role_id ) {{ 'selected' }} @elseif( $dataArr->role_id == $role_id ) {{ 'selected' }} @endif>{{ $role }}</option>
                     @endforeach
                  </select>
               </x-form.group_lyt1_2_10>
               @endif

               <x-form.group_lyt1_2_10 label="{{ __('admin.username_txt') }}" for="username" error="{{ $errors->first('username') }}">
                  <x-form.field.text id="username" name="username" value="{{ $dataArr->username }}" disabled="disabled" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.display_name_txt') }}" for="display_name" error="{{ $errors->first('display_name') }}" required="true">
                  <x-form.field.text id="display_name" name="display_name" value="{{ $dataArr->display_name }}" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('common.f_name_txt') }}" for="first_name" error="{{ $errors->first('first_name') }}" required="true">
                  <x-form.field.text id="first_name" name="first_name" value="{{ $dataArr->first_name }}" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('common.l_name_txt') }}" for="last_name" error="{{ $errors->first('last_name') }}">
                  <x-form.field.text id="last_name" name="last_name" value="{{ $dataArr->last_name }}" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('common.email_txt') }}" for="email" error="{{ $errors->first('email') }}" required="true">
                  <x-form.field.text id="email" name="email" value="{{ $dataArr->email }}" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.website_txt') }}" for="website" error="{{ $errors->first('website') }}">
                  <x-form.field.text id="website" name="website" value="{{ $dataArr->website }}" type="url" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.secret_txt') }}" for="secret" error="{{ $errors->first('secret') }}" info="{!! __('admin.info.secret') !!}">
                  <x-form.field.text type="password" id="secret" name="secret" value="" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.password_txt') }}" for="password" error="{{ $errors->first('password') }}">
                  <x-form.field.text id="password" name="password" value="" type="password" />
               </x-form.group_lyt1_2_10>

               @if( ( $editDataAtrArr['login_admin_id'] > 0 ) && ( $editDataAtrArr['login_admin_id'] != $dataArr->admin_id ) )
               <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="role" error="{{ $errors->first('status') }}" required="true">
                  <select name="status" id="status" class="form-control">
                     @foreach( $statusArr as $id => $status )
                     <option value="{{ $id }}" {{ ( $id == $dataArr->status ) ? 'selected' : '' }}>{{ $status }}</option>
                     @endforeach
                  </select>
               </x-form.group_lyt1_2_10>
               @endif

               <div class="row">
                  <div class="col-sm-12">
                     <x-form.group_lyt1_2_10 class="m-t-10">
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