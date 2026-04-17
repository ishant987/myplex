@extends('themes.backend.layouts.app')

@section('datetimeRangePicker') @endsection

@section('breadcrumb')
{{ Breadcrumbs::render('subscribeduser.index')  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('subscribeduser.all_txt') }}</h5>
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
            <x-link_add_new url="{{ route('admin.subscribeduser.create') }}" />
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
          <form id="filterForm" name="filterForm" method="get" action="{{ route('admin.subscribeduser.index') }}">
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
        <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.deletesubscribeduser') }}">
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
                  <th>{{ __('subscribeduser.user_code_txt') }}</th>
                  <th>{{ $sortbyArr['f_name'] }}</th>
                  <th>{{ $sortbyArr['l_name'] }}</th>
                  <th>{{ $sortbyArr['email'] }}</th>
                  <th>{{ $sortbyArr['mobile'] }}</th>
                  <th class="cc-w-70">{{ __('subscribeduser.profile_pic_txt') }}</th>
                  <th class="cc-w-60">{{ __('admin.status_txt') }}</th>
                  <th>{{ $sortbyArr['acc_type'] }}</th>
                  <th>{{ $sortbyArr['s_acc_medium'] }}</th>
                  <th class="cc-w-150">{{ $sortbyArr['created_at'] }}</th>
                  <th>{{ $sortbyArr['created_by'] }}</th>
                  <th>{{ __('admin.added_user_txt') }}</th>
                  <th>Package</th>
                  <th>Price Paid</th>
                  <th>Subscription End On</th>
                  <th class="cc-w-150">{{ $sortbyArr['updated_at'] }}</th>
                  <th class="cc-w-95">{{ $sortbyArr['updated_by'] }}</th>
                  <th>{{ __('admin.mdfy_user_txt') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  @if($roleRights['delete'])
                  <td></td>
                  @endif
                  <td>
                    <x-form.field.text id="fucd" name="fucd" value="{{ $fltrDataArr['u_code'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="ffn" name="ffn" value="{{ $fltrDataArr['f_name'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fln" name="fln" value="{{ $fltrDataArr['l_name'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fem" name="fem" value="{{ $fltrDataArr['email'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fmb" name="fmb" value="{{ $fltrDataArr['mobile'] ?? '' }}" />
                  </td>
                  <td></td>
                  <td>
                    <select name="fsts" id="fsts" aria-controls="example" class="form-control">
                      <option value="">{{ $cFilterArr['all_txt'] }}</option>
                      @foreach($moduleAtrArr['status']['label'] as $key => $statusFtxt)
                      <option value="{{ $key }}" @if( $key==old('fsts') ) {{ 'selected' }} @elseif( $key==$fltrDataArr['status'] ) {{ 'selected' }} @endif>{{ $statusFtxt }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <select name="fat" id="fat" aria-controls="example" class="form-control">
                      <option value="">{{ $cFilterArr['all_txt'] }}</option>
                      @foreach($moduleAtrArr['acc_type']['value'] as $key => $fatVal)
                      <option value="{{ $fatVal }}" @if( $fatVal==old('fat') ) {{ 'selected' }} @elseif( $fatVal==$fltrDataArr['acc_type'] ) {{ 'selected' }} @endif>{{ $moduleAtrArr['acc_type']['text'][$fatVal] }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <select name="fsm" id="fsm" aria-controls="example" class="form-control">
                      <option value="">{{ $cFilterArr['all_txt'] }}</option>
                      @foreach($moduleAtrArr['s_acc_medium']['value'] as $key => $fsmVal)
                      <option value="{{ $fsmVal }}" @if( $fsmVal==old('fsm') ) {{ 'selected' }} @elseif( $fsmVal==$fltrDataArr['s_acc_medium'] ) {{ 'selected' }} @endif>{{ $moduleAtrArr['s_acc_medium']['text'][$fsmVal] }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <x-form.field.text id="fad" name="fad" value="{{ $fltrDataArr['created_at'] ?? '' }}" class="period" />
                  </td>
                  <td>
                    <select name="fay" id="fay" aria-controls="example" class="form-control">
                      <option value="">{{ $cFilterArr['all_txt'] }}</option>
                      @foreach($moduleAtrArr['cu_by_val'] as $key => $abyVal)
                      <option value="{{ $abyVal }}" @if( $abyVal==old('fay') ) {{ 'selected' }} @elseif( $abyVal==$fltrDataArr['created_by'] ) {{ 'selected' }} @endif>{{ $moduleAtrArr['cu_by_txt'][$abyVal] }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <x-form.field.text id="fmd" name="fmd" value="{{ $fltrDataArr['updated_at'] ?? '' }}" class="period" />
                  </td>
                  <td>
                    <select name="fmby" id="fmby" aria-controls="example" class="form-control">
                      <option value="">{{ $cFilterArr['all_txt'] }}</option>
                      @foreach($moduleAtrArr['cu_by_val'] as $key => $fmbyVal)
                      <option value="{{ $fmbyVal }}" @if( $fmbyVal==old('fmby') ) {{ 'selected' }} @elseif( $fmbyVal==$fltrDataArr['updated_by'] ) {{ 'selected' }} @endif>{{ $moduleAtrArr['cu_by_txt'][$fmbyVal] }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td></td>
                </tr>
                @if( count($dataListModel) > 0 )
                @foreach( $dataListModel as $key => $record )
                @php($latestPaidSubscription = $record->latestPaidSubscription)
                <tr role="row" class="">
                  @if($roleRights['delete'])
                  <td class="sorting_{{$key}">
            <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->u_id }}" fldclass="del-chkbx" />
                  </td>
                  @endif
                  <td>{{ $record->u_code }}</td>
                  <td>
                    @if($roleRights['edit'])
                    <x-link_tooltip url="{{ route('admin.subscribeduser.edit', $record->u_id) }}" title="{{ $listDataAtrArr['edit_txt'] }}">
                      {{ $record->f_name }}
                    </x-link_tooltip>
                    @else
                    {{ $record->f_name }}
                    @endif
                  </td>
                  <td>{{ $record->l_name }}</td>
                  <td>{{ $record->email }}</td>
                  <td>{{ $record->mobile }}</td>
                  <td>
                    @if($record->p_picture)
                    <x-link_tooltip url="{{ $moduleAtrArr['media_folder'].$record->p_picture }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" placement="right">
                      <x-img src="{{ $moduleAtrArr['media_folder'].$record->p_picture }}" width="{{ $moduleAtrArr['img_width']['small'] }}" class="img-fluid img-thumbnail w-70" />
                    </x-link_tooltip>
                    @endif
                  </td>
                  <td>
                    @if($roleRights['edit'])
                    <label id="change_status{{ $record->u_id }}" onclick="return changeStatus('u_id', {{ $record->u_id }}, 'users', {{ $record->status }}, '{{ $moduleAtrArr['status']['status_type'] }}');" class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }}">{{ $moduleAtrArr['status']['label'][$record->status] }}</label>
                    @else
                    <label id="change_status{{ $record->u_id }}" class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }} no-drop">{{ $moduleAtrArr['status']['label'][$record->status] }}</label>
                    @endif
                  </td>
                  <td>{{ $moduleAtrArr['acc_type']['text'][$record->acc_type] }}</td>
                  <td>
                    @if($record->s_acc_medium)
                    {{ $moduleAtrArr['s_acc_medium']['text'][$record->s_acc_medium] }}
                    @endif
                  </td>
                  <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->created_at)) }}</td>
                  <td>{{ $moduleAtrArr['cu_by_txt'][$record->created_by] ?? $listDataAtrArr['unknown_txt'] }}</td>
                  <td>
                    @switch($record->created_by)
                    @case($moduleAtrArr['cu_by_val'][1])
                    @if($record->addedby)
                    {{ $record->addedby->display_name ?? $listDataAtrArr['unknown_txt'] }}
                    @else
                    {{ $listDataAtrArr['unknown_txt'] }}
                    @endif
                    @break
                    @case($moduleAtrArr['cu_by_val'][2])
                    @if($record->addedbyuser)
                    {{ $record->addedbyuser->f_name.' '.$record->addedbyuser->l_name ?? $listDataAtrArr['unknown_txt'] }}
                    @else
                    {{ $listDataAtrArr['unknown_txt'] }}
                    @endif
                    @break
                    @endswitch
                  </td>
                  <td>
                    @if($latestPaidSubscription)
                    @if(Route::has('admin.subscriptions.show'))
                    <a href="{{ route('admin.subscriptions.show', $latestPaidSubscription->id) }}">
                      {{ optional($latestPaidSubscription->plan)->name ?: ucfirst(str_replace('_', ' ', $latestPaidSubscription->subscription_type ?: '-')) }}
                    </a>
                    @else
                    {{ optional($latestPaidSubscription->plan)->name ?: ucfirst(str_replace('_', ' ', $latestPaidSubscription->subscription_type ?: '-')) }}
                    @endif
                    @else
                    -
                    @endif
                  </td>
                  <td>
                    @if($latestPaidSubscription && $latestPaidSubscription->amount !== null)
                    {{ $latestPaidSubscription->currency ?: 'INR' }} {{ number_format((float) $latestPaidSubscription->amount, 2) }}
                    @else
                    -
                    @endif
                  </td>
                  <td>
                    @if($latestPaidSubscription && $latestPaidSubscription->subscription_expiry_date)
                    {{ \Carbon\Carbon::parse($latestPaidSubscription->subscription_expiry_date)->format('d M Y') }}
                    @elseif($latestPaidSubscription && $latestPaidSubscription->ends_at)
                    {{ optional($latestPaidSubscription->ends_at)->format('d M Y') }}
                    @else
                    -
                    @endif
                  </td>
                  <td>@if($record->updated_at){{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)) }}@endif</td>
                  <td>@if($record->updated_by){{ $moduleAtrArr['cu_by_txt'][$record->updated_by] ?? $listDataAtrArr['unknown_txt'] }}@endif</td>
                  <td>
                    @if($record->updated_by)
                    @switch($record->updated_by)
                    @case($moduleAtrArr['cu_by_val'][1])
                    @if($record->updatedby)
                    {{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}
                    @else
                    {{ $listDataAtrArr['unknown_txt'] }}
                    @endif
                    @break
                    @case($moduleAtrArr['cu_by_val'][2])
                    @if($record->updatedbyuser)
                    {{ $record->updatedbyuser->f_name.' '.$record->updatedbyuser->l_name ?? $listDataAtrArr['unknown_txt'] }}
                    @else
                    {{ $listDataAtrArr['unknown_txt'] }}
                    @endif
                    @break
                    @endswitch
                    @endif
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="19">{{ __('message.data_not_available') }}</td>
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
    var ftrFucdVlu = document.getElementById("fucd").value;
    if (ftrFucdVlu != "") {
      searchPagiData = searchPagiData + "&fucd=" + ftrFucdVlu;
    }
    var ftrFfnVlu = document.getElementById("ffn").value;
    if (ftrFfnVlu != "") {
      searchPagiData = searchPagiData + "&ffn=" + ftrFfnVlu;
    }
    var ftrFlnVlu = document.getElementById("fln").value;
    if (ftrFlnVlu != "") {
      searchPagiData = searchPagiData + "&fln=" + ftrFlnVlu;
    }
    var ftrFemVlu = document.getElementById("fem").value;
    if (ftrFemVlu != "") {
      searchPagiData = searchPagiData + "&fem=" + ftrFemVlu;
    }
    var ftrFmbVlu = document.getElementById("fmb").value;
    if (ftrFmbVlu != "") {
      searchPagiData = searchPagiData + "&fmb=" + ftrFmbVlu;
    }
    var ftrFatVlu = document.getElementById("fat").value;
    if (ftrFatVlu != "") {
      searchPagiData = searchPagiData + "&fat=" + ftrFatVlu;
    }
    var ftrFsmVlu = document.getElementById("fsm").value;
    if (ftrFsmVlu != "") {
      searchPagiData = searchPagiData + "&fsm=" + ftrFsmVlu;
    }
    var ftrFadVlu = document.getElementById("fad").value;
    if (ftrFadVlu != "") {
      searchPagiData = searchPagiData + "&fad=" + ftrFadVlu;
    }
    var ftrFayVlu = document.getElementById("fay").value;
    if (ftrFayVlu != "") {
      searchPagiData = searchPagiData + "&fay=" + ftrFayVlu;
    }
    var ftrFmdVlu = document.getElementById("fmd").value;
    if (ftrFmdVlu != "") {
      searchPagiData = searchPagiData + "&fmd=" + ftrFmdVlu;
    }
    var ftrFmbyVlu = document.getElementById("fmby").value;
    if (ftrFmbyVlu != "") {
      searchPagiData = searchPagiData + "&fmby=" + ftrFmbyVlu;
    }
    var ftrFstsVlu = document.getElementById("fsts").value;
    if (ftrFstsVlu != "") {
      searchPagiData = searchPagiData + "&fsts=" + ftrFstsVlu;
    }
    /*alert(searchPagiData);*/
    window.location.href = "{{ route('admin.subscribeduser.index') }}" + "?page=0" + searchPagiData + "&ppage=" + "{{ $perPage }}";
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "{{ route('admin.subscribeduser.index') }}";
  }
</script>
@endpush
