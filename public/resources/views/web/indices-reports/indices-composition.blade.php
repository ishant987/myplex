@extends('web.layout.infosolz_user_app')

@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.indices_report') }}">indices report</a></li>
                        <li>Indices Composition</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>Indices Composition</h2>
                    </div>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select class="select2" name="indices" data-placeholder="Select Indices">
                                            <option value="">Select Indices</option>
                                            @foreach ($indices as $index)
                                                <option value="{{ $index->corelation }}"
                                                    @if (isset($indices_name) && $index->corelation == $indices_name) selected @endif>{{ $index->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="text" class="datepicker" placeholder="Start Date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="text" class="datepicker" placeholder="End Date">
                                    </div>
                                </div> --}}

                                @include('web.layout.includes.year_month', [
                                    'yearFieldName' => 'year',
                                    'monthFieldName' => 'month',
                                    'selectedYear' => $year ?? '',
                                    'selectedMonth' => $month ?? '',
                                    'size' => 3,
                                ])

                                <div class="col-md-2">
                                    <div class="bttn_grp">
                                        <button type="submit" id="classification">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if (isset($indices_composition))
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>Benchmark :</p>
                                    @isset($indices_name)
                                        <span>{{ $indices_name }}</span>
                                    @endisset
                                </li>
                                <li>
                                    <p>Indices Composition : </p>
                                    @if (isset($year) && isset($month))
                                        <span>For the Month of {{ date('F', mktime(0, 0, 0, $month, 1, $year)) }},
                                            {{ $year }}</span>
                                    @endif

                                </li>
                            </ul>
                        </div>

                        <div class="graph_table">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>name of the scrip</th>
                                        <th>type</th>
                                        <th>industry</th>
                                        <th class="text_center">percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($indices_composition)
                                        @foreach ($indices_composition as $item)
                                            <tr>
                                                <td>{{ $item['scrip_name'] }}</td>
                                                <td>{{ $item['type'] }}</td>
                                                <td>{{ $item['industry'] }}</td>
                                                <td class="text_right">{{ number_format($item['percentage'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @endisset

                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="graph_section">
                            <p style="text-align: center;">Please search above to show the results</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
