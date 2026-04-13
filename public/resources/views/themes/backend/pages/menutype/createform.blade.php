@extends('themes.backend.layouts.app')
@section('breadcrumb')
{{ Breadcrumbs::render('menutype.create') }} 
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ __('admin.menutype.add_txt') }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            
            <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.menutype.store')}}" method="POST">
              {{ csrf_field() }}

              <x-form.group_lyt1_2_10 label="{{ __('admin.menutype.title_txt') }}" for="label" 
                  error="{{ $errors->first('label') }}" required="true">                  
                <x-form.field.text id="label" name="label" value="{{ old('label') }}" onblur="setSlugValue('label','menu_name');" />
              </x-form.group_lyt1_2_10>

              <x-form.group_lyt1_2_10 label="{{ __('admin.menutype.slug_txt') }}" for="menu_name"
                  error="{{ $errors->first('menu_name') }}" required="true" info="{{ __('admin.menutype.add_slug_info') }}">
                  <x-form.field.text id="menu_name" name="menu_name" value="{{ old('menu_name') }}" />
              </x-form.group_lyt1_2_10> 

              <x-form.group_lyt1_2_10 label="{{ __('admin.menutype.menufor_txt') }}" for="menu_for" 
                  error="{{ $errors->first('menu_for') }}" required="true" info="{{ __('admin.menutype.add_menufor_info') }}">
                <select id="menu_for" class="form-control" name="menu_for">
                  <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
                  @foreach( $menuforAssoc as $key => $name )
                  <option value="{{ $key }}" {{ $key == old('menu_for') ? 'selected' : '' }}>{{ $name }}</option>
                  @endforeach
                </select>
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