@extends('themes.backend.layouts.app')
@section('dataTables') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('testimonial.index')  }} 
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('testimonial.all_txt') }}</h5>
        @if($roleRights['add'])
          <!-- Add New -->
          <x-link_add_new url="{{ route('admin.testimonial.create') }}" />
        @endif
        @if($roleRights['delete'])
          @if( count( $dataListModel ) > 0 )
            <!-- Multi Delete -->
            <x-form.btn_multi_delete />
            &nbsp; 
          @endif    
        @endif 
      </div>
      <div class="card-block">
       <!-- Show message. -->
       <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
       <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.testimonial.delete') }}">
        {{ csrf_field() }}
        <div class="table-responsive dt-responsive">
          <table id="dom-jqry" class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                @if($roleRights['delete'])
                  @if( count( $dataListModel ) > 0 )
                  <th class="cc-w-35 no-sort-del">
                    <x-form.field.checkbox style="default" name="check_all" id="check_all" />
                  </th>
                  @endif
                @endif
                <th>{{ __('testimonial.name_txt') }}</th>
                <th class="cc-w-70 no-sort">{{ __('testimonial.prof_pic_txt') }}</th>
                <th>{{ __('testimonial.designation_txt') }}</th>
                <th>{{ __('testimonial.company_txt') }}</th>
                <th class="cc-w-60">{{ __('admin.order_txt') }}</th>
                <th class="cc-w-60 no-sort">{{ __('admin.status_txt') }}</th>
                <th class="cc-w-150">{{ __('admin.mdfy_date_txt') }}</th>
                <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
              </tr>
            </thead>
            <tbody>    
              @if( count($dataListModel) > 0 )             
              @foreach( $dataListModel as $key => $record )
              <tr role="row" class="">
                @if($roleRights['delete'])
                  <td class="sorting_{{ $record->tmnl_id }}">
                    <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->tmnl_id }}" fldclass="del-chkbx" />
                  </td>
                @endif
              <td>
                @if($roleRights['edit'])
                  <x-link_tooltip url="{{ route('admin.testimonial.edit', $record->tmnl_id) }}" title="{{ $listDataAtrArr['edit_txt'] }}">
                    {{ $record->name }}
                  </x-link_tooltip>
                @else
                    {{ $record->name }}
                @endif
                </td>
                <td>
                  @if( $record->media != null )
                    <x-link_tooltip url="{{  $record->media->getModuleVars()['media_folder'].$record->media['path'] }}" title="{{ $record->media->getModuleVars()['view_txt'] }}" target="{{ $record->media->getModuleVars()['target'] }}" placement="right">
                      <x-img src="{{ $record->media->getModuleVars()['media_folder'].$record->media['path'] }}" width="{{ $record->media->getModuleVars()['img_width']['small'] }}" class="img-fluid img-thumbnail w-70" />
                    </x-link_tooltip>
                  @endif
                </td>
                <td>{{ $record->designation }}</td>
                <td>{{ $record->company }}</td>
                <td>{{ $record->c_order > 0 ? $record->c_order : '' }}</td>
                <td>
                  @if($roleRights['edit'])
                    <label id="change_status{{ $record->tmnl_id }}" onclick="return changeStatus('tmnl_id', {{ $record->tmnl_id }}, 'testimonial', {{ $record->status }}, '{{ $statusAtrArr['status_type'] }}');" class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }}">{{ $statusAtrArr['label'][$record->status] }}</label>
                  @else
                    <label class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }} no-drop">{{ $statusAtrArr['label'][$record->status] }}</label>
                  @endif                                    
                </td>
                <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)) }}</td>
                <td>{{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}</td>
               </tr>
               @endforeach  
               @else
                  <tr>
                    <td colspan="9">{{ __('message.data_not_available') }}</td>
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