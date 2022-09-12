@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('template.create') }} 
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ __('admin.template.add_txt') }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            
            <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.template.store')}}" method="POST">
              {{ csrf_field() }}

              <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" 
                  error="{{ $errors->first('title') }}" required="true">
                  <x-form.field.text id="title" name="title" value="{{ old('title') }}" onblur="setSlugValue();" />
              </x-form.group_lyt1_2_10>

              <x-form.group_lyt1_2_10 label="{{ __('admin.slug_txt') }}" for="slug" error="{{ $errors->first('slug') }}" required="true" info="{{ __('admin.info.add_slug') }}">
                  <x-form.field.text id="slug" name="slug" value="{{ old('slug') }}" />
              </x-form.group_lyt1_2_10>

              @if( $fldsHide['descp'] == $boolFalse )
              <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="descp" 
                  error="{{ $errors->first('descp') }}">
                  <x-form.field.textarea id="descp" name="descp" value="{!! old('descp') !!}" />
              </x-form.group_lyt1_2_10>
              @endif   

               <x-form.group_lyt1_2_10 label="{{ __('admin.template.class_name_txt') }}" for="class_id" 
                  error="{{ $errors->first('class_id') }}" required="true">
                <select id="class_id" class="form-control" name="class_id">
                  <option value="">--select--</option>
                  @foreach( $templatesArr as $id => $className )
                  <option value="{{ $id }}" {{ ( $id == old('class_id') ) ? 'selected' : '' }}>{{ $className }}</option>
                  @endforeach
                </select>
              </x-form.group_lyt1_2_10>
              
              @if( $fldsHide['c_order'] == $boolFalse )
              <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" 
                  error="{{ $errors->first('c_order') }}">
                  <x-form.field.text id="c_order" name="c_order" value="{{ old('c_order') > 0 ? old('c_order') : '' }}" />
              </x-form.group_lyt1_2_10>
              @endif       

              <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="status" 
                  error="{{ $errors->first('status') }}" required="true">
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