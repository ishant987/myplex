@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('fundwatch.create') }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text">{{ __('admin.fundwatch.add_txt') }}</h5>
      </div>
      <div class="card-block">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

        <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.fund-watch.store')}}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <x-form.group_lyt1_2_10 label="Select fund" for="fund_name" 
          error="{{ $errors->first('fund_name') }}" required="true">
                    <select id="fund_name" class="form-control fund_name" name="fund_code">
                        <option value="">--Select--</option>
                        @foreach( $fundMaster as  $key=>$value )
                        <option value="{{ $value->fund_code }}"> {{$value->fund_name}}</option>
                        @endforeach
                    </select>
      </x-form.group_lyt1_2_10>
          <x-form.group_lyt1_2_10 label="Preamble" for="preamble" error="{{ $errors->first('preamble') }}" required="true">
            <x-form.field.text id="preamble" name="preamble" value="{{ old('preamble') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="Research Team Members" for="team" error="{{ $errors->first('team') }}" info="Enter multiple by comma seperatd" required="true">
            <x-form.field.text id="team" name="team" value="{!! old('team') !!}" rows="8" />
          </x-form.group_lyt1_2_10>
          <x-form.group_lyt1_2_10 label="Fund Philosophy" for="philosophy" error="{{ $errors->first('philosophy') }}"  required="true">
            <x-form.field.textarea id="philosophy" name="philosophy" value="{!! old('philosophy') !!}" rows="8" />
          </x-form.group_lyt1_2_10>
          <x-form.group_lyt1_2_10 label="Investment Style" for="investment_style" error="{{ $errors->first('investment_style') }}" required="true" >
            <x-form.field.textarea id="investment_style" name="investment_style" value="{!! old('investment_style') !!}" rows="8" />
          </x-form.group_lyt1_2_10>
          <x-form.group_lyt1_2_10 label="Fund Composition Analysis" for="composition_analysis_top" error="{{ $errors->first('composition_analysis_top') }}" info="Top description" required="true">
            <x-form.field.textarea id="composition_analysis_top" name="composition_analysis_top" value="{!! old('composition_analysis_top') !!}" rows="8" />
          </x-form.group_lyt1_2_10>
          <x-form.group_lyt1_2_10 label="Fund Composition Analysis" for="composition_analysis_bottom" error="{{ $errors->first('composition_analysis_bottom') }}" info="Bottom description" required="true">
            <x-form.field.textarea id="composition_analysis_bottom" name="composition_analysis_bottom" value="{!! old('composition_analysis_bottom') !!}" rows="8" />
          </x-form.group_lyt1_2_10>
          <x-form.group_lyt1_2_10 label="Myplexus feedback" for="feedback" error="{{ $errors->first('feedback') }}"  required="true">
            <x-form.field.text id="feedback" name="feedback" value="{!! old('feedback') !!}" rows="8" />
          </x-form.group_lyt1_2_10>

        

          @if( $fldsHide['c_order'] == $boolFalse )
          <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" error="{{ $errors->first('c_order') }}">
            <x-form.field.text id="c_order" name="c_order" value="{{ old('c_order') > 0 ? old('c_order') : '' }}" />
          </x-form.group_lyt1_2_10>
          @endif

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
@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('themes/backend/css/choosen.css')}}">
@endpush
@push('scripts')
<script src="{{asset('themes/backend/js/chosen.js')}}"></script>
<script>
  // File types validate
  $(".fund_name").chosen({no_results_text: "Oops, nothing found!",width: "100%"});

</script>
@endpush