@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['route'], $editDataAtrArr['title']) }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ $editDataAtrArr['title'] }}</h5>
      </div>
      <div class="card-block">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

        

        <form name="eDataFrm" id="eDataFrm" action="{{ route($editDataAtrArr['postroute']) }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}

          @if( !empty( $dataObj ) )
          @foreach( $dataObj as $key => $record )
          @switch($record->field_type)
          @case('image')
          <x-form.group_lyt1_2_10 label="{{ $record->field_label }}" for="{{ $record->option_key }}" error="{{ $errors->first($record->option_key) }}" info="{!! $record->field_info !!}" required="{{ $record->is_required }}">
            @if($record->option_value)
            <div class="m-b-10">
              <x-link_tooltip url="{{ $moduleAtrArr['media_folder'].$record->option_value }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" placement="right">
                <x-img src="{{ $moduleAtrArr['media_folder'].$record->option_value }}" width="{{ $moduleAtrArr['img_width']['big'] }}" class="img-fluid img-thumbnail img-150" />
              </x-link_tooltip>
            </div>
            @if($record->is_required == 'n')
            <x-link class="btn waves-effect waves-light delLink btn-danger btn-mini m-b-10 delLink" url="{{ route('admin.settings.deletefile', $record->option_id) }}">
              {{ $moduleAtrArr['remove_txt'] }}
            </x-link>
            @endif
            @endif
            <x-form.field.file id="{{ $record->option_key }}" name="{{ $record->option_key }}" />
          </x-form.group_lyt1_2_10>
          @break
          @case('text')
          <x-form.group_lyt1_2_10 label="{{ $record->field_label }}" for="{{ $record->option_key }}" error="{{ $errors->first($record->option_key) }}" info="{!! $record->field_info !!}" required="{{ $record->is_required }}">
            <x-form.field.text id="{{ $record->option_key }}" name="{{ $record->option_key }}" value="{{ $record['option_value'] }}" />
          </x-form.group_lyt1_2_10>
          @break
          @case('textarea')
          <x-form.group_lyt1_2_10 label="{{ $record->field_label }}" for="{{ $record->option_key }}" error="{{ $errors->first($record->option_key) }}" info="{!! $record->field_info !!}" required="{{ $record->is_required }}">
            <x-form.field.textarea id="{{ $record->option_key }}" name="{{ $record->option_key }}" value="{!! $record['option_value'] !!}" />
          </x-form.group_lyt1_2_10>
          @break
          @case('editor')
          <x-form.group_lyt1_2_10 label="{{ $record->field_label }}" for="{{ $record->option_key }}" error="{{ $errors->first($record->option_key) }}" info="{!! $record->field_info !!}" required="{{ $record->is_required }}">
            <x-form.field.textarea id="{{ $record->option_key }}" name="{{ $record->option_key }}" value="{!! $record['option_value'] !!}" />
          </x-form.group_lyt1_2_10>
          @break
          @case('radio')
          <x-form.group_lyt1_2_10_radio label="{{ $record->field_label }}" for="{{ $record->option_key }}" error="{{ $errors->first($record->option_key) }}" info="{!! $record->field_info !!}" required="{{ $record->is_required }}">
            @foreach( json_decode($record->options_value) as $key => $value )
            <x-form.field.radio id="{{ $record->option_key }}{{ $key }}" name="{{ $record->option_key }}" label="{{ json_decode($record->options_label)[$key] }}" value="{{ $value }}" checked="{{ $record['option_value'] }}" />
            @endforeach
          </x-form.group_lyt1_2_10_radio>
          @break
          @case('dropdown')
          <x-form.group_lyt1_2_10 label="{{ $record->field_label }}" for="{{ $record->option_key }}" error="{{ $errors->first($record->option_key) }}" info="{!! $record->field_info !!}" required="{{ $record->is_required }}">
            <select id="{{ $record->option_key }}" class="form-control" name="{{ $record->option_key }}">
              <option value="">{{ $moduleAtrArr['def_drop_optn'] }}</option>
              @foreach( json_decode($record->options_value) as $key => $value )
              <option value="{{ $value }}" @if($value==$record['option_value']) selected="selected" @endif>{{ json_decode($record->options_label)[$key] }}</option>
              @endforeach
            </select>
          </x-form.group_lyt1_2_10>
          @break
          @endswitch
          @endforeach
          @endif
          <div class="row">
            <div class="col-sm-12">
              <x-form.group_lyt1_2_10 class="m-t-10">
                <x-form.field.button id="submit" name="submit" />
                <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}" />
              </x-form.group_lyt1_2_10>
            </div>
          </div>

      </div>
    </div>
  </div>
</div>
@stop
