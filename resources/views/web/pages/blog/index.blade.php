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
            @if(!empty($data['editors_pick']))
            @foreach($data['editors_pick'] as $key=>$value)
            <div class="col-md-4">
                <div class="single_blog">
                    <div class="single_blog_img">
                        <img src="img/blog.jpg" class="img-fluid" />
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
            @else
            <div class="col-12">
                No Editor picks are available now. Will be uploaded soon.
            </div>
            @endif
        </div>
    </div>
</section>
<section class="must_read_blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="blog_title">
                    <h4>Must Read</h4>
                </div>
            </div>
        </div>
        <div class="row">
            @if(!empty($data['must_read']))
            @foreach($data['must_read'] as $key=>$value)
            <div class="col-md-4">
                <div class="single_blog">
                    <div class="single_blog_img">
                        <img src="img/blog.jpg" class="img-fluid" />
                    </div>
                    <a href="">
                        <div class="blog_content">
                            <h4>{{$value['heading']}}</h4>
                            <p>{{$value['sub_heading']}}</p>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i> {{$value['author']}}</div>
                                @php
                                $date = explode("-",explode("T", $value['created_at'])[0]);
                                @endphp
                                <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> {{$date[2].'.'.$date[1].'.'.$date[0]}}</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-12">
                No must read are available now. Will be uploaded soon.
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="pagination d-block d-sm-flex align-items-center justify-content-center">
                    <a href="#" class="navigation"><i class="ph-arrow-left-light"></i> Prev</a>
                    <ul class="d-flex align-items-center">
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li>....</li>
                        <li><a href="#">17</a></li>
                        <li><a href="#">18</a></li>
                        <li><a href="#">19</a></li>
                    </ul>
                    <a href="#" class="navigation"> Next <i class="ph-arrow-right-light"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
@stop