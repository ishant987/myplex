@extends('web.layout.infosolz_app')


@section('content')
   

<section class="inner-top">

    <div class="container">
        <h3 class="report-sub-heading">Report : Tracking Error</h3>
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

                    <div class="col-lg-6 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>From Date :</label>
                                <input type="text" id="from" name="search_from_date" value="{{old('search_from_date',isset($search_from_date)?$search_from_date:'')}}" class=" form-control" readonly required>
                            </div>
                            @if ($errors->has('search_from_date'))
                                <span class="text-danger">{{ $errors->first('search_from_date') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6">
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
                                <th style="text-align: center">Fund Return (A)</th>
                                <th style="text-align: center">Index Return (B)</th>
                                <th style="text-align: center">A-B</th>
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
                                        <td align="right">{{$row['index_return']}}</td>
                                        <td align="right">{{$row['sub_of_fund_index']}}</td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        @if(isset($tracking_error))
            <div class="row">

                <div class="col-12">
                    <div class="table-wrapper">
                        <table class="table table-bordered result-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Tracking Error</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td align="center">{{$tracking_error}}</td>
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