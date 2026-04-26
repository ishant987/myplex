@extends('web.layout.infosolz_user_app')

@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                @include('web.auth.partials.landing-dashboard', [
                    'landingSlug' => 'composition-report',
                    'title' => 'Composition Report',
                    'eyebrow' => 'Portfolio Mix',
                    'eyebrowIcon' => 'fa-solid fa-layer-group',
                    'description' => 'Explore holdings, allocation shifts, and portfolio movement from one cleaner entry point. Open composition reports faster and move into the exact portfolio view you need.',
                    'highlights' => [
                        ['title' => 'Allocation', 'description' => 'Review fund composition snapshots and allocation balance quickly.'],
                        ['title' => 'Portfolio', 'description' => 'Inspect scheme holdings, occurrences, and sector weight changes.'],
                        ['title' => 'Movers', 'description' => 'Track boomers, busters, and new portfolio entries in one place.'],
                    ],
                    'cards' => [
                        ['route' => 'user.allocation_snapshot', 'icon' => 'new-images/Composition.png', 'title' => 'Allocation Snapshot', 'subtitle' => 'Review composition allocation'],
                        ['route' => 'user.scheme_portfolio', 'icon' => 'new-images/Scheme-Portfolio.png', 'title' => 'Scheme Portfolio', 'subtitle' => 'Inspect portfolio holdings'],
                        ['route' => 'user.occurrence_report', 'icon' => 'new-images/Occurrence-Report.png', 'title' => 'Occurrence Report', 'subtitle' => 'Check repeat portfolio entries'],
                        ['route' => 'user.top_script_rop_industry', 'icon' => 'new-images/Top-Scrips.png', 'title' => 'Top Scrips & Industries', 'subtitle' => 'See leading sector exposure'],
                        ['route' => 'user.new_script_new_industry', 'icon' => 'new-images/New-Scrips.png', 'title' => 'New Scrips & Industries', 'subtitle' => 'Spot fresh allocation changes'],
                        ['route' => 'user.boomers', 'icon' => 'new-images/Boomers.png', 'title' => 'Boomers', 'subtitle' => 'Open top positive movers'],
                        ['route' => 'user.busters', 'icon' => 'new-images/Busters.png', 'title' => 'Busters', 'subtitle' => 'Open top negative movers'],
                    ],
                ])
            </div>
        </div>
    </div>
@endsection
