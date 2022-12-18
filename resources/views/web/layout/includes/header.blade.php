<section class="trade_detais_sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="trade_details_result">
                    {{-- <div class="single_trade_info">
                        RELIANCE 2,576.10 <span class="up_trade"><i class="ph-caret-up-fill"></i> 0.05%</span>
                    </div> --}}
                    {{-- <div class="single_trade_info">
                        SBIN 540.40 <span class="down_trade"><i class="ph-caret-down-fill"></i> 0.05%</span>
                    </div>
                    <div class="single_trade_info">
                        TCS 3280.60 <span class="down_trade"><i class="ph-caret-down-fill"></i> 0.05%</span>
                    </div>
                    <div class="single_trade_info">
                        NIFTY 50 17295.85.60 <span class="up_trade"><i class="ph-caret-up-fill"></i> 0.05%</span>
                    </div>
                    <div class="single_trade_info">
                        BAJFINANCE 7335.30 <span class="up_trade"><i class="ph-caret-up-fill"></i> 0.05%</span>
                    </div>
                    <div class="single_trade_info">
                        BHARATIARTL 686.00 <span class="up_trade"><i class="ph-caret-up-fill"></i> 0.05%</span>
                    </div>
                    <div class="single_trade_info">
                        HDFC BANK 1425.25 <span class="up_trade"><i class="ph-caret-up-fill"></i> 0.05%</span>
                    </div>
                    <div class="single_trade_info">
                        TCS 3280.60 <span class="down_trade"><i class="ph-caret-down-fill"></i> 0.05%</span>
                    </div>
                    <div class="single_trade_info">
                        NIFTY 50 17295.85.60 <span class="up_trade"><i class="ph-caret-up-fill"></i> 0.05%</span>
                    </div>
                    <div class="single_trade_info">
                        BAJFINANCE 7335.30 <span class="up_trade"><i class="ph-caret-up-fill"></i> 0.05%</span>
                    </div>
                    <div class="single_trade_info">
                        BHARATIARTL 686.00 <span class="up_trade"><i class="ph-caret-up-fill"></i> 0.05%</span>
                    </div>
                    <div class="single_trade_info">
                        HDFC BANK 1425.25 <span class="up_trade"><i class="ph-caret-up-fill"></i> 0.05%</span>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>
<section class="header_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar_section">
                    <nav class="navbar navbar-expand-lg p-0">

                        <a class="navbar-brand" href="{{url('/')}}">
                            <img src="{{asset('themes/frontend/assets/v1/img/logo-white-backup.png')}}" />
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="ph-list-light"></i>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                            {{-- {!! $webtopquicklinkmenuNew ?? '' !!} --}}
                            <div class="navbar-nav">
                                <!---<a class="nav-link active" aria-current="page" href="/monthly-ranking">Monthly Ranking</a>--->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Portfolio
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/fund-portfolio">Fund Portfolio</a></li>
                                        <li><a class="dropdown-item" href="/composition-snapshot">Composition Snapshot</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Snapshot Report
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/monthly-snapshot">Monthly Snapshot</a></li>
                                        <li><a class="dropdown-item" href="/weekly-snapshot">Weekly Snapshot</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Paathshaala
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/mutual-fund-taxation">Mutual Fund Taxation</a></li>
                                        <li><a class="dropdown-item" href="/mutual-fund-classifications">Mutual Fund Classifications</a></li>
                                        <li><a class="dropdown-item" href="/know-the-ratio">Know The Ratio</a></li>
                                        <li><a class="dropdown-item" href="#">Thoughts and Opinion on Funds</a></li>
                                        <li><a class="dropdown-item" href="/mutual-fund-dictionary">Mutual Fund Dictionary</a></li>
                                    </ul>
                                </li>
                                <!-----<a class="nav-link" href="/fund-watch">Fund Watch</a>------>
                                <a class="nav-link" href="{{route('web.get-blogs')}}">Money Seriously</a>
								
								<li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                       About Us
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/about">About Us</a></li>
                                        <li><a class="dropdown-item" href="/contact">Contact Us</a></li>
                                    </ul>
                                </li>
                                <a class="cta_header_link" href="/ask-an-expert">Ask Experts</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

