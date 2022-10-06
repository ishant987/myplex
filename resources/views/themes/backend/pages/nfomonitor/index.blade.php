@extends('themes.backend.layouts.app')
@section('dataTables') @stop

@section('breadcrumb')
    {{ Breadcrumbs::render('nfomonitor.index') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card m-b-0">
                <div class="card-header">
                    <h5>{{ __('admin.nfomonitor.all_txt') }}</h5>
                    @if ($roleRights['add'])
                        <!-- Add New -->
                        <x-link_add_new url="{{ route('admin.nfo-monitor.create') }}" />
                    @endif
                    @if ($roleRights['delete'])
                        @if (count($dataListModel) > 0)
                            <!-- Multi Delete -->
                            <x-form.btn_multi_delete />
                            &nbsp;
                        @endif
                    @endif
                </div>
                <div class="card-block">
                    <!-- Show message. -->
                    <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}"
                        message="{{ session()->get('message') }}" />
                    <form id="listDataForm" name="listDataForm" method="post"
                        action="{{ route('admin.nfo-monitor.delete') }}">
                        {{ csrf_field() }}
                        <div class="table-responsive dt-responsive">
                            <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        @if ($roleRights['delete'])
                                            @if (count($dataListModel) > 0)
                                                <th class="cc-w-35 no-sort-del">
                                                    <x-form.field.checkbox style="default" name="check_all"
                                                        id="check_all" />
                                                </th>
                                            @endif
                                        @endif
                                        <th>{{ __('admin.nfomonitor.fund_name') }}</th>
                                        <th>{{ __('admin.nfomonitor.ft_id') }}</th>
                                        <th class="cc-w-150">{{ __('admin.type_txt') }}</th>
                                        <th class="cc-w-150">{{ __('admin.nfomonitor.post_date') }}</th>
                                        <th class="cc-w-60 no-sort">{{ __('admin.status_txt') }}</th>
                                        <th class="cc-w-150">{{ __('admin.mdfy_date_txt') }}</th>
                                        <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($dataListModel) > 0)
                                        @foreach ($dataListModel as $key => $record)
                                            <tr role="row" class="">
                                                @if ($roleRights['delete'])
                                                    <td class="sorting_{{ $record->no_id }}">
                                                        <x-form.field.checkbox style="default" name="checkbox[]"
                                                            value="{{ $record->no_id }}" fldclass="del-chkbx" />
                                                    </td>
                                                @endif
                                                <td>
                                                    @if ($roleRights['edit'])
                                                        <x-link_tooltip
                                                            url="{{ route('admin.nfo-monitor.edit', $record->no_id) }}"
                                                            title="{{ $listDataAtrArr['edit_txt'] }}">
                                                            {{ $record->fund_name }}
                                                        </x-link_tooltip>
                                                    @else
                                                        {{ $record->fund_name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($record->fundtype != null)
                                                        {{ $record->fundtype->name }}
                                                    @endif
                                                </td>
                                                <td>{{ $record->type ? $moduleAtrArr['type']['text'][$record->type] : '' }}
                                                </td>
                                                <td>{{ $record->post_date }}</td>
                                                <td>
                                                    @if ($roleRights['edit'])
                                                        <label id="change_status{{ $record->no_id }}"
                                                            onclick="return changeStatus('no_id', {{ $record->no_id }}, 'nfo_offer', {{ $record->status }}, '{{ $statusAtrArr['status_type'] }}');"
                                                            class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }}">{{ $statusAtrArr['label'][$record->status] }}</label>
                                                    @else
                                                        <label
                                                            class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }} no-drop">{{ $statusAtrArr['label'][$record->status] }}</label>
                                                    @endif
                                                </td>
                                                <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)) }}
                                                </td>
                                                <td>{{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}
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
