@extends('themes.backend.layouts.app')

@section('datetimeRangePicker') @endsection

@section('breadcrumb')
{{ Breadcrumbs::render('fund.index')  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('admin.fund.all_txt') }}</h5>
        <div class="c-f-btns">
          <div class="c-f-b-f">
            <!-- Filter -->
            <x-form.btn_filter />
            <!-- Reset -->
            <x-form.btn_reset />
          </div>
          <div class="c-f-b-r">
            <x-link url="{{ route('admin.fund.nocor') }}" class="b-b-primary text-primary sctn-link-right">
              {{ __('admin.fund.nocor.label_txt') }}
            </x-link>
            @if($roleRights['add'])
            <!-- Add New -->
            <x-link_add_new url="{{ route('admin.fund.create') }}" />
            @endif

            @if($roleRights['delete'])
            @if( count( $dataListModel ) > 0 )
            &nbsp;
            <!-- Multi Delete -->
            <x-form.btn_multi_delete message="{{ __('message.confirm.del_related_data_too') }}" />
            @endif
            @endif
          </div>
        </div>
      </div>
      <div class="card-block">
        <!-- Show message. -->
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
          <form id="filterForm" name="filterForm" method="get" action="{{ route('admin.fund.index') }}">
            <div class="row align-items-center">
              <div class="col-md-3">
                <div class="sw-entry">
                  <label>
                    {{ __('admin.sw_entry.show_txt') }}
                    <select name="ppage" aria-controls="example" class="form-control" onchange="form.submit();">
                      @foreach($showEntryArr['value'] as $key => $option)
                      <option value="{{ $option }}" {{ $option == $perPage ? 'selected' : '' }}>{{ $showEntryArr['text'][$key] }}</option>
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
                        <select name="sby" aria-controls="example" class="form-control" onchange="form.submit();">
                          @foreach($sortbyArr as $key=>$sort)
                          <option value="{{ $key }}" {{ $sortBy==$key?'selected':''}}>{{ $sort}}</option>
                          @endforeach
                        </select>
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="order-by">
                      <label>
                        {{ __('admin.order_by_txt') }}
                        <select name="oby" aria-controls="example" class="form-control" onchange="form.submit();">
                          @foreach($orderbyArr as $key => $orderby)
                          <option value="{{ $key }}" {{ strtolower($orderBy) == $key ? 'selected' : '' }}>{{ $orderby }}</option>
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
        <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.fund.delete') }}">
          {{ csrf_field() }}
          <div class="table-responsive dt-responsive">
            <table class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  @if($roleRights['delete'])
                  <th class="cc-w-35">
                    <x-form.field.checkbox style="default" name="check_all" id="check_all" />
                  </th>
                  @endif
                  <th>{{ $sortbyArr['fund_name'] }}</th>
                  <th class="cc-w-95">{{ $sortbyArr['fund_code'] }}</th>
                  <th>{{ $sortbyArr['fund_type_id'] }}</th>
                  <th class="cc-w-150">{{ $sortbyArr['fund_term_id'] }}</th>
                  <th class="cc-w-70">{{ $sortbyArr['fund_opened'] }}</th>
                  <th class="cc-w-60 no-sort">{{ __('admin.status_txt') }}</th>
                  <th class="cc-w-150">{{ __('admin.mdfy_date_txt') }}</th>
                  <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
                  <th class="cc-w-35">{{ __('admin.action_txt') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  @if($roleRights['delete'])
                  <td></td>
                  @endif
                  <td>
                    <x-form.field.text id="ffn" name="ffn" value="{{ $fltrDataArr['fund_name'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="ffc" name="ffc" value="{{ $fltrDataArr['fund_code'] ?? '' }}" />
                  </td>
                  <td>
                    <select name="fft" id="fft" aria-controls="example" class="form-control">
                      <option value="">{{ $cFilterArr['all_txt'] }}</option>
                      @foreach($moduleAtrArr['fund_type_list'] as $key => $fType)
                      <option value="{{ $fType->ft_id }}" @if( $fType->ft_id==old('fft') ) {{ 'selected' }} @elseif( $fType->ft_id==$fltrDataArr['fund_type_id'] ) {{ 'selected' }} @endif>{{ $fType->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <select name="fftm" id="fftm" aria-controls="example" class="form-control">
                      <option value="">{{ $cFilterArr['all_txt'] }}</option>
                      @foreach($moduleAtrArr['fund_term_list'] as $key => $fTerm)
                      <option value="{{ $fTerm->ftm_id }}" @if( $fTerm->ftm_id==old('fftm') ) {{ 'selected' }} @elseif( $fTerm->ftm_id==$fltrDataArr['fund_term_id'] ) {{ 'selected' }} @endif>{{ $fTerm->term }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <x-form.field.text id="ffo" name="ffo" value="{{ $fltrDataArr['fund_opened'] ?? '' }}" class="period" />
                  </td>
                  <td>
                    <select name="fsts" id="fsts" aria-controls="example" class="form-control">
                      <option value="">{{ $cFilterArr['all_txt'] }}</option>
                      @foreach($moduleAtrArr['status_list']['label'] as $key => $statusFtxt)
                      <option value="{{ $key }}" @if( $key==old('fsts') ) {{ 'selected' }} @elseif( $key==$fltrDataArr['status'] ) {{ 'selected' }} @endif>{{ $statusFtxt }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <x-form.field.text id="fmd" name="fmd" value="{{ $fltrDataArr['updated_at'] ?? '' }}" class="period" />
                  </td>
                  <td></td>
                  <td></td>
                </tr>
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
                  <td>
                    @if($roleRights['edit'])
                    <label id="change_status{{ $record->fund_id }}" onclick="return changeStatus('fund_id', {{ $record->fund_id }}, 'fund_master', {{ $record->status }}, '{{ $moduleAtrArr['status_list']['status_type'] }}');" class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }}">{{ $moduleAtrArr['status_list']['label'][$record->status] }}</label>
                    @else
                    <label class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }} no-drop">{{ $moduleAtrArr['status_list']['label'][$record->status] }}</label>
                    @endif
                  </td>
                  <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)) }}</td>
                  <td>{{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}</td>
                  <td>
                    <x-link url="{{ route('admin.fund.corpus.edit', $record->fund_id) }}">
                      <label class="label label-info hand">{{ __('admin.fund.corpus_txt') }}</label>
                    </x-link>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="10">{{ __('message.data_not_available') }}</td>
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
    var ftrFfnVlu = document.getElementById("ffn").value;
    if (ftrFfnVlu != "") {
      searchPagiData = searchPagiData + "&ffn=" + ftrFfnVlu;
    }
    var ftrFfcVlu = document.getElementById("ffc").value;
    if (ftrFfcVlu != "") {
      searchPagiData = searchPagiData + "&ffc=" + ftrFfcVlu;
    }
    var ftrFftVlu = document.getElementById("fft").value;
    if (ftrFftVlu != "") {
      searchPagiData = searchPagiData + "&fft=" + ftrFftVlu;
    }
    var ftrFftmVlu = document.getElementById("fftm").value;
    if (ftrFftmVlu != "") {
      searchPagiData = searchPagiData + "&fftm=" + ftrFftmVlu;
    }
    var ftrFfoVlu = document.getElementById("ffo").value;
    if (ftrFfoVlu != "") {
      searchPagiData = searchPagiData + "&ffo=" + ftrFfoVlu;
    }
    var ftrFstsVlu = document.getElementById("fsts").value;
    if (ftrFstsVlu != "") {
      searchPagiData = searchPagiData + "&fsts=" + ftrFstsVlu;
    }
    var ftrFmdVlu = document.getElementById("fmd").value;
    if (ftrFmdVlu != "") {
      searchPagiData = searchPagiData + "&fmd=" + ftrFmdVlu;
    }
    /*alert(searchPagiData);*/
    window.location.href = "{{ route('admin.fund.index') }}" + "?page=0" + searchPagiData + "&ppage=" + "{{ $perPage }}";
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "{{ route('admin.fund.index') }}";
  }
</script>
@endpush