@extends('themes.backend.layouts.app')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>Calculator Logins</h5>
        <div class="c-f-btns">
          <div class="c-f-b-f">
            <x-form.btn_filter />
            <x-form.btn_reset />
          </div>
        </div>
      </div>
      <div class="card-block">
        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
          <form id="filterForm" name="filterForm" method="get" action="{{ route('admin.calculatorlogin.list') }}">
            <div class="row align-items-center">
              <div class="col-md-3">
                <div class="sw-entry">
                  <label>
                    {{ __('admin.sw_entry.show_txt') }}
                    <select name="ppage" aria-controls="example" class="form-control" onchange="form.submit();">
                      @foreach($showEntryArr['value'] as $key => $option)
                      <option value="{{ $option }}" {{ (string) $option === (string) $perPage ? 'selected' : '' }}>{{ $showEntryArr['text'][$key] }}</option>
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
                          @foreach($availableSorts as $key => $label)
                          <option value="{{ $key }}" {{ $sortBy === $key ? 'selected' : '' }}>{{ $label }}</option>
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
                          @foreach($orderbyArr as $key => $label)
                          <option value="{{ $key }}" {{ strtolower($orderBy) === $key ? 'selected' : '' }}>{{ $label }}</option>
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
                @if(in_array('id', $columns, true))
                <th>ID</th>
                @endif
                @if(in_array('username', $columns, true))
                <th>Username</th>
                @endif
                @if(in_array('email', $columns, true))
                <th>Email</th>
                @endif
                @if(in_array('platform', $columns, true))
                <th>Platform</th>
                @endif
                @if(in_array('created_at', $columns, true))
                <th class="cc-w-150">Created At</th>
                @endif
              </tr>
            </thead>
            <tbody>
              <tr>
                @if(in_array('id', $columns, true))
                <td></td>
                @endif
                @if(in_array('username', $columns, true))
                <td><x-form.field.text id="fun" name="fun" value="{{ $fltrDataArr['username'] }}" /></td>
                @endif
                @if(in_array('email', $columns, true))
                <td><x-form.field.text id="fel" name="fel" value="{{ $fltrDataArr['email'] }}" /></td>
                @endif
                @if(in_array('platform', $columns, true))
                <td>
                  <select id="fpl" name="fpl" class="form-control" onchange="filter();">
                    @foreach($platformOptions as $value => $label)
                    <option value="{{ $value }}" {{ (string) $fltrDataArr['platform'] === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                  </select>
                </td>
                @endif
                @if(in_array('created_at', $columns, true))
                <td><x-form.field.text id="fad" name="fad" value="{{ $fltrDataArr['created_at'] }}" class="period" /></td>
                @endif
              </tr>

              @if(!empty($columns) && count($dataListModel) > 0)
              @foreach($dataListModel as $record)
              <tr>
                @if(in_array('id', $columns, true))
                <td>{{ $record->id }}</td>
                @endif
                @if(in_array('username', $columns, true))
                <td>{{ $record->username ?? $listDataAtrArr['na_txt'] }}</td>
                @endif
                @if(in_array('email', $columns, true))
                <td>{{ $record->email ?? $listDataAtrArr['na_txt'] }}</td>
                @endif
                @if(in_array('platform', $columns, true))
                <td>
                  @if((string) ($record->platform ?? '') === '1')
                  Google
                  @elseif((string) ($record->platform ?? '') === '2')
                  Facebook
                  @else
                  {{ $listDataAtrArr['na_txt'] }}
                  @endif
                </td>
                @endif
                @if(in_array('created_at', $columns, true))
                <td>{{ $record->created_at ? date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->created_at)) : $listDataAtrArr['na_txt'] }}</td>
                @endif
              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="{{ max(count($columns), 1) }}">{{ empty($columns) ? 'Calculator login table is not available.' : __('message.data_not_available') }}</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>

        @if(!empty($columns) && method_exists($dataListModel, 'appends'))
        {{ $dataListModel->appends($data)->links('vendor.pagination.app-admin') }}
        @endif
      </div>
    </div>
  </div>
</div>
@stop

@push('scripts')
<script>
  function filter() {
    var searchPagiData = "";
    var ftrFunVlu = document.getElementById("fun");
    if (ftrFunVlu && ftrFunVlu.value !== "") {
      searchPagiData = searchPagiData + "&fun=" + ftrFunVlu.value;
    }
    var ftrFelVlu = document.getElementById("fel");
    if (ftrFelVlu && ftrFelVlu.value !== "") {
      searchPagiData = searchPagiData + "&fel=" + ftrFelVlu.value;
    }
    var ftrFplVlu = document.getElementById("fpl");
    if (ftrFplVlu && ftrFplVlu.value !== "") {
      searchPagiData = searchPagiData + "&fpl=" + ftrFplVlu.value;
    }
    var ftrFadVlu = document.getElementById("fad");
    if (ftrFadVlu && ftrFadVlu.value !== "") {
      searchPagiData = searchPagiData + "&fad=" + ftrFadVlu.value;
    }
    var ftrSbyVlu = document.getElementById("sby");
    if (ftrSbyVlu && ftrSbyVlu.value !== "") {
      searchPagiData = searchPagiData + "&sby=" + ftrSbyVlu.value;
    }
    var ftrObyVlu = document.getElementById("oby");
    if (ftrObyVlu && ftrObyVlu.value !== "") {
      searchPagiData = searchPagiData + "&oby=" + ftrObyVlu.value;
    }

    window.location.href = "{{ route('admin.calculatorlogin.list') }}" + "?page=0" + searchPagiData + "&ppage=" + "{{ $perPage }}";
    return false;
  }

  function resetfilter() {
    window.location.href = "{{ route('admin.calculatorlogin.list') }}";
  }
</script>
@endpush
