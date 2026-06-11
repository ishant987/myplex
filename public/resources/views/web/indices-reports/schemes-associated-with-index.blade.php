@extends('web.layout.infosolz_user_app')

@section('content')

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.indices_report') }}">indices report</a></li>
                        <li>Schemes Associated<br> With Index</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>Schemes Associated With Index</h2>
                    </div>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form_group">
                                        <select name="selected_index" class="select2" data-placeholder="Select Index">
                                            <option value="">Select Indices</option>
                                            @foreach ($indices as $index_val)
                                                <option value="{{ $index_val->name }}"
                                                    {{ !empty($request) && $request->selected_index == $index_val->name ? 'Selected' : '' }}>
                                                    {{ $index_val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form_group">
                                        <input type="text" class="datepicker" name="date" placeholder="Date"
                                            value="{{ isset($request->date) ? date('d/m/Y', strtotime($request->date)) : '' }}">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="bttn_grp">
                                        <button type="submit" id="classification">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (isset($all_schemes) && count($all_schemes) > 0)
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>Index Name :</p>
                                    <span>{{ !empty($request) ? $request->selected_index : '' }}</span>
                                </li>
                                <li>
                                    <p>As On : </p>
                                    <span>{{ !empty($request) ? date('d/m/Y', strtotime($request->date)) : '' }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="graph_table">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th class="text_left">Schemes name</th>
                                        <th class="text_left">Fund Category</th>
                                        <th class="text_center">NAV (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_schemes as $schemes)
                                        <tr>
                                            <td class="text_left">{{ $schemes->fund_name }}</td>
                                            <td class="text_left">{{ $schemes->classification }}</td>
                                            <td class="text_right">{{ printValue($schemes->closing_nav) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {!! printNoData() !!}
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection
