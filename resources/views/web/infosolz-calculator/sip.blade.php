@extends('web.layout.infosolz_app')


@section('content')
   

<section class="inner-top">

    <div class="container">
        <h3 class="report-sub-heading">Report : SIP Return</h3>
        <form id="myForm" onsubmit="return sipSearchFormValidation()">
            <div class="top-form">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper mb-2">
                                <label>Fund Name :</label>
                                <select class="form-control single-select2" name="search_fund_name" required>
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
                                <label>SIP Amount (INR) :</label>
                                <input type="text" name="search_sip_amount" id="sip_amount" value="{{old('search_sip_amount',isset($search_sip_amount)?$search_sip_amount:'')}}" class="onlynum form-control" required >
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper mb-2">
                                <label>Term (Year) :</label>
                                <input type="text" name="search_term" id="sip_term" class="onlynum form-control" value="{{old('search_term',isset($search_term)?$search_term:'')}}"  onkeyup="getEntryDate();getReportDate();">
                            </div>
                        </div>
                        @if ($errors->has('search_term'))
                            <span class="text-danger">{{ $errors->first('search_term') }}</span>
                        @endif
                        <span class="text-danger" id="sip_term_err_msg"></span>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper mb-2">
                                <label>Term (Month) :</label>
                                <input type="text" name="search_term_month" id="sip_term_month" class="onlynum form-control" value="{{old('search_term_month',isset($search_term_month)?$search_term_month:'')}}"  onkeyup="getEntryDate();getReportDate();">
                            </div>
                        </div>
                        @if ($errors->has('search_term_month'))
                            <span class="text-danger">{{ $errors->first('search_term_month') }}</span>
                        @endif
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>Entry Date :</label>
                                <input type="text" id="sip_entry_date" name="search_entry_date" value="{{old('search_from_date',isset($search_entry_date)?$search_entry_date:'')}}" class=" form-control" readonly required onchange="getReportDate()">
                            </div>
                            @if ($errors->has('search_entry_date'))
                                <span class="text-danger">{{ $errors->first('search_entry_date') }}</span>
                            @endif
                            <span class="text-danger" id="sip_entry_date_err_msg"></span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>Report Date :</label>
                                <input type="text" class=" form-control" id="report_date" name="search_report_date" value="{{old('search_report_date',isset($search_report_date)?$search_report_date:'')}}" readonly required>
                            </div>
                            @if ($errors->has('search_report_date'))
                                <span class="text-danger">{{ $errors->first('search_report_date') }}</span>
                            @endif
                            <span class="text-danger" id="report_date_err_msg"></span>
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
                                <th style="text-align: center">SIP Amount (INR)</th>
                                <th style="text-align: center">NAV</th>
                                <th style="text-align: center">Units</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(isset($searched_result) && count($searched_result) > 0)
                            @php $i = 1; @endphp
                                @foreach($searched_result as $row)
                                    <tr>
                                        <td align="center">{{$i++}}</td>
                                        <td align="center" style="white-space: nowrap;">{{$row['entry_date']}}</td>
                                        <td align="right">{{$row['sip_amount']}}</td>
                                        <td align="right">{{$row['fund_closing']}}</td>
                                        <td align="right">{{$row['units']}}</td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        @if(isset($search_report_date) &&
            isset($redemption_date) &&
            isset($total_sip_amount) &&
            isset($final_nav) &&
            isset($sum_of_units) &&
            isset($xirr))
            <div class="row">

                <div class="col-12">
                    <div class="table-wrapper">
                        <table class="table table-bordered result-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Report Date</th>
                                    <th style="text-align: center">Redemption Date </th>
                                    <th style="text-align: center">SIP Amount (INR)</th>
                                    <th style="text-align: center">Nav</th>
                                    <th style="text-align: center">Units</th>
                                    <th style="text-align: center">SIP Return</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td align="center">{{$search_report_date}}</td>
                                    <td align="center">{{$redemption_date}}</td>
                                    <td align="center">{{$total_sip_amount}}</td>
                                    <td align="center">{{$final_nav}}</td>
                                    <td align="center">{{$sum_of_units}}</td>
                                    <td align="center">{{$xirr}}</td>
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