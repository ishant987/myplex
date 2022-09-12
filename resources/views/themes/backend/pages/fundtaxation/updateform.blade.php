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

        <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.fund-taxation.update', $dataArr->ft_id) }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

          <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" error="{{ $errors->first('title') }}" required="true">
            <x-form.field.text id="title" name="title" value="{{ $dataArr->title }}" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="description" error="{{ $errors->first('description') }}" info="{!! __('admin.info.descp') !!}">
            <x-form.field.textarea id="description" name="description" value="{!! $dataArr->description !!}" rows="8" />
          </x-form.group_lyt1_2_10>

          <x-form.group_lyt1_2_10 label="{{ __('admin.file_txt') }}" for="file" error="{{ $errors->first('file') }}" info="{!! __('admin.info.def_pdf') !!}" required="false">
            @if($dataArr->file != '')
            <div class="m-b-10">
              <x-link_tooltip url="{{ $moduleAtrArr['media_folder'].$dataArr->file }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" class="f-30 m-b-10" placement="right">
                <i class="fa fa-file-pdf-o"></i>
              </x-link_tooltip>
            </div>
            @endif
            <x-form.field.file id="file" name="file" />
          </x-form.group_lyt1_2_10>

          @if( $fldsHide['c_order'] == $boolFalse )
          <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" error="{{ $errors->first('c_order') }}">
            <x-form.field.text id="c_order" name="c_order" value="{{ $dataArr->c_order > 0 ? $dataArr->c_order : '' }}" />
          </x-form.group_lyt1_2_10>
          @endif

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
@push('scripts')
<script>
  // File types validate
  var file = document.getElementById('file');
  file.onchange = function(e) {
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch (ext) {
      case 'pdf':
        break;
      default:
        alert('{{ __('
          message.warning.validate_file_type ') }}');
        this.value = '';
    }
  };
</script>
@endpush