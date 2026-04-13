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
@push('styles')
<link rel="stylesheet" href="{{asset('themes/frontend/assets/jquery-bar-rating-master/dist/themes/fontawesome-stars.css')}}">
<style>
    .custom-banner {
        background-image: url('{{ $dataArr['image_path'] }}');
    }
</style>
@endpush
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif
@section('content')
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4 class="f-b">{{ $dataArr['title'] }}</h4>
                  
                </div>
            </div>
        </div>
    </div>
</section>  
<section class="pentatech_section section">
    <div class="custom-banner no-bg the-news-banner">
        <div class="container">
            <div class="col-md-12">
                <div class="pentatech_inner_wrapper">
                    <div class="pentatech_filter_title m-3">
                        <h4>Stay Updated With MyPlexus Insights</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="news-listing">
        <div class="container">
            <div class="row" id="news">                
            </div>
        </div>
    </div>
</section>
@stop

@push('scripts')

<script>
	
$(document).ready(function() {

	showNews();

});
	
	async function showNews()
	{			
		const url = 'https://myplexus.com/api/v1/news';
		
		const data = await $.ajax({			
		  type: 'GET',
          url: url,          
          dataType: "JSON"		
		});
		
		if(data.success)
		{
			let html = "";
			
			for(var i=0; i<data.data.length; i++)
			{
				html += '<div class="col-lg-4 col-md-6 col-sm-12">';
                html += '<div class="new-listing-wrapper">';
                html += '<div class="news-listing-img">';
				html += '<a href="'+data.data[i].news_source_link+'" target="_blank">';
			html +=  '<img src="https://myplexus.com/storage/news/'+data.data[i].image+'" alt="'+data.data[i].title+'" class="img-fluid" />';
				html += '</a>';				
				html += '</div>';
				html += '<div class="new-lisiting-title">';
				html += '<a href="'+data.data[i].news_source_link+'" target="_blank">';
				html +=  data.data[i].title;
				html += '</a>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
			}
			
			$('#news').html();
			$('#news').html(html);
			
			console.log(html);
			
		} else {
			
		}
	}

</script>

@endpush