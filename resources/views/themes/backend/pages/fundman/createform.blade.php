@extends('themes.backend.layouts.app')
@section('editor') @stop
@section('fancybox') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('fundman.create') }}
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ __('admin.fundman.add_txt') }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

            <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.fund-man.store')}}" method="POST">
               {{ csrf_field() }}

               <x-form.group_lyt1_2_10 label="{{ __('common.name_txt') }}" for="name" error="{{ $errors->first('name') }}" required="true">
                  <x-form.field.text id="name" name="name" value="{{ old('name') }}" onblur="setSlugValue('name');" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.slug_txt') }}" for="slug" error="{{ $errors->first('slug') }}" required="true" info="{{ __('admin.info.add_slug') }}">
                  <x-form.field.text id="slug" name="slug" value="{{ old('slug') }}" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.prof_pic_txt') }}" for="media_id" error="{{ $errors->first('media_id') }}" info="{!! __('admin.info.prof_pic') !!}">
                  <div class="media_img_area">
                     <x-link_media_popup href="0" src="{{ route('admin.media.gallery', 0) }}">
                        {{ __('admin.browse_media_txt') }}
                     </x-link_media_popup>
                     <x-form.field.hidden value="" name="media_id" id="featuredImgVal-0" />
                     <x-form.field.button_def class="btn-danger btn-mini waves-effect waves-light remove_featured show-scn m-t-10 d-none" id="featuredImgRemov-0" text="{{ __('admin.remove_media_txt') }}" />
                  </div>
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.designation_txt') }}" for="designation" error="{{ $errors->first('designation') }}">
                  <x-form.field.text id="designation" name="designation" value="{{ old('designation') }}" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.company_txt') }}" for="company_name" error="{{ $errors->first('company_name') }}">
                  <x-form.field.text id="company_name" name="company_name" value="{{ old('company_name') }}" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.fundman.synopsis_txt') }}" for="synopsis" error="{{ $errors->first('synopsis') }}" info="{!! __('admin.info.descp') !!}">
                  <x-form.field.textarea id="synopsis" name="synopsis" value="{!! old('synopsis') !!}" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="description" error="{{ $errors->first('description') }}">
                  <x-form.field.textarea id="description" name="description" value="{!! old('description') !!}" class="editor_full" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.fundman.disclaimer_txt') }}" for="disclaimer" error="{{ $errors->first('disclaimer') }}">
                  <x-form.field.textarea id="disclaimer" name="disclaimer" value="{!! old('disclaimer') !!}" class="editor_full" />
               </x-form.group_lyt1_2_10>

               <x-form.group_lyt1_2_10 label="{{ __('admin.fundman.disclaimer_note_txt') }}" for="disclaimer_note" error="{{ $errors->first('disclaimer_note') }}" info="{!! __('admin.info.descp') !!}">
                  <x-form.field.textarea id="disclaimer_note" name="disclaimer_note" value="{!! old('disclaimer_note') !!}" />
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