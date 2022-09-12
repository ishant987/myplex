@extends('themes.frontend.layouts.app')
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
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif
@section('content')
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="breadcrumbWrapper">
					{{ Breadcrumbs::render('web.page', $dataArr) }}
				</div>
			</div>
		</div>
	</div>
</section>

@include('themes.frontend.includes.user-account')

<section class="eventslikeSections">
	<div class="container">
		<div class="row">
			{{-- Alert message start --}}
			@if(session()->has('alert'))
			<div class="col-md-12">
				<x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
			</div>
			@endif
			{{-- Alert message end --}}

			@if(count($dataList) == 0)
				<div class="col-md-12"><p>{{ __('message.data_not_available') }}</p></div>
			@else
				<div class="col-md-6 text-left">
					<p class="total-draft">{{ $dataList->total() }} @if($dataList->total() == 1){{ $defDataArr['askexpert_lang']['draft_txt'] }}@else{{ $defDataArr['askexpert_lang']['drafts_txt'] }}@endif</p>
				</div>
				<div class="col-md-6 text-right">
					<form action="{{ route('web.answer.draft.delete', 'all') }}" method="post">
						{{ csrf_field() }}
						<button type="submit" class="delete-draft-all" onclick="return confirm('{{ $defDataArr['askexpert_lang']['warning']['delete_draft'] }}');">
							{{ $defDataArr['askexpert_lang']['dlt_all_draft_txt'] }}
						</button>
					</form>
				</div>
				<div class="col-md-12">
					@foreach($dataList as $key => $answer)
					<div class="textBlocks wow fadeIn" data-wow-duration="500ms" data-wow-delay="600ms">
						<div class="textBlocksInner">
							<label class="label">{{ $defDataArr['askexpert_lang']['question_txt'] }}:</label>
							<h4>{!! $answer->question->question !!}</h4>
							<label class="label">{{ $defDataArr['askexpert_lang']['answer_txt'] }}: </label>
							<p>{!! $answer->answer !!}</p>
						</div>
						<div class="blockMeta">
							<div class="iconsTag iconsTag w-100">
								<ul>
									<li><div class="edit-draft"><span><a data-fancybox data-type="iframe" data-src="{{ route('web.draft-answer', $answer->aeqa_id) }}" href="javascript:;" title="{{ $defDataArr['askexpert_lang']['edit_draft_txt'] }}">{{ $defDataArr['askexpert_lang']['edit_draft_txt'] }}</a></span></div></li>
									<li>
										<div class="delete-draft">
											<span>
												<form action="{{ route('web.answer.draft.delete', $answer->aeqa_id) }}" method="post">
													{{ csrf_field() }}
													<button type="submit" class="delete-btn" onclick="return confirm('{{ $defDataArr['askexpert_lang']['warning']['delete_draft'] }}');">
														{{ $defDataArr['askexpert_lang']['dlt_draft_txt'] }}
													</button>
												</form>
											</span>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			@endif

			<div class="col-md-12">
				{{ $dataList->links() }}
			</div>

		</div>
	</div>
</section>
@stop