@extends('web.layout.infosolz_app')


@section('content')
   

<section class="inner-top">

    <div class="container">
        <h3 class="report-sub-heading">Report : Sortino</h3>
        <form id="myForm">
            <div class="top-form">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper mb-2">
                                <label>Fund Name :</label>
                                <select class="form-control single-select2" name="search_fund_name" id="fund_name_id" onchange="getIndicesName()" required>
                                    <option value="">Select Fund</option>
                                    @if(isset($fundNames))
                                        @foreach($fundNames as $row)
                                            @if($row->fund_code != '')
                                                <option value="{{$row->fund_code}}" @if(old('search_fund_name',isset($search_fund_name)?$search_fund_name:'') == $row->fund_code) selected @endif>{{$row->fund_name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            @if ($errors->has('search_fund_name'))
                                <span class="text-danger">{{ $errors->first('search_fund_name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper mb-2">
                                <label>Indices Name :</label>
                                <input type="text" id="indices_name_id" name="search_indices_name" class=" form-control" readonly required>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label style="max-width: 235px;">Minimum Acceptable Return(MAR) :</label>
                                <div class="position-relative">
                                <div class="position-relative">
                                     <input type="text" name="search_mar" id="search_mar" onkeyup="checkMarVal()" value="{{old('search_mar',isset($search_mar)?$search_mar:'')}}" class=" form-control" required style="width:100px;">
                                     <i class="position-absolute top-50 end-0 translate-middle-y" style="padding:5px;">%</i>
                                </div>
                                <div class="position-absolute top-100 start-0 translate-middle" style="padding-left:48px; padding-top: 20px;">
                                <em>p.a</em>
                                </div>
                                </div>
                            </div>
                            @if ($errors->has('search_mar'))
                                <span class="text-danger">{{ $errors->first('search_mar') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>Form Date :</label>
                                <input type="text" id="from" name="search_from_date" value="{{old('search_from_date',isset($search_from_date)?$search_from_date:'')}}" class=" form-control" readonly required>
                            </div>
                            @if ($errors->has('search_from_date'))
                                <span class="text-danger">{{ $errors->first('search_from_date') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>To Date :</label>
                                <input type="text" class=" form-control" id="to" name="search_to_date" value="{{old('search_to_date',isset($search_to_date)?$search_to_date:'')}}" readonly required>
                            </div>
                            @if ($errors->has('search_to_date'))
                                <span class="text-danger">{{ $errors->first('search_to_date') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">

                    <div class="col-lg-12 col-sm-12">
                        <div class="form-submit">
                            <input type="submit" name="search" class="search-submit" value="Search">
                            {{-- <a href="javascript:void(0)" onclick="document.getElementById('myForm').submit()" >Search</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">

            <div class="col-12">
                <div class="table-wrapper">
                    <table class="table table-bordered result-table" id="myDatatable">
                        <thead>
                            <tr>
                                <th style="text-align: center">#</th>
                                <th style="text-align: center">Entry Date</th>
                                <th style="text-align: center">Fund Closing</th>
                                <th style="text-align: center">Indices Closing</th>
                                <th style="text-align: center">Fund Return</th>
                                <th style="text-align: center">Fund Return-MAR</th>
                                <th style="text-align: center">Negative Returns</th>
                                <th style="text-align: center">(Negative Returns)<sup>2</sup></th>
                                <th style="text-align: center">Fund Return - Daily Risk Free</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(isset($searched_result) && count($searched_result) > 0)
                            @php $i = 1; @endphp
                                @foreach($searched_result as $row)
                                    <tr>
                                        <td align="center">{{$i++}}</td>
                                        <td align="center" style="white-space: nowrap;">{{$row['entry_date']}}</td>
                                        <td align="right">{{$row['fund_closing']}}</td>
                                        <td align="right">{{$row['indices_closing']}}</td>
                                        <td align="right">{{$row['fund_return']}}</td>
                                        <td align="right">{{$row['fund_return_mar']}}</td>
                                        <td align="right">{{$row['negetive_return']}}</td>
                                        <td align="right">{{$row['negetive_return_squere']}}</td>
                                        <td align="right">{{$row['fund_return_daily_risk_free']}}</td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        @if(isset($search_mar) &&
            isset($daily_risk_free) &&
            isset($daily_mar) &&
            isset($downside_risk) &&
            isset($fund_return_daily_risk_free_average) &&
            isset($sortino))
            <div class="row">

                <div class="col-12">
                    <div class="table-wrapper">
                        <table class="table table-bordered result-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Minimum Acceptable Return(MAR)</th>
                                    <th style="text-align: center">Daily Risk Free</th>
                                    <th style="text-align: center">Daily MAR</th>
                                    <th style="text-align: center">Downside Risk</th>
                                    <th style="text-align: center">Average of (Fund Return-Daily Risk Free)</th>
                                    <th style="text-align: center">Sortino</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td align="center">{{$search_mar}}%</td>
                                    <td align="center">{{$daily_risk_free}}</td>
                                    <td align="center">{{$daily_mar}}</td>
                                    <td align="center">{{$downside_risk}}</td>
                                    <td align="center">{{$fund_return_daily_risk_free_average}}</td>
                                    <td align="center">{{$sortino}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        @endif
    </div>
</section>
@endsection