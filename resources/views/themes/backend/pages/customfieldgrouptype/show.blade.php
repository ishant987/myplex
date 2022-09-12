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
                <x-link_edit_new title='Edit' url="{{ route('admin.customfield.grouptype.edit', [ $dataArr->cf_group_id, $dataArr->cf_group_type_id]) }}" />
            </div>
            <div class="card-block">

            <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.sel_fldfor_txt') }}" for="title" 
                error="{{ $errors->first('field_for') }}">
                <i>{{ $dataArr->getCfForAssoc()[$dataArr->field_for] }}</i>
            </x-form.group_lyt1_2_10>

            <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.sel_fldtype_txt') }}" for="title" 
                error="{{ $errors->first('field_type') }}">
                <i>{{ $dataArr->field_type }}</i>
            </x-form.group_lyt1_2_10>

            <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.field_name_txt') }}" for="title" 
                error="{{ $errors->first('field_name') }}">
                <i>{{ $dataArr->field_name }}</i>
            </x-form.group_lyt1_2_10>

            <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.label_txt') }}" for="title" 
                error="{{ $errors->first('title') }}">
                <i>{{ $dataArr->field_options['label'] }}</i>
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
                <x-link_add_new url="{{ route('admin.customfield.grouptype.classtemplate.create', [$dataArr->cf_group_id, $dataArr->cf_group_type_id]) }}" />
                
                @if( count( $dataListModel ) > 0 )
                <!-- Multi Delete -->
                <x-form.btn_multi_delete />
                @endif
            </div>
            <div class="card-block">
                <!-- Show message. -->
                <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.deletecustomfieldgrouptypeclasstemplate') }}">
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
                                <th>{{ __('admin.customfield.grouptype.class_name_txt') }}</th>
                                <th>{{ __('admin.customfield.grouptype.template_for_txt') }}</th>
                                <th class="cc-w-150">{{ __('admin.mdfy_date_txt') }}</th>
                                <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
                                </tr>
                            </thead>
                            <tbody>      
                                @if( count($dataListModel) > 0 )       
                                @foreach( $dataListModel as $key => $record )
                                <tr role="row" class="">
                                <td class="sorting_{{ $record->cf_gt_class_template_id }}">
                                <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->cf_gt_class_template_id }}" fldclass="del-chkbx" />
                                </td>
                                <td>
                                <x-link_tooltip url="{{ route('admin.customfield.grouptype.classtemplate.edit', [ $record->cfgt->cf_group_id, $record->cf_group_type_id, $record->cf_gt_class_template_id]) }}" title="">
                                {{ $record->moduleclass->class_name }}
                                </x-link_tooltip>
                                </td>
                                <td>{{ $record->template->title }}</td>
                                <td>{{ strtotime($record->updated_at)?date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)):'' }}</td>
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