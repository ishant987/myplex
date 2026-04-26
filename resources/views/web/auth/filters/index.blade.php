@extends('web.layout.infosolz_user_app')

@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                @include('web.auth.partials.landing-dashboard', [
                    'landingSlug' => 'filters',
                    'title' => 'Filters',
                    'eyebrow' => 'Smart Screening',
                    'eyebrowIcon' => 'fa-solid fa-sliders',
                    'description' => 'Narrow funds faster with focused ratio, composition, and volatility filters. This page now gives you a cleaner path into the exact screening workflow you want to run.',
                    'highlights' => [
                        ['title' => 'Ratios', 'description' => 'Filter by ratio metrics when you need direct performance screening.'],
                        ['title' => 'Composition', 'description' => 'Screen based on allocation mix and underlying portfolio structure.'],
                        ['title' => 'Risk Signals', 'description' => 'Use Jensen, beta, and volatility filters to refine risk exposure.'],
                    ],
                    'cards' => [
                        ['route' => 'user.filters.ratios', 'icon' => 'new-images/By-Ratios.png', 'title' => 'By Ratios', 'subtitle' => 'Filter by ratio metrics'],
                        ['route' => 'user.filters.composition', 'icon' => 'new-images/By-Composition.png', 'title' => 'By Composition', 'subtitle' => 'Filter by allocation mix'],
                        ['route' => 'user.filters.jensens', 'icon' => 'new-images/dh4.png', 'title' => "By Jensen's", 'subtitle' => 'Screen alpha-based funds'],
                        ['route' => 'user.filters.beta', 'icon' => 'new-images/by-Beta.png', 'title' => 'By Beta', 'subtitle' => 'Focus on beta exposure'],
                        ['route' => 'user.filters.volatility', 'icon' => 'new-images/Volatility.png', 'title' => 'By Volatility', 'subtitle' => 'Sort by risk swings'],
                    ],
                ])
            </div>
        </div>
    </div>
@endsection
