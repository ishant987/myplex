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
@section('content')
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>{{$dataArr['title']}}</h4>
                </div>
            </div>
        </div>
    </div>
</section>

@include('web.pages.blog.latest_blogs',['heading'=>'','sub_heading'=>'Highlighted Posts'])

@if(!empty($data['editors_pick']))
<section class="editor_pics_blog section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="blog_title">
                    <h4>Editors Picks</h4>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($data['editors_pick'] as $key=>$value)
            <div class="col-md-6 col-lg-4">
                <div class="single_blog">
                    <div class="single_blog_img">
                        <img src="{{$ImagePath.$value['image_thumb']}}" class="img-fluid" />
                    </div>
                    <div class="blog_content single_highlight_post1">
                        <h4>
                            <a href="{{url('money_seriously').'/'.$value['unique_url']}}">
                                {{$value['heading']}}
                            </a>
                        </h4>
                        <p>{{$value['sub_heading']}}</p>
                        <div class="post_author d-flex align-items-enter">
                            <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i>{{$value['author']}}</div>
                            @php
                            $date = explode("-",explode("T", $value['created_at'])[0]);
                            @endphp
                            <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> {{$date[2].'.'.$date[1].'.'.$date[0]}}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(!empty($data['must_read']))
@include('web.pages.blog.must_read_blogs',['heading'=>'Must Read'])
@endif
@stop