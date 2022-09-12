@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('customfield.grouptype.classtemplate.create', $dataArr) }} 
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5 class="card-header-text">{{ __('admin.customfield.grouptype.classtemplate.add_txt') }}</h5>
            </div>
            <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            
            <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.customfield.grouptype.classtemplate.store', [$dataArr->cf_group_id, $dataArr->cf_group_type_id])}}" method="POST">
                {{ csrf_field() }}

                <x-form.section_label>
                {{ __('admin.general_lbl') }}
                </x-form.section_label>

                <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.class_name_txt') }}" for="class_id" 
                    error="{{ $errors->first('class_id') }}" required="true">
                <select id="class_id" class="form-control" name="class_id">
                    <option value="">--Select--</option>
                    @foreach( $moduleClassAssoc as $class_id => $class_name )
                    <option value="{{ $class_id }}" {{ ( $class_id == old('class_id') ) ? 'selected' : '' }}>{{ $class_name }}</option>
                    @endforeach
                </select>
                </x-form.group_lyt1_2_10>

                <x-form.group_lyt1_2_10 label="{{ __('admin.customfield.grouptype.template_for_txt') }}" for="template_id" 
                    error="{{ $errors->first('template_id') }}" required="true">
                <select id="template_id" class="form-control" name="template_id">
                    
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
        getclasstemplate('{{ old('template_id') }}');
    });

    $('#class_id').bind('change', function() {       
        getclasstemplate();
    });

    function getclasstemplate(template_id)
    {
        var class_id = $('#class_id').val();
        var url = '';
        if(class_id)
        {
            url = '{{ route("admin.customfield.grouptype.classtemplate.getclasstemplate", ":class_id") }}';
            url = url.replace(':class_id', class_id);
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (data)
                {
                    var $el = $("#template_id");
                    $el.empty(); // remove old options
                    $.each(data, function(key,value) {
                    $el.append($("<option></option>")
                        .attr("value", key).text(value));
                    });
                    if(template_id)
                        $('#template_id option[value="'+template_id+'"]').attr("selected", "selected");
                }
            });
        }
    }
</script>
@endpush