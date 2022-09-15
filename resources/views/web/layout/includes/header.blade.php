
<section class="trade_detais_sec d-none">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                    <div class="live-market-data">
                        <div class="container">
                            <div class="live-market-wrap">
                                <div id="marketRadar" style="display:none">
                                    <input type="hidden" value="0" id="pricevalcntr">
                                    <div class="tpSec clearfix">
                                        <div class="stockDsl">
                                            <div class="mrdBox item" id="elm1"></div>
                                            <div class="mrdBox item" id="elm2"></div>
                                            <div class="mrdBox item" id="elm3"></div>
                                            <div class="mrdBox item" id="elm4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <nav class="navbar navbar-expand-lg">

                        <a class="navbar-brand" href="{{url('/')}}">
                            <img src="{{asset('themes/frontend/assets/v1/img/logo-white.png')}}" />
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="ph-list-light"></i>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                            {!! $webtopquicklinkmenuNew ?? '' !!}
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

