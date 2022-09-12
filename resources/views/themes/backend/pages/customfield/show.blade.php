@extends('themes.backend.layouts.app')
@section('dataTables') @stop

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['route'], $dataArr) }} 
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5 class="card-header-text">{{ $editDataAtrArr['title'] }}</h5>
                <!-- Edit New -->
                <x-link_edit_new title='Edit' url="{{ route('admin.customfield.edit', $dataArr->cf_group_id) }}" />
            </div>
            <div class="card-block">

            <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" 
                error="{{ $errors->first('title') }}">
                <i>{{ $dataArr->title }}</i>
            </x-form.group_lyt1_2_10>

            <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="status" 
                error="{{ $errors->first('status') }}">
                <i>{{ $moduleAtrArr['status'] }}</i>
            </x-form.group_lyt1_2_10>
            
            </div>
            <!-- end of card-block -->
        </div>
    </div>
</div>

<!-- Custom fields groups -->

<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5 class="card-header-text">{{ $editDataAtrArr['titlegt'] }}</h5>
                <!-- Add New -->
                <x-link_add_new url="{{ route('admin.customfield.grouptype.create', $dataArr->cf_group_id) }}" />
                
                @if( count( $dataListModel ) > 0 )
                <!-- Multi Delete -->
                <x-form.btn_multi_delete />
                @endif
            </div>
            <div class="card-block">
                <!-- Show message. -->
                <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.deletecustomfieldgrouptype') }}">
                    {{ csrf_field() }}
                    <div class="table-responsive dt-responsive">
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                @if( count( $dataListModel ) > 0 )
                                <th class="cc-w-35 no-sort-del">
                                    <x-form.field.checkbox style="default" name="check_all" id="check_all" />
                                </th>
                                @endif
                                <th>{{ __('admin.customfield.field_name_txt') }}</th>
                                <th>{{ __('admin.customfield.field_type_txt') }}</th>
                                <th>{{ __('admin.customfield.field_for_txt') }}</th>
                                <th>{{ __('admin.customfield.field_options_txt') }}</th>
                                <th class="cc-w-60">{{ __('admin.order_txt') }}</th>
                                <th class="cc-w-60 no-sort">{{ __('admin.status_txt') }}</th>
                                <th class="cc-w-150">{{ __('admin.mdfy_date_txt') }}</th>
                                <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
                                <th class="cc-w-95 no-sort">{{ __('admin.action_txt') }}</th>
                                </tr>
                            </thead>
                            <tbody>      
                                @if( count($dataListModel) > 0 )       
                                @foreach( $dataListModel as $key => $record )
                                <tr role="row" class="">
                                <td class="sorting_{{ $record->cf_group_type_id }}">
                                <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->cf_group_type_id }}" fldclass="del-chkbx" />
                                </td>
                                <td>
                                <x-link_tooltip url="{{ route('admin.customfield.grouptype.edit', [ $record->cf_group_id, $record->cf_group_type_id]) }}" title="">
                                {{ $record->field_name }}
                                </x-link_tooltip>
                                </td>
                                <td>{{ $record->field_type }}</td>
                                <td>{{ $record->getCfForAssoc()[$record->field_for] }}</td>
                                <td>
                                    {!! __('admin.customfield.grouptype.label_txt').': <i>'.$record->field_options['label'].'</i>' !!}<br/>
                                    {!! __('admin.customfield.grouptype.placeholder_txt').': <i>'.$record->field_options['placeholder'].'</i>' !!}<br/>
                                    {{__('admin.customfield.grouptype.required_txt') }}: {!! '<i>'.$record->field_options['required']?'Yes':'No'.'</i>' !!}<br/>
                                    {!! __('admin.customfield.grouptype.description_txt').': <i>'.$record->field_options['description'].'</i>' !!}<br/>
                                    {!! __('admin.customfield.grouptype.instruction_txt').': <i>'.$record->field_options['instruction'].'</i>' !!}
                                </td>
                                <td>{{ $record->c_order }}</td>
                                <td>
                                <label id="change_status{{ $record->cf_group_type_id }}" onclick="return changeStatus('cf_group_type_id', {{ $record->cf_group_type_id }}, 'custom_field_group_type', {{ $record->status }}, '{{ $statusAtrArr['status_type'] }}','{{ route('admin.changestatus') }}');" class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }}">{{ $statusAtrArr['label'][$record->status] }}</label>                                   
                                </td>
                                <td>{{ strtotime($record->updated_at)?date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)):'' }}</td>
                                <td>{{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}</td>
                                <td>
                                    <x-link_tooltip url="{{ route('admin.customfield.grouptype.show', [$record->cf_group_id, $record->cf_group_type_id]) }}" title="List" class="f-20" placement="left">
                                        <i class="ti-view-list"></i>
                                    </x-link_tooltip>
                                </td>
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