<section class="hightlight_post_sec section">
    @if(isset($data['highlighted_posts']))
    <div class="container">
        @if($heading)
            <div class="row">
                <div class="col-md-12">
                    <div class="latest_blog_title">
                        <h4>{{$heading}}</h4>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-7">
                <div class="single_big_post">
                    <div class="big_post_img_wrapper">
                        <img src="{{$ImagePath.$data['highlighted_posts'][0]['image_thumb']}}" class="img-fluid" />
                    </div>
                    <div class=big_post_cont_wrpper>
                        <h4>
                            <a href="{{url('money_seriously').'/'.$data['highlighted_posts'][0]['unique_url']}}">
                                {{$data['highlighted_posts'][0]['heading']}}
                            </a>
                        </h4>
                        <p>{{$data['highlighted_posts'][0]['sub_heading']}}</p>
                        <div class="post_author d-flex align-items-enter">
                            <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i>{{$data['highlighted_posts'][0]['author']}}</div>
                            @php
                            $date = explode("-",explode("T", $data['highlighted_posts'][0]['created_at'])[0]);
                            @endphp
                            <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> {{$date[2].'.'.$date[1].'.'.$date[0]}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="hightlight_post_listing">
                    <h2>{{$sub_heading}}</h2>
                    @php
                    unset($data['highlighted_posts'][0]);
                    @endphp
                    @if(!empty($data['highlighted_posts']))
                    @foreach($data['highlighted_posts'] as $key=> $value)
                    <li class="single_highlight_post">
                        <h4><a href="{{url('money_seriously').'/'.$value['unique_url']}}">{{$value['heading']}}</a></h4>
                        <div class="post_author d-flex align-items-enter">
                            <div class="post_admin"><i class="ph-user-light"></i>{{$value['author']}}</div>
                            @php
                            $date = explode("-",explode("T", $value['created_at'])[0]);
                            @endphp
                            <div class="posted_date"><i class="ph-calendar-blank-light"></i> {{$date[2].'.'.$date[1].'.'.$date[0]}}</div>
                        </div>
                    </li>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</section>