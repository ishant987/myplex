@extends('themes.backend.layouts.app')

@section('datetimePicker') @endsection

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['route']) }}
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

        <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.currency.values.update') }}" method="POST">
          {{ csrf_field() }}

          @if( count($dataListModel) > 0 )

          <x-form.group_lyt1_2_10 label="{{ __('admin.save_values_date_txt') }}" for="entry_date" error="{{ $errors->first('entry_date') }}" required="true">
            <x-form.field.text id="entry_date" name="entry_date" value="" class="def-date" />
          </x-form.group_lyt1_2_10>
          
          <div class="form-group has-primary row">
            <label class="col-sm-2 col-form-label">{{ __('admin.currency.last_save_txt') }}</label>
            <div class="col-sm-10">
              <div class="col-form-label">{{ $otherData['last_saved_cur'] }}</div>
            </div>
          </div>

          <x-form.section_label>
            {{ __('admin.currency.all_txt') }}
          </x-form.section_label>
          @foreach( $dataListModel as $key => $record )
          <x-form.group_lyt1_2_10 label="{{ $record->name }}">
            <x-form.field.text id="entry_value_{{ $record->cm_id }}" name="entry_value[{{ $record->cm_id }}]" value="{{ $record->entry_value }}" />
          </x-form.group_lyt1_2_10>
          @endforeach
          <div class="row">
            <div class="col-sm-12">
              <x-form.group_lyt1_2_10 class="m-t-10">
                <x-form.field.button id="submit" name="submit" onclick="return confirm('{{ __('message.confirm.save') }}')" />
                <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}" onclick="return confirm('{{ __('message.confirm.cancel') }}')" />
              </x-form.group_lyt1_2_10>
            </div>
          </div>
          @else
          <p>{{ __('message.data_not_available') }}</p>
          @endif
        </form>
      </div>
      <!-- end of card-block -->
    </div>
  </div>
</div>
@stop
@push('scripts')
<script>
  $(function() {
    $("#entry_date[value='']").datepicker("setDate", "0d");
  });
</script>
@endpush