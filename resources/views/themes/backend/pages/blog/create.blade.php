@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('faq.create') }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text">{{ __('faq.add_txt') }}</h5>
      </div>
      <div class="card-block">

        <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.blog.store')}}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="text" name="created_by" id="" value="{{$data['adminID']}}" hidden>
          <input type="text" name="updated_id" id="" value="{{$data['adminID']}}" hidden>
          <x-form.group_lyt1_2_10 label="{{ __('blog.title_txt') }}" for="category" error="{{ $errors->first('category') }}" required="true">
            <x-form.field.text id="category" name="category" value="{{ old('category') }}" />
          </x-form.group_lyt1_2_10>
          <x-form.group_lyt1_2_10 label="{{ __('blog.heading') }}" for="heading" error="{{ $errors->first('heading') }}" required="true">
            <x-form.field.text id="heading" name="heading" value="{{ old('heading') }}" />
          </x-form.group_lyt1_2_10>
          <x-form.group_lyt1_2_10 label="{{ __('blog.sub_heading') }}" for="sub_heading" error="{{ $errors->first('sub_heading') }}" required="true">
            <x-form.field.text id="sub_heading" name="sub_heading" value="{{ old('sub_heading') }}" />
          </x-form.group_lyt1_2_10>
          
          <x-form.group_lyt1_2_10 label="{{ __('blog.description_txt') }}" for="description" error="{{ $errors->first('description') }}" info="{!! __('admin.info.description') !!}" required="true">
            <x-form.field.textarea id="description" name="description" value="{!! old('description') !!}" class="editor_full"/>
          </x-form.group_lyt1_2_10>
          
          <x-form.group_lyt1_2_10 label="Select sub category" for="sub_category" 
                error="{{ $errors->first('sub_category') }}" required="true">
            <select id="sub_category" class="form-control" name="sub_category">
                <option value="">--Select--</option>
                @foreach( ['highlighted_posts' => 'Highlighted Posts', 'editors_pick' => 'Editor picks', 'must_read'=> 'Must Read'] as  $key=>$value )
                <option value="{{ $key }}"> {{$value}}</option>
                @endforeach
            </select>
            </x-form.group_lyt1_2_10>
          
          
          <x-form.group_lyt1_2_10 label="{{ __('blog.image_banner') }}" for="image_banner" error="{{ $errors->first('image_banner') }}" required="true">
            <x-form.field.file id="image_banner" name="image_banner" value="{{ old('image_banner') }}" />
          </x-form.group_lyt1_2_10>
          <x-form.group_lyt1_2_10 label="{{ __('blog.image_thumb') }}" for="image_thumb" error="{{ $errors->first('image_thumb') }}" required="true">
            <x-form.field.file id="image_thumb" name="image_thumb" value="{{ old('image_thumb') }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('blog.author') }}" for="author" error="{{ $errors->first('author') }}" required="true">
            <x-form.field.text id="author" name="author" value="{{ old('author') }}" />
          </x-form.group_lyt1_2_10>
          <x-form.group_lyt1_2_10 label="{{ __('blog.tags') }}" for="tags" error="{{ $errors->first('tags') }}" required="true">
            <x-form.field.text id="tags" name="tags" value="{{ old('tags') }}" />
          </x-form.group_lyt1_2_10>


          <x-form.group_lyt1_2_10 label="{{ __('blog.status_txt') }}" for="is_active" error="{{ $errors->first('is_active') }}" required="true">
            <select id="is_active" class="form-control" name="is_active">
              @foreach( [1 => 'Enable', 2=> 'Disable'] as $id => $status )
              <option value="{{ $id }}" {{ ( $id == old('is_active') ) ? 'selected' : '' }}>{{ $status }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('blog.is_cta') }}" for="cta_required" error="{{ $errors->first('cta_required') }}" required="true">
            <select id="is_cta" class="form-control" name="is_cta">
              @foreach( [ 1=> 'Yes', 0 => 'No'] as $id => $status )
              <option value="{{ $id }}" {{ ( $id == old('status') ) ? 'selected' : '' }}>{{ $status }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>
          
          <x-form.group_lyt1_2_10 label="{{ __('blog.cta_required_url') }}" for="tags" error="{{ $errors->first('cta_required_url') }}">
            <x-form.field.text id="cta_required_url" name="cta_required_url" value="{{ old('cta_required_url') }}" />
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