@extends('themes.backend.layouts.app')

@section('datetimeRangePicker') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('media.index')  }} 
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('media.all_txt') }}</h5>
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
              <x-link_add_new url="{{ route('admin.media.create') }}" />
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
        <form id="filterForm" name="filterForm" method="get" action="{{ route('admin.media.index') }}">
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
       <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.deletemedia') }}">
        {{ csrf_field() }}
        <div class="table-responsive dt-responsive">
          <table class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                @if($roleRights['delete'])
                  @if( count( $dataListModel ) > 0 )
                    <th class="cc-w-35">
                      <x-form.field.checkbox style="default" name="check_all" id="check_all" />
                    </th>
                  @endif
                @endif
                <th class="cc-w-150">{{ __('media.media_file_txt') }}</th>
                <th>{{ $sortbyArr['title'] }}</th>
                <th>{{ $sortbyArr['alt'] }}</th>
                <th class="cc-w-150">{{ $sortbyArr['updated_at'] }}</th>
                <th>{{ __('admin.mdfy_by_txt') }}</th>
                @if($roleRights['edit'])
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
                  <td></td>
                  <td>
                    <x-form.field.text id="ftl" name="ftl" value="{{ $fltrDataArr['title'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fat" name="fat" value="{{ $fltrDataArr['alt'] ?? '' }}" />
                  </td>
                  <td>
                    <x-form.field.text id="fud" name="fud" value="{{ $fltrDataArr['updated_at'] ?? '' }}" class="period" />
                  </td>
                  <td>
                    <x-form.field.text id="fuu" name="fuu" value="{{ $fltrDataArr['updated_by_name'] ?? '' }}" />
                  </td>
                  @if($roleRights['edit'])
                    <td></td>
                  @endif
                </tr>    
              @if( count($dataListModel) > 0 )       
              @foreach( $dataListModel as $key => $record )
              <tr role="row" class="">
                @if($roleRights['delete'])
                  <td class="sorting_{{ $record->media_id }}">
                    <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->media_id }}" fldclass="del-chkbx" />
                  </td>
                @endif
              <td>
                <x-link_tooltip url="{!! $moduleAtrArr['media_folder'].$record->path !!}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" placement="right">
                  @if('displayimage' == \App\Lib\Core\Core::getFaIconByMimeType($record->mime_type))
                    <x-img src="{!! $moduleAtrArr['media_folder'].$record->path !!}" width="{{ $moduleAtrArr['img_width']['big'] }}" class="img-fluid img-thumbnail cc-w-150" />
                  @else                    
                      <i class="fa {{ \App\Lib\Core\Core::getFaIconByMimeType($record->mime_type) }} fa-5x" aria-hidden="true"></i>
                  @endif

                </x-link_tooltip>
              </td>
              <td>{!! $record->title !!}</td>
              <td>{!! $record->alt !!}</td>
              <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)) }}</td>
              <td>{{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}</td>
                @if($roleRights['edit'])
                  <td>
                    <x-link_tooltip url="{{ route('admin.media.edit', $record->media_id) }}" title="{{ $listDataAtrArr['edit_txt'] }}" class="f-20" placement="left">
                      <i class="fa fa-edit"></i>
                    </x-link_tooltip>
                  </td> 
                @endif
               </tr>
               @endforeach  
               @else
                <tr><td colspan="6">{{ __('message.data_not_available') }}</td></tr>
                @endif            
             </tbody>
           </table>
         </div>
       </form>
       {{ $dataListModel->links('vendor.pagination.app-admin') }}
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
    var ftrFtlVlu = document.getElementById("ftl").value;
    if (ftrFtlVlu != "") {
      searchPagiData = searchPagiData + "&ftl=" + ftrFtlVlu;
    }
    var ftrFatVlu = document.getElementById("fat").value;
    if (ftrFatVlu != "") {
      searchPagiData = searchPagiData + "&fat=" + ftrFatVlu;
    }
    var ftrFudVlu = document.getElementById("fud").value;
    if (ftrFudVlu != "") {
      searchPagiData = searchPagiData + "&fud=" + ftrFudVlu;
    }
    var ftrFuuVlu = document.getElementById("fuu").value;
    if (ftrFuuVlu != "") {
      searchPagiData = searchPagiData + "&fuu=" + ftrFuuVlu;
    }
    /*alert(searchPagiData);*/
    window.location.href = "{{ route('admin.media.index') }}"+"?page=0"+searchPagiData+"&ppage="+"{{ $perPage }}";
    return false;
  }
  /*Reset Filter*/
  function resetfilter() {
    window.location.href = "{{ route('admin.media.index') }}";
  }
</script>
@endpush