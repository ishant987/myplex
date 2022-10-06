@extends('themes.backend.layouts.app')
@section('datetimeRangePicker') @endsection

@section('breadcrumb')
{{ Breadcrumbs::render('contact.index')  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('contact.all_txt') }}</h5>
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
            <!-- Multi Delete -->
            <x-form.btn_multi_delete />
            @endif
            <!-- Export -->
            <x-link_tooltip url="{!! route('admin.contact.export', $exportDataArr) !!}" class="btn waves-effect waves-light btn-sm f-right btn-success" title="{{ __('admin.export_txt') }}">
              <i class="fa fa-file-excel-o"></i>
            </x-link_tooltip>
            @endif
          </div>
        </div>
      </div>
      <div class="card-block">
        <!-- Show message. -->
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
          <form id="filterForm" name="filterForm" method="get" action="{{ route('admin.contact.index') }}">
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
        <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.deletecontact') }}">
          {{ csrf_field() }}
          <div class="table-responsive dt-responsive">
            <table class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  @if($roleRights['delete'])
                  @if( count( $dataListModel ) > 0 )
                  <th class="cc-w-35 no-sort-del">
                    <x-form.field.checkbox style="default" name="check_all" id="check_all" />
                  </th>
                  @endif
                  @endif
                  <th>{{ $sortbyArr['name'] }}</th>
                  <th>{{ $sortbyArr['email'] }}</th>
                  <th class="cc-w-95">{{ $sortbyArr['mobile'] }}</th>
                  <th>{{ $sortbyArr['message'] }}</th>
                  <th class="cc-w-150">{{ $sortbyArr['created_at'] }}</th>
                  @if($roleRights['view'])
                  <th class="cc-w-35">{{ __('admin.action_txt') }}</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                <tr>
                  @if($roleRights['delete'])
                  @if( count( $dataListModel ) > 0 )
                  <td></td>
                  @endif
                  @endif
                  <td>
                    <x-form.field.text id="ffn" name="ffn" value="{{ $fltrDataArr['name'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fel" name="fel" value="{{ $fltrDataArr['email'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fml" name="fml" value="{{ $fltrDataArr['mobile'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fms" name="fms" value="{{ $fltrDataArr['message'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fad" name="fad" value="{{ $fltrDataArr['created_at'] ?? '' }}" class="period" />
                  </td>
                  @if($roleRights['view'])
                  <td></td>
                  @endif
                </tr>
                @if( count($dataListModel) > 0 )
                @foreach( $dataListModel as $key => $record )
                <tr role="row" class="">
                  @if($roleRights['delete'])
                  <td class="sorting_{{ $record->enq_id }}">
                    <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->enq_id }}" fldclass="del-chkbx" />
                  </td>
                  @endif
                  <td>
                    @if($record->u_id > 0)
                    <x-link_tooltip url="{{ route('admin.subscribeduser.edit', $record->u_id) }}" title="{{ $listDataAtrArr['view_txt'] }}" target="{{ $listDataAtrArr['target'] }}">
                      {{ $record->name }}
                    </x-link_tooltip>
                    @else
                    {{ $record->name }}
                    @endif
                  </td>
                  <td>{{ $record->email }}</td>
                  <td>{{ $record->mobile }}</td>
                  <td>{!! \App\Lib\Core\Useful::getShortContent( strip_tags($record->message), 100) !!}</td>
                  <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->created_at)) }}</td>
                  @if($roleRights['view'])
                  <td>
                    <x-link_tooltip url="{{ route('admin.contact.show', $record->enq_id) }}" title="{{ $listDataAtrArr['view_txt'] }}" target="{{ $listDataAtrArr['target'] }}" class="f-20" placement="left">
                      <i class="fa fa-eye"></i>
                    </x-link_tooltip>
                  </td>
                  @endif
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
    var ftrFelVlu = document.getElementById("fel").value;
    if (ftrFelVlu != "") {
      searchPagiData = searchPagiData + "&fel=" + ftrFelVlu;
    }
    var ftrFmlVlu = document.getElementById("fml").value;
    if (ftrFmlVlu != "") {
      searchPagiData = searchPagiData + "&fml=" + ftrFmlVlu;
    }
    var ftrFmsVlu = document.getElementById("fms").value;
    if (ftrFmsVlu != "") {
      searchPagiData = searchPagiData + "&fms=" + ftrFmsVlu;
    }
    var ftrFadVlu = document.getElementById("fad").value;
    if (ftrFadVlu != "") {
      searchPagiData = searchPagiData + "&fad=" + ftrFadVlu;
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
    window.location.href = "{{ route('admin.contact.index') }}" + "?page=0" + searchPagiData + "&ppage=" + "{{ $perPage }}";
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "{{ route('admin.contact.index') }}";
  }
</script>
@endpush