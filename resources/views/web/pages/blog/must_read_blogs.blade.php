
<section class="must_read_blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="blog_title">
                    <h4>{{$heading}}</h4>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($data['must_read'] as $key=>$value)
            <div class="col-md-4">
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
                                <div class="post_admin d-flex align-items-enter"><i class="ph-user-light"></i> {{$value['author']}}</div>
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
        <div class="row d-none">
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