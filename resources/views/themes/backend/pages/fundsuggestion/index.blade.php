@extends('themes.backend.layouts.app')
@section('dataTables') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('fundsuggestion.index') }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('admin.fundsuggestion.all_txt') }}</h5>
        @if($roleRights['add'])
        <!-- Add New -->
        <x-link_add_new url="{{ route('admin.fund-suggestion.create') }}" />
        @endif
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
        <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.fund-suggestion.delete') }}">
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
                  <th>{{ __('admin.title_txt') }}</th>
                  <th class="cc-w-70 no-sort">{{ __('admin.file_txt') }}</th>
                  @if( $fldsHide['c_order'] == $boolFalse )
                  <th class="cc-w-60">{{ __('admin.order_txt') }}</th>
                  @endif
                  <th class="cc-w-60 no-sort">{{ __('admin.status_txt') }}</th>
                  <th class="cc-w-150">{{ __('admin.mdfy_date_txt') }}</th>
                  <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
                </tr>
              </thead>
              <tbody>
                @if( count($dataListModel) > 0 )
                @foreach( $dataListModel as $key => $record )
                <tr role="row" class="">
                  @if($roleRights['delete'])
                  <td class="sorting_{{ $record->fs_id }}">
                    <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->fs_id }}" fldclass="del-chkbx" />
                  </td>
                  @endif
                  <td>
                    @if($roleRights['edit'])
                    <x-link_tooltip url="{{ route('admin.fund-suggestion.edit', $record->fs_id) }}" title="{{ $listDataAtrArr['edit_txt'] }}">
                      {{ $record->title }}
                    </x-link_tooltip>
                    @else
                    {{ $record->title }}
                    @endif
                  </td>
                  <td>
                    @if( $record->file != '' )
                    <x-link_tooltip url="{{ $moduleAtrArr['media_folder'].$record->file }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" class="f-30 m-b-10" placement="right">
                      <i class="fa fa-file-pdf-o"></i>
                    </x-link_tooltip>
                    @endif
                  </td>
                  @if( $fldsHide['c_order'] == $boolFalse )
                  <td>{{ $record->c_order > 0 ? $record->c_order : '' }}</td>
                  @endif
                  <td>
                    @if($roleRights['edit'])
                    <label id="change_status{{ $record->fs_id }}" onclick="return changeStatus('fs_id', {{ $record->fs_id }}, 'fund_suggestion', {{ $record->status }}, '{{ $statusAtrArr['status_type'] }}');" class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }}">{{ $statusAtrArr['label'][$record->status] }}</label>
                    @else
                    <label class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }} no-drop">{{ $statusAtrArr['label'][$record->status] }}</label>
                    @endif
                  </td>
                  <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)) }}</td>
                  <td>{{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="7">{{ __('message.data_not_available') }}</td>
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