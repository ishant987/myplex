@extends('themes.backend.layouts.app')
@section('datetimePicker') @endsection

@section('breadcrumb')
{{ Breadcrumbs::render('navs.list')  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('admin.fund.nav.list_label_txt') }}</h5>
        <div class="c-f-btns">
          <div class="c-f-b-f">
            <!-- Filter -->
            <x-form.btn_filter />
            <!-- Reset -->
            <x-form.btn_reset />
          </div>
          <div class="c-f-b-r">
            @if( count( $dataListModel ) > 0 )
            @if($roleRights['delete'])
            <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.navs.delete') }}">
              {{ csrf_field() }}
              <x-form.field.button_def type="submit" name="submit" text="{{__('admin.del_last_saved_pfx_txt').$lastSavedDate.__('admin.del_last_saved_sfx_txt')}}" class="btn btn-sm waves-effect waves-light btn-danger btn-square" onclick="return confirm('{{ __('message.confirm.del_last_saved') }}')?confirm('{{ __('message.confirm.click_ok_txt') }}'):false" />
            </form>
            @endif
            @endif
          </div>
        </div>
      </div>
      <div class="card-block">
        <!-- Show message. -->
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
          <form id="filterForm" name="filterForm" method="get" action="{{ route('admin.navs.list') }}">
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
        <div class="table-responsive dt-responsive">
          <table class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <th class="cc-w-125">{{ __('admin.entry_date_txt') }}</th>
                <th>{{ $sortbyArr['fund_code'] }}</th>
                <th class="cc-w-125">{{ $sortbyArr['closing_nav'] }}</th>
                <th class="cc-w-125">{{ $sortbyArr['percentage_change'] }}</th>
                <th class="cc-w-80">{{ __('admin.holiday_txt') }}</th>
                <th class="cc-w-125">{{ __('admin.publish_txt') }}</th>
                <th>{{ __('admin.added_user_txt') }}</th>
                <th class="cc-w-150">{{ __('admin.added_date_txt') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <x-form.field.text id="fed" name="fed" value="{{ $fltrDataArr['entry_date'] ?? '' }}" class="def-date" />
                </td>
                <td>
                  <x-form.field.text id="ffc" name="ffc" value="{{ $fltrDataArr['fund_code'] ?? '' }}" />
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              @if( count($dataListModel) > 0 )
              @foreach( $dataListModel as $key => $record )
              <tr role="row" class="">
                <td>{{ $record->entry_date }}</td>
                <td>{{ $record->fund_code }}</td>
                <td>{{ $record->closing_nav }}</td>
                <td>{{ $record->percentage_change }}</td>
                <td>{{ $moduleAtrArr['holiday'][$record->holiday] }}</td>
                <td>{{ $moduleAtrArr['published'][$record->publish] }}</td>
                <td>{{ $record->createdby->display_name ?? $listDataAtrArr['unknown_txt'] }}</td>
                <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->created_at)) }}</td>
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
    var ftrFedVlu = document.getElementById("fed").value;
    if (ftrFedVlu != "") {
      searchPagiData = searchPagiData + "&fed=" + ftrFedVlu;
    }
    var ftrFfcVlu = document.getElementById("ffc").value;
    if (ftrFfcVlu != "") {
      searchPagiData = searchPagiData + "&ffc=" + ftrFfcVlu;
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
    window.location.href = "{{ route('admin.navs.list') }}" + "?page=0" + searchPagiData + "&ppage=" + "{{ $perPage }}";
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "{{ route('admin.navs.list') }}";
  }
</script>
@endpush