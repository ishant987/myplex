@extends('themes.backend.layouts.app')
@section('datetimeRangePicker') @stop

@section('breadcrumb')
    {{ Breadcrumbs::render('question.index') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card m-b-0">
                <div class="card-header">
                    <h5>{{ __('askexpert.question.all_txt') }}</h5>
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
                        <form id="filterForm" name="filterForm" method="get" action="{{ route('admin.question.index') }}">
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
                        action="{{ route('admin.question.delete') }}">
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
                                        <th>{{ $sortbyArr['question'] }}</th>
                                        <th>{{ $sortbyArr['topic'] }}</th>
                                        <th class="cc-w-60 no-sort">{{ __('admin.status_txt') }}</th>
                                        <th class="cc-w-150">{{ $sortbyArr['created_at'] }}</th>
                                        <th class="cc-w-150">{{ __('admin.added_user_txt') }}</th>
                                        <th class="cc-w-150">{{ $sortbyArr['updated_at'] }}</th>
                                        <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
                                        <th class="cc-w-35">{{ __('admin.action_txt') }}</th>
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
                                            <x-form.field.text id="fqn" name="fqn"
                                                value="{{ $fltrDataArr['question'] ?? '' }}" />
                                        </td>
                                        <td>
                                            <x-form.field.text id="ftc" name="ftc"
                                                value="{{ $fltrDataArr['topic'] ?? '' }}" />
                                        </td>
                                        <td>
                                            <select id="fst" class="form-control" name="fst">
                                                <option value=""
                                                    {{ !isset($fltrDataArr['status']) || $fltrDataArr['status'] == '' ? 'selected' : '' }}>
                                                    {{ $cFilterArr['all_txt'] }}</option>
                                                @foreach ($statusAtrArr['label'] as $id => $status)
                                                    <option value="{{ $id }}"
                                                        {{ isset($fltrDataArr['status']) && $id == $fltrDataArr['status'] ? 'selected' : '' }}>
                                                        {{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <x-form.field.text id="fct" name="fct"
                                                value="{{ $fltrDataArr['created_at'] ?? '' }}" class="period" />
                                        </td>
                                        <td>
                                            <x-form.field.text id="fcu" name="fcu"
                                                value="{{ $fltrDataArr['created_user'] ?? '' }}" />
                                        </td>
                                        <td>
                                            <x-form.field.text id="fut" name="fut"
                                                value="{{ $fltrDataArr['updated_at'] ?? '' }}" class="period" />
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @if (count($dataListModel) > 0)
                                        @foreach ($dataListModel as $key => $record)
                                            <tr role="row" class="">
                                                @if ($roleRights['delete'])
                                                    <td class="sorting_{{ $record->aeq_id }}">
                                                        <x-form.field.checkbox style="default" name="checkbox[]"
                                                            value="{{ $record->aeq_id }}" fldclass="del-chkbx" />
                                                    </td>
                                                @endif
                                                <td>
                                                    @if ($roleRights['edit'])
                                                        <x-link_tooltip
                                                            url="{{ route('admin.question.edit', $record->aeq_id) }}"
                                                            title="{{ $listDataAtrArr['edit_txt'] }}">
                                                            {!! \App\Lib\Core\Useful::getShortContent(strip_tags($record->question), $moduleAtrArr['descp_char_lngth']) !!}
                                                        </x-link_tooltip>
                                                    @else
                                                        {!! \App\Lib\Core\Useful::getShortContent(strip_tags($record->question), $moduleAtrArr['descp_char_lngth']) !!}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($record->topic != null)
                                                        <x-link_tooltip
                                                            url="{{ route('admin.topic.edit', $record->aet_id) }}"
                                                            title="{{ $moduleAtrArr['view_txt'] }}"
                                                            target="{{ $moduleAtrArr['target'] }}">
                                                            {{ $record->topic }}
                                                        </x-link_tooltip>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($roleRights['edit'])
                                                        <label id="change_status{{ $record->aeq_id }}"
                                                            onclick="return changeStatus('aeq_id', {{ $record->aeq_id }}, 'ask_expert_question', {{ $record->status }}, '{{ $statusAtrArr['status_type'] }}');"
                                                            class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }}">{{ $statusAtrArr['label'][$record->status] }}</label>
                                                    @else
                                                        <label
                                                            class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }} no-drop">{{ $statusAtrArr['label'][$record->status] }}</label>
                                                    @endif
                                                </td>
                                                <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->created_at)) }}
                                                </td>
                                                <td>
                                                    @if ($record->addedbyuser != null)
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
                                                    @if ($record->updated_id > 0)
                                                        {{ $record->updatedbyadmin->display_name ?? $listDataAtrArr['unknown_txt'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <x-link_tooltip
                                                        url="{{ route('admin.answer.list', $record->aeq_id) }}"
                                                        title="{{ $moduleAtrArr['answer_list_txt'] }}"
                                                        target="{{ $moduleAtrArr['target'] }}" class="f-20"
                                                        placement="left">
                                                        <i class="ti-view-list"></i>
                                                    </x-link_tooltip>
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
            var ftrFqnVlu = document.getElementById("fqn").value;
            if (ftrFqnVlu != "") {
                searchPagiData = searchPagiData + "&fqn=" + ftrFqnVlu;
            }
            var ftrFtcVlu = document.getElementById("ftc").value;
            if (ftrFtcVlu != "") {
                searchPagiData = searchPagiData + "&ftc=" + ftrFtcVlu;
            }
            var ftrFstVlu = document.getElementById("fst").value;
            if (ftrFstVlu != "") {
                searchPagiData = searchPagiData + "&fst=" + ftrFstVlu;
            }
            var ftrFctVlu = document.getElementById("fct").value;
            if (ftrFctVlu != "") {
                searchPagiData = searchPagiData + "&fct=" + ftrFctVlu;
            }
            var ftrFcuVlu = document.getElementById("fcu").value;
            if (ftrFcuVlu != "") {
                searchPagiData = searchPagiData + "&fcu=" + ftrFcuVlu;
            }
            var ftrFutVlu = document.getElementById("fut").value;
            if (ftrFutVlu != "") {
                searchPagiData = searchPagiData + "&fut=" + ftrFutVlu;
            }
            /*alert(searchPagiData);*/
            window.location.href = "{{ route('admin.question.index') }}" + "?page=0" + searchPagiData + "&ppage=" +
                "{{ $perPage }}";
            return false;
        }
        /*Reset Filter*/
        function resetfilter() {
            window.location.href = "{{ route('admin.question.index') }}";
        }
    </script>
@endpush
