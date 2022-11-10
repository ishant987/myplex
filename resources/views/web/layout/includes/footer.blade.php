<section class="footer_section ">
    <div class="container">
        <div class="row align-items-center ">
            <div class="col-md-4 col-lg-3">
                <div class="footer_logo_sec">
                    <img src="{{asset('themes/frontend/assets/v1/img/logo-white.png')}}" alt='myplex-logo'/>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's</p>

                    <div class="neswlatter_inner d-block d-sm-flex align-items-center mb-4">
                        <form action="{{ route('web.newsletter.save') }}" name="newsletterFrm" id="newsletterFrm" method="post">
                            </form>
                            <div class="newsletter_input_group">
                                <input type="email" name="email" id="email" placeholder="Enter Your Email" />
                                <span><img src="{{asset('themes/frontend/assets/v1/img/newslatter_icon.png')}}" /></span>
                            </div>
                            <button class="subsribe_btn money_title_btn"  ><i class="ph-arrow-right-light"></i></button>
                        <div id="msg_id"></div>
                    </div>

                    <div class="footer_social">
                        @if( isset( $optsDbArr['facebook'] ) || isset( $optsDbArr['twitter'] ) || isset( $optsDbArr['linkedin'] ) )
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
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="row">
                    <div class="col-md-6 col-lg-3 col-6 ">
                        <div class="footer_menu color_inverse">
                            <h4>Important Links</h4>
                            <ul>
                                <li><a href="/">Home Page</a></li>
                                <li><a href="/compare-scheme">Compare Scheme</a></li>
                                <li><a href="/calculator">Calculator</a></li>
                                <li><a href="#">Paathshaala</a></li>
                                <li><a href="#">Money Seriously</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-6 ">
                        <div class="footer_menu">
                            <h4>Fund</h4>
                            <ul>

                                <li><a href="/fund-portfolio">Fund Portfolio</a></li>
                                <li><a href="/fund-performance">Fund Performance</a></li>
                                <li><a href="/fund-watch">Fund Watch</a></li>
                                <li><a href="/nfo-monitor">NFO Monitor</a></li>
                                <li><a href="#">Know Your Scheme</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-6 ">
                        <div class="footer_menu color_inverse ">
                            <h4>Snapshot</h4>
                            <ul>
                                <li><a href="/monthly-ranking">Rankings</a></li>
                                <li><a href="/monthly-snapshot">Monthly Snapshot</a></li>
                                <li><a href="/weekly-snapshot">Weekly Snapshot</a></li>
                                <li><a href="/composition-snapshot">Composition Snapshot</a></li>
                                <li><a href="/pentatech">Pentatec</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-6 ">
                        <div class="footer_menu">
                            <h4>Company</h4>
                            <ul>
                                <li><a href="/about">About Us</a></li>
                            <li><a href="#">Contact Us</a></li>                                    
                            <li><a href="#">In The News</a></li>
                            <li><a href="/faq">FAQs</a></li>
                            <li><a href="/founder">Meet The Fund Man</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="copyright_inner d-sm-flex d-block align-items-center justify-content-between">
                    <p>©Copyright {{date('Y')}} All Rights Reserved.</p>
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