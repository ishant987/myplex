@extends('web.layout.app')
@section('content')

    <section class="blog_details_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="blog_details">
                        <div class="blog_details_img">
                            <img src="img/blog-details.jpg" />
                        </div>
                        <div class="blog_details_cont">
                            <h4>{{$blog_details['category']}}</h4>
                            <p>{{$blog_details['description']}}</p>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i>{{$blog_details['author']}}</div>
                                @php
                                $date = explode("-",explode("T", $blog_details['created_at'])[0]);
                                @endphp
                                <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> {{$date[2].'.'.$date[1].'.'.$date[0]}}</div>
                                <div class="post_share d-flex align-items-enter"><i class="ph-share-network-light"></i> Share</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="blog_comments mt-5">
                        <h4>What do you think about this article?</h4>
                        <p>Share your thoughts with us..</p>
                        <textarea class="blog_comments_textarea"></textarea>
                        <button class="blog_comment_submit">Submit Information</button>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="hightlight_post_sec section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="latest_blog_title">
                        <h4>Latest Blog</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="single_big_post">
                        <div class="big_post_img_wrapper">
                            <img src="img/blog.jpg" class="img-fluid" />
                        </div>
                        <div class=big_post_cont_wrpper>
                            <h4>Growth v/s Value Investing: Which One to Choose?</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i> Anubh Jain</div>
                                <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> 01.01.2020</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="hightlight_post_listing">
                        <h2>Read like this one</h2>
                        <li class="single_highlight_post">
                            <h4>Will i invest now! is it the right time?</h4>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin"><i class="ph-user-light"></i> Anubh Jain</div>
                                <div class="posted_date"><i class="ph-calendar-blank-light"></i> 01.01.2020</div>
                            </div>
                        </li>
                        <li class="single_highlight_post">
                            <h4>The second stage of co-vid and your investments plan</h4>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin"><i class="ph-user-light"></i> Anubh Jain</div>
                                <div class="posted_date"><i class="ph-calendar-blank-light"></i> 01.01.2020</div>
                            </div>
                        </li>
                        <li class="single_highlight_post">
                            <h4>Growth v/s Value Investing: Which One to Choose?</h4>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin"><i class="ph-user-light"></i> Anubh Jain</div>
                                <div class="posted_date"><i class="ph-calendar-blank-light"></i> 01.01.2020</div>
                            </div>
                        </li>
                        <li class="single_highlight_post">
                            <h4>Are the small cap funds expensive?</h4>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin"><i class="ph-user-light"></i> Anubh Jain</div>
                                <div class="posted_date"><i class="ph-calendar-blank-light"></i> 01.01.2020</div>
                            </div>
                        </li>
                        <li class="single_highlight_post">
                            <h4>What, when, who anud were they successful?</h4>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin"><i class="ph-user-light"></i> Anubh Jain</div>
                                <div class="posted_date"><i class="ph-calendar-blank-light"></i> 01.01.2020</div>
                            </div>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <section class="editor_pics_blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="blog_title">
                        <h4>Populer Read</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="single_blog">
                        <div class="single_blog_img">
                            <img src="img/blog.jpg" class="img-fluid" />
                        </div>
                        <div class="blog_content">
                            <h4>Growth v/s Value Investing: Which One to Choose?</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i> Anubh Jain</div>
                                <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> 01.01.2020</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_blog">
                        <div class="single_blog_img">
                            <img src="img/blog.jpg" class="img-fluid" />
                        </div>
                        <div class="blog_content">
                            <h4>Growth v/s Value Investing: Which One to Choose?</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i> Anubh Jain</div>
                                <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> 01.01.2020</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_blog">
                        <div class="single_blog_img">
                            <img src="img/blog.jpg" class="img-fluid" />
                        </div>
                        <div class="blog_content">
                            <h4>Growth v/s Value Investing: Which One to Choose?</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                            <div class="post_author d-flex align-items-enter">
                                <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i> Anubh Jain</div>
                                <div class="posted_date d-flex align-items-enter"><i class="ph-calendar-blank-light"></i> 01.01.2020</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
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
