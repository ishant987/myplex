@extends('web.layout.infosolz_user_app')

@section('content')
    <style>
        .ratio-reports-shell {
            display: grid;
            gap: 18px;
        }

        .ratio-reports-hero {
            background: linear-gradient(135deg, #f4fbf6 0%, #ffffff 100%);
            border: 1px solid #dcece1;
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 12px 28px rgba(18, 119, 62, 0.06);
        }

        .ratio-reports-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #e8f5ed;
            color: #12773E;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .ratio-reports-copy {
            max-width: 760px;
            margin: 0;
            color: #667085;
            font-size: 15px;
            line-height: 1.65;
        }

        .ratio-reports-highlights {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .ratio-reports-highlight {
            padding: 14px 16px;
            border-radius: 18px;
            background: #ffffff;
            border: 1px solid #e4ece7;
        }

        .ratio-reports-highlight strong {
            display: block;
            margin-bottom: 4px;
            color: #1f2937;
            font-size: 14px;
            font-weight: 600;
        }

        .ratio-reports-highlight span {
            display: block;
            color: #667085;
            font-size: 13px;
            line-height: 1.5;
        }

        .ratio-reports-shell .all_dash {
            padding-left: 0;
        }

        .ratio-reports-shell .all_dash ul {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        @media only screen and (max-width: 991px) {
            .ratio-reports-hero {
                padding: 18px;
                border-radius: 18px;
            }

            .ratio-reports-copy {
                font-size: 14px;
                line-height: 1.6;
            }

            .ratio-reports-highlights,
            .ratio-reports-shell .all_dash ul {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                

                <div class="ratio-reports-shell">
                    <section class="ratio-reports-hero">
                        <span class="ratio-reports-eyebrow">
                            <i class="fa-solid fa-chart-column"></i>
                            Report Hub
                        </span>
                        <h1 class="page_heading">Ratio Reports</h1>
                        <p class="ratio-reports-copy">
                            Access your ratio reporting toolkit from one clear dashboard. Jump into snapshots, factsheets,
                            performance comparisons, and peer ranking views without digging through cluttered navigation.
                        </p>
                    </section>

                    <section class="ratio-reports-highlights" aria-label="Ratio report highlights">
                        <article class="ratio-reports-highlight">
                            <strong>Snapshots</strong>
                            <span>Review quick weekly and monthly changes from one place.</span>
                        </article>
                        <article class="ratio-reports-highlight">
                            <strong>Comparisons</strong>
                            <span>Move into quartile, comparative, and R-square views faster.</span>
                        </article>
                        <article class="ratio-reports-highlight">
                            <strong>Details</strong>
                            <span>Open factsheets and performance ratios with fewer taps.</span>
                        </article>
                    </section>

                    <div class="all_dash">
                        <ul>
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.quick_ratio', 'icon' => 'new-images/dh1.png', 'title' => 'Quick Ratios', 'subtitle' => 'Fast ratio overview'])
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.weekly_snapshot_new', 'icon' => 'new-images/dh2.png', 'title' => 'Weekly Snapshot', 'subtitle' => 'Latest weekly report'])
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.monthly_snapshot_new', 'icon' => 'new-images/dh2.png', 'title' => 'Monthly Snapshot', 'subtitle' => 'Monthly trend summary'])
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.fund_factsheet', 'icon' => 'new-images/dh3.png', 'title' => 'Fund Factsheet', 'subtitle' => 'View fund essentials'])
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.performance_ratios', 'icon' => 'new-images/dh4.png', 'title' => 'Performance Ratios', 'subtitle' => 'Track ratio performance'])
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.quartile_decile', 'icon' => 'new-images/dh5.png', 'title' => 'Quartile & Decile', 'subtitle' => 'Rank peer group standing'])
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.comparative', 'icon' => 'new-images/dh6.png', 'title' => 'Comparative', 'subtitle' => 'Compare multiple funds'])
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.r_square_comparison', 'icon' => 'new-images/dh6.png', 'title' => 'R-Square Comparison', 'subtitle' => 'Check correlation strength'])
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.notifications', 'icon' => 'new-images/dh4.png', 'title' => 'Notifications', 'subtitle' => 'Review account alerts'])
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
