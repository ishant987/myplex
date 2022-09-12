
<section class="footer_section pt-4">
    <div class="container">
        <div class="row pt-5 pb-5">
            <div class="col-md-4 col-lg-3">
                <div class="footer_logo_sec">
                    <img src="{{asset('themes/frontend/assets/v1/img/logo-white.png')}}" alt='myplex-logo'/>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    @if( isset( $optsDbArr['facebook'] ) || isset( $optsDbArr['twitter'] ) || isset( $optsDbArr['linkedin'] ) )
                    <div class="footer_social">
                        <ul class="d-flex align-items-center">
                            @if( isset( $optsDbArr['facebook'] ) )
                                <li><a href="{{ $optsDbArr['facebook'] }}" target="_blank"><i class="ph-facebook-logo-light"></i></a></li>
                            @endif
                            @if( isset( $optsDbArr['twitter'] ) )
                                <li><a href="{{$optsDbArr['twitter'] }}"><i class="ph-twitter-logo-light" target="_blank"></i></a></li>
                            @endif
                            @if( isset( $optsDbArr['linkedin'] ) )
                            <li><a href="{{$optsDbArr['linkedin']}}"><i class="ph-instagram-logo-light" target="_blank"></i></a></li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="row">
                    <div class="col-md-6 col-lg-3 col-6 ">
                        <div class="footer_menu">
                            <h4>Company</h4>
                            {!! $webFooterCompanyLinks!!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-6 ">
                        <div class="footer_menu">
                            <h4>Business Type</h4>
                            {!! $webFooterBusinessLinks !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-6 ">
                        <div class="footer_menu">
                            <h4>Products</h4>
                            {!! $webFooterProductsLinks !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-6 ">
                        <div class="footer_menu">
                            <h4>Explore</h4>
                          {!!$webFooterExploreLinks!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="copyright_inner d-sm-flex d-block align-items-center justify-content-between">
                    <p>©Copyright 2022 All Rights Reserved.</p>
                    <div class="copyright_menu">
                        <ul class="d-flex align-items-center justify-content-end">
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Sitemap</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>