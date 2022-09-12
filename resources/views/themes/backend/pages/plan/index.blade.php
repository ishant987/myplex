@extends('themes.backend.layouts.app')
@section('dataTables') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('plan.index')  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('plan.all_txt') }}</h5>
        @if($roleRights['add'])
        <!-- Add New -->
        <x-link_add_new url="{{ route('admin.plan.create') }}" />
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
        <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.plan.delete') }}">
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
                  <th>{{ __('plan.name_txt') }}</th>
                  <th class="cc-w-70">{{ __('plan.type_txt') }}</th>
                  <th class="cc-w-70">{{ __('plan.amount_txt') }}</th>
                  <th class="cc-w-70">{{ __('plan.duration_txt') }}</th>
                  <th>{{ __('plan.duration_name_txt') }}</th>
                  <th class="cc-w-70">{{ __('plan.free_trial_txt') }}</th>
                  <th class="cc-w-60">{{ __('admin.order_txt') }}</th>
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
                  <td class="sorting_{{ $record->p_id }}">
                    <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->p_id }}" fldclass="del-chkbx" />
                  </td>
                  @endif
                  <td>
                    @if($roleRights['edit'])
                    <x-link_tooltip url="{{ route('admin.plan.edit', $record->p_id) }}" title="{{ $listDataAtrArr['edit_txt'] }}">
                      {{ $record->plan_name }}
                    </x-link_tooltip>
                    @else
                    {{ $record->plan_name }}
                    @endif
                  </td>
                  <td>{{ $moduleAtrArr['plan_type']['text'][$record->plan_type] }}</td>
                  <td>{{ number_format($record->amount, 2) }}</td>
                  <td>{{ $record->duration > 0 ? $record->duration : '' }}</td>
                  <td>{{ $record->duration_name }}</td>
                  <td>{{ $moduleAtrArr['yes_no'][$record->free_trial] }}</td>
                  <td>{{ $record->c_order > 0 ? $record->c_order : '' }}</td>
                  <td>
                    @if($roleRights['edit'])
                    <label id="change_status{{ $record->p_id }}" onclick="return changeStatus('p_id', '{{ $record->p_id }}', 'plans', '{{ $record->status }}', '{{ $statusAtrArr["status_type"] }}');" class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }}">{{ $statusAtrArr['label'][$record->status] }}</label>
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
                  <td colspan="11">{{ __('message.data_not_available') }}</td>
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