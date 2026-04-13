@extends('themes.frontend.layouts.app')
@section('moneycontrol') @stop
@section('select2') @stop
@section('captcha') @stop
@section('jquery-validate') @stop
@section('vue-js') @stop
@if (isset($dataArr['meta_title']))
@section('page-title'){{ $dataArr['meta_title'] }}@stop
@else
@section('page-title'){{ $dataArr['title'] }}@stop
@endif
@if (isset($dataArr['meta_key']))
@section('meta-keywords'){{ $dataArr['meta_key'] }}@stop
@endif
@if (isset($dataArr['meta_descp']))
@section('meta-description'){{ $dataArr['meta_descp'] }}@stop
@endif
@if (isset($dataArr['image_path']))
@section('meta-image'){{ $dataArr['image_path'] }}@stop
@endif
@if ($dataArr['full_url'])
@section('cur-url'){{ $dataArr['full_url'] }}@stop
@endif
@section('content')
<div class="data-slider">
    <div class="slider-wrapper">
        @if (count($bnrMdl) > 0)
        <div id="carouselControls" class="main-slider carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($bnrMdl as $key => $record)
                <div class="carousel-item{{ $key == 0 ? ' active' : '' }}">
                    @if ($record->media != null)
                    @if ($record->media['path'])
                    <x-img src="{{ $defDataArr['media_folder'] . $record->media->path }}" class="d-block w-100" alt="{{ $record->media->alt }}" title="{{ $record->media->title }}" />
                    @endif
                    @endif
                    <div class="slider-c-wrapper">
                        <div class="container">
                            <div class="s-c-lft">
                                <h3>{{ $record->title }}</h3>
                                {!! $record->descp !!}
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 sc-btn-1">
                                        @if ($record->link)
                                        <a @if ($record->link_target) target="{{ $record->link_target }}" @endif
                                            href="{{ $record->link }}"
                                            class="explore-s">{{ $record->link_text }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        @endif
        <div class="market-updates-slider">
            <div class="container p-0 mr-0">
                @if (isset($dataArr['custom_fields']['text_1']))
                <h3>{{ $dataArr['custom_fields']['text_1']['value'] }}</h3>
                @endif
                @if ($nwsApiData)
                <div class="verticalCarousel">
                    <div class="verticalCarouselHeader">
                        <a href="#" class="vc_goDown">
                            <x-img src="{{ asset('themes/frontend/assets/images/select-arrow.png') }}" />
                        </a>
                        <a href="#" class="vc_goUp">
                            <x-img src="{{ asset('themes/frontend/assets/images/select-arrow.png') }}" />
                        </a>
                    </div>
                    <ul class="verticalCarouselGroup vc_list">
                        {!! $nwsApiData !!}
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="live-market-data">
    <div class="container">
        <div class="live-market-wrap">
            <div id="marketRadar" style="display:none">
                <input type="hidden" value="0" id="pricevalcntr">
                <div class="tpSec clearfix">
                    <div class="stockDsl">
                        <div class="mrdBox item" id="elm1"></div>
                        <div class="mrdBox item" id="elm2"></div>
                        <div class="mrdBox item" id="elm3"></div>
                        <div class="mrdBox item" id="elm4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="g-ads-sec">
    <div class="container">
        <div class="ads-continer">
            @if (isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_54']))
            @if (isset($dataArr['custom_fields']['text_55']))
            <x-link url="{{ $dataArr['custom_fields']['text_55']['value'] }}" target="_blank">
                <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_54']['value'] }}" />
            </x-link>
            @else
            <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_54']['value'] }}" />
            @endif
            @endif
        </div>
    </div>
</div>

<div class="home-select-service select2-styles" id="vue-app-selections-home">
    <selections-home></selections-home>
</div>

<div class="advisor-slider">
    <div class="container">
        <div id="advisor-slides" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="adv-slides d-flex">
                        <div class="adv-s-image float-left">
                            <x-img src="{{ asset('themes/frontend/assets/images/financial-advisor.jpg') }}" class="img-fluid" />
                        </div>
                        <div class="adv-s-content float-right">
                            <h3>Are You A Financial Advisor?</h3>
                            <h4 class="text-green">Claim Your 90 Days Access!</h4>
                            <p>Professional service uses specialised, <br />
                                project management techniques to oversee the... <br>
                                service uses specialised,
                            </p>
                            <x-link url="{{ route('web.login') }}" class="explore-btn">ADVISOR LOGIN</x-link>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="compare-scemes-sec select2-styles" id="vue-app-compare-scheme-home">
    <div class="container">
        <div class="compare-block">
            @if (isset($dataArr['custom_fields']['text_5']))
            <h3 class="text-center">{{ $dataArr['custom_fields']['text_5']['value'] }}</h3>
            @endif
            @if (isset($dataArr['custom_fields']['textarea_6']))
            <p class="text-center">{!! nl2br($dataArr['custom_fields']['textarea_6']['value']) !!}</p>
            @endif
        </div>
    </div>
    <compare-scheme-home></compare-scheme-home>
</div>

<div class="compare-scemes-sec investing-tools select2-styles home-calculators">
    <div class="container">
        <div class="compare-block">
            @if (isset($dataArr['custom_fields']['editor_7']))
            <h3 class="text-center">{!! $dataArr['custom_fields']['editor_7']['value'] !!}</h3>
            @endif
        </div>
        <ul class="nav nav-tabs justify-content-center border-0">
            <li>
                <x-link url="{{ route('web.calculators') }}?tab=sip-planner">SIP Planner</x-link>
            </li>
            <li>
                <x-link url="{{ route('web.calculators') }}?tab=sip-p-calc">SIP Performance Calculator</x-link>
            </li>
            <li>
                <x-link url="{{ route('web.calculators') }}?tab=inf-calc">Inflation Calculator</x-link>
            </li>
            <li>
                <x-link url="{{ route('web.calculators') }}?tab=retire-calc">Retirement Calculator</x-link>
            </li>
            <li>
                <x-link url="{{ route('web.calculators') }}?tab=risk-tol-eval">Risk Tolerance Evaluator</x-link>
            </li>
        </ul>
    </div>
</div>

<div class="blogs-sec">
    <div class="container">
        @if (isset($dataArr['custom_fields']['text_2']))
        <h3>{{ $dataArr['custom_fields']['text_2']['value'] }}</h3>
        @endif
        <div class="row">
            @if (count($blogPosts) > 0)
            @foreach ($blogPosts as $key => $recordBlog)
            <div class="col-lg-4 b-block">
                <div class="wrap">
                    <div class="block-lft float-left">
                        @if (isset($recordBlog['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium']['source_url']))
                        <x-link url="{{ $recordBlog['link'] }}" target="_blank">
                            <x-img src="{{ $recordBlog['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium']['source_url'] }}" alt="{!! $recordBlog['_embedded']['wp:featuredmedia'][0]['alt_text'] !!}" title="{!! $recordBlog['_embedded']['wp:featuredmedia'][0]['title']['rendered'] !!}" class="img-fluid" />
                        </x-link>
                        @endif
                    </div>
                    <div class="block-rgt float-right">
                        <x-link url="{{ $recordBlog['link'] }}" target="_blank">{!! \App\Lib\Core\Useful::getShortContent(strip_tags($recordBlog['title']['rendered']), 50) !!}
                        </x-link>
                        <!-- {!! $recordBlog['excerpt']['rendered'] !!} -->
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

<div class="g-ads-sec g-ads-sec-2">
    <div class="container">
        <div class="ads-continer">
            @if (isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_56']))
            @if (isset($dataArr['custom_fields']['text_57']))
            <x-link url="{{ $dataArr['custom_fields']['text_57']['value'] }}" target="_blank">
                <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_56']['value'] }}" />
            </x-link>
            @else
            <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_56']['value'] }}" />
            @endif
            @endif
        </div>
    </div>
</div>

<div class="fund-expert-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 fund-expert">
                @if (count($fundManMdl) > 0)
                @if (isset($dataArr['custom_fields']['text_8']))
                <h3>{{ $dataArr['custom_fields']['text_8']['value'] }}</h3>
                @endif
                <div class="fe-profile">
                    @if ($fundManMdl[0]->media != null)
                    @if ($fundManMdl[0]->media['path'])
                    <x-link url="{{ route('web.fundman', $fundManMdl[0]->slug) }}">
                        <x-img src="{{ $defDataArr['media_folder'] . $fundManMdl[0]->media->path }}" alt="{{ $fundManMdl[0]->media->alt }}" title="{{ $fundManMdl[0]->media->title }}" />
                    </x-link>
                    @endif
                    @endif
                </div>
                <div class="fe-info">
                    <div class="fe-person">
                        <div class="fe-title float-left">
                            <x-link url="{{ route('web.fundman', $fundManMdl[0]->slug) }}">
                                <h6>{{ $fundManMdl[0]->name }}</h6>
                            </x-link>
                            @if ($fundManMdl[0]->designation)
                            <span class="desig">{{ $fundManMdl[0]->designation }}</span>
                            @endif
                            @if ($fundManMdl[0]->company_name)
                            <span class="desig">{{ $fundManMdl[0]->company_name }}</span>
                            @endif
                        </div>
                        <div class="clear"></div>
                        @if ($fundManMdl[0]->synopsis)
                        <p class="bio">{!! \App\Lib\Core\Useful::getShortContent( strip_tags($fundManMdl[0]->synopsis), 240) !!}</p>
                        @endif
                    </div>
                </div>
                <div class="clear"></div>
                @endif
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 faq-sec">
                @if (isset($dataArr['custom_fields']['text_9']))
                <h3>{{ $dataArr['custom_fields']['text_9']['value'] }}</h3>
                @endif
                @if (count($faqMdl) > 0)
                <div id="accordion" class="faq-ac">
                    @foreach ($faqMdl as $faqKey => $faqRecord)
                    <div class="card">
                        <div class="card-header" id="heading_{{ $faqRecord->faq_id }}">
                            <h5 class="mb-0">
                                <button class="btn btn-link{{ $faqKey == 0 ? '' : ' collapsed' }}" data-toggle="collapse" data-target="#collapse_{{ $faqRecord->faq_id }}" aria-expanded="{{ $faqKey == 0 ? 'true' : 'false' }}" aria-controls="collapse_{{ $faqRecord->faq_id }}">
                                    {{ $faqRecord->title }}
                                </button>
                            </h5>
                        </div>
                        <div id="collapse_{{ $faqRecord->faq_id }}" class="collapse{{ $faqKey == 0 ? ' show' : '' }}" aria-labelledby="heading_{{ $faqRecord->faq_id }}" data-parent="#accordion">
                            <div class="card-body">
                                @if ($faqRecord->descp)
                                <p>{!! nl2br($faqRecord->descp) !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="patshala-new">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                @if(isset($stngDataArr['paathshaala_heading']))
                <h3>{{ $stngDataArr['paathshaala_heading'] }}</h3>
                @endif
                <div class="patshala-new-lft br-5">
                    @if(count($pthPgsMdl) > 0)
                    <ul>
                        @foreach($pthPgsMdl as $key => $pthRecord)
                        @if( $pthRecord->getPageName() != false )
                        <li><a href="{{ $pthRecord->getPageName() }}">{!! $pthRecord->title !!}</a></li>
                        @endif
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h3>Fund Watch</h3>
                <div class="patshala-new-rgt">
                    <div class="patshala-box-1">
                        @if(count($fndWtchMdl) > 0)
                        <h5>{{ $fndWtchMdl[0]->title }}</h5>
                        @if($fndWtchMdl[0]->description)
                        <p>{!! \App\Lib\Core\Useful::getShortContent( strip_tags($fndWtchMdl[0]->description), 260) !!}</p>
                        @endif
                        <div class="home-fw-btn">
                            <x-link url="{{ route('web.fundwatch', $fndWtchMdl[0]->fw_id) }}">View Details</x-link>
                        </div>
                        @endif
                    </div>
                    <div class="patshala-box-2">
                        @if(count($nfoMdl) > 0)
                        <x-link url="{{ route('web.nfomonitor', $nfoMdl[0]->no_id) }}">
                            <x-img src="{{ asset('themes/frontend/assets/images/new-fund-offer.jpg') }}" class="img-fluid" />
                        </x-link>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="customer-speaks">
    <div class="container">
        @if (isset($dataArr['custom_fields']['text_10']))
        <h3 class="text-center">{{ $dataArr['custom_fields']['text_10']['value'] }}</h3>
        @endif
        <div class="row">
            @if (count($tstmnlMdl) > 0)
            <div id="testimonials" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner text-center">
                    @foreach ($tstmnlMdl as $key => $tstmnlRecord)
                    <div class="carousel-item{{ $key == 0 ? ' active' : '' }}">
                        <div class="c-content">
                            {!! nl2br($tstmnlRecord->descp) !!}
                            <div class="profile">
                                <div class="profile-pic">
                                    @if ($tstmnlRecord->media != null)
                                    @if ($tstmnlRecord->media['path'])
                                    <x-img src="{{ $defDataArr['media_folder'] . $tstmnlRecord->media->path }}" alt="{{ $tstmnlRecord->media->alt }}" title="{{ $tstmnlRecord->media->title }}" />
                                    @endif
                                    @endif
                                </div>
                                <div class="info">
                                    <h6>{{ $tstmnlRecord->name }}</h6>
                                    @if ($tstmnlRecord->designation)
                                    <span>{{ $tstmnlRecord->designation }}</span>
                                    @endif
                                    @if ($tstmnlRecord->company)
                                    <span>{{ $tstmnlRecord->company }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#testimonials" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#testimonials" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="patshala-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 patshala">
                <h3>Ask An Expert</h3>
                <div class="patshala-lft-wrap d-flex">
                    @if(count($aeQuesMdl) > 0)
                    <div class="expert-says border-s box-shadow bg-gry br-5">
                        <div class="expert-para">
                            <p><span class="quote-1">"</span>{!! \App\Lib\Core\Useful::getShortContent( strip_tags($aeQuesMdl[0]->question), 190) !!}<span class="quote-2">"</span></p>
                        </div>
                        <div class="expert-data">
                            <div class="exp-profile">
                                @if($aeQuesMdl[0]->user != null)
                                @if($aeQuesMdl[0]->user->p_picture)
                                <x-img src="{{ url('storage', [$aeQuesMdl[0]->user->p_picture, $defDataArr['user_media_folder'], 78, 78, 100]) }}" alt="{{ $aeQuesMdl[0]->user->f_name??'' }}" title="{{ $aeQuesMdl[0]->user->f_name??'' }}" />
                                @else
                                <x-img src="{{ asset('themes/frontend/assets/images/expert-profile.png') }}" />
                                @endif
                                @endif
                                @if($aeQuesMdl[0]->addedbyuser != null)
                                <span class="qName">{{ $aeQuesMdl[0]->addedbyuser->f_name }}@if($aeQuesMdl[0]->addedbyuser->l_name){{ ' '.$aeQuesMdl[0]->addedbyuser->l_name }} @endif</span>
                                @endif
                            </div>
                            <div class="exp-btn">
                                <x-link url="{{ route('web.ask-expert') }}">View All</x-link>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 newsletter">
                @if(isset($stngDataArr['newsletter_heading']))
                <h3>{{ $stngDataArr['newsletter_heading'] }}</h3>
                @endif
                <div class="news-wrap">
                    @if(isset($stngDataArr['newsletter_description']))
                    <p>{!! nl2br($stngDataArr['newsletter_description']) !!}</p>
                    @endif
                    <form action="{{ route('web.newsletter.save') }}" name="newsletterFrm" id="newsletterFrm" method="post">
                        {{ csrf_field() }}
                        <x-form.field.hidden name="recaptcha_v3" id="recaptcha_v3" />
                        <div class="f-fields d-flex">
                            <div class="f-email">
                                <input type="email" name="email" id="email" placeholder="Enter Email" />
                            </div>
                            <div class="f-submit">
                                <input type="button" id="sendNewsletterFrm" name="sendNewsletterFrm" value="{{ $defDataArr['web_lang']['submit_txt'] }}" />
                            </div>
                        </div>
                    </form>
                    <div id="msg_id"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(count($nwsListMdl) > 0)
<div class="press-release">
    <div class="container">
        <div class="row justify-content-center align-items-center press-header">
            <div class="col press-lft">
                <h3>In The News</h3>
            </div>
            <div class="col press-rgt">
                <x-link url="{{ route('web.news') }}">View All</x-link>
            </div>
        </div>
        <div class="row news-blocks">
            @foreach ($nwsListMdl as $key => $nwsRecord)
            <div class="col-lg-4 col-md-md-4 col-sm-12">
                <div class="news-inner-block">
                    @if($nwsRecord->news_source_link != '')
                    <x-link url="{{ $nwsRecord->news_source_link }}" target="_blank">
                        @endif
                        @if($nwsRecord->media_type != '')
                        @switch($nwsRecord->media_type)
                        @case('i')
                        <x-img src="{{ $defDataArr['news_folder'] . $nwsRecord->image }}" alt="{{ $nwsRecord->title }}" title="{{ $nwsRecord->title }}" class="img-fluid" />
                        @break
                        @case('v')
                        @switch($nwsRecord->video_from)
                        @case('l')
                        {{ \App\Lib\Core\Core::htmlVideoPlayer($defDataArr['news_folder'].$nwsRecord->video_data) }}
                        @break
                        @case('y')
                        @if($nwsRecord->video_image != '')
                        <x-img src="{{ $defDataArr['news_folder'] . $nwsRecord->video_image }}" alt="{{ $nwsRecord->title }}" title="{{ $nwsRecord->title }}" class="img-fluid" />
                        @endif
                        @break
                        @endswitch
                        @break
                        @endswitch
                        @endif
                        <span>{{ $nwsRecord->title }}</span>
                        @if($nwsRecord->news_source_link != '')
                    </x-link>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@stop
@push('scripts')
<script src="{{ asset('themes/frontend/assets/js/vertical-slider/jQueryVerticalCarousel.js') }}"></script>
<script>
    $(".verticalCarousel").verticalCarousel({
        currentItem: 1,
        showItems: 6,
    });
    $(function() {
        $("#newsletterFrm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: "{{ $defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt')) }}",
                        email: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt')) }}"
                    }
                }
            }),
            $("#sendNewsletterFrm").click(function(e) {
                e.preventDefault();
                grecaptcha.ready(function() {
                    grecaptcha.execute("{{ Config('commonconstants.recaptcha.site_key') }}", {
                        action: 'newsletter_form'
                    }).then(function(token) {
                        var a = $("#newsletterFrm");
                        if (1 == a.valid()) {
                            if (token) {
                                $("#recaptcha_v3").val(token);
                                // alert($("#recaptcha_v3").val());
                                var formData = {
                                    "_token": $('meta[name="csrf-token"]').attr('content'),
                                    email: $("#email").val(),
                                    recaptcha_v3: $("#recaptcha_v3").val()
                                };
                                $.ajax({
                                    url: "{{ route('web.newsletter.save') }}",
                                    type: "post",
                                    data: formData,
                                    dataType: 'json',
                                    beforeSend: function() {
                                        $('#sendNewsletterFrm').prop('disabled', true);
                                        $("#sendNewsletterFrm").attr('value', "{{ $defDataArr['web_lang']['processing_txt'] }}");
                                    },
                                    success: function(data) {
                                        // alert(data['msg']);
                                        $('#sendNewsletterFrm').prop('disabled', false);
                                        $("#sendNewsletterFrm").attr('value', "{{ $defDataArr['web_lang']['submit_txt'] }}");
                                        $("#msg_id").html(data['msg']);
                                        $('#newsletterFrm')[0].reset();
                                    },
                                    error: function() {
                                        $("#msg_id").html('There is error while submit');
                                    }
                                });
                            }
                        }
                    });
                });
            });
    });
</script>
@endpush