@extends('web.layout.infosolz_user_app')

@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                @include('web.auth.partials.landing-dashboard', [
                    'landingSlug' => 'model-portfolio',
                    'title' => 'Model Portfolio',
                    'eyebrow' => 'Curated Allocation',
                    'eyebrowIcon' => 'fa-solid fa-briefcase',
                    'description' => 'Model Portfolio is now presented as a cleaner landing page so this section feels consistent with the rest of the dashboard. It is ready to expand into deeper portfolio workflows as content grows.',
                    'highlights' => [
                        ['title' => 'Allocation Ready', 'description' => 'This section is positioned for curated portfolio and allocation workflows.'],
                        ['title' => 'Consistent UI', 'description' => 'The page now matches the improved dashboard experience across reports.'],
                        ['title' => 'Expandable', 'description' => 'You can extend this landing page into a richer portfolio module later.'],
                    ],
                    'cards' => [
                        ['route' => 'user.model_portfolio', 'icon' => 'new-images/dh3.png', 'title' => 'Model Portfolio', 'subtitle' => 'Portfolio content hub'],
                    ],
                ])
            </div>
        </div>
    </div>
@endsection
