@extends('themes.frontend.layouts.app')
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
<div class="custom-banner no-bg ask-question-banner">
	<div class="container">
		@if ($dataArr['descp'])
		<h1 class="f-b">{!! $dataArr['descp'] !!}</h1>
		@endif
	</div>
</div>

<div class="ask-expert-qna">
	<div class="container">

		<div class="ask-expert-qna-top">
			<h3>{!! $dataArr['title'] !!}</h3>
		</div>

		<div class="ask-expert-search">
			<div class="row ask-expert-wrapper">
				<div class="col-lg-4 col-md-4 col-sm-12 search-cm ask-expert-search-1">
					<form action="#" id="m_search_form" method="get">
						<input type="text" id="m_search_text" autocomplete="off" name="ms" placeholder="{{ __('web.search_txt') }}" value="{{ (isset($_GET['ms']))?$_GET['ms']:'' }}">
						<span class="expert-select"><input type="submit" /></span>
					</form>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 search-cm ask-expert-search-2 select2-styles">
					<select class="js-example-placeholder-single js-states form-control" name="topic" id="topic">
						<option value="{{ route('web.ask-expert') }}">{{ $defDataArr['askexpert_lang']['search_by_topic_txt'] }}</option>
						@foreach($topicsModel as $key => $value)
						<option value="{{ route('web.ask-expert.topic', $value->slug) }}" {{ ( ( isset($dataArr['req_slug']) && $dataArr['req_slug'] == $value->slug ) || ( $dataArr['aet_id'] == $defDataArr['other_topic_id'] ) || ( $dataArr['parent'] == $defDataArr['other_topic_id'] ) )?'selected':'' }}>{{ $value->title }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 search-cm ask-expert-search-3">
					<x-link url="{{ route('web.ask-question') }}" class="ask-btn">{{ $defDataArr['askexpert_lang']['ask_question_txt'] }}</x-link>
				</div>
			</div>
		</div>

		<div class="qna-main">

			<div class="questions-wrapper">
				<h6 id="question-sort" class="text-d-green">
					@if(\Request::route()->getName() == 'web.ask-expert.topic')
					{{ $dataArr['title'] }}
					@else
					{{ __('common.all_txt') }}
					@endif
				</h6>
				<div class="question-blocks-wrap">
					@if(count($dataList) == 0)
					<p>{{ __('message.data_not_available') }}</p>
					@else
					@foreach($dataList as $key => $record)
					<div class="question-block">
						<div class="row">
							<div class="col-lg-2 col-md-3 col-sm-3">
								<div class="profile user-profile">
									@if($record->user != null)
									@if($record->user->p_picture)
									<x-img src="{{ url('storage', [$record->user->p_picture, $defDataArr['user_media_folder'], 125, 125, 100]) }}" alt="{{ $record->user->f_name??'' }}" title="{{ $record->user->f_name??'' }}" />
									@else
									<x-img src="{{asset('img/user-def-grey-bg.png')}}" />
									@endif
									@endif
								</div>
							</div>
							<div class="col-lg-10 col-md-9 col-sm-9">
								<div class="user-question">
									<h6 onclick="toggleAnswer({{ $record->aeq_id  }})">{!! \App\Lib\Core\Useful::getShortContent( strip_tags($record->question), $defDataArr['askexpert_lang']['title_char_limit']) !!}</h6>
								</div>
								<div class="user-data">
									<div class="row mx-0">
										<div><span class="user-name">{{ $record->user->f_name . " " . $record->user->l_name }}</span>|</div>
										<div><span class="posted-date">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($record->created_at))->diffForHumans() }}</span></div>
										@if(\Request::route()->getName() == 'web.ask-expert')
										<div>|&nbsp;<span class="post-type">
												<x-link url="{{ route('web.ask-expert.topic', $record->topic->slug) }}"><span class="postTag blue-text">{{ $record->topic->title }}</span></x-link>
											</span></div>
										@endif
									</div>
								</div>
								<div class="question-data">
									<div class="row mx-0">
										<div class="col-lg-9 col-md-9 col-sm-12">
											<div class="row max-0 comment-data">
												<div class="col-lg-2 co-md-2 pl-0">
													<span class="answer-data">{{ $record->totalAnswers()['normal'] }}<span class="inner-title">{{ $defDataArr['askexpert_lang']['answer_txt'] }}</span></span>
												</div>
												<div class="col-lg-2 co-md-2">
													<span class="expert-data">{{ $record->totalAnswers()['expert'] }}<span class="inner-title">{{ $defDataArr['askexpert_lang']['expert_txt'] }}</span></span>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="comment-action">
												<div class="row align-items-center mx-0">
													<span class="cmt">
														@if(\Auth::check())
														<a data-fancybox data-type="iframe" data-src="{{ route('web.add-answer', $record->aeq_id) }}" href="javascript:;" class="edit" title="{{ $defDataArr['askexpert_lang']['add_answer'] }}">
															<x-img src="{{asset('themes/frontend/assets/images/comment-icon.png')}}" />
														</a>
														@else
														<a href="{{ route('web.login') }}" class="edit" title="{{ $defDataArr['askexpert_lang']['add_answer'] }}">
															<x-img src="{{asset('themes/frontend/assets/images/comment-icon.png')}}" />
														</a>
														@endif
													</span>
													<span class="like">
														@if($record->isLike())
														<a href="javascript:void(0);" class="liked like-unlike" data-id="{{$record->aeq_id}}" data-type="{{ $defDataArr['q_like_type'] }}">
															<sup class="like-counter">{{$record->getLikes()}}</sup>
														</a>
														@else
														<a href="javascript:void(0);" class="like like-unlike" data-id="{{$record->aeq_id}}" data-type="{{ $defDataArr['q_like_type'] }}">
															<sup class="like-counter">{{$record->getLikes()}}</sup>
														</a>
														@endif
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="comment-replies-wrap box-shadow postsReply" id="postsReply{{ $record->aeq_id }}">
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
										<div class="col-lg-2 col-md-3 col-sm-3">
											<div class="profile user-profile">
												@if($record2->user->p_picture)
												<x-img src="{{ url('storage', [$record2->user->p_picture, $defDataArr['user_media_folder'], 90, 90, 100]) }}" alt="{{ $record2->user->f_name??'' }}" title="{{ $record2->user->f_name??'' }}" />
												@else
												<x-img src="{{asset('img/user-def-grey-bg.png')}}" />
												@endif
												@if( $record2->isUserExpert($record2->user->u_id) == true)
												<span class="postImgIco"></span>
												@endif
											</div>
										</div>
										<div class="col-lg-10 col-md-9 col-sm-9">
											<div class="posts">
												<p>{!! $record2->answer !!}</p>
												<div class="user-data">
													<div class="row mx-0">
														<div><span class="user-name">{{ $record2->user->f_name ." ". $record2->user->l_name }}</span> | </div>
														<div><span class="posted-date">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($record2->created_at))->diffForHumans() }}</span></div>
													</div>
												</div>
												<div class="question-data">
													<div class="row mx-0">
														<div class="col-12 px-0">
															<div class="comment-action">
																<div class="row mx-0">
																	@if($record2->isLike())
																	<span class="like"><a href="javascript:void(0);" class="liked re-like-unlike replylike" data-id="{{$record2->aeqa_id}}" data-type="{{ $defDataArr['a_like_type'] }}">
																			<sup class="like-counter">{{$record2->getLikes()}}</sup>
																		</a></span>
																	@else
																	<span class="like"><a href="javascript:void(0);" class="like re-like-unlike replylike" data-id="{{$record2->aeqa_id}}" data-type="{{ $defDataArr['a_like_type'] }}">
																			<sup class="like-counter">{{$record2->getLikes()}}</sup>
																		</a></span>
																	@endif
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									@endforeach
									@endif
								</div>
							</div>
						</div>
					</div>
					@endforeach
					@endif
					<div class="col-md-12">
						{{ $dataList->links() }}
					</div>
				</div>
			</div>

			<div class="experts-totals">

				<div class="experts-total-wrap">
					<div class="row">
						<div class="col-lg-4 col-md-4 sm-12">
							<span class="expert-answered">{{ $countArr['expert_answer_count'] }}</span>
							<img src="{{asset('themes/frontend/assets/images/expert-icon.png')}}" alt="expert-icon">
							<h6>{{ $defDataArr['askexpert_lang']['total_expert_ans_txt'] }}</h6>
						</div>
						<div class="col-lg-4 col-md-4 sm-12">
							<span class="expert-answered">{{ $countArr['normal_answer_count'] }}</span>
							<img src="{{asset('themes/frontend/assets/images/answered-icon.png')}}" alt="answered-icon">
							<h6>{{ $defDataArr['askexpert_lang']['total_ans_txt'] }}</h6>
						</div>
						<div class="col-lg-4 col-md-4 sm-12">
							<span class="expert-answered">{{ $countArr['total_likes_count'] }}</span>
							<img src="{{asset('themes/frontend/assets/images/like-icon.png')}}" alt="like-icon">
							<h6>{{ $defDataArr['askexpert_lang']['total_liked_txt'] }}</h6>
						</div>
					</div>
				</div>
				@if(count($expertUsersArr) > 0)
				<div class="experts-slider">
					<h5>{{ $defDataArr['askexpert_lang']['pnl_of_exprts_txt'] }}</h5>
					<div class="experts-slider-wrap">
						<div id="expert-sliders" class="owl-carousel owl-theme">
							@foreach($expertUsersArr as $user)
							<div class="item">
								<div class="s-block">
									@if($user->p_picture)
									<x-img src="{{ url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 400, 400, 100]) }}" alt="{{ $user->f_name??'' }}" title="{{ $user->f_name??'' }}" />
									@else
									<x-img src="{{asset('img/blank-profile-picture.png')}}" />
									@endif
									<span class="name">{{ $user->f_name??'' }} {{ $user->l_name??'' }}</span>
									@if($user->about != "")
									<span class="position">{{ $user->about }}</span>
									@endif
								</div>
								@if($user->profile != "")
								<div class="cont">
									<p class="text-center w-100">
										{{ $user->profile }}
									</p>
								</div>
								@endif
							</div>
							@endforeach
						</div>
					</div>
				</div>
				@endif
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
@stop
@push('scripts')
<script src="{{asset('themes/frontend/assets/js/ask-experts.js')}}"></script>
<script>
	var owl = $('#expert-sliders');
	owl.owlCarousel({
		items: 1,
		loop: true,
		nav: true,
		dots: false,
		margin: 0,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
	});
	// 
	$("#topic").change(function() {
		window.location = this.value;
	});
</script>
@endpush