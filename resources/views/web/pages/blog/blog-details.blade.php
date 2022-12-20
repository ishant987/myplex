@extends('web.layout.app')
@if(isset($blog_details['sub_heading']))
@section('page-title'){{$blog_details['sub_heading']}}@stop
@else
@section('page-title'){{$blog_details['heading']}}@stop
@endif
@if(isset($blog_details['description']))
@section('meta-description'){{$blog_details['description']}}@stop
@endif
@section('cur-url'){{ Request::fullUrl()}}@stop
@section('content')

<section class="blog_details_section">
    <div class="row">
        <div class="container">
            <div class="row">
                @if (Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="blog_details">
                    <div class="blog_details_img">
                        <img src="{{$ImagePath.$blog_details['image_banner']}}" />
                    </div>
                    <div class="blog_details_cont">
                        <h4>
                            {{$blog_details['heading']}}
                        </h4>
                        <p>{!!$blog_details['description']!!}</p>
                        <div class="post_author d-flex align-items-enter">
                            <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i>{{$blog_details['author']}}</div>
                            @php
                            $date = date('d.m.Y',strtotime($blog_details['created_at']));
                            @endphp
                            <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> {{$date}}</div>
                            <div class="post_share d-flex align-items-enter"><i class="ph-share-network-light"></i> Share</div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('web.post-blogs-detail')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="blog_comments mt-5 col-12">
                            <h4>What do you think about this article?</h4>
                            <p>Share your thoughts with us..</p>
                            <input type="text" name="blog_id" value="{{$blog_details['id']}}" id="" hidden>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
								<div class="col-12 mt-4">
                                    <div class="form-group">
                                        <label for="email">Comment</label>
                                         <textarea class="blog_comments_textarea col-12" name="comment" required></textarea>
                                    </div>
                                </div>
                               
                            </div>
                            <button class="blog_comment_submit" type="submit">Submit Information</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


@include('web.pages.blog.latest_blogs',['heading'=>'Latest blog','sub_heading'=>'Read like this one'])


@if(!empty($data['must_read']))
@include('web.pages.blog.must_read_blogs',['heading'=>'Popular Read'])
@endif

<section class="hastag_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="blog_title">
                    <h4>Populer Hashtags</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="hashtag_wrapper">
                    <div class="single_hasgtag">#MutualFunds</div>
                    <div class="single_hasgtag">#Investment</div>
                    <div class="single_hasgtag">#Investing</div>
                    <div class="single_hasgtag">#financialfreedom</div>
                    <div class="single_hasgtag">#sip</div>
                    <div class="single_hasgtag">#stocks</div>
                    <div class="single_hasgtag">#sharemarket</div>
                    <div class="single_hasgtag">#nifty</div>
                    <div class="single_hasgtag">#sensex</div>
                    <div class="single_hasgtag">#money</div>
                    <div class="single_hasgtag">#wealth</div>
                    <div class="single_hasgtag">#insurance</div>
                    <div class="single_hasgtag">#trading</div>
                    <div class="single_hasgtag">#equity</div>
                    <div class="single_hasgtag">#dalalstreet</div>
                    <div class="single_hasgtag">#lifeinsurance</div>
                    <div class="single_hasgtag">#MutualFunds</div>
                    <div class="single_hasgtag">#Investment</div>
                    <div class="single_hasgtag">#Investing</div>
                    <div class="single_hasgtag">#financialfreedom</div>
                    <div class="single_hasgtag">#sip</div>
                    <div class="single_hasgtag">#stocks</div>
                    <div class="single_hasgtag">#sharemarket</div>
                    <div class="single_hasgtag">#nifty</div>
                    <div class="single_hasgtag">#sensex</div>
                    <div class="single_hasgtag">#money</div>
                    <div class="single_hasgtag">#wealth</div>
                    <div class="single_hasgtag">#insurance</div>
                    <div class="single_hasgtag">#trading</div>
                    <div class="single_hasgtag">#equity</div>
                    <div class="single_hasgtag">#dalalstreet</div>
                    <div class="single_hasgtag">#lifeinsurance</div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop