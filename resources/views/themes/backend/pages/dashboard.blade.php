@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('dashboard') }}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12 dshbrd">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
    </div>
</div>
{{-- Quick Total Boxes --}}
<div class="row dshbrd-qck-bx">
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="{{ $moduleAtrArr['target'] }}" href="{{ $totalBoxes[0]['url'] }}" title="{{ $moduleAtrArr['list_txt'] }}">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-envelope f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">{{ $totalBoxes[0]['title'] }}</h6>
                            <h2 class="m-b-0">{{ $totalBoxes[0]['total'] }}</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="{{ $moduleAtrArr['target'] }}" href="{{ $totalBoxes[1]['url'] }}" title="{{ $moduleAtrArr['list_txt'] }}">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-question-circle f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">{{ $totalBoxes[1]['title'] }}</h6>
                            <h2 class="m-b-0">{{ $totalBoxes[1]['total'] }}</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="{{ $moduleAtrArr['target'] }}" href="{{ $totalBoxes[2]['url'] }}" title="{{ $moduleAtrArr['list_txt'] }}">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-users f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">{{ $totalBoxes[2]['title'] }}</h6>
                            <h2 class="m-b-0">{{ $totalBoxes[2]['total'] }}</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="{{ $moduleAtrArr['target'] }}" href="{{ $totalBoxes[3]['url'] }}" title="{{ $moduleAtrArr['list_txt'] }}">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-send f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">{{ $totalBoxes[3]['title'] }}</h6>
                            <h2 class="m-b-0">{{ $totalBoxes[3]['total'] }}</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="{{ $moduleAtrArr['target'] }}" href="{{ $totalBoxes[4]['url'] }}" title="{{ $moduleAtrArr['list_txt'] }}">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-money f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">{{ $totalBoxes[4]['title'] }}</h6>
                            <h2 class="m-b-0">{{ $totalBoxes[4]['total'] }}</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="{{ $moduleAtrArr['target'] }}" href="{{ $totalBoxes[5]['url'] }}" title="{{ $moduleAtrArr['list_txt'] }}">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-line-chart f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">{{ $totalBoxes[5]['title'] }}</h6>
                            <h2 class="m-b-0">{{ $totalBoxes[5]['total'] }}</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="{{ $moduleAtrArr['target'] }}" href="{{ $totalBoxes[6]['url'] }}" title="{{ $moduleAtrArr['list_txt'] }}">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-money f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">{{ $totalBoxes[6]['title'] }}</h6>
                            <h2 class="m-b-0">{{ $totalBoxes[6]['total'] }}</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@if (!empty($subscriptionStats))
