<script src="{{asset('themes/frontend/assets/v1/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('themes/frontend/assets/v1/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="{{ mix('js/vue-app.js') }}"></script>
<script src="{{asset('themes/frontend/assets/v1/js/stock_header.js')}}"></script>
<script src="{{asset('themes/frontend/assets/v1/js/custom.js')}}"></script>
<script src="{{ asset('themes/assets/js/jquery.validate.min.js') }}"></script>
<script src="{{asset('themes/frontend/assets/v1/js/newsletter.js')}}"></script>
{{-- @if(View::hasSection('moneycontrol'))
<script src="https://stat2.moneycontrol.com/mcjs/common/jquery-1.7.2.min.js"></script>
<script>
  var ct_v = '170940';
</script>
<!-- <script src="https://www.gstatic.com/swiffy/v7.3.0/runtime.js"></script> -->
<script src="https://stat4.moneycontrol.com/mcjs/mcradar/market_radar_aws.js?ver=20200516"></script>
<script src="https://stat.moneycontrol.co.in/mcjs/mcradar/jquery-ui-1.10.3.custom.min.js"></script>
<script src=" https://stat.moneycontrol.co.in/mcjs/portfolio_plus/datepicker.js?"></script>
<script src="https://stat.moneycontrol.co.in/mcjs/mcradar/jquery.webticker.js"></script>
@endif --}}

@stack('scripts')