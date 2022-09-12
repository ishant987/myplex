@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('customfield.grouptype.create', $dataArr) }} 
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5 class="card-header-text">{{ __('admin.customfield.grouptype.add_txt') }}</h5>
            </div>
            <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            
            <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.customfield.grouptype.store', $dataArr->cf_group_id)}}" method="POST">
                {{ csrf_field() }}

                <x-form.section_label>
                {{ __('admin.general_lbl') }}
                </x-form.section_label>

                <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.sel_fldfor_txt') }}" for="field_for" 
                    error="{{ $errors->first('field_for') }}" required="true">
                <select id="field_for" class="form-control" name="field_for">
                    @foreach( $cfForAssoc as $fld_for => $field_for )
                    <option value="{{ $fld_for }}" {{ ( $fld_for == old('field_for') ) ? 'selected' : '' }}>{{ $field_for }}</option>
                    @endforeach
                </select>
                </x-form.group_lyt1_2_10>

                <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.sel_fldtype_txt') }}" for="field_type" 
                    error="{{ $errors->first('field_type') }}" required="true">
                <select id="field_type" class="form-control" name="field_type">
                    @foreach( $cfTypeAssoc as $type => $field_type )
                    <option value="{{ $type }}" {{ ( $type == old('field_type') ) ? 'selected' : '' }}>{{ $field_type }}</option>
                    @endforeach
                </select>
                </x-form.group_lyt1_2_10>

                <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.label_txt') }}" for="label" 
                    error="{{ $errors->first('label') }}" required="true">
                    <x-form.field.text id="label" name="label" value="{{ old('label') }}" />
                </x-form.group_lyt1_2_10>                                   

                <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.placeholder_txt') }}" for="placeholder" 
                    error="{{ $errors->first('placeholder') }}">
                    <x-form.field.text id="placeholder" name="placeholder" value="{{ old('placeholder') }}" />
                </x-form.group_lyt1_2_10>      

                <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.required_txt') }}" for="required" 
                    error="{{ $errors->first('required') }}">
                <select id="required" class="form-control" name="required">
                    @foreach( $reqArr as $opt => $optval )
                    <option value="{{ $opt }}" {{ ( $opt == old('optval') ) ? 'selected' : '' }}>{{ $optval }}</option>
                    @endforeach
                </select>
                </x-form.group_lyt1_2_10>  

                <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.description_txt') }}" for="description" 
                    error="{{ $errors->first('description') }}">
                    <x-form.field.textarea id="description" name="description" value="{!! old('description') !!}" />
                </x-form.group_lyt1_2_10>                                   

                <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.instruction_txt') }}" for="instruction" 
                    error="{{ $errors->first('instruction') }}">
                    <x-form.field.textarea id="instruction" name="instruction" value="{!! old('instruction') !!}" />
                </x-form.group_lyt1_2_10>                                   
                
                <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" 
                    error="{{ $errors->first('c_order') }}">
                    <x-form.field.text id="c_order" name="c_order" value="{{ old('c_order') > 0 ? old('c_order') : '' }}" />
                </x-form.group_lyt1_2_10>      

                <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="status" 
                    error="{{ $errors->first('status') }}" required="true">
                <select id="status" class="form-control" name="status">
                    @foreach( $statsArr as $sid => $status )
                    <option value="{{ $sid }}" {{ ( $sid == old('status') ) ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                </x-form.group_lyt1_2_10>

                <div class="row">
                    <div class="col-sm-12">
                    <x-form.group_lyt1_2_10 class="m-t-10">
                    <x-form.field.button id="submit" name="submit" />
                    <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}"/>
                    </x-form.group_lyt1_2_10>
                    </div>
                </div>

            </form>
            </div>
            <!-- end of card-block -->
        </div>
    </div>
</div>
@stop

@push('scripts') 
<script>

    $(document).ready(function () {
        getdefaultoption();
    });

    $('#field_type').bind('change', function() {       
        getdefaultoption();
    });

    function getdefaultoption()
    {
        var field_type = $("#field_type").val();
        var url = '';
        if(field_type)
        {
            url = '{{ route("admin.customfield.grouptype.defaultoption", ":field_type") }}';
            url = url.replace(':field_type', field_type);
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (data)
                {
                    $("#label").val(data.label);
                    $("#placeholder").val(data.placeholder);
                    if(data.required)
                        $("#required").val('y');
                    else
                        $("#required").val('n');
                    $("#description").val(data.description);
                    $("#instruction").val(data.instruction);
                }
            });
        }
    }
</script>
@endpush