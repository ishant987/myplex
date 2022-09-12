@extends('themes.backend.layouts.app')

@section('datetimeRangePicker') @endsection

@section('breadcrumb')
{{ Breadcrumbs::render('scrips.index')  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('admin.scrip.all_txt') }}</h5>
        <div class="c-f-btns">
          <div class="c-f-b-f">
            <!-- Filter -->
            <x-form.btn_filter />
            <!-- Reset -->
            <x-form.btn_reset />
          </div>
          <div class="c-f-b-r">
            @if($roleRights['add'])
            <!-- Add New -->
            <x-link_add_new url="{{ route('admin.scrips.create') }}" />
            @endif
            @if($roleRights['delete'])
            @if( count( $dataListModel ) > 0 )
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
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
          <form id="filterForm" name="filterForm" method="get" action="{{ route('admin.scrips.index') }}">
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
                        <select name="sby" id="sby" aria-controls="example" class="form-control" onchange="filter();">
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
                        <select name="oby" id="oby" aria-controls="example" class="form-control" onchange="filter();">
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
        <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.scrips.delete') }}">
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
                  <th>{{ $sortbyArr['scrip_name'] }}</th>
                  <th class="cc-w-125">{{ $sortbyArr['type'] }}</th>
                  <th class="cc-w-125">{{ $sortbyArr['industry'] }}</th>
                  <th>{{ $sortbyArr['actual_scrip'] }}</th>
                  <th class="cc-w-150">{{ $sortbyArr['updated_at'] }}</th>
                  <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  @if($roleRights['delete'])
                  <td></td>
                  @endif
                  <td>
                    <x-form.field.text id="fsn" name="fsn" value="{{ $fltrDataArr['scrip_name'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fte" name="fte" value="{{ $fltrDataArr['type'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fiy" name="fiy" value="{{ $fltrDataArr['industry'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fas" name="fas" value="{{ $fltrDataArr['actual_scrip'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fmd" name="fmd" value="{{ $fltrDataArr['updated_at'] ?? '' }}" class="period" />
                  </td>
                  <td></td>
                </tr>
                @if( count($dataListModel) > 0 )
                @foreach( $dataListModel as $key => $record )
                <tr role="row" class="">
                  @if($roleRights['delete'])
                  <td class="sorting_{{$key}">
                    <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->scrp_id }}" fldclass="del-chkbx" />
                  </td>
                  @endif
                  <td>
                    @if($roleRights['edit'])
                    <x-link_tooltip url="{{ route('admin.scrips.edit', $record->scrp_id) }}" title="{{ $listDataAtrArr['edit_txt'] }}">
                      {{ $record->scrip_name }}
                    </x-link_tooltip>
                    @else
                    {{ $record->scrip_name }}
                    @endif
                  </td>
                  <td>{{ $record->type }}</td>
                  <td>{{ $record->industry }}</td>
                  <td>{{ $record->actual_scrip }}</td>
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
    var ftrFsnVlu = document.getElementById("fsn").value;
    if (ftrFsnVlu != "") {
      searchPagiData = searchPagiData + "&fsn=" + ftrFsnVlu.replace("&", "_");
    }
    var ftrFteVlu = document.getElementById("fte").value;
    if (ftrFteVlu != "") {
      searchPagiData = searchPagiData + "&fte=" + ftrFteVlu;
    }
    var ftrFiyVlu = document.getElementById("fiy").value;
    if (ftrFiyVlu != "") {
      searchPagiData = searchPagiData + "&fiy=" + ftrFiyVlu;
    }
    var ftrFasVlu = document.getElementById("fas").value;
    if (ftrFasVlu != "") {
      searchPagiData = searchPagiData + "&fas=" + ftrFasVlu.replace("&", "_");
    }
    var ftrFmdVlu = document.getElementById("fmd").value;
    if (ftrFmdVlu != "") {
      searchPagiData = searchPagiData + "&fmd=" + ftrFmdVlu;
    }
    var ftrSbyVlu = document.getElementById("sby").value;
    if (ftrSbyVlu != "") {
      searchPagiData = searchPagiData + "&sby=" + ftrSbyVlu;
    }
    var ftrObyVlu = document.getElementById("oby").value;
    if (ftrObyVlu != "") {
      searchPagiData = searchPagiData + "&oby=" + ftrObyVlu;
    }
    /*alert(searchPagiData);*/
    window.location.href = "{{ route('admin.scrips.index') }}" + "?page=0" + searchPagiData + "&ppage=" + "{{ $perPage }}";
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "{{ route('admin.scrips.index') }}";
  }
</script>
@endpush