@extends('web.layout.app')
@if(isset($dataArr['meta_title']))
@section('page-title'){{$dataArr['meta_title']}}@stop
@else
@section('page-title'){{$dataArr['title']}}@stop
@endif
@if(isset($dataArr['meta_key']))
@section('meta-keywords'){{$dataArr['meta_key']}}@stop
@endif
@if(isset($dataArr['meta_descp']))
@section('meta-description'){{$dataArr['meta_descp']}}@stop
@endif
@if(isset($dataArr['image_path']))
@section('meta-image'){{$dataArr['image_path']}}@stop
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif
<style>
   .containers{
    
    margin: 0 auto;
   }
   div#loaders {
    position:absolute !important;
    top:500px !important;
    left:50% !important;
    
}
	table.table.fund_table,
table.table.fund_table td
{
    border:2px solid #00665e !important;
}
.fund_table th{
    background:#00665e !important;
    color:#fff !important;
  border:2px solid #000  
}
#dnon{
    display: none;
}
   @media(min-width:767px){
    .containers{
        width:1250px;
    }
   }
</style>
@section('content')
<div class="custom-banner no-bg fw-banner @if(!$dataArr['image_path']) fund-portfolio-banner  @endif" @if($dataArr['image_path']) style="background-image:url({{$dataArr['image_path']}})" @endif>
    <section class="inner_banner_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner_section_banner">
                        <h4>{{ $dataArr['title'] }}</h4>
                    </div>

                    <div class="col-lg-3 col-md-3 col-12 login-nav">
                        <ul class="navbar-nav d-flex flex-row justify-content-end">
                           <!-- @if(\Auth::check())
                            <li class="user-register">
                                <x-link url="{{ route('web.logout') }}">{{ __('auth.logout_txt') }}</x-link>
                            </li>
                            @endif-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- <div id="vue-app"> -->
<!-- <performance-synopsis image_path="{{asset('themes/frontend/assets/v1/img/')}}"></performance-synopsis> -->
<div class="bgcon" style="padding: 50px 0;
    background: linear-gradient(109.6deg, rgb(251, 250, 225) 11.2%, rgb(206, 240, 185) 47.5%, rgb(100, 163, 111) 100.2%);">
<div class="containers">
    <!-- <div id="loaders"><img  class="imgload" src="{{asset('themes/frontend/assets/v1/img/loading.gif')}}" alt="">'</div>  -->
    <h4 id="dnon">Quartile Returns Performance for Equity &amp; Equity Linked Schemes from <span id="quone"></span> to <span id="quotwo"></span></h4>
<table class="table fund_table">
<div id="loaders"><img  class="imgload" src="{{asset('themes/frontend/assets/v1/img/loading.gif')}}" alt="">'</div> 

    <thead>
        <tr>
            <th scope="col" rowspan="2">No. of Equity Schemes</th>
            <th scope="col" rowspan="2">Fund House</th>
            <th scope="col" colspan="4" class="text-center">Number of Schemes as per Quartile Ranks</th>
        </tr>
        <tr>
            <th scope="col" class="text-center">1</th>
            <th scope="col" class="text-center">2</th>
            <th scope="col" class="text-center">3</th>
            <th scope="col" class="text-center">4</th>
        </tr>
    </thead>
    

    <tbody id="myTbody">
        
    </tbody>
</table>
<div class="clearfix">&nbsp;</div>
</div>
</div>
@stop

<script>
    document.addEventListener("DOMContentLoaded", () => {
	    const loader = document.getElementById("loaders");
         loader.style.display = "block";

    fetch('https://new.myplexus.com/api/v1/performance-synopsis').then(function(response) {
        // The API call was successful!
        return response.json();
    }).then(function(data) {
        // This is the JSON from our response
       
        loader.style.display = "none";
        var datafund = [];
        var startdate=data.data['start_date'];
        var lastdate=data.data['last_date'];
        var spanone = document.getElementById("quone"); 
        var spantwo = document.getElementById("quotwo");
        const dnone = document.getElementById("dnon"); 
        spanone.textContent = startdate; 
        spantwo.textContent = lastdate; 
        dnone.style.display="block";
        

        const tbody = document.getElementById("myTbody");
        for (let info of data.data['data']) {
           // console.log(info);
            var fund_house = info['fund_house'];
            var total_scheme = info['total_scheme'];
            var one = info['one'];
            var two = info['two'];
            var three = info['three'];
            var four = info['four'];
            // console.log(total_scheme);
            
            //const cell1 = document.createElement("td");
            const newRow = document.createElement("tr");
            const cell1 = document.createElement("td");
            cell1.textContent = total_scheme;
            const cell2 = document.createElement("td");
            cell2.textContent = fund_house;
            const cell3 = document.createElement("td");
            cell3.textContent = one;
            cell3.classList.add('text-center');
            const cell4 = document.createElement("td");
            cell4.textContent = two;
            cell4.classList.add('text-center');
            const cell5 = document.createElement("td");
            cell5.textContent = three;
            cell5.classList.add('text-center');
            const cell6 = document.createElement("td");
            cell6.textContent = four;
            cell6.classList.add('text-center');

            newRow.appendChild(cell1);
            newRow.appendChild(cell2);
            newRow.appendChild(cell3);
            newRow.appendChild(cell4);
            newRow.appendChild(cell5);
            newRow.appendChild(cell6);

            tbody.appendChild(newRow);
            
           
        };
        


    }).catch(function(err) {
        // There was an error
        console.warn('Something went wrong.', err);
    });
});
	
</script>
@push('style')
@endpush