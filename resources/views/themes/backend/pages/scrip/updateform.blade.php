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
        <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.scrips.update', $dataArr->scrp_id) }}" method="POST">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

          <x-form.group_lyt1_2_10 label="{{ __('admin.scrip.label_txt') }}" for="scrip_name" error="{{ $errors->first('scrip_name') }}" required="true">
            <x-form.field.text id="scrip_name" name="scrip_name" value="{{ $dataArr->scrip_name }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.type_txt') }}" for="type" error="{{ $errors->first('type') }}" required="true">
            <x-form.field.text id="type" name="type" value="{{ $dataArr->type }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.industry_txt') }}" for="industry" error="{{ $errors->first('industry') }}" required="true">
            <x-form.field.text id="industry" name="industry" value="{{ $dataArr->industry }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.scrip.actual_txt') }}" for="actual_scrip" error="{{ $errors->first('actual_scrip') }}" required="true">
            <x-form.field.text id="actual_scrip" name="actual_scrip" value="{{ $dataArr->actual_scrip }}" />
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