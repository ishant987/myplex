@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('customfield.create') }} 
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5 class="card-header-text">{{ __('admin.customfield.add_txt') }}</h5>
            </div>
            <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            
            <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.customfield.store')}}" method="POST">
                {{ csrf_field() }}

                <x-form.section_label>
                {{ __('admin.general_lbl') }}
                </x-form.section_label>

                <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" 
                    error="{{ $errors->first('title') }}" required="true">
                    <x-form.field.text id="title" name="title" value="{{ old('title') }}" />
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