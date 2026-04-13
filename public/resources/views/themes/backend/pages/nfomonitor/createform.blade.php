@extends('themes.backend.layouts.app')

@section('autocomplete') @endsection
@section('fancybox') @stop

@section('breadcrumb')
    {{ Breadcrumbs::render('nfomonitor.create') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card m-b-0">
                <div class="card-header">
                    <h5 class="card-header-text">{{ __('admin.nfomonitor.add_txt') }}</h5>
                </div>
                <div class="card-block">
                    <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}"
                        message="{{ session()->get('message') }}" />

                    <form name="aeDataFrm" id="aeDataFrm" action="{{ route('admin.nfo-monitor.store') }}" method="POST">
                        {{ csrf_field() }}

                        <x-form.section_label>
                            {{ __('admin.nfomonitor.fund_facts_lbl') }}
                        </x-form.section_label>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.fund_name') }}" for="fund_name"
                            error="{{ $errors->first('fund_name') }}" required="true">
                            <x-form.field.text id="fund_name" name="fund_name" value="{{ old('fund_name') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.fund_opening') }}" for="fund_opening"
                            error="{{ $errors->first('fund_opening') }}" required="true">
                            <x-form.field.text id="fund_opening" name="fund_opening" value="{{ old('fund_opening') }}"
                                class="def-date" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.fund_closing') }}" for="fund_closing"
                            error="{{ $errors->first('fund_closing') }}" required="true">
                            <x-form.field.text id="fund_closing" name="fund_closing" value="{{ old('fund_closing') }}"
                                class="def-date" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.ft_id') }}" for="ft_id"
                            error="{{ $errors->first('ft_id') }}" required="true">
                            <select name="ft_id" id="ft_id" class="form-control">
                                <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                                @foreach ($moduleAtrArr['fund_type_list'] as $key => $fType)
                                    <option value="{{ $fType->ft_id }}"
                                        @if ($fType->ft_id == old('ft_id')) {{ 'selected' }} @endif>{{ $fType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.minimum_investment') }}"
                            for="minimum_investment" error="{{ $errors->first('minimum_investment') }}" required="true">
                            <x-form.field.text id="minimum_investment" name="minimum_investment"
                                value="{{ old('minimum_investment') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.plan') }}" for="plan"
                            error="{{ $errors->first('plan') }}" required="true">
                            <x-form.field.text id="plan" name="plan" value="{{ old('plan') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.options') }}" for="options"
                            error="{{ $errors->first('options') }}" required="true">
                            <x-form.field.text id="options" name="options" value="{{ old('options') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.entry_load') }}" for="entry_load"
                            error="{{ $errors->first('entry_load') }}" required="true">
                            <x-form.field.text id="entry_load" name="entry_load" value="{{ old('entry_load') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.exit_load') }}" for="exit_load"
                            error="{{ $errors->first('exit_load') }}" required="true">
                            <x-form.field.text id="exit_load" name="exit_load" value="{{ old('exit_load') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.thereafter') }}" for="thereafter"
                            error="{{ $errors->first('thereafter') }}" required="true">
                            <x-form.field.text id="thereafter" name="thereafter" value="{{ old('thereafter') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.section_label>
                            {{ __('admin.nfomonitor.fund_stats_lbl') }}
                        </x-form.section_label>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.objective') }}" for="objective"
                            error="{{ $errors->first('objective') }}" info="{!! __('admin.info.descp') !!}" required="true">
                            <x-form.field.textarea id="objective" name="objective" value="{!! old('objective') !!}"
                                rows="5" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.idc_id') }}" for="idc_id"
                            error="{{ $errors->first('idc_id') }}" required="true">
                            <select name="idc_id" id="idc_id" class="form-control">
                                <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                                @foreach ($moduleAtrArr['index_list'] as $key => $index)
                                    <option value="{{ $index->idc_id }}"
                                        @if ($index->idc_id == old('idc_id')) {{ 'selected' }} @endif>{{ $index->name }}
                                    </option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.fund_manager') }}" for="fund_manager"
                            error="{{ $errors->first('fund_manager') }}" required="true">
                            <x-form.field.text id="fund_manager" name="fund_manager" value="{{ old('fund_manager') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.section_label>
                            {{ __('admin.nfomonitor.asset_allocation_lbl') }}
                        </x-form.section_label>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.aa_col1_value') }}" for="aa_col1_value"
                            error="{{ $errors->first('aa_col1_value') }}" required="true">
                            <x-form.field.text id="aa_col1_value" name="aa_col1_value"
                                value="{{ old('aa_col1_value') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.aa_col1_text') }}" for="aa_col1_text"
                            error="{{ $errors->first('aa_col1_text') }}" required="true">
                            <x-form.field.text id="aa_col1_text" name="aa_col1_text" value="{{ old('aa_col1_text') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.aa_col2_value') }}" for="aa_col2_value"
                            error="{{ $errors->first('aa_col2_value') }}" required="true">
                            <x-form.field.text id="aa_col2_value" name="aa_col2_value"
                                value="{{ old('aa_col2_value') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.aa_col2_text') }}" for="aa_col2_text"
                            error="{{ $errors->first('aa_col2_text') }}" required="true">
                            <x-form.field.text id="aa_col2_text" name="aa_col2_text" value="{{ old('aa_col2_text') }}" />
                        </x-form.group_lyt1_2_10>
						
						<x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.aa_col3_value') }}" for="aa_col3_value"
                            error="{{ $errors->first('aa_col3_value') }}" required="true">
                            <x-form.field.text id="aa_col3_value" name="aa_col3_value"
                                value="{{ old('aa_col3_value') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.aa_col3_text') }}" for="aa_col3_text"
                            error="{{ $errors->first('aa_col3_text') }}" required="true">
                            <x-form.field.text id="aa_col3_text" name="aa_col3_text" value="{{ old('aa_col3_text') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.aa_col4_value') }}" for="aa_col4_value"
                            error="{{ $errors->first('aa_col4_value') }}" required="true">
                            <x-form.field.text id="aa_col4_value" name="aa_col4_value"
                                value="{{ old('aa_col4_value') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.aa_col4_text') }}" for="aa_col4_text"
                            error="{{ $errors->first('aa_col4_text') }}" required="true">
                            <x-form.field.text id="aa_col4_text" name="aa_col4_text" value="{{ old('aa_col4_text') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.section_label>
                            {{ __('admin.nfomonitor.comparable_existing_schemes_lbl') }}
                        </x-form.section_label>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.ces_row1_col1_text') }}"
                            for="ces_row1_col1_text" error="{{ $errors->first('ces_row1_col1_text') }}" required="true">
                            <x-form.field.text id="ces_row1_col1_text" name="ces_row1_col1_text"
                                value="{{ old('ces_row1_col1_text') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.ces_row1_col2_text') }}"
                            for="ces_row1_col2_text" error="{{ $errors->first('ces_row1_col2_text') }}" required="true">
                            <x-form.field.text id="ces_row1_col2_text" name="ces_row1_col2_text"
                                value="{{ old('ces_row1_col2_text') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.ces_row1_col3_text') }}"
                            for="ces_row1_col3_text" error="{{ $errors->first('ces_row1_col3_text') }}" required="true">
                            <x-form.field.text id="ces_row1_col3_text" name="ces_row1_col3_text"
                                value="{{ old('ces_row1_col3_text') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.ces_row2_col1_text') }}"
                            for="ces_row2_col1_text" error="{{ $errors->first('ces_row2_col1_text') }}" required="true">
                            <x-form.field.text id="ces_row2_col1_text" name="ces_row2_col1_text"
                                value="{{ old('ces_row2_col1_text') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.ces_row2_col2_text') }}"
                            for="ces_row2_col2_text" error="{{ $errors->first('ces_row2_col2_text') }}" required="true">
                            <x-form.field.text id="ces_row2_col2_text" name="ces_row2_col2_text"
                                value="{{ old('ces_row2_col2_text') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.ces_row2_col3_text') }}"
                            for="ces_row2_col3_text" error="{{ $errors->first('ces_row2_col3_text') }}" required="true">
                            <x-form.field.text id="ces_row2_col3_text" name="ces_row2_col3_text"
                                value="{{ old('ces_row2_col3_text') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.section_label>
                            {{ __('admin.nfomonitor.fund_prognonosis_lbl') }}
                        </x-form.section_label>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.idea_distiller') }}" for="idea_distiller"
                            error="{{ $errors->first('idea_distiller') }}" info="{!! __('admin.info.descp') !!}"
                            required="true">
                            <x-form.field.textarea id="idea_distiller" name="idea_distiller" value="{!! old('idea_distiller') !!}"
                                rows="5" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.fund_house_aaum') }}"
                            for="fund_house_aaum" error="{{ $errors->first('fund_house_aaum') }}" required="true">
                            <x-form.field.text id="fund_house_aaum" name="fund_house_aaum"
                                value="{{ old('fund_house_aaum') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.fund_manager_experience') }}"
                            for="fund_manager_experience" error="{{ $errors->first('fund_manager_experience') }}"
                            required="true">
                            <x-form.field.text id="fund_manager_experience" name="fund_manager_experience"
                                value="{{ old('fund_manager_experience') }}" />
                        </x-form.group_lyt1_2_10>

                        <x-form.section_label>
                            {{ __('admin.nfomonitor.scheme_dna_lbl') }}
                        </x-form.section_label>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.uniqness') }}" for="uniqness"
                            error="{{ $errors->first('uniqness') }}" required="true">
                            <select name="uniqness" id="uniqness" class="form-control">
                                <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                                @foreach ($moduleAtrArr['scheme_dna_list'] as $key => $value)
                                    <option value="{{ $value }}"
                                        @if ($value == old('uniqness')) {{ 'selected' }} @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.return') }}" for="return"
                            error="{{ $errors->first('return') }}" required="true">
                            <select name="return" id="return" class="form-control">
                                <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                                @foreach ($moduleAtrArr['scheme_dna_list'] as $key => $value)
                                    <option value="{{ $value }}"
                                        @if ($value == old('return')) {{ 'selected' }} @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.risk') }}" for="risk"
                            error="{{ $errors->first('risk') }}" required="true">
                            <select name="risk" id="risk" class="form-control">
                                <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                                @foreach ($moduleAtrArr['scheme_dna_list'] as $key => $value)
                                    <option value="{{ $value }}"
                                        @if ($value == old('risk')) {{ 'selected' }} @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.operability') }}" for="operability"
                            error="{{ $errors->first('operability') }}" required="true">
                            <select name="operability" id="operability" class="form-control">
                                <option value="">{{ __('admin.def_drop_optn_styl2_txt') }}</option>
                                @foreach ($moduleAtrArr['scheme_dna_list'] as $key => $value)
                                    <option value="{{ $value }}"
                                        @if ($value == old('operability')) {{ 'selected' }} @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </x-form.group_lyt1_2_10>

                        <x-form.section_label>
                            {{ __('admin.others_lbl') }}
                        </x-form.section_label>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.oomph_factor') }}" for="oomph_factor"
                            error="{{ $errors->first('oomph_factor') }}" info="{!! __('admin.info.descp') !!}" required="true">
                            <x-form.field.textarea id="oomph_factor" name="oomph_factor" value="{!! old('oomph_factor') !!}"
                                rows="5" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.media_id') }}" for="media_id"
                            error="{{ $errors->first('media_id') }}" info="{!! __('admin.nfomonitor.media_id_info') !!}">
                            <div class="media_img_area">
                                <x-link_media_popup href="0" src="{{ route('admin.media.gallery', 0) }}">
                                    {{ __('admin.browse_media_txt') }}
                                </x-link_media_popup>
                                <x-form.field.hidden value="" name="media_id" id="featuredImgVal-0" />
                                <x-form.field.button_def
                                    class="btn-danger btn-mini waves-effect waves-light remove_featured show-scn m-t-10 d-none"
                                    id="featuredImgRemov-0" text="{{ __('admin.remove_media_txt') }}" />
                            </div>
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.nfomonitor.post_date') }}" for="post_date"
                            error="{{ $errors->first('post_date') }}" required="true">
                            <x-form.field.text id="post_date" name="post_date" value="{{ old('post_date') }}"
                                class="def-date" />
                        </x-form.group_lyt1_2_10>

                        <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="status"
                            error="{{ $errors->first('status') }}" required="true">
                            <select id="status" class="form-control" name="status">
                                @foreach ($statusArr as $id => $status)
                                    <option value="{{ $id }}" {{ $id == old('status') ? 'selected' : '' }}>
                                        {{ $status }}</option>
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
            $(".def-date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
@endpush
