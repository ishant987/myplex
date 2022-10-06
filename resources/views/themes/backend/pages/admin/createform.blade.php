@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('admin.create') }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text">{{ __('admin.add_admn_user_txt') }}</h5>
      </div>
      <div class="card-block">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

        <form name="aeUsrFrm" id="aeUsrFrm" action="{{ route('admin.admin.store')}}" method="POST">
          {{ csrf_field() }}

          <x-form.group_lyt1_2_10 label="{{ __('admin.role_txt') }}" for="role" error="{{ $errors->first('role_id') }}" required="true">
            <select id="role_id" class="form-control" name="role_id">
              <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
              @foreach($roles as $rol_id=>$role)
              <option value="{{ $rol_id }}" {{ ( $rol_id == old('role_id') ) ? 'selected' : '' }}>{{ $role }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.username_txt') }}" for="username" error="{{ $errors->first('username') }}" required="true">
            <x-form.field.text id="username" name="username" value="{{ old('username') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.display_name_txt') }}" for="display_name" error="{{ $errors->first('display_name') }}" required="true">
            <x-form.field.text id="display_name" name="display_name" value="{{ old('display_name') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('common.f_name_txt') }}" for="first_name" error="{{ $errors->first('first_name') }}" required="true">
            <x-form.field.text id="first_name" name="first_name" value="{{ old('first_name') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('common.l_name_txt') }}" for="last_name" error="{{ $errors->first('last_name') }}">
            <x-form.field.text id="last_name" name="last_name" value="{{ old('last_name') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('common.email_txt') }}" for="email" error="{{ $errors->first('email') }}" required="true">
            <x-form.field.text id="email" name="email" value="{{ old('email') }}" type="email" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.website_txt') }}" for="website" error="{{ $errors->first('website') }}">
            <x-form.field.text id="website" name="website" value="{{ old('website') }}" type="url" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.secret_txt') }}" for="secret" error="{{ $errors->first('secret') }}" info="{!! __('admin.info.secret') !!}">
            <x-form.field.text type="password" id="secret" name="secret" value="" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.password_txt') }}" for="password" error="{{ $errors->first('password') }}" required="true">
            <x-form.field.text type="password" id="password" name="password" value="" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('common.c_password_txt') }}" for="confirm_password" error="{{ $errors->first('confirm_password') }}" required="true">
            <x-form.field.text type="password" id="confirm_password" name="confirm_password" value="" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="status" error="{{ $errors->first('status') }}" required="true">
            <select id="status" class="form-control" name="status">
              @foreach( $statusArr as $id => $status )
              <option value="{{ $id }}" {{ ( $id == old('status') ) ? 'selected' : '' }}>{{ $status }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>

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