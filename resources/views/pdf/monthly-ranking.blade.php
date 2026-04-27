<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Ranking</title>
</head>

<body style="font-family: 'Volte-Semibold'; color: #000;">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
    @font-face {
    font-family: 'Volte-Regular';
    src: url('{{ url('fonts/Volte-Regular.ttf') }}') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'Volte-Medium';
    src: url('{{ url('fonts/Volte-Medium.ttf') }}') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'Volte-Semibold';
    src: url('{{ url('fonts/Volte-Semibold.ttf') }}') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'Volte-Bold';
    src: url('{{ url('fonts/Volte-Bold.ttf') }}') format('truetype');
    font-weight: normal;
    font-style: normal;
}
table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Volte-Regular'
     
}
table td.header{
    font-family: 'Volte-Bold'
}
.data_tr{
    font-family: 'Volte-Medium'
}
.container {
    width: 100%;
    max-width: 96%;
    margin: 0 auto;
}
.half {
    width: 50%;
}
tbody tr:last-child td {
    border-bottom: 0 !important;
}
tbody tr:last-child {
    border-radius: 5px;
}

.table-col {
    justify-content: space-between;
}
.top-banner::after {
    position: absolute;
    content: '';
    top: -10px;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('{{ url('images/top-layer.png') }}');
    background-repeat: no-repeat;
    background-size: contain;
    z-index: 0;
}
.w-arr{
    width:15px;
}
</style>

    <div class="top-banner" style="border-top: 10px solid #6ab130; background-image: url('{{ url('images/banner-img.jpg') }}'); background-repeat: no-repeat; background-size: cover; padding-bottom: 70px; position: relative;">
        <div class="container">
            <table style="">
                <tbody style="">
                    <tr style="">
                        <td style="">
                            <p style="width: 480px; margin: 0 auto; text-transform: uppercase; font-size: 55px; line-height: 50px; font-family: 'Volte-Bold'; text-align: center; color: #fff; background-color: #6ab130; padding: 35px 30px 0 30px;"><span style="position: relative; z-index: 1;">{{ $branding['headline'] ?? 'myplexus.com' }}</span></p>
                            <p style="width: 480px; margin: 0 auto; font-size:28px; text-align: center; color: #fff; background-color: #6ab130; padding: 0px 30px 30px 30px; border-bottom-right-radius: 25px; border-bottom-left-radius: 25px;"><span style="position: relative; z-index: 1;">{{ $branding['tagline'] ?? 'Search, Research Mutual Funds' }}</span></p>
                        </td>
                    </tr>
                    <tr style=" margin-top: 90px;">
                        <td style="">
                            <p style="text-align: center; font-family: 'Volte-Bold'; font-size: 60px; color: #fff;">Monthly Ranking</p>
                            <p style="text-align: center; color: #6ab130; font-size: 35px;">
                                <span class="title">{{$dataArr['type_data']['name']}}</span><br>
                                <span class="date">{{ $dataArr['month'] }}, {{ $dataArr['year'] }}</span>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<table style="margin-bottom: 0px; margin-top: 0px;font-size:12px">
        
        <thead style="" class="container">
            <tr role="row" style=" text-align: center;">
                <td class="header" style="background-color: #000; color: #509b41; padding: 15px 20px;" colspan="1" rowspan="1">&nbsp;</td>
                <td class="header" style="background-color: #000; color: #509b41; padding: 15px 20px;" colspan="1" rowspan="1">&nbsp;</td>
                <td class="header" style="background-color: #000; color: #509b41; padding: 15px 20px;" colspan="1" rowspan="1">&nbsp;</td>
                <td class="header" style="background-color: #000; color: #509b41; padding: 15px 20px;border-left:1px solid #fff; " rowspan="1" colspan="3">RANKING</td>
            </tr>
            <tr style=" text-align: left;">
                <td class="header" style="background-color: #000; color: #509b41; padding: 15px 20px;width:20% ">Name of the Fund</td>
                <td class="header" style="background-color: #000; color: #509b41; padding: 15px 20px;width:20% ">AAUM (Rs. Lacs)</td>
                <td class="header" style="background-color: #000; color: #509b41; padding: 15px 20px;width:10% ">Return% (1 Year)</td>
                <td class="header" style="background-color: #000; color: #509b41; padding: 15px 20px;border-left:1px solid #fff;width:20% ">Return Quality</td>
                <td class="header" style="background-color: #000; color: #509b41; padding: 15px 20px;width:20%">Volatility</td>
                <td class="header" style="background-color: #000; color: #509b41; padding: 15px 20px;width:20% ">Market Risk</td>
            </tr>
        </thead>
        <tbody style="box-shadow: 2px 8px 15px -6px #0000001f;  border: 1px solid #e7e4e4; border-top: 0; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;" class="container">
            @foreach($dataArr['monthly_ranking_data'] as $monthly_ranking_data)

                @if(!$monthly_ranking_data['one_year_return'])
                <tr style=" background-color:#f7f7fb;" class="data_tr">
                    <td style=" padding: 15px 20px; border-bottom: 1px solid #000;" rowspan="1" colspan="1">{{ $monthly_ranking_data['fund_name'] }}</td>
                    <td style=" padding: 15px 20px; border-bottom: 1px solid #000;text-align:center;" rowspan="1" colspan="5">NA</td>
                </tr>
                @else
                <tr style=" background-color:#f7f7fb;" class="data_tr">
                    <td style=" padding: 15px 20px; border-bottom: 1px solid #000;">{{ $monthly_ranking_data['fund_name'] }}</td>
                    <td style=" padding: 15px 20px; border-bottom: 1px solid #000;text-align:center;">
                        @if($monthly_ranking_data['per_change_aaum'] > 0)
                        <img class="w-arr" src="{{ url('images/up-green-arrow.png') }}" title="{{ $monthly_ranking_data['per_change_aaum'] }}%" class="arrow-up" > 
                        @elseif($monthly_ranking_data['per_change_aaum'] < 0)
                        <img class="w-arr" src="{{ url('images/down-red-arrow.png') }}"  title="{{ $monthly_ranking_data['per_change_aaum'] }}%" class="arrow-up" > 
                        @endif
                        ({{ number_format((float)$monthly_ranking_data['per_change_aaum'], 2, '.', '') }}%)<br>
                        {{ number_format((float)$monthly_ranking_data['aaum'], 2, '.', '') }}
                    </td>
                    <td style=" padding: 15px 20px; border-bottom: 1px solid #000;text-align:center;">{{ number_format((float)$monthly_ranking_data['one_year_return'], 2, '.', '') }}</td>
                    <td style=" padding: 15px 20px; border-bottom: 1px solid #000;text-align:center;">
                        <img  src="{{ url('images/'.$monthly_ranking_data['return_quality'].'-green-star.png') }}" title="{{ $monthly_ranking_data['return_quality'] }}" alt="{{ $monthly_ranking_data['return_quality'] }}">
                    </td>
                    <td style=" padding: 15px 20px; border-bottom: 1px solid #000;text-align:center;">
                        <img  src="{{ url('images/'.$monthly_ranking_data['volatality'].'-red-star.png') }}" title="{{ $monthly_ranking_data['volatality'] }}" alt="{{ $monthly_ranking_data['volatality'] }}">
                    </td>
                    <td style=" padding: 15px 20px; border-bottom: 1px solid #000;text-align:center;">
                        <img src="{{ url('images/'.$monthly_ranking_data['market_risk'].'-red-star.png') }}" title="{{ $monthly_ranking_data['market_risk'] }}" alt="{{ $monthly_ranking_data['market_risk'] }}">
                    </td>
                </tr>
                @endif

            @endforeach
        </tbody>
    </table>
    <!-- FOOTER -->

    <table style=" background-image: url('{{ url('images/footer-bg.jpg') }}'); background-size: 100%; background-repeat: no-repeat; padding: 28px 0 10px 0;">
        <tbody style="" class="container">
            <tr style="justify-content:space-between">
                <td class="half" style="padding-left:20px;margin-top: -10px"><img src="{{ $branding['footer_logo'] ?? public_path('images/myplexus-footer-logo.png') }}" /></td>
                <td class="half" style="text-align: right;padding-right:20px">
                    <a href="https://www.facebook.com/MyplexusMF" target="_blank" style="margin-right: 8px;"><img src="{{ url('images/facebook-icon.png') }}"></a>
                    <a href="https://twitter.com/myplexusMF" target="_blank" style="margin-right: 8px;"><img src="{{ url('images/twiiter-icon.png') }}"></a>
                    <a href="https://www.linkedin.com/company/myplexus.com" target="_blank" style="margin-right: 8px;"><img src="{{ url('images/linkedin-icon.png') }}"></a>
                </td>
            </tr>
        </tbody>
    </table>

<table style="background-color: #000; padding: 20px 0;">
    <tbody>
        <tr class="container">
            <td><p style="font-size: 16px; line-height: 24px; margin: 0; opacity: 0.5; color: #fff;padding-left:20px">Copyright© 2020 All rights reserved.</p></td>
        </tr>
    </tbody>
</table>
</body>

</html>
