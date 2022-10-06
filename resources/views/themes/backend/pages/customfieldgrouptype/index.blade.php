@extends('themes.backend.layouts.app')
@section('dataTables') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('customfield.index')  }} 
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5>{{ __('admin.page.all_txt') }}</h5>
                @if($roleRights['add'])
                    <!-- Add New -->
                    <x-link_add_new url="{{ route('admin.customfield.create') }}" />
                @endif
                @if($roleRights['delete'])
                    @if( count( $dataListModel ) > 0 )
                    <!-- Multi Delete -->
                    <x-form.btn_multi_delete />
                    @endif    
                @endif 
            </div>
            <div class="card-block">
                <!-- Show message. -->
                <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.deletecustomfield') }}">
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
                                <th class="cc-w-60">{{ __('admin.order_txt') }}</th>
                                <th class="cc-w-60 no-sort">{{ __('admin.status_txt') }}</th>
                                <th class="cc-w-150">{{ __('admin.mdfy_date_txt') }}</th>
                                <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
                                <th class="cc-w-95 no-sort">{{ __('admin.action_txt') }}</th>
                                </tr>
                            </thead>
                            <tbody>      
                                @if( count($dataListModel) > 0 )       
                                @foreach( $dataListModel as $key => $record )
                                <tr role="row" class="">
                                @if($roleRights['delete'])
                                    <td class="sorting_{{ $record->cf_group_id }}">
                                    <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->cf_group_id }}" fldclass="del-chkbx" />
                                    </td>
                                @endif
                                <td>
                                @if($roleRights['edit'])
                                    <x-link_tooltip url="{{ route('admin.customfield.edit', [$record->cf_group_id]) }}" title="">
                                    {{ $record->title }}
                                    </x-link_tooltip>
                                @else
                                    {{ $record->title }}
                                @endif
                                </td>
                                <td>{{ $record->c_order > 0 ? $record->c_order : '' }}</td>
                                <td>
                                    @if($roleRights['edit'])
                                    <label id="change_status{{ $record->cf_group_id }}" onclick="return changeStatus('cf_group_id', {{ $record->cf_group_id }}, 'custom_field_group', {{ $record->status }}, '{{ $statusAtrArr['status_type'] }}');" class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }}">{{ $statusAtrArr['label'][$record->status] }}</label>
                                    @else
                                    <label id="change_status{{ $record->cf_group_id }}" class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }} no-drop">{{ $statusAtrArr['label'][$record->status] }}</label>
                                    @endif                                   
                                </td>
                                <td>{{ strtotime($record->updated_at)?date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)):'' }}</td>
                                <td>{{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}</td>
                                <td>
                                    <x-link_tooltip url="{{ route('admin.customfield.show', $record->cf_group_id) }}" title="List" class="f-20" placement="left">
                                        <i class="ti-view-list"></i>
                                    </x-link_tooltip>
                                </td>
                                </tr>
                                @endforeach    
                                @else
                                    <tr>
                                        <td colspan="9">{{ __('message.data_not_available') }}</td>
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