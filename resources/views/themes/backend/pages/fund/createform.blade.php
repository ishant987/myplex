@extends('themes.backend.layouts.app')

@section('autocomplete') @endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('fund.create') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card m-b-0">
                <div class="card-header">
                    <h5 class="card-header-text">{{ __('admin.fund.add_txt') }}</h5>
                </div>
                <div class="card-block">
                    <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}"
                        message="{{ session()->get('message') }}" />

                    <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.fund.store') }}" method="POST">
                        {{ csrf_field() }}

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.name_txt') }}" for="fund_name"
                            error="{{ $errors->first('fund_name') }}" required="true">
                            <x-form.field.text id="fund_name" name="fund_name" value="{{ old('fund_name') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.code_txt') }}" for="fund_code"
                            error="{{ $errors->first('fund_code') }}" required="true">
                            <x-form.field.text id="fund_code" name="fund_code" value="{{ old('fund_code') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.corelation_txt') }}" for="cor"
                            error="{{ $errors->first('cor') }}" required="true">
                            <x-form.field.text id="cor" name="cor" value="{{ old('cor') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.house_txt') }}" for="fund_house"
                            error="{{ $errors->first('fund_house') }}" info="{{ __('message.info.autocomplete') }}"
                            required="true">
                            <x-form.field.text id="fund_house" name="fund_house" value="{{ old('fund_house') }}"
                                autocomplete="off" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.manager_txt') }}" for="fund_manager"
                            error="{{ $errors->first('fund_manager') }}" required="true">
                            <x-form.field.text id="fund_manager" name="fund_manager" value="{{ old('fund_manager') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.type_txt') }}" for="fund_type"
                            error="{{ $errors->first('fund_type') }}" required="true">
                            <select name="fund_type" id="fund_type" class="form-control">
                                <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                                @foreach ($moduleAtrArr['fund_type_list'] as $key => $fType)
                                    <option value="{{ $fType->ft_id }}"
                                        @if ($fType->ft_id == old('fund_type')) {{ 'selected' }} @endif>{{ $fType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.term_txt') }}" for="fund_term"
                            error="{{ $errors->first('fund_term') }}" required="true">
                            <select name="fund_term" id="fund_term" class="form-control">
                                <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                                @foreach ($moduleAtrArr['fund_term_list'] as $key => $fTerm)
                                    <option value="{{ $fTerm->ftm_id }}"
                                        @if ($fTerm->ftm_id == old('fund_term')) {{ 'selected' }} @endif>{{ $fTerm->term }}
                                    </option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.index_txt') }}" for="index"
                            error="{{ $errors->first('index') }}" required="true">
                            <select name="index" id="index" class="form-control">
                                <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                                @foreach ($moduleAtrArr['index_list'] as $key => $index)
                                    <option value="{{ $index->name }}"
                                        @if ($index->name == old('index')) {{ 'selected' }} @endif>{{ $index->name }}
                                    </option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.classification_txt') }}" for="classification"
                            error="{{ $errors->first('classification') }}" required="true">
                            <select name="classification" id="classification" class="form-control">
                                <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                                @foreach ($moduleAtrArr['fund_type_list'] as $key => $fType)
                                    <option value="{{ $fType->name }}"
                                        @if ($fType->name == old('fund_type')) {{ 'selected' }} @endif>{{ $fType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.face_value_txt') }}" for="face_value"
                            error="{{ $errors->first('face_value') }}" required="true">
                            <x-form.field.text id="face_value" name="face_value" value="{{ old('face_value') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.risk_free_return_txt') }}"
                            for="risk_free_return" error="{{ $errors->first('risk_free_return') }}" required="true">
                            <x-form.field.text id="risk_free_return" name="risk_free_return"
                                value="{{ old('risk_free_return') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.opened_txt') }}" for="fund_opened"
                            error="{{ $errors->first('fund_opened') }}" required="true">
                            <x-form.field.text id="fund_opened" name="fund_opened" value="{{ old('fund_opened') }}"
                                class="def-date" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.fund.cost_txt') }}" for="cost"
                            error="{{ $errors->first('cost') }}" required="true">
                            <x-form.field.text id="cost" name="cost" value="{{ old('cost') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="status"
                            error="{{ $errors->first('status') }}" required="true">
                            <select id="status" class="form-control" name="status">
                                @foreach ($moduleAtrArr['status_list']['label'] as $id => $status)
                                    <option value="{{ $id }}"
                                        {{ $id == old('status') ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <div class="row">
                            <div class="col-sm-12">
                                <x-form.group_lyt1_2_10 class="m-t-10">
                                    <x-form.field.button id="submit" name="submit" />
                                    <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger"
                                        text="{{ __('admin.cancel_txt') }}" />
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
        $(function() {
            var availableTags = {!! $moduleAtrArr['fund_house_list'] !!};
            $("#fund_house").autocomplete({
                source: availableTags
            });

            $(".def-date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
@endpush