<div class="row dshbrd-qck-bx">
    @foreach ($subscriptionStats as $stat)
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <div class="row align-items-center m-l-0">
                    <div class="col-auto">
                        <i class="fa fa-credit-card f-30 text-c-blue"></i>
                    </div>
                    <div class="col-auto">
                        <h6 class="text-muted m-b-10">{{ $stat['title'] }}</h6>
                        <h2 class="m-b-0">{{ $stat['total'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
{{-- Section Links Boxes --}}
<div class="row dshbrd-qck-bx">
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a target="{{ $moduleAtrArr['target'] }}" href="{{ $slBoxes[1]['url'] }}" title="{{ $moduleAtrArr['list_txt'] }}">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-line-chart f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">{{ $slBoxes[1]['title'] }}</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 p-r-0">
        <div class="card m-b-10">
            <div class="card-block">
                <a href="{{ $slBoxes[2]['url'] }}" title="{{ $slBoxes[2]['title'] }}" onclick="return confirm('{{ __('admin.confirm.clear_cache') }}');">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-refresh f-30 text-c-blue"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">{{ $slBoxes[2]['title'] }}</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
{{-- Recent List Boxes --}}
<div class="row">
    <div class="col-xl-4 col-md-6 p-r-0">
        <div class="card feed-card">
            <div class="card-header">
                <h5>{{ $recentBoxesAtr['box1_title'] }}</h5>
            </div>
            <div class="card-block">
                @if (count($nwsRcntList) > 0)
                @foreach ($nwsRcntList as $key => $record)
                <div class="row m-b-20">
                    <div class="col">
                        <h5 class="m-b-10">
                            <x-link_tooltip url="{{ route('admin.news.edit', $record->n_id) }}" title="{{ $moduleAtrArr['edit_txt'] }}" target="{{ $moduleAtrArr['target'] }}">{{ $record->title }}
                            </x-link_tooltip>
                        </h5>
                        <p class="m-b-0 gray-col">
                            {{ $moduleAtrArr['added_date_txt'] .' : ' .date($moduleAtrArr['mdfy_dt_frmt'], strtotime($record->created_at)) }}
                        </p>
                    </div>
                </div>
                @endforeach
                <div class="text-right">
                    <x-link url="{{ route('admin.news.index') }}" target="{{ $moduleAtrArr['target'] }}" class="b-b-primary text-primary">
                        {{ $moduleAtrArr['see_all'] }}
                    </x-link>
                </div>
                @else
                {{ $moduleAtrArr['data_not_available'] }}
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 p-r-0">
        <div class="card feed-card">
            <div class="card-header">
                <h5>{{ $recentBoxesAtr['box2_title'] }}</h5>
            </div>
            <div class="card-block">
                @if (count($aeqRcntList) > 0)
                @foreach ($aeqRcntList as $key => $record)
                <div class="row m-b-20">
                    <div class="col">
                        <h5 class="m-b-10">
                            <x-link_tooltip url="{{ route('admin.question.edit', $record->aeq_id) }}" title="{{ $moduleAtrArr['edit_txt'] }}" target="{{ $moduleAtrArr['target'] }}">{!! \App\Lib\Core\Useful::getShortContent( strip_tags($record->question), 70) !!}
                            </x-link_tooltip>
                        </h5>
                        <p class="m-b-0 gray-col">
                            {{ $moduleAtrArr['added_date_txt'] .' : ' .date($moduleAtrArr['mdfy_dt_frmt'], strtotime($record->created_at)) }}
                        </p>
                    </div>
                </div>
                @endforeach
                <div class="text-right">
                    <x-link url="{{ $totalBoxes[1]['url'] }}" target="{{ $moduleAtrArr['target'] }}" class="b-b-primary text-primary">
                        {{ $moduleAtrArr['see_all'] }}
                    </x-link>
                </div>
                @else
                {{ $moduleAtrArr['data_not_available'] }}
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card feed-card">
            <div class="card-header">
                <h5>{{ $recentBoxesAtr['box3_title'] }}</h5>
            </div>
            <div class="card-block">
                @if (count($suRcntList) > 0)
                @foreach ($suRcntList as $key => $record)
                <div class="row m-b-20">
                    <div class="col">
                        <h5 class="m-b-10">
                            <x-link_tooltip url="{{ route('admin.subscribeduser.edit', $record->u_id) }}" title="{{ $moduleAtrArr['edit_txt'] }}" target="{{ $moduleAtrArr['target'] }}">{{ $record->fullname }}
                            </x-link_tooltip>
                        </h5>
                        <p class="m-b-0 gray-col">
                            {{ $moduleAtrArr['added_date_txt'] .' : ' .date($moduleAtrArr['mdfy_dt_frmt'], strtotime($record->created_at)) }}
                        </p>
                    </div>
                </div>
                @endforeach
                <div class="text-right">
                    <x-link url="{{ $totalBoxes[2]['url'] }}" target="{{ $moduleAtrArr['target'] }}" class="b-b-primary text-primary">
                        {{ $moduleAtrArr['see_all'] }}
                    </x-link>
                </div>
                @else
                {{ $moduleAtrArr['data_not_available'] }}
                @endif
            </div>
        </div>
    </div>
</div>
@stop
