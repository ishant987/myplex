@extends('themes.backend.layouts.app')
@section('dataTables') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('fund.nocor')  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('admin.fund.nocor.all_txt') }}</h5>
        @if($roleRights['delete'])
        @if( count( $dataListModel ) > 0 )
        <!-- Multi Delete -->
        <x-form.btn_multi_delete />
        &nbsp;
        @endif
        @endif
      </div>
      <div class="card-block">
        <!-- Show message. -->
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.fund.delete') }}">
          {{ csrf_field() }}
          <div class="table-responsive dt-responsive">
            <table id="dom-jqry" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  @if($roleRights['delete'])
                  @if( count( $dataListModel ) > 0 )
                  <th class="cc-w-35 no-sort-del">
                    <x-form.field.checkbox style="default" name="check_all" id="check_all" />
                  </th>
                  @endif
                  @endif
                  <th>{{ __('admin.fund.name_txt') }}</th>
                  <th class="cc-w-95">{{ __('admin.fund.code_txt') }}</th>
                  <th>{{ __('admin.fund.type_txt') }}</th>
                  <th class="cc-w-150">{{ __('admin.fund.term_txt') }}</th>
                  <th class="cc-w-70">{{ __('admin.fund.opened_txt') }}</th>
                  <th class="cc-w-150">{{ __('admin.mdfy_date_txt') }}</th>
                  <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
                </tr>
              </thead>
              <tbody>
                @if( count($dataListModel) > 0 )
                @foreach( $dataListModel as $key => $record )
                <tr role="row" class="">
                  @if($roleRights['delete'])
                  <td class="sorting_{{$key}">
                    <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->fund_id }}" fldclass="del-chkbx" />
                  </td>
                  @endif
                  <td>
                    @if($roleRights['edit'])
                    <x-link_tooltip url="{{ route('admin.fund.edit', $record->fund_id) }}" title="{{ $listDataAtrArr['edit_txt'] }}">
                      {{ $record->fund_name }}
                    </x-link_tooltip>
                    @else
                    {{ $record->fund_name }}
                    @endif
                  </td>
                  <td>{{ $record->fund_code }}</td>
                  <td>@if( $record->fundtype != null ){{ $record->fundtype->name }}@endif</td>
                  <td>@if( $record->fundterm != null ){{ $record->fundterm->term }}@endif</td>
                  <td>{{ $record->fund_opened }}</td>
                  <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)) }}</td>
                  <td>{{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="8">{{ __('message.data_not_available') }}</td>
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