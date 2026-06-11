@extends('web.layout.infosolz_user_app')

@section('content')

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
        <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="{{route('user.auth-dashboard')}}">dashboard</a></li>
                    <li>filters</li>
                </ul>
            </div>
            <div class="new_page">
            <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                <div class="perform_head">
                    <h2>filters</h2>
                </div>
                
                <div class="light_green_bg">
                    <form action=""> 
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form_group radio_btn">
                                    <label>
                                        <input type="radio" name="ranking" value="range" checked>
                                        Date Range
                                    </label>
                                    <label>
                                        <input type="radio" name="ranking" value="as_on">
                                        As On
                                    </label>
                                    </div>
                                    
                            </div>

                            <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="text" class="datepicker">
                                    </div>
                            </div>

                            <div class="col-md-3">
                                    <div class="form_group">
                                        <select>
                                            <option value="">Duration</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form_group">
                                        <select>
                                            <option value="">Category</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form_group">
                                        <select>
                                            <option value="">Ratios</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="text" placeholder="Records">
                                    </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form_group">
                                        <select>
                                            <option value="">Composition</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form_group">
                                        <select>
                                            <option value="">Return Ratio</option>
                                        </select>
                                    </div>
                            </div>

                             <div class="col-md-12">
                                <div class="bttn_grp">
                                    <button type="submit" name="search" id="fund_type_btn" value="search">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="fund_section new_fund_section">
                    <ul>
                                                
                        
                        <li>
                            <p>Fund type : </p>
                            <span>N/A</span>
                        </li>
                        <li>
                            <p>Composition : </p>
                            <span>N/A</span>
                        </li>
                        <li>
                            <p>Return Ratio : </p>
                            <span>N/A</span>
                        </li>
                      


                    </ul>
                </div>

                <div class="graph_table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fund name</th>
                                <th>Industry Name</th>
                                <th class="text_center">content (%)</th>
                                <th class="text_center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>            
                            <tr>
                                <td>abc</td>
                                <td>xyz</td>
                                <td class="text_right">000</td>
                                <td class="text_right">000</td>
                            </tr>          
                             <!-- <tr>
                                <td class="text_center" colspan="4">No data available in table</td>
                            </tr>  -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
              
</div>

<!-- <div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                    <div class="head_brdcm">
                        <ul class="brdcmb">
                            <li><a href="#">dashboard</a></li>
                            <li><a href="#">filters</a></li>
                            <li>filters</li>
                        </ul>
                    </div>
                        <div class="all_dash">
                            <ul>
                                <li>
                                    <a href="{{route('user.filters.ratios')}}">
                                        <figure><img src="{{asset('new-images/By-Ratios.png')}}" alt=""></figure>
                                        <h4>By Ratios</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.filters.composition')}}">
                                        <figure><img src="{{asset('new-images/By-Composition.png')}}" alt=""></figure>
                                        <h4>By Composition</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.filters.jensens')}}">
                                        <figure><img src="{{asset('new-images/dh4.png')}}" alt=""></figure>
                                        <h4>By Jensen’s</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.filters.beta')}}">
                                        <figure><img src="{{asset('new-images/by-Beta.png')}}" alt=""></figure>
                                        <h4>By Beta</h4>
                                    </a>
                                </li>
                               
                                <li>
                                    <a href="{{route('user.filters.volatility')}}">
                                        <figure><img src="{{asset('new-images/Volatility.png')}}" alt=""></figure>
                                        <h4>By Volatility</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>

                       
                    </div>
                   
                </div>
        </div> -->

@endsection
