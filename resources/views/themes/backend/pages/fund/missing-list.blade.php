@extends('themes.backend.layouts.app')
@section('dataTables') @stop
@section('datetimeRangePicker') @endsection
@section('select2') @endsection

@section('breadcrumb')
{{ Breadcrumbs::render('missingnav.index')  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('admin.fund.missing.label_txt') }}</h5>
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
            <x-link_add_new url="{{ route('admin.missing-nav.create') }}" target="_blank" />
            @endif
            @if( count( $dataListModel ) > 0 )
            <!-- Export -->
            <x-link_tooltip url="{!! route('admin.missing-nav.export',$exportDataArr) !!}" class="btn waves-effect waves-light btn-sm f-right btn-success" title="{{ __('admin.export_txt') }}">
              <i class="fa fa-file-excel-o"></i>
            </x-link_tooltip>
            @endif
          </div>
        </div>
      </div>
      <div class="card-block">
        <!-- Show message. -->
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.missing-nav.index') }}">
          {{ csrf_field() }}

          <div class="row">
            <div class="col-sm-3">
              <x-form.group_lyt1_3_7_2 label="{{ __('admin.period_txt') }}" for="fmd" error="{{ $errors->first('fmd') }}" required="true">
                <x-form.field.text id="fmd" name="fmd" value="{{ $fltrDataArr['missing_date'] ?? '' }}" class="period-saved" />
              </x-form.group_lyt1_3_7_2>
            </div>
            <div class="col-sm-5">
              <x-form.group_lyt1_3_7_2 label="{{ __('admin.fund.missing.scheme_txt') }}" for="ffc" error="{{ $errors->first('ffc') }}" required="true">
                <select name="ffc" id="ffc" class="form-control js-example-basic-single">
                  <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                  @foreach ($fundList as $key => $value)
                  <option value="{{ $value->fund_code }}" @if( $value->fund_code==old('ffc') ) {{ 'selected' }} @elseif( $value->fund_code==$fltrDataArr['fund_code'] ) {{ 'selected' }} @endif>{{ $value->fund_name }}
                  </option>
                  @endforeach
                </select>
                </x-form.group_group_lyt1_3_7_2lyt1_2_10>
            </div>
          </div>

          <div class="table-responsive dt-responsive">
            <table id="dom-jqry" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th class="cc-w-150">{{ __('admin.missing_date_txt') }}</th>
                  <th>{{ __('admin.fund.missing.scheme_txt') }}</th>
                  <th>{{ __('admin.fund.code_txt') }}</th>
                </tr>
              </thead>
              <tbody>
                @if( count($dataListModel) > 0 )
                @foreach( $dataListModel as $key => $record )
                <tr role="row">
                  <td>{{ $record->missing_date }}</td>
                  <td>{{ $fundName }}</td>
                  <td>{{ $record->fund_code }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="3">
                    @if(isset($defMsg))
                    {{ $defMsg }}
                    @else
                    {{ __('message.data_not_available') }}
                    @endif
                  </td>
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
@push('scripts')
<script>
  $(function() {
    // Period(Start and End Date)
    $('.period-saved').daterangepicker({
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD'
      },
      /*startDate: "",*/
      maxDate: "{{ $lastSavedDate }}"
    });
    $('.period-saved').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('.period-saved').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });
  });
  /*Filter*/
  function filter() {
    var searchPagiData = "";
    var ftrFmdVlu = document.getElementById("fmd").value;
    if (ftrFmdVlu != "") {
      searchPagiData = searchPagiData + "&fmd=" + ftrFmdVlu;
    }
    var ftrFfcVlu = document.getElementById("ffc").value;
    if (ftrFfcVlu != "") {
      searchPagiData = searchPagiData + "&ffc=" + ftrFfcVlu;
    }
    /*alert(searchPagiData);*/
    window.location.href = "{{ route('admin.missing-nav.index') }}" + "?type=filter" + searchPagiData;
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "{{ route('admin.missing-nav.index') }}";
  }
</script>
@endpush