@extends('themes.backend.layouts.app')

@section('datetimeRangePicker') @stop

@section('breadcrumb')
    {{ Breadcrumbs::render('answer.index', $fltrDataArr['aeq_id']) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card m-b-0">
                <div class="card-header">
                    <h5>{{ __('askexpert.answer.all_txt') }}</h5>
                    <div class="c-f-btns">
                        <div class="c-f-b-f">
                            <!-- Filter -->
                            <x-form.btn_filter />
                            <!-- Reset -->
                            <x-form.btn_reset />
                        </div>
                        <div class="c-f-b-r">
                            @if ($roleRights['delete'])
                                @if (count($dataListModel) > 0)
                                    &nbsp;
                                    <!-- Multi Delete -->
                                    <x-form.btn_multi_delete />
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <!-- Show message. -->
                    <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}"
                        message="{{ session()->get('message') }}" />
                    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <form id="filterForm" name="filterForm" method="get" action="{{ route('admin.answer.index') }}">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="sw-entry">
                                        <label>
                                            {{ __('admin.sw_entry.show_txt') }}
                                            <select name="ppage" aria-controls="example" class="form-control"
                                                onchange="form.submit();">
                                                @foreach ($showEntryArr['value'] as $key => $option)
                                                    <option value="{{ $option }}"
                                                        {{ $option == $perPage ? 'selected' : '' }}>
                                                        {{ $showEntryArr['text'][$key] }}</option>
                                                @endforeach
                                            </select>
                                            {{ __('admin.sw_entry.entries_txt') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row f-right">
                                        <div class="col-md-6">
                                            <div class="sort-by">
                                                <label>
                                                    {{ __('admin.sort_txt') }}
                                                    <select name="sby" aria-controls="example" class="form-control"
                                                        onchange="form.submit();">
                                                        @foreach ($sortbyArr as $key => $sort)
                                                            <option value="{{ $key }}"
                                                                {{ $sortBy == $key ? 'selected' : '' }}>
                                                                {{ $sort }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="order-by">
                                                <label>
                                                    {{ __('admin.order_by_txt') }}
                                                    <select name="oby" aria-controls="example" class="form-control"
                                                        onchange="form.submit();">
                                                        @foreach ($orderbyArr as $key => $orderby)
                                                            <option value="{{ $key }}"
                                                                {{ strtolower($orderBy) == $key ? 'selected' : '' }}>
                                                                {{ $orderby }}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form id="listDataForm" name="listDataForm" method="post"
                        action="{{ route('admin.answer.delete') }}">
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
                                        <th>{{ $sortbyArr['answer'] }}</th>
                                        <th class="cc-w-60 no-sort">{{ __('admin.status_txt') }}</th>
                                        <th class="cc-w-150">{{ $sortbyArr['created_at'] }}</th>
                                        <th class="cc-w-150">{{ __('admin.added_user_txt') }}</th>
                                        <th class="cc-w-150">{{ $sortbyArr['updated_at'] }}</th>
                                        <th class="cc-w-95">{{ __('admin.mdfy_by_txt') }}</th>
                                        <th class="cc-w-150 no-sort">{{ __('admin.mdfy_user_txt') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @if ($roleRights['delete'])
                                            @if (count($dataListModel) > 0)
                                                <td></td>
                                            @endif
                                        @endif
                                        <td>
                                            <x-form.field.text id="far" name="far"
                                                value="{{ $fltrDataArr['answer'] ?? '' }}" />
                                        </td>
                                        <td>
                                            <select id="fst" class="form-control" name="fst">
                                                <option value=""
                                                    {{ !isset($fltrDataArr['status']) || $fltrDataArr['status'] == '' ? 'selected' : '' }}>
                                                    {{ $cFilterArr['all_txt'] }}</option>
                                                @foreach ($moduleAtrArr['status'] as $id => $status)
                                                    <option value="{{ $id }}"
                                                        {{ isset($fltrDataArr['status']) && $id == $fltrDataArr['status'] ? 'selected' : '' }}>
                                                        {{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <x-form.field.text id="fca" name="fca"
                                                value="{{ $fltrDataArr['created_at'] ?? '' }}" class="period" />
                                        </td>
                                        <td>
                                            <x-form.field.text id="fcu" name="fcu"
                                                value="{{ $fltrDataArr['created_user'] ?? '' }}" />
                                        </td>
                                        <td>
                                            <x-form.field.text id="fua" name="fua"
                                                value="{{ $fltrDataArr['updated_at'] ?? '' }}" class="period" />
                                        </td>
                                        <td>
                                            <select name="fub" id="fub" aria-controls="example" class="form-control">
                                                <option value="">{{ $cFilterArr['all_txt'] }}</option>
                                                @foreach ($moduleAtrArr['cu_by_val'] as $key => $fmbyVal)
                                                    <option value="{{ $fmbyVal }}"
                                                        @if ($fmbyVal == old('fub')) {{ 'selected' }} @elseif($fmbyVal == $fltrDataArr['updated_by']) {{ 'selected' }} @endif>
                                                        {{ $moduleAtrArr['cu_by_txt'][$fmbyVal] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @if (count($dataListModel) > 0)
                                        @foreach ($dataListModel as $key => $record)
                                            <tr role="row" class="">
                                                @if ($roleRights['delete'])
                                                    <td class="sorting_{{ $record->aeqa_id }}">
                                                        <x-form.field.checkbox style="default" name="checkbox[]"
                                                            value="{{ $record->aeqa_id }}" fldclass="del-chkbx" />
                                                    </td>
                                                @endif
                                                <td>
                                                    @if ($roleRights['edit'])
                                                        <x-link_tooltip
                                                            url="{{ route('admin.answer.edit', $record->aeqa_id) }}"
                                                            title="{{ $listDataAtrArr['edit_txt'] }}">
                                                            {!! \App\Lib\Core\Useful::getShortContent(strip_tags($record->answer), $moduleAtrArr['descp_char_lngth']) !!}
                                                        </x-link_tooltip>
                                                    @else
                                                        {!! \App\Lib\Core\Useful::getShortContent(strip_tags($record->answer), $moduleAtrArr['descp_char_lngth']) !!}
                                                    @endif
                                                </td>
                                                <td>
                                                    <label
                                                        class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }} no-drop">{{ $moduleAtrArr['status'][$record->status] }}</label>
                                                </td>
                                                <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->created_at)) }}
                                                </td>
                                                <td>
                                                    @if ($record->addedbyuser->f_name)
                                                        <x-link_tooltip
                                                            url="{{ route('admin.subscribeduser.edit', $record->addedbyuser->u_id) }}"
                                                            title="{{ $moduleAtrArr['view_txt'] }}"
                                                            target="{{ $moduleAtrArr['target'] }}">
                                                            {{ $record->addedbyuser->f_name . ' ' . $record->addedbyuser->l_name }}
                                                        </x-link_tooltip>
                                                    @else
                                                        {{ $listDataAtrArr['unknown_txt'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($record->updated_at != '')
                                                        {{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($record->updated_by != '')
                                                        {{ $moduleAtrArr['cu_by_txt'][$record->updated_by] ?? $listDataAtrArr['unknown_txt'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($record->updated_by != '')
                                                        @switch($record->updated_by)
                                                            @case($moduleAtrArr['cu_by_val'][1])
                                                                {{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}
                                                            @break

                                                            @case($moduleAtrArr['cu_by_val'][2])
                                                                {{ $record->updatedbyuser->f_name . ' ' . $record->updatedbyuser->l_name ?? $listDataAtrArr['unknown_txt'] }}
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </td>
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
                    {{ $dataListModel->appends($data)->links('vendor.pagination.app-admin') }}
                </div>
            </div>
        </div>
    </div>
@stop
@push('scripts')
    <script>
        /*Filter*/
        function filter() {
            var searchPagiData = "";
            var ftrFarVlu = document.getElementById("far").value;
            if (ftrFarVlu != "") {
                searchPagiData = searchPagiData + "&far=" + ftrFarVlu;
            }
            var ftrFstVlu = document.getElementById("fst").value;
            if (ftrFstVlu != "") {
                searchPagiData = searchPagiData + "&fst=" + ftrFstVlu;
            }
            var ftrFcaVlu = document.getElementById("fca").value;
            if (ftrFcaVlu != "") {
                searchPagiData = searchPagiData + "&fca=" + ftrFcaVlu;
            }
            var ftrFcuVlu = document.getElementById("fcu").value;
            if (ftrFcuVlu != "") {
                searchPagiData = searchPagiData + "&fcu=" + ftrFcuVlu;
            }
            var ftrFuaVlu = document.getElementById("fua").value;
            if (ftrFuaVlu != "") {
                searchPagiData = searchPagiData + "&fua=" + ftrFuaVlu;
            }
            var ftrFubVlu = document.getElementById("fub").value;
            if (ftrFubVlu != "") {
                searchPagiData = searchPagiData + "&fub=" + ftrFubVlu;
            }
            /*alert(searchPagiData);*/
            window.location.href = "{{ route('admin.answer.list', $fltrDataArr['aeq_id']) }}" + "?page=0" +
                searchPagiData + "&ppage=" + "{{ $perPage }}";
            return false;
        }
        /*Reset Filter*/
        function resetfilter() {
            window.location.href = "{{ route('admin.answer.list', $fltrDataArr['aeq_id']) }}";
        }
    </script>
@endpush
