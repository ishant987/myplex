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

            <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.fundtype.update', $dataArr->ft_id) }}" method="POST">
               {{ csrf_field() }}
               {{ method_field('PATCH') }}

               <x-form.group_lyt1_2_10 label="{{ __('admin.fundtype.name_txt') }}" for="name" error="{{ $errors->first('name') }}" required="true">
                  <x-form.field.text id="name" name="name" value="{{ $dataArr->name }}" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.fundtype.active_passive_txt') }}" for="active_passive" error="{{ $errors->first('active_passive') }}" required="true">
                  <select name="active_passive" id="active_passive" class="form-control">
                     <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                     @foreach($moduleAtrArr['active_passive'] as $key => $activePassive)
                     <option value="{{ $key }}" @if( $key==old('active_passive') ) {{ 'selected' }} @elseif( $key==$dataArr->active_passive ) {{ 'selected' }} @endif>{{ $activePassive }}</option>
                     @endforeach
                  </select>
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.fundtype.monthly_performance_txt') }}" for="monthly_performance" error="{{ $errors->first('monthly_performance') }}" required="true">
                  <select name="monthly_performance" id="monthly_performance" class="form-control">
                     <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                     @foreach($moduleAtrArr['monthly_performance'] as $key => $monthlyPerformance)
                     <option value="{{ $key }}" @if( $key==old('monthly_performance') ) {{ 'selected' }} @elseif( $key==$dataArr->monthly_performance ) {{ 'selected' }} @endif>{{ $monthlyPerformance }}</option>
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