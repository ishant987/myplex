@extends('web.layout.infosolz_user_app')

@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                @include('web.auth.partials.landing-dashboard', [
                    'landingSlug' => 'indices-report',
                    'title' => 'Indices Report',
                    'eyebrow' => 'Benchmark View',
                    'eyebrowIcon' => 'fa-solid fa-chart-line',
                    'description' => 'Review benchmark history, composition, and relative movement from a more focused dashboard. Open index-based reports quickly without scanning through dense navigation.',
                    'highlights' => [
                        ['title' => 'History', 'description' => 'Track how indices have moved across time and market phases.'],
                        ['title' => 'Composition', 'description' => 'Inspect index holdings, scheme relationships, and NAV comparisons.'],
                        ['title' => 'Movers', 'description' => 'Open boomers and busters to spot standout benchmark swings.'],
                    ],
                    'cards' => [
                        ['route' => 'user.indices-history', 'icon' => 'new-images/Indices-History.png', 'title' => 'Indices History', 'subtitle' => 'Review historical index moves'],
                        ['route' => 'user.indices-composition', 'icon' => 'new-images/Indices-Composition.png', 'title' => 'Indices Composition', 'subtitle' => 'Inspect index holdings mix'],
                        ['route' => 'user.schemes-associated-with-index', 'icon' => 'new-images/Schemes-Associated-With-Index.png', 'title' => 'Schemes With Index', 'subtitle' => 'Map schemes to benchmark indices'],
                        ['route' => 'user.indices-report.boomers', 'icon' => 'new-images/Boomers.png', 'title' => 'Boomers', 'subtitle' => 'View strongest gainers'],
                        ['route' => 'user.indices-report.busters', 'icon' => 'new-images/Busters.png', 'title' => 'Busters', 'subtitle' => 'View biggest laggards'],
                        ['route' => 'user.index_vs_NAV', 'icon' => 'new-images/Index-vs-NAV.png', 'title' => 'Index vs NAV', 'subtitle' => 'Compare benchmark and NAV'],
                    ],
                ])
            </div>
        </div>
    </div>
@endsection
