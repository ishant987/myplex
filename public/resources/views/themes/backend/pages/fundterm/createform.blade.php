@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('fundterm.create') }} 
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ __('admin.fundterm.add_txt') }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            
            <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.fundterm.store')}}" method="POST">
              {{ csrf_field() }}

              <x-form.group_lyt1_2_10 label="{{ __('admin.fundterm.term_txt') }}" for="term" error="{{ $errors->first('term') }}" required="true">
                  <x-form.field.text id="term" name="term" value="{{ old('term') }}" />
              </x-form.group_lyt1_2_10>

              <x-form.group_lyt1_2_10 label="{{ __('admin.fundterm.days_txt') }}" for="days" error="{{ $errors->first('days') }}" required="true">
                  <x-form.field.text type="number" id="days" name="days" value="{{ old('days') }}" />
              </x-form.group_lyt1_2_10>

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