@extends('web.layout.infosolz_user_app')

@section('content')

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
        <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="#">dashboard</a></li>
                    <li><a href="#">filters</a></li>
                    <li>By Ratios</li>
                </ul>
            </div>
            <div class="new_page">
            <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                <div class="light_green_bg">
                    <form action=""> 
                            <div class="row">
                            <div class="col-md-2">
                            <div class="form_group radio_btn">
                                    <label>
                                        <input type="radio" name="by" value="return" checked="">
                                        Return
                                    </label>
                                   </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <select>
                                        <option value="">Return</option>
                                        <option value="">Bse 200</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form_group radio_btn">
                                    <label>
                                        <input type="radio" name="by" value="risk">
                                        Risk
                                    </label>
                                   </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="form_group">
                                <select>
                                        <option value="">By function</option>
                                        <option value="">Open ended</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <input type="text" placeholder="Return">
                                </div>
                            </div>
                            
                            <!-- <div class="col-md-12">
                                <div class="bttn_grp">
                                    <button type="submit" id="classification" disabled="">show by classification</button>
                                    <button type="submit" id="fund_type" disabled="">show by fund</button>
                                </div>
                            </div> -->
                        </div>
                    </form>
                </div>

                <div class="fund_section new_fund_section">
                    <ul>
                        <li>
                            <p>Return ratios as on  :</p>
                            <span>00/00/0000</span>
                        </li>
                        <li>
                            <p>Fund Return :</p>
                            <span>Return</span>
                        </li>
                        <li>
                            <p>Fund risk :</p>
                            <span>Volatility</span>
                        </li>
                        <li>
                            <p>Fund Classification :</p>
                            <span>abc</span>
                        </li>
                        <li>
                            <p>Top fund :</p>
                            <span>10</span>
                        </li>
                    </ul>
                </div>

                <div class="graph_table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text_left">fund name</th>
                                <th class="text_center">Value</th>
                                <th class="text_center">rank</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>abc</td>
                                <td class="text_right">99.8</td>
                                <td class="text_right">1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
              
</div>

@endsection
