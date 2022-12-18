@extends('web.layout.app')
@section('select2') @stop
@section('like-unlike') @stop
@section('ans-like-unlike') @stop
@section('owl-carousel') @stop
@section('fancybox') @stop
@section('login-redirect') @stop
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
                    <h4>Ask An Experts</h4>
                    <p>The mutual fund industry is fast becoming the preferred savings and investment vehicle for most of us.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section ask_question_section">
    <div class="container">
        <div class="row">
           <div class="col-md-8">
                <div class="vision_title mb-5">
                    <h4 data-aos="fade-down" data-aos-duration="1000">Get The Best Advice From MyPlexus Team!</h4>
                    <p data-aos="fade-down" data-aos-duration="1500">A plexus (from the Latin for "braid") is a branching network of vessels or nerves.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="question_listing_sec pe-5">                       
                    <div class="question_search_panel">
                        <form action="#" id="m_search_form" method="get">
                            <input type="text" id="m_search_text" autocomplete="off" name="ms" placeholder="{{ __('web.search_txt') }}" value="{{ (isset($_GET['ms']))?$_GET['ms']:'' }}"/>
                            <i class="ph-magnifying-glass-bold"></i>
                            {{-- <input type="submit" /></span> --}}
                        </form>
                    </div>
                    <div class="question_wrapper mt-4">
                        @foreach($dataList as $key => $record)
                        <div class="single_question mb-4">
                            <p  onclick="toggleAnswer({{ $record->aeq_id  }})"> {!! \App\Lib\Core\Useful::getShortContent( strip_tags($record->question), $defDataArr['askexpert_lang']['title_char_limit']) !!}</p>
                            <small>{{ $record->user->f_name . " " . $record->user->l_name }} | {{ \Carbon\Carbon::createFromTimeStamp(strtotime($record->created_at))->diffForHumans() }}</small>
                            <div class="d-flex align-items-center mt-3">
                                <div class="answer_count me-5">
                                    <span>{{ $record->totalAnswers()['normal'] }}</span>
                                    <span>{{ $defDataArr['askexpert_lang']['answer_txt'] }}</span>
                                </div>
                                <div class="answer_count">
                                    <span>{{ $record->totalAnswers()['expert'] }}</span>
                                    <span>{{ $defDataArr['askexpert_lang']['expert_txt'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="comment-replies-wrap box-shadow postsReply mb-2" id="postsReply{{ $record->aeq_id }}">
                            <div class="question-block">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="user-answer">
                                            @if($record->question)
                                            <p>{!! $record->question !!}</p>
                                            @endif
                                            @if($record->image1)
                                            <figure class="postImage m-b-15">
                                                <a href="{{ $defDataArr['media_folder'].$record->image1 }}" data-fancybox="images{{ $record->aeq_id }}" data-caption="" class="adsImg wow fadeIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                                    <x-img src="{{ $defDataArr['media_folder'].$record->image1 }}" />
                                                </a>
                                            </figure>
                                            @endif
                                            @if($record->image2)
                                            <figure class="postImage m-b-15">
                                                <a href="{{ $defDataArr['media_folder'].$record->image2 }}" data-fancybox="images{{ $record->aeq_id }}" data-caption="" class="adsImg wow fadeIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                                    <x-img src="{{ $defDataArr['media_folder'].$record->image2 }}" />
                                                </a>
                                            </figure>
                                            @endif
                                            @if($record->image3)
                                            <figure class="postImage m-b-15">
                                                <a href="{{ $defDataArr['media_folder'].$record->image3 }}" data-fancybox="images{{ $record->aeq_id }}" data-caption="" class="adsImg wow fadeIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                                    <x-img src="{{ $defDataArr['media_folder'].$record->image3 }}" />
                                                </a>
                                            </figure>
                                            @endif
                                            @if($record->video_from && $record->video_data)
                                            <div class="postVideo">
                                                @switch($record->video_from)
                                                @case($defDataArr['video_type']['0'])
                                                <div class="localVideo">
                                                    {{ \App\Lib\Core\Core::htmlVideoPlayer($defDataArr['media_folder'].$record->video_data) }}
                                                </div>
                                                @break
                                                @case($defDataArr['video_type']['1'])
                                                <div class="ytubeVideo">
                                                    {{ \App\Lib\Core\Core::ytubePlayer($defDataArr['media_folder'].$record->video_data) }}
                                                </div>
                                                @break
                                                @endswitch
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if(count($record->answersFront) > 0)
                                @foreach($record->answersFront as $record2)
                                <div class="row">
                                    <div class="col-lg-10 col-md-9 col-sm-9">
                                        <div class="posts">
                                            <p>{!! $record2->answer !!}</p>
                                            <div class="user-data">
                                                <div class="row mx-0">
                                                    <small>{{ $record2->user->f_name . " " . $record2->user->l_name }} | {{ \Carbon\Carbon::createFromTimeStamp(strtotime($record2->created_at))->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <div class="question-data">
                                                <div class="row mx-0">
                                                    <div class="col-12 px-0">
                                                        <div class="comment-action">
                                                            {{-- <div class="row mx-0">
                                                                @if($record2->isLike())
                                                                <span class="like"><a href="javascript:void(0);" class="liked re-like-unlike replylike" data-id="{{$record2->aeqa_id}}" data-type="{{ $defDataArr['a_like_type'] }}">
                                                                        <sup class="like-counter">{{$record2->getLikes()}}</sup>
                                                                    </a></span>
                                                                @else
                                                                <span class="like"><a href="javascript:void(0);" class="like re-like-unlike replylike" data-id="{{$record2->aeqa_id}}" data-type="{{ $defDataArr['a_like_type'] }}">
                                                                        <sup class="like-counter">{{$record2->getLikes()}}</sup>
                                                                    </a></span>
                                                                @endif
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="ask_question_form">
                    <h4>Ask Question</h4>
                    <p>Share your thoughts with us..</p>
                    <form name="quesForm" id="quesForm" action="{{ route('web.ask-question.save') }}" method="post" class="quesForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <x-form.field.hidden name="recaptcha_v3" id="recaptcha_v3" />
                        <input type="text" placeholder="Enter Your Name"/>
                        <textarea placeholder="Ask An Question"></textarea>
                        <button class="compare_scheme_btn mt-1">Submit Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="abt_meet_our_section section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="vision_title mb-5">
                    <h4 data-aos="fade-down" data-aos-duration="1000">{{ $defDataArr['askexpert_lang']['pnl_of_exprts_txt'] }}</h4>
                    <p data-aos="fade-down" data-aos-duration="1500">We, at myplexus.com believe the financial intermediation and personal finance industry in India is going through the fastest evolutionary stage.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="meet_team_slider">
                    @foreach($expertUsersArr as $user)
                        <div class="single_team">
                            <div class="single_team_wrapper">
                                <div class="single_team_img">
                                    @if($user->p_picture)
                                    <img src="{{ url('storage/user', [$user->p_picture]) }}" alt="{{ $user->f_name??'' }}"/>
                                    @else
									<x-img src="{{asset('img/blank-profile-picture.png')}}" />
									@endif
                                </div>
                                <ul>
                                    <li><a href="#"><i class="ph-facebook-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-twitter-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-instagram-logo"></i></a></li>
                                </ul>
                            </div>
                            <div class="single_team_content">
                                <h4>{{ $user->f_name??'' }} {{ $user->l_name??'' }}</h4>
                                @if($user->about != "")
                                    <p>{{ $user->about }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@push('scripts')
<script src="{{asset('themes/frontend/assets/js/ask-experts.js')}}"></script>
@endpush
@push('style')
<style>
    .ask_question_section .comment-replies-wrap {
    background: #fff;
    border-radius: 5px;
    padding: 40px 30px;
    /* margin-left: 160px; */
    margin-top: 40px;
    display: none;
}
</style>
@endpush