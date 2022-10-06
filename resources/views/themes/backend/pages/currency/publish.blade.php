@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('currencies.publish.create') }}
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5 class="card-header-text">{{ __('admin.currency.publish_label_txt') }}</h5>
            </div>
            <div class="card-block">
                <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

                <form name="addForm" id="addForm" action="{{ route('admin.currencies.publish.store')}}" method="POST">
                    {{ csrf_field() }}

                    <x-form.group_lyt1_2_10 label="{{ __('admin.value_ready_txt') }}" for="values_ready" error="{{ $errors->first('values_ready') }}" required="true">
                        <x-form.field.text id="values_ready" name="values_ready" value="{{ $otherData['values_ready_date'] }}" readonly="true" />
                    </x-form.group_lyt1_2_10>

                    <x-form.group_lyt1_2_10 label="{{ __('admin.value_published_txt') }}" for="values_published" error="{{ $errors->first('values_published') }}" required="true">
                        <x-form.field.text id="values_published" name="values_published" value="{{ $otherData['values_published_date'] }}" readonly="true" />
                    </x-form.group_lyt1_2_10>

                    <x-form.group_lyt1_2_10 label="{{ __('admin.secret_txt') }}" for="secret" error="{{ $errors->first('secret') }}" required="true">
                        <x-form.field.text type="password" id="secret" name="secret" value="" />
                    </x-form.group_lyt1_2_10>

                    <div class="row">
                        <div class="col-sm-12">
                            <x-form.group_lyt1_2_10 class="m-t-10">
                                <x-form.field.button id="submit" name="submit" />
                                <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}" />
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