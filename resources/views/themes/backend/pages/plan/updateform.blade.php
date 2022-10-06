@extends('themes.backend.layouts.app')
@section('editor') @stop

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

        <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.plan.update', $dataArr->p_id) }}" method="POST">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

          <x-form.group_lyt1_2_10 label="{{ __('plan.type_txt') }}" for="plan_type" error="{{ $errors->first('plan_type') }}" required="true">
            <select name="plan_type" id="plan_type" aria-controls="example" class="form-control" disabled="true">
              <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
              @foreach($moduleAtrArr['plan_type']['value'] as $key => $ptVal)
              <option value="{{ $ptVal }}" @if($ptVal==old('plan_type')) {{ 'selected' }} @elseif($ptVal==$dataArr->plan_type) {{ 'selected' }} @endif>{{ $moduleAtrArr['plan_type']['text'][$ptVal] }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('plan.name_txt') }}" for="plan_name" error="{{ $errors->first('plan_name') }}" required="true">
            <x-form.field.text id="plan_name" name="plan_name" value="{{ $dataArr->plan_name }}" />
          </x-form.group_lyt1_2_10>

          <div id="lp_div" @if($dataArr->plan_type == $moduleAtrArr["plan_type"]["value"][1]) {{ 'class=show-scn' }} @else {{ 'class=hide-scn' }} @endif>

            <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="description" error="{{ $errors->first('description') }}">
              <x-form.field.textarea id="description" name="description" value="{!! $dataArr->description !!}" rows="3" class="editor_full" />
            </x-form.group_lyt1_2_10>

            <x-form.group_lyt1_2_10 label="{{ __('plan.amount_txt') }}" for="amount" error="{{ $errors->first('amount') }}" info="{!! __('plan.info.not_change') !!}">
              <x-form.field.text type="number" id="amount" name="amount" value="{{ $dataArr->amount }}" min="0" disabled="true" />
            </x-form.group_lyt1_2_10>

            <x-form.group_lyt1_2_10 label="{{ __('plan.duration_txt') }}" for="plan_duration" error="{{ $errors->first('plan_duration') }}" required="true" info="{!! __('plan.info.plan_duration') !!}">
              <x-form.field.text type="number" id="plan_duration" name="plan_duration" value="{{ $dataArr->duration }}" min="0" disabled="true" />
            </x-form.group_lyt1_2_10>

            <x-form.group_lyt1_2_10 label="{{ __('plan.duration_name_txt') }}" for="plan_duration_name" error="{{ $errors->first('plan_duration_name') }}">
              <x-form.field.text id="plan_duration_name" name="plan_duration_name" value="{{ $dataArr->duration_name }}" />
            </x-form.group_lyt1_2_10>

            <x-form.group_lyt1_2_10 label="{{ __('plan.free_trial_txt') }}" for="free_trial" error="{{ $errors->first('free_trial') }}" required="true">
              <select name="free_trial" id="free_trial" aria-controls="example" class="form-control">
                @foreach(array_reverse($moduleAtrArr['yes_no']) as $key2 => $ftvalue)
                <option value="{{ $key2 }}" @if($key2==old('free_trial')) {{ 'selected' }} @elseif($key2==$dataArr->free_trial) {{ 'selected' }} @endif>{{ $ftvalue }}</option>
                @endforeach
              </select>
            </x-form.group_lyt1_2_10>

            <x-form.group_lyt1_2_10 label="{!! __('plan.show_website_app_txt') !!}" for="show_on_wa" error="{{ $errors->first('show_on_wa') }}" required="true">
              <select name="show_on_wa" id="show_on_wa" aria-controls="example" class="form-control">
                @foreach(array_reverse($moduleAtrArr['yes_no']) as $key3 => $wavalue)
                <option value="{{ $key3 }}" @if($key3==old('show_on_wa')) {{ 'selected' }} @elseif($key3==$dataArr->show_on_wa) {{ 'selected' }} @endif>{{ $wavalue }}</option>
                @endforeach
              </select>
            </x-form.group_lyt1_2_10>

            <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" error="{{ $errors->first('c_order') }}">
              <x-form.field.text id="c_order" name="c_order" value="{{ $dataArr->c_order > 0 ? $dataArr->c_order : '' }}" />
            </x-form.group_lyt1_2_10>

          </div>

          <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="role" error="{{ $errors->first('status') }}" required="true">
            <select name="status" id="status" class="form-control">
              @foreach( $statusArr as $id => $status )
              <option value="{{ $id }}" @if((old('status')> 0) && ($id == old('status'))) {{ 'selected' }} @elseif((($dataArr->status > 0) && ($id == $dataArr->status))) {{ 'selected' }} @endif>{{ $status }}</option>
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