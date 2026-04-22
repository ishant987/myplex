@extends('web.layout.infosolz_user_app')

@section('content')

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
        <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="#">dashboard</a></li>
                    <li><a href="#">filters</a></li>
                    <li>By Jensen’s</li>
                </ul>
            </div>
            <div class="new_page">
            <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                <div class="light_green_bg">
                    <form action=""> 
                            <div class="row">
                            <div class="col-md-5">
                                <div class="form_group">
                                    <select>
                                        <option value="">Fund</option>
                                        <option value="">Bse 200</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <input type="text" placeholder="Return">
                                </div>
                            </div>
                            
                            
                            <div class="col-md-3">
                                <div class="bttn_grp">
                                    <button type="submit">6m</button>
                                    <button type="submit">1y</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="fund_section new_fund_section">
                    <ul>
                        <li>
                            <p>Current daye  :</p>
                            <span>00/00/0000</span>
                        </li>
                        <li>
                            <p>Index name :</p>
                            <span>abc</span>
                        </li>
                        <li>
                            <p>Current value :</p>
                            <span>11.5</span>
                        </li>
                    </ul>
                </div>

                <div class="graph_section">
                    <img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/graph.png" alt="">
                </div>

            </div>
        </div>
    </div>
              
</div>

@endsection
