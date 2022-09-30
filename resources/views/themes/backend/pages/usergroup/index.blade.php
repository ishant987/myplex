@extends('themes.backend.layouts.app')
@section('dataTables') @stop

@section('breadcrumb')
{{ Breadcrumbs::render('usergroup.index') }} 
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('subscribeduser.user_group.all_txt') }}</h5>
        @if($roleRights['add'])
          <!-- Add New -->
          <x-link_add_new url="{{ route('admin.usergroup.create') }}" />
        @endif
        @if($roleRights['delete'])
          <!-- Multi Delete -->
          @if( count( $dataListModel ) > 1 )
            <x-form.btn_multi_delete />
            &nbsp;     
          @endif
        @endif
      </div>
      <div class="card-block">
       <!-- Show message. -->
       <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
       <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.deleteusergroup') }}">
        {{ csrf_field() }}
        <div class="table-responsive dt-responsive">
          <table id="dom-jqry" class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                @if($roleRights['delete'])
                  @if( count( $dataListModel ) > 1 )
                    <th class="cc-w-35 no-sort-del">
                      <x-form.field.checkbox style="default" name="check_all" id="check_all" />
                    </th>
                  @endif
                @endif
                <th>{{ __('subscribeduser.user_group.name') }}</th>
                <th class="cc-w-150">{{ __('admin.mdfy_date_txt') }}</th>
                <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
              </tr>
            </thead>
            <tbody>             
              @if( count($dataListModel) > 0 )         
              @foreach( $dataListModel as $key => $record )
              <tr role="row" class="">
                @if($roleRights['delete'])
                  @if( $record->u_g_id != 1 )
                    <td class="sorting_{{ $record->u_g_id }}">
                      <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->u_g_id }}" fldclass="del-chkbx" />
                    </td>
                    @else
                      @if( count( $dataListModel ) > 1 )
                        <td></td>
                      @endif
                  @endif
                @endif
              <td>
                @if($roleRights['edit'])
                  <x-link_tooltip url="{{ route('admin.usergroup.edit', $record->u_g_id) }}" title="{{ $listDataAtrArr['edit_txt'] }}">
                    {{ $record->group_name }}
                  </x-link_tooltip>
                @else
                    {{ $record->group_name }}
                @endif
                </td>
                <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)) }}</td>
                <td>{{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}</td>
               </tr>
               @endforeach 
               @else
                <tr>
                  <td colspan="4">{{ __('message.data_not_available') }}</td>
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