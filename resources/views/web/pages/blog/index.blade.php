@extends('web.layout.app')
@section('content')
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>Recent News</h4>
                    <p>The mutual fund industry is fast becoming the preferred savings and investment vehicle for most of us.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@include('web.pages.blog.latest_blogs',['heading'=>'','sub_heading'=>'Highlighted Posts'])

@if(!empty($data['editors_pick']))
<section class="editor_pics_blog">
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
            <div class="col-md-4">
                <div class="single_blog">
                    <div class="single_blog_img">
                        <img src="{{$ImagePath.$value['image_thumb']}}" class="img-fluid" />
                    </div>
                    <div class="blog_content">
                        <h4>{{$value['heading']}}</h4>
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