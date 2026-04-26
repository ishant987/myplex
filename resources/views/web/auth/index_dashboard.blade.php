@extends('web.layout.infosolz_user_app')

@section('content')

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <h1 class="page_heading">Dashboard</h1>
            <div class="all_dash">
                <ul>
                    @include('web.auth.partials.dashboard-card', ['route' => 'user.ratio_dashboard', 'icon' => 'new-images/dh1.png', 'title' => 'Ratio Reports', 'subtitle' => 'Explore report snapshots'])
                    @include('web.auth.partials.dashboard-card', ['route' => 'user.ratio_analysis', 'icon' => 'new-images/Risk-Ratio.png', 'title' => 'Ratio Analysis', 'subtitle' => 'Compare key ratio insights'])
                    @include('web.auth.partials.dashboard-card', ['route' => 'user.composition_report', 'icon' => 'new-images/Composition.png', 'title' => 'Composition Report', 'subtitle' => 'Review holdings and mix'])
                    @include('web.auth.partials.dashboard-card', ['route' => 'user.indies_report', 'icon' => 'new-images/Indices-History.png', 'title' => 'Indies Report', 'subtitle' => 'Track index-linked trends'])
                    @include('web.auth.partials.dashboard-card', ['route' => 'user.model_portfolio', 'icon' => 'new-images/dh3.png', 'title' => 'Model Portfolio', 'subtitle' => 'Open curated allocations'])
                    @include('web.auth.partials.dashboard-card', ['route' => 'user.filters', 'icon' => 'new-images/By-Ratios.png', 'title' => 'Filters', 'subtitle' => 'Narrow down fund results'])
                    @include('web.auth.partials.dashboard-card', ['route' => 'user.predictive', 'icon' => 'new-images/Occurrence-Report.png', 'title' => 'Predictive', 'subtitle' => 'View forward-looking metrics'])
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
