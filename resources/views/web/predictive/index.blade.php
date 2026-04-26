@extends('web.layout.infosolz_user_app')

@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                @include('web.auth.partials.landing-dashboard', [
                    'landingSlug' => 'predictive',
                    'title' => 'Predictive',
                    'eyebrow' => 'Forward Signals',
                    'eyebrowIcon' => 'fa-solid fa-wave-square',
                    'description' => 'Use predictive ratios to examine alpha, Sharpe, and Treynor perspectives from one streamlined dashboard. The layout now gives these forward-looking tools a cleaner, easier starting point.',
                    'highlights' => [
                        ['title' => 'Alpha', 'description' => 'Use Jensen’s Alpha to evaluate excess return skill over benchmark.'],
                        ['title' => 'Sharpe', 'description' => 'Compare return per unit of total risk with less friction.'],
                        ['title' => 'Treynor', 'description' => 'Assess beta-adjusted return for benchmark-sensitive analysis.'],
                    ],
                    'cards' => [
                        ['route' => 'user.predictive.jensen-alpha', 'icon' => 'new-images/New-Scrips.png', 'title' => "By Jensen's Alpha", 'subtitle' => 'Measure excess return skill'],
                        ['route' => 'user.predictive.sharp-ratio', 'icon' => 'new-images/Indices-Composition.png', 'title' => 'By Sharpe', 'subtitle' => 'Compare return per risk'],
                        ['route' => 'user.predictive.trenyor', 'icon' => 'new-images/Occurrence-Report.png', 'title' => 'By Treynor', 'subtitle' => 'Assess beta-adjusted return'],
                    ],
                ])
            </div>
        </div>
    </div>
@endsection
