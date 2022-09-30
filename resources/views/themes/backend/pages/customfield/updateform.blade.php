@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['route'], $dataArr) }} 
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5 class="card-header-text">{{ $editDataAtrArr['title'] }}</h5>
            </div>
            <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            
            <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.customfield.update', $dataArr->cf_group_id)}}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <x-form.section_label>
                {{ __('admin.general_lbl') }}
                </x-form.section_label>

                <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" 
                    error="{{ $errors->first('title') }}" required="true">
                    <x-form.field.text id="title" name="title" value="{{ $dataArr->title }}" />
                </x-form.group_lyt1_2_10>                                   
                
                <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" 
                    error="{{ $errors->first('c_order') }}">
                    <x-form.field.text id="c_order" name="c_order" value="{{ $dataArr->c_order > 0 ? $dataArr->c_order : '' }}" />
                </x-form.group_lyt1_2_10>      

                <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="status" 
                    error="{{ $errors->first('status') }}" required="true">
                <select id="status" class="form-control" name="status">
                    @foreach( $moduleAtrArr['status'] as $sid => $status )
                    <option value="{{ $sid }}" @if((old('status') > 0) && ($sid == old('status'))) {{ 'selected' }} @elseif((($dataArr->status > 0) && ($sid == $dataArr->status))) {{ 'selected' }} @endif>{{ $status }}</option>
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