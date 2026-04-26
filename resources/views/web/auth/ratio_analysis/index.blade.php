@extends('web.layout.infosolz_user_app')

@section('content')
    <style>
        .ratio-analysis-shell {
            display: grid;
            gap: 18px;
        }

        .ratio-analysis-hero {
            background: linear-gradient(135deg, #f4fbf6 0%, #ffffff 100%);
            border: 1px solid #dcece1;
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 12px 28px rgba(18, 119, 62, 0.06);
        }

        .ratio-analysis-eyebrow {
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

        .ratio-analysis-eyebrow i {
            font-size: 12px;
        }

        .ratio-analysis-copy {
            max-width: 720px;
            margin: 0;
            color: #667085;
            font-size: 15px;
            line-height: 1.65;
        }

        .ratio-analysis-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .ratio-analysis-tips {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .ratio-analysis-tip {
            padding: 14px 16px;
            border-radius: 18px;
            background: #ffffff;
            border: 1px solid #e4ece7;
        }

        .ratio-analysis-tip strong {
            display: block;
            margin-bottom: 4px;
            color: #1f2937;
            font-size: 14px;
            font-weight: 600;
        }

        .ratio-analysis-tip span {
            display: block;
            color: #667085;
            font-size: 13px;
            line-height: 1.5;
        }

        .ratio-analysis-shell .all_dash {
            padding-left: 0;
        }

        .ratio-analysis-shell .all_dash h1.page_heading {
            margin-left: 0;
            margin-bottom: 8px;
        }

        .ratio-analysis-shell .all_dash ul {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        @media only screen and (max-width: 991px) {
            .ratio-analysis-hero {
                padding: 18px;
                border-radius: 18px;
            }

            .ratio-analysis-copy {
                font-size: 14px;
                line-height: 1.6;
            }

            .ratio-analysis-tips,
            .ratio-analysis-shell .all_dash ul {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                

                <div class="ratio-analysis-shell">
                    <section class="ratio-analysis-hero">
                        <span class="ratio-analysis-eyebrow">
                            <i class="fa-solid fa-chart-line"></i>
                            Performance Lens
                        </span>
                        <h1 class="page_heading">Ratio Analysis</h1>
                        <p class="ratio-analysis-copy">
                            Review risk, return, and downside efficiency from one clean workspace. Choose a ratio to compare
                            fund behavior faster and move into the detailed tables with less friction.
                        </p>
                    </section>

                    <section class="ratio-analysis-tips" aria-label="Ratio analysis highlights">
                        <article class="ratio-analysis-tip">
                            <strong>Risk Ratio</strong>
                            <span>Understand volatility-sensitive performance and downside exposure.</span>
                        </article>
                        <article class="ratio-analysis-tip">
                            <strong>Return Ratio</strong>
                            <span>Check how efficiently returns are being generated across funds.</span>
                        </article>
                        <article class="ratio-analysis-tip">
                            <strong>Sortino Ratio</strong>
                            <span>Focus on downside-adjusted returns for cleaner risk comparison.</span>
                        </article>
                    </section>

                    <div class="all_dash">
                        <ul>
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.risk_ratio', 'icon' => 'new-images/Risk-Ratio.png', 'title' => 'Risk Ratio', 'subtitle' => 'Evaluate downside exposure'])
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.return_ratio', 'icon' => 'new-images/Return-Ratio.png', 'title' => 'Return Ratio', 'subtitle' => 'Compare return efficiency'])
                            @include('web.auth.partials.dashboard-card', ['route' => 'user.sortino_ratio', 'icon' => 'new-images/Sortino-Ratio.png', 'title' => 'Sortino Ratio', 'subtitle' => 'Focus on downside-adjusted return'])
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
