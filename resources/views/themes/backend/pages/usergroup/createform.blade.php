@extends('themes.backend.layouts.app')
@section('multiselectAvailableSelected') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('usergroup.create') }} 
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ __('subscribeduser.user_group.add_txt') }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.usergroup.store')}}" method="POST">
              {{ csrf_field() }}

              <x-form.group_lyt1_2_10 label="{{ __('subscribeduser.user_group.name') }}" for="group_name" 
                  error="{{ $errors->first('group_name') }}" required="true">
                  <x-form.field.text id="group_name" name="group_name" value="{{ old('group_name') }}" />
              </x-form.group_lyt1_2_10>

              <div class="row m-b-20{{ $errors->first('assigned_to')?' has-danger':'' }}">
                <div class="col-sm-12">
                    <label class="col-form-label">{{ __('subscribeduser.label_txt') }}</label>
                    </div>
                <div class="col-sm-5">
                    <label class="col-form-label">{{ __('admin.available_usr_txt') }}</label>
                    <select name="assigned_from[]" id="multiselect" class="form-control multiselect" size="25" multiple="multiple">
                        @foreach( $sbsUsrObj as $key => $value )
                          <option value="{{ $value->u_id }}">{{ $value->fullinfo }}</option>
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
                    <label class="col-form-label">{{ __('admin.selected_usr_txt') }}</label>
                    <select name="assigned_to[]" id="multiselect_to" class="form-control multiselect" size="25" multiple="multiple"></select>
                </div>
                @if($errors->first('assigned_to'))
                  <div class="col-sm-12 col-form-label">{{ $errors->first('assigned_to') }}</div>
                @endif
              </div>

              <div class="row">
                  <div class="col-sm-12">
                    <x-form.group_lyt1_2_10 class="m-t-10">
                    <x-form.field.button id="submit" name="submit" />
                    <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}"/>
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