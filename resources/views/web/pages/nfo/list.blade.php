@extends('web.layout.app')
@section('vue-js') @stop
@section('captcha') @stop
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
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>{{$dataArr['title']}}</h4>
                    <p>{{$dataArr['descp']}}</p>
                </div>
            </div>
        </div>
    </div>
</section> 
<section  class="money_seriously_section fund_watch_setion_home nfo_monitor_home_section section">
    <div class="container">
        @if(count($dataListModel) == 0)
            <p>{{ __('message.data_not_available') }}</p>
        @else
            @if($reqYear > 0)
                <div class="archive-wrapper">
                    <div class="archives-posts">
                        <div class="row m-0 archive-row">
                        @foreach($dataListModel as $key => $record)
                            <div class="archive-block">
                                <x-link url="{{ route('web.nfomonitor', $record['no_id']) }}">{{ $record['fund_name'] }}</x-link>
                                @if($record['objective'] != '')
                                    <p>{!! \App\Lib\Core\Useful::getShortContent(strip_tags($record['objective']), 80) !!}</p>
                                @endif
                                <h6>Posted On <span class="archive-post-date">{{ date($dateFormat, strtotime($record['post_date'])) }}</span></h6>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            @else
                @foreach($dataListModel as $key => $record)
                <div class="archive-wrapper">
                    <div class="row m-0 justify-content-between align-items-center">
                        <div class="archive-title"><h3>{{ $key == 0 ? 'Recent NFO' : 'Archives From '.$record['archive']['year'] }} <span class="posts-count">({{ $record['archive']['tot'] }})</span></h3></div>
                        <div class="archive-view-all">
                            <x-link url="{{ route('web.nfomonitor.list', $record['archive']['year']) }}">View All</x-link>
                        </div>
                    </div>
                    <div class="archives-posts">
                        <div class="row m-0 archive-row">
                            @if(count($record['items']) == 0)
                                <p>{{ __('message.data_not_available') }}</p>
                            @else
                            <table id="example" class="table table-striped dataTable no-footer" style="width: 100%;">
                                <thead>
                                    <tr>
                                        
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name of Fund: activate to sort column descending" style="width: 273px;">
                                            Name of Fund
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="AAUM (Lacs): activate to sort column ascending" style="width: 204px;">Date</th>
                                        
                                </thead>
                                <tbody>  
                                @foreach($record['items'] as $key => $record2)
                                <tr class="odd">
                                        <td data-label="Name of Fund" class="sorting_1">
                                                <x-link url="{{ route('web.nfomonitor', $record2['no_id']) }}">{{ $record2['fund_name'] }}</x-link>
                                        </td>
                                        <td data-label="AAUM">
                                            @if($record2['objective'] != '')
                                            <p>{!! \App\Lib\Core\Useful::getShortContent(strip_tags($record2['objective']), 80) !!}</p>
                                        @endif
                                        <h6>Posted On <span class="archive-post-date">{{ date($dateFormat, strtotime($record2['post_date'])) }}</span></h6>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        @endif
    </div>
</section>
@stop