@extends('themes.backend.layouts.app')
@section('dataTables') @stop

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['route'])  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ $editDataAtrArr['title'] }}</h5>
      </div>
      <div class="card-block">
        <!-- Show message. -->
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.aums.values.update') }}">
          {{ csrf_field() }}
          
          <div class="row">
            <div class="col-sm-5">
              <x-form.field.button_def type="submit" name="submit" value="save" text="{{ __('admin.save_new_txt') }}" class="btn btn-out-dashed waves-effect waves-light btn-primary btn-square" onclick="return confirm('{{ __('message.confirm.save') }}')?confirm('{{ __('message.confirm.click_ok_txt') }}'):false" />
            </div>
            <div class="col-sm-7">
              <div class="row">
                <div class="col-sm-5">
                  <x-form.group_lyt1_7_5 label="{{ __('admin.save_values_date_txt') }}" for="entry_date" error="{{ $errors->first('entry_date') }}" required="true">
                    <x-form.field.text id="entry_date" name="entry_date" value="{{ $otherData['save_value_date'] }}" readonly="readonly" class="def-date" />
                  </x-form.group_lyt1_7_5>
                </div>
                <div class="col-sm-7">
                  <div class="form-group has-primary row">
                    <label class="col-sm-3 col-form-label">{{ __('admin.last_save_txt') }}</label>
                    <div class="col-sm-9">
                      <div class="col-form-label">{{ $otherData['last_saved_date'] }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive dt-responsive">
            <table id="dom-jqry-all" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th>{{ __('admin.fund.name_txt') }}</th>
                  <th class="cc-w-150">{{ __('admin.fund.code_txt') }}</th>
                  <th class="cc-w-95">{{ __('admin.fund.aums.no_of_funds_txt') }}</th>
                  <th class="cc-w-95 no-sort">{{ __('admin.fund.aums.in_lacs_txt') }}</th>
                </tr>
              </thead>
              <tbody>
                @if( count($dataListModel) > 0 )
                @foreach( $dataListModel as $key => $record )
                <tr role="row">
                  <td>{{ $record->fund_name }}</td>
                  <td>{{ $record->fund_code }}</td>
                  <td>{{ $record->no }}</td>
                  <td>
                    <x-form.field.text id="aum_{{ $loop->iteration }}" name="aum[{{ $record->fund_code }}]" value="{{ $record->aum }}" />
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="4">{{ __('message.data_not_available') }}</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@stop