@extends('web.layout.infosolz_app')


@section('content')
   

<div class="card-section">
    
    <div class="container">
        <h3 class="report-heading">Report Dashboard</h3>
        <div class="card-wrapper">
            <div class="card">
                <a href="{{url('report-beta')}}">Beta </a>
            </div>

            <div class="card">
                <a href="{{url('report-volatility')}}">Volatility </a>
            </div>

            <div class="card">
                <a href="{{url('report-jensens-alpla')}}">Jensen's Alpha </a>
            </div>

            <div class="card">
                <a href="{{url('report-sharpe')}}">Sharpe</a>
            </div>

            <div class="card">
                <a href="{{url('report-treynor')}}">Treynor</a>
            </div>

            <div class="card">
                <a href="{{url('report-tracking-error')}}">Tracking Error </a>
            </div>

            <div class="card">
                <a href="{{url('report-information-ratio')}}">Information Ratio </a>
            </div>

            <div class="card">
                <a href="{{url('report-r-squere')}}">R Square </a>
            </div>

            <div class="card">
                <a href="{{url('report-skewness')}}">Skewness   </a>
            </div>

            <div class="card">
                <a href="{{url('report-kurtosis')}}">Kurtosis   </a>
            </div>

            <div class="card">
                <a href="{{url('report-sip-return')}}">SIP Return</a>
            </div>

            <div class="card">
                <a href="{{url('report-rolling-return')}}">Rolling Return</a>
            </div>

            <div class="card">
                <a href="{{url('report-cagr')}}">CAGR Return </a>
            </div>

            <div class="card">
                <a href="{{url('report-sortino')}}">Sortino Ratio</a>
            </div>
        </div>
        
    </div>
</div>
@endsection