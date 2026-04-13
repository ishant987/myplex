@extends('themes.backend.layouts.app')
@section('multiselectAvailableSelected') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('subscribeduser.createmanual') }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text">{{ __('subscribeduser.add_manual_txt') }}</h5>
      </div>
      <div class="card-block">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        <form name="aeUsrFrm" id="aeUsrFrm" action="{{ route('admin.subscribeduser.store') }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}

          <x-form.group_lyt1_2_10 label="{{ __('common.f_name_txt') }}" for="first_name" error="{{ $errors->first('first_name') }}" required="true">
            <x-form.field.text id="first_name" name="first_name" value="{{ old('first_name') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('common.l_name_txt') }}" for="l_name" error="{{ $errors->first('l_name') }}">
            <x-form.field.text id="l_name" name="l_name" value="{{ old('l_name') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('common.email_txt') }}" for="email" error="{{ $errors->first('email') }}" required="true">
            <x-form.field.text id="email" name="email" value="{{ old('email') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('common.mobile_txt') }}" for="mobile" error="{{ $errors->first('mobile') }}" required="true">
            <x-form.field.text id="mobile" name="mobile" value="{{ old('mobile') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('subscribeduser.profile_pic_txt') }}" for="p_picture" error="{{ $errors->first('p_picture') }}" info="{!! __('subscribeduser.info.image') !!}">
            <x-form.field.file id="p_picture" name="p_picture" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('subscribeduser.about_txt') }}" for="about" error="{{ $errors->first('about') }}">
            <x-form.field.text id="about" name="about" value="{{ old('about') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('subscribeduser.profile_txt') }}" for="profile" error="{{ $errors->first('profile') }}">
            <x-form.field.text id="profile" name="profile" value="{{ old('profile') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('subscribeduser.company_txt') }}" for="company" error="{{ $errors->first('company') }}">
            <x-form.field.text id="company" name="company" value="{{ old('company') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('subscribeduser.brthdy_txt') }}" for="b_date" error="{{ $errors->first('b_date') }}">
            <div class="row">
              <div class="col-sm-6">
                <select id="b_date" class="form-control" name="b_date">
                  <option value="">{{ __('subscribeduser.brthdy_day_def_opt_txt') }}</option>
                  @if(!empty($daysArr))
                  @foreach ($daysArr as $value)
                  <option value="{{ $value }}" {{ ( $value == old('b_date') ) ? 'selected' : '' }}>{{ $value }}</option>
                  @endforeach
                  @endif
                </select>
              </div>
              <div class="col-sm-6">
                <select id="b_month" class="form-control" name="b_month">
                  <option value="">{{ __('subscribeduser.brthdy_month_def_opt_txt') }}</option>
                  @if(!empty($monthsArr))
                  @foreach ($monthsArr as $key => $mValue)
                  <option value="{{ $key }}" {{ ( $key == old('b_month') ) ? 'selected' : '' }}>{{ $mValue }}</option>
                  @endforeach
                  @endif
                </select>
              </div>
            </div>
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('subscribeduser.pincode_txt') }}" for="pincode" error="{{ $errors->first('pincode') }}">
            <x-form.field.text id="pincode" name="pincode" value="{{ old('pincode') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('subscribeduser.address_txt') }}" for="address" error="{{ $errors->first('address') }}">
            <x-form.field.textarea id="address" name="address" value="{{ old('address') }}" rows=3 />
          </x-form.group_lyt1_2_10>

          <div class="row m-b-20{{ $errors->first('user_group')?' has-danger':'' }}">
            <div class="col-sm-12">
              <label class="col-form-label">{{ __('admin.user_group_txt') }}<span class="required"> *</span></label>
            </div>
            <div class="col-sm-5">
              <label class="col-form-label">{{ __('admin.available_ug_txt') }}</label>
              <select name="user_group_from[]" id="multiselect" class="form-control multiselect" size="15" multiple="multiple">
                @foreach( $userGroupArr as $key => $value )
                <option value="{{ $value['u_g_id'] }}">{{ $value['group_name'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-2 m-t-100">
              <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="fa fa-forward" aria-hidden="true"></i></button>
              <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
              <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
              <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="fa fa-backward" aria-hidden="true"></i></button>
            </div>
            <div class="col-sm-5">
              <label class="col-form-label">{{ __('admin.selected_ug_txt') }}</label>
              <select name="user_group[]" id="multiselect_to" class="form-control multiselect" size="15" multiple="multiple"></select>
            </div>
            @if($errors->first('user_group'))
            <div class="col-sm-12 col-form-label">{{ $errors->first('user_group') }}</div>
            @endif
          </div>

          <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="status" error="{{ $errors->first('status') }}" required="true">
            <select id="status" class="form-control" name="status">
              @foreach( $moduleAtrArr['status']['label'] as $id => $status )
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