@extends('web.layout.app')
@section('moneycontrol') @stop
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
@php
    $blogItems = collect($blogResponses ?? []);
    $fundItems = collect(data_get($fundReponses, 'data', []));
    $performanceItems = collect(data_get($performaceResponses, 'data', []));
    $newsItems = collect($nwsListMdl ?? []);
    $watchItems = collect($fndWtchMdl ?? []);
    $expertItems = collect($fundManMdl ?? []);
    $newFromItems = collect($allnewfroms ?? []);

    $heroBlog = $blogItems->first();
    $heroFund = $fundItems->first();
    $heroPerformance = $performanceItems->first();
    $heroWatch = $watchItems->first();
    $heroNews = $newsItems->first();
    $fundTypeOptions = collect(data_get($dataArr, 'fund_types', []));
    $benchmarkOptions = collect(data_get($dataArr, 'benchmark_options', []));
    $classificationOptions = collect(data_get($dataArr, 'classification_options', []));

    $fundCount = $fundItems->count();
    $performanceCount = $performanceItems->count();
    $blogCount = $blogItems->count();
    $watchCount = $watchItems->count();
    $expertCount = $expertItems->count();
    $newsCount = $newsItems->count();

    $kpis = [
        ['value' => number_format($fundCount ?: 0), 'label' => 'Funds in view', 'sub' => 'Live data from the research stack'],
        ['value' => number_format($performanceCount ?: 0), 'label' => 'Performance groups', 'sub' => 'Snapshot-ready category views'],
        ['value' => number_format($watchCount ?: 0), 'label' => 'Fund Watch items', 'sub' => 'Research picks and monitored funds'],
    ];

    $featureCards = [
        [
            'eyebrow' => 'Compare',
            'title' => 'Scheme, index, currency and commodity views in one place',
            'desc' => 'Side-by-side research views that help visitors move from exploration to comparison without leaving the landing page.',
            'link' => '/compare-scheme',
            'link_text' => 'Open compare',
        ],
        [
            'eyebrow' => 'Rank',
            'title' => 'Category-wise return and risk ranking',
            'desc' => 'Surface the ranking logic visitors already look for in the monthly ranking experience, but present it as a clean product story.',
            'link' => '/monthly-ranking',
            'link_text' => 'Open ranking',
        ],
        [
            'eyebrow' => 'Snapshot',
            'title' => 'Scheme performance, ratios and highlights',
            'desc' => 'Lead into the deep-dive report pages with a compact card that explains what the section does before the click.',
            'link' => '/performance-snapshot',
            'link_text' => 'Open snapshot',
        ],
    ];

    $resourceCards = [
        [
            'title' => 'Fund Watch',
            'desc' => 'Track selected funds and investor-facing insights in a compact, editorial style.',
            'link' => '/new-fundwatch-list',
        ],
        [
            'title' => 'Paathshaala',
            'desc' => 'Keep the education layer visible with taxation, ratio and classification resources.',
            'link' => '/mutual-fund-taxation',
        ],
        [
            'title' => 'Calculators',
            'desc' => 'Keep planning tools one tap away so the landing page stays useful and not only beautiful.',
            'link' => '/calculators',
        ],
    ];

    $heroSignals = [
        ['label' => 'Compare', 'value' => number_format($fundCount ?: 0) . ' funds'],
        ['label' => 'Rank', 'value' => number_format($performanceCount ?: 0) . ' reports'],
        ['label' => 'Snapshot', 'value' => number_format($blogCount ?: 0) . ' insights'],
        ['label' => 'Fund Watch', 'value' => number_format($watchCount ?: 0) . ' tracked'],
        ['label' => 'Learn', 'value' => number_format($newsCount ?: 0) . ' updates'],
    ];
@endphp

<style>
    :root {
        --lp-bg: #f3f5f1;
        --lp-ink: #3a3b3c;
        --lp-muted: rgba(17, 19, 21, 0.65);
        --lp-line: rgba(17, 19, 21, 0.10);
        --lp-dark: #08110d;
        --lp-brand: #2b6a45;
        --lp-brand-soft: #7ea27f;
        --lp-card: #ffffff;
    }

    .header_section,
    .footer_section {
        display: none !important;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    body {
        background: var(--lp-bg);
    }

    .landing-shell {
        padding: 0;
        color: var(--lp-ink);
    }

    .landing-top,
    .landing-hero,
    .metrics-strip,
    .two-column-section,
    .simple-grid,
    .split-callout,
    .testimonial-section,
    .resource-section,
    .cta-section,
    .footer-landing {
        max-width: 1360px;
        margin: 0 auto;
        padding: 0 24px 24px;
    }

    .footer-landing {
        width: 100vw;
        max-width: none;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        padding-left: 0;
        padding-right: 0;
    }

    .landing-top {
        width: 100vw;
        max-width: none;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        padding-left: 0;
        padding-right: 0;
        padding-bottom: 12px;
    }

    .landing-hero {
        width: 100vw;
        max-width: none;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        padding-left: 0;
        padding-right: 0;
        padding-top: 0;
        padding-bottom: 0;
        margin-top: -18px;
    }

    .landing-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 14px 32px 14px 28px;
        border-radius: 24px 24px 0 0;
        background: rgba(8, 17, 13, 0.94);
        color: #fff;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.18);
    }

    .landing-brand {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #fff;
        font-weight: 700;
        letter-spacing: -0.02em;
    }

    .landing-brand img {
        width: 132px;
        height: auto;
        display: block;
    }

    .landing-menu {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.06);
        flex-wrap: wrap;
        justify-content: center;
    }

    .landing-menu a {
        color: rgba(255, 255, 255, 0.72);
        text-decoration: none;
        font-size: 13px;
        padding: 10px 14px;
        border-radius: 999px;
        transition: background 0.18s ease, color 0.18s ease;
    }

    .landing-menu a:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
    }

    .landing-signup {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 0 18px;
        border-radius: 999px;
        background: var(--lp-brand);
        color: #fff;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 14px 30px rgba(43, 106, 69, 0.24);
    }

    .landing-auth-actions {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .landing-signin {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 0 18px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: #fff;
        text-decoration: none;
        font-weight: 700;
        white-space: nowrap;
        background: rgba(255, 255, 255, 0.04);
    }

    .hero-panel {
        position: relative;
        overflow: hidden;
        border-radius: 0 0 34px 34px;
        background:
            radial-gradient(circle at 18% 12%, rgba(43, 106, 69, 0.22), transparent 18%),
        radial-gradient(circle at 74% 28%, rgba(255, 255, 255, 0.12), transparent 22%),
        linear-gradient(180deg, rgba(7, 15, 11, 0.99) 0%, rgba(28, 49, 38, 0.98) 54%, rgba(241, 243, 237, 1) 100%);
        color: #fff;
        padding: 22px 40px 28px;
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.16);
        margin-top: -1px;
    }

    .hero-panel::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.11) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.11) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.55) 0%, rgba(0, 0, 0, 0.22) 35%, transparent 78%);
        pointer-events: none;
    }

    .hero-grid {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: minmax(0, 1.08fr) minmax(320px, 0.92fr);
        gap: 32px;
        align-items: center;
    }

    .hero-eyebrow,
    .section-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        border-radius: 999px;
        background: rgba(17, 19, 21, 0.06);
        color: rgba(17, 19, 21, 0.72);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.10em;
        margin-bottom: 14px;
    }

    .hero-eyebrow {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.86);
        margin-bottom: 18px;
    }

    .hero-title,
    .section-title,
    .testimonial-copy h3,
    .cta-card h3 {
        margin: 0;
        line-height: 0.98;
        letter-spacing: -0.06em;
    }

    .hero-title {
        font-size: clamp(42px, 4.6vw, 68px);
        max-width: 12ch;
    }

    .section-title {
        font-size: clamp(28px, 3.4vw, 44px);
    }

    .hero-copy,
    .section-copy,
    .cta-card p,
    .testimonial-copy .quote,
    .footer-brand p {
        line-height: 1.7;
        color: var(--lp-muted);
        font-size: 15px;
    }

    .hero-copy {
        margin: 18px 0 0;
        max-width: 58ch;
        color: rgba(255, 255, 255, 0.70);
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 24px;
    }

    .hero-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: 0 18px;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 800;
        transition: transform 0.18s ease;
    }

    .hero-btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .hero-btn.primary {
        background: var(--lp-brand);
        color: #fff;
    }

    .hero-btn.secondary {
        background: rgba(255, 255, 255, 0.06);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.10);
    }

    .hero-trust {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 26px;
    }

    .hero-avatars {
        display: flex;
        align-items: center;
    }

    .hero-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.9);
        margin-left: -10px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #7ea27f 0%, #2b6a45 100%);
        color: #101916;
        font-weight: 900;
        font-size: 12px;
    }

    .hero-avatar:first-child {
        margin-left: 0;
    }

    .hero-trust strong {
        display: block;
        font-size: 20px;
        line-height: 1;
        color: #fff;
    }

    .hero-trust span {
        display: block;
        color: rgba(255, 255, 255, 0.68);
        font-size: 13px;
    }

    .hero-partners {
        margin-top: 18px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .partner-chip {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.8);
    }

    .mini-tag,
    .partner-row .mark {
        background: rgba(17, 19, 21, 0.06);
        border: 1px solid rgba(17, 19, 21, 0.08);
        color: rgba(17, 19, 21, 0.72);
    }

    .hero-art {
        position: relative;
        min-height: 520px;
        display: grid;
        place-items: center;
    }

    .hero-card {
        position: absolute;
        right: 0;
        top: 0;
        width: min(420px, 100%);
        min-height: 500px;
        border-radius: 28px;
        background:
            radial-gradient(circle at 18% 12%, rgba(43, 106, 69, 0.12), transparent 22%),
            linear-gradient(180deg, rgba(9, 14, 12, 0.98) 0%, rgba(17, 34, 25, 0.96) 60%, rgba(238, 243, 233, 1) 100%);
        color: #121212;
        box-shadow: 0 26px 54px rgba(0, 0, 0, 0.20);
        padding: 18px;
        transform: rotate(-1.5deg);
        overflow: hidden;
    }

    .card-topline,
    .chart-head,
    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .mini-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(17, 19, 21, 0.06);
        font-size: 12px;
        font-weight: 700;
        color: #111315;
    }

    .detail-chip,
    .metric-card,
    .surface-card,
    .testimonial-card,
    .cta-card,
    .footer-card,
    .mini-stat,
    .mini-card,
    .grid-card,
    .world-card {
        border: 1px solid var(--lp-line);
        background: rgba(255, 255, 255, 0.80);
        border-radius: 26px;
        box-shadow: 0 18px 48px rgba(24, 29, 25, 0.08);
    }

    .detail-chip {
        padding: 12px 14px;
        border-radius: 18px;
        background: rgba(17, 19, 21, 0.05);
        box-shadow: none;
    }

    .detail-chip span,
    .mini-card .card-kicker,
    .grid-card .eyebrow {
        display: block;
        color: rgba(17, 19, 21, 0.55);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 6px;
    }

    .hero-chart {
        position: relative;
        margin-top: 16px;
        border-radius: 22px;
        background: rgba(8, 17, 13, 0.96);
        color: #fff;
        padding: 18px;
        overflow: hidden;
    }

    .hero-chart::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        background-size: 28px 28px;
        opacity: 0.55;
        pointer-events: none;
    }

    .chart-head strong {
        font-size: 13px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .chart-head .pill {
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.76);
        font-size: 12px;
    }

    .chart-body {
        position: relative;
        z-index: 1;
    }

    .chart-value {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .chart-value small {
        font-size: 14px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.55);
    }

    .chart-svg {
        width: 100%;
        height: auto;
        display: block;
        margin-top: 8px;
        position: relative;
        z-index: 1;
    }

    .market-marquee {
        margin-bottom: 14px;
        overflow: hidden;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.06);
    }

    .market-track {
        display: flex;
        align-items: center;
        gap: 12px;
        width: max-content;
        padding: 10px 0;
        animation: research-scroll 26s linear infinite;
    }

    .market-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        white-space: nowrap;
        font-size: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.10);
    }

    .market-pill b {
        color: #d9e8d4;
        font-weight: 800;
    }

    .market-board {
        display: grid;
        gap: 14px;
    }

    .market-header {
        display: grid;
        gap: 6px;
        padding: 14px 16px;
        border-radius: 22px;
        background: linear-gradient(180deg, rgba(17, 27, 21, 0.96) 0%, rgba(30, 52, 38, 0.90) 100%);
        color: #fff;
        box-shadow: 0 18px 34px rgba(0, 0, 0, 0.16);
    }

    .market-header .label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.68);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .market-header .brand-name {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .market-index {
        display: grid;
        gap: 8px;
        padding: 16px;
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.84);
        border: 1px solid rgba(17, 19, 21, 0.08);
        box-shadow: 0 18px 32px rgba(24, 29, 25, 0.08);
    }

    .market-index .topline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .market-index .name {
        font-size: 12px;
        color: var(--lp-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .market-index .price {
        font-size: 34px;
        line-height: 1;
        font-weight: 800;
        letter-spacing: -0.05em;
    }

    .market-index .change {
        font-size: 14px;
        font-weight: 700;
        color: #0e7a4f;
    }

    .market-index .change.down {
        color: #c73d3d;
    }

    .market-spark {
        width: 100%;
        height: 72px;
        display: block;
    }

    .market-heatmap {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .market-tile {
        min-height: 72px;
        border-radius: 18px;
        padding: 10px;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.02em;
        box-shadow: 0 14px 28px rgba(24, 29, 25, 0.08);
    }

    .market-tile small {
        opacity: 0.78;
        font-weight: 600;
    }

    .market-tile.up {
        background: linear-gradient(180deg, #2b6a45 0%, #204d34 100%);
    }

    .market-tile.up-soft {
        background: linear-gradient(180deg, #7ea27f 0%, #4f7250 100%);
    }

    .market-tile.flat {
        background: linear-gradient(180deg, #4d5b55 0%, #343c37 100%);
    }

    .market-tile.down {
        background: linear-gradient(180deg, #9f4d49 0%, #7c3431 100%);
    }

    .market-movers {
        display: grid;
        gap: 10px;
    }

    .market-mover {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.84);
        border: 1px solid rgba(17, 19, 21, 0.08);
    }

    .market-mover .symbol {
        font-size: 13px;
        font-weight: 800;
    }

    .market-mover .meta {
        margin-top: 4px;
        font-size: 12px;
        color: var(--lp-muted);
    }

    .market-mover .price {
        font-size: 18px;
        font-weight: 800;
        letter-spacing: -0.03em;
        white-space: nowrap;
    }

    .market-radar {
        padding: 12px 14px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.84);
        border: 1px solid rgba(17, 19, 21, 0.08);
    }

    .market-radar .label {
        font-size: 12px;
        color: var(--lp-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .market-radar .running {
        margin-top: 8px;
        height: 10px;
        border-radius: 999px;
        background: rgba(17, 19, 21, 0.08);
        overflow: hidden;
    }

    .market-radar .running span {
        display: block;
        height: 100%;
        width: 38%;
        border-radius: inherit;
        background: linear-gradient(90deg, rgba(126, 162, 127, 0.15), var(--lp-brand), rgba(126, 162, 127, 0.15));
        animation: research-sweep 2.8s ease-in-out infinite;
    }

    @keyframes research-scroll {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(-50%);
        }
    }

    @keyframes research-sweep {
        0% {
            transform: translateX(-25%);
        }
        50% {
            transform: translateX(120%);
        }
        100% {
            transform: translateX(-25%);
        }
    }

    .hero-floating {
        position: absolute;
        left: 0;
        bottom: 28px;
        width: min(290px, 72%);
        padding: 18px;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.94);
        color: #111;
        box-shadow: 0 18px 38px rgba(0, 0, 0, 0.16);
        transform: rotate(2deg);
    }

    .hero-floating .label {
        font-size: 12px;
        color: rgba(17, 19, 21, 0.58);
    }

    .hero-floating .big {
        font-size: 21px;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .hero-floating .small {
        font-size: 12px;
        color: rgba(17, 19, 21, 0.58);
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .metric-card,
    .surface-card,
    .testimonial-card,
    .cta-card,
    .footer-card,
    .mini-stat,
    .mini-card,
    .grid-card,
    .world-card {
        padding: 22px;
    }

    .metric-card .value {
        font-size: clamp(30px, 4vw, 50px);
        line-height: 1;
        font-weight: 800;
        letter-spacing: -0.05em;
    }

    .metric-card .label {
        margin-top: 10px;
        font-size: 13px;
        color: var(--lp-muted);
    }

    .compare_section {
        position: relative;
        overflow: hidden;
        padding: 18px 0 10px;
        background: #fff;
    }

    .compare_section .container {
        max-width: 1520px;
        padding-left: 12px;
        padding-right: 12px;
    }

    .tools_showcase_section {
        background: #fff;
        padding: 10px 0 14px;
    }

    .tools_showcase_shell {
        max-width: 1520px;
        margin: 0 auto;
        padding: 35px 12px;
      
    }

    .tools_showcase_grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 22px;
        align-items: stretch;
    }

    .tools_showcase_copy {
        padding: 14px 0 0;
        text-align: center;
    }

    .tools_showcase_kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        border: 1px solid rgba(43, 106, 69, 0.24);
        color: var(--lp-brand);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        background: #fff;
    }

    .tools_showcase_title {
        margin: 18px auto 0;
        color: var(--lp-ink);
        font-family: 'headingdont', serif;
        font-size: clamp(35px, 4.2vw, 65px);
        line-height: 1.04;
        letter-spacing: -0.01em;
        word-spacing: 0.18em;
        max-width: 1300px;
        font-weight: 400;
    }

    .tools_showcase_title .accent {
        color: var(--lp-brand);
    }

    .tools_showcase_title .title-line {
        display: block;
    }

    .tools_showcase_copytext {
        margin: 20px auto 0;
        max-width: 820px;
        color: rgba(17, 19, 21, 0.72);
        font-size: 18px;
        line-height: 1.65;
    }

    .tools_grid_cards {
        margin-top: 28px;
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 12px;
    }

    .tool-mini-card {
        position: relative;
        min-height: 170px;
        padding: 18px 16px 14px;
        border-radius: 20px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(247, 250, 246, 0.98) 100%);
        border: 1px solid rgba(43, 106, 69, 0.10);
        box-shadow: 0 14px 32px rgba(24, 29, 25, 0.08);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 16px;
        overflow: hidden;
        transition: transform 180ms ease, box-shadow 180ms ease, border-color 180ms ease;
    }

    .tool-mini-card::before {
        content: "";
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, rgba(43, 106, 69, 0.95) 0%, rgba(126, 162, 127, 0.82) 100%);
    }

    .tool-mini-card::after {
        content: "";
        position: absolute;
        right: -18px;
        top: -18px;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(43, 106, 69, 0.10), transparent 72%);
        pointer-events: none;
    }

    .tool-mini-card:hover {
        transform: translateY(-3px);
        border-color: rgba(43, 106, 69, 0.18);
        box-shadow: 0 18px 40px rgba(24, 29, 25, 0.10);
    }

    .tool-mini-card .icon {
        width: 44px;
        height: 44px;
        border-radius: 13px;
        display: grid;
        place-items: center;
        background: rgba(43, 106, 69, 0.08);
        border: 1px solid rgba(43, 106, 69, 0.10);
        color: var(--lp-brand);
        font-size: 19px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }

    .tool-mini-card h3 {
        margin: 12px 0 0;
        font-size: 17px;
        line-height: 1.1;
        letter-spacing: -0.05em;
        color: var(--lp-ink);
    }

    .tool-mini-card p {
        margin: 6px 0 0;
        color: rgba(17, 19, 21, 0.68);
        font-size: 13px;
        line-height: 1.5;
    }

    .tool-mini-card .go {
        width: 30px;
        height: 30px;
        border-radius: 999px;
        display: grid;
        place-items: center;
        align-self: flex-end;
        border: 1px solid rgba(43, 106, 69, 0.18);
        color: var(--lp-brand);
        background: #fff;
        font-size: 12px;
        box-shadow: 0 8px 16px rgba(24, 29, 25, 0.06);
    }

    .cta-bar {
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 26px;
        border-radius: 22px;
        background: linear-gradient(180deg, rgba(13, 74, 49, 0.98) 0%, rgba(5, 44, 28, 0.98) 100%);
        color: #fff;
        box-shadow: 0 20px 46px rgba(9, 36, 24, 0.22);
    }

    .cta-bar h3 {
        margin: 0;
        font-size: clamp(24px, 3vw, 34px);
        line-height: 1.05;
        letter-spacing: -0.05em;
    }

    .cta-bar p {
        margin: 6px 0 0;
        color: rgba(255, 255, 255, 0.76);
        font-size: 15px;
    }

    .cta-bar a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 50px;
        padding: 0 20px;
        border-radius: 999px;
        background: #fff;
        color: var(--lp-brand);
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
    }

    .cta-bar a i {
        font-size: 16px;
    }

    .compare_section::before,
    .compare_section::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        filter: blur(10px);
    }

    .compare_section::before {
        width: 320px;
        height: 320px;
        left: -110px;
        top: -60px;
        background: radial-gradient(circle, rgba(0, 113, 105, 0.22), transparent 68%);
    }

    .compare_section::after {
        width: 260px;
        height: 260px;
        right: -90px;
        bottom: -120px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.06), transparent 68%);
    }

    .compare-shell {
        position: relative;
        z-index: 1;
        padding: 34px 18px 30px;
        border-radius: 34px;
        background: linear-gradient(180deg, rgba(0, 80, 76, 0.98) 0%, rgba(0, 113, 105, 0.94) 100%);
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.14);
        overflow: hidden;
    }

    .compare-shell::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 12px 12px, rgba(255, 255, 255, 0.10) 0 6px, transparent 7px);
        background-size: 34px 34px;
        opacity: 0.14;
        pointer-events: none;
    }

    .compare-shell .compare_titile h2 {
        color: #fff;
        font-size: clamp(30px, 4vw, 56px);
        letter-spacing: -0.05em;
        margin-bottom: 0;
    }

    .compare-shell .compare_titile p {
        color: rgba(255, 255, 255, 0.74);
        max-width: 920px;
        margin: 12px auto 0;
        font-size: 15px;
        line-height: 1.7;
    }

    .compare-tools-grid {
        margin-top: 26px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .compare-tool-card {
        position: relative;
        overflow: hidden;
        min-height: 100%;
        padding: 26px;
        border-radius: 28px;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.22);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.35),
            0 18px 45px rgba(0, 0, 0, 0.12);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        text-align: left;
        color: #fff;
    }

    .compare-tool-card::after {
        content: "";
        position: absolute;
        inset: auto -18px -18px auto;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.16), transparent 72%);
        pointer-events: none;
    }

    .compare-tool-top {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 18px;
    }

    .compare-tool-icon {
        flex: 0 0 auto;
        width: 74px;
        height: 74px;
        border-radius: 22px;
        display: grid;
        place-items: center;
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.22);
        font-size: 28px;
        color: #fff;
    }

    .compare-tool-card h3 {
        margin: 0;
        font-size: 24px;
        line-height: 1.08;
        letter-spacing: -0.04em;
        color: #fff;
    }

    .compare-tool-card p {
        margin: 0;
        font-size: 15px;
        line-height: 1.75;
        color: rgba(255, 255, 255, 0.82);
    }

    .compare-tool-field {
        margin-top: 20px;
    }

    .compare-tool-field select {
        width: 100%;
        min-height: 56px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        background: rgba(255, 255, 255, 0.92);
        color: #101315;
        padding: 0 16px;
        font-size: 15px;
        font-weight: 600;
        outline: none;
        box-shadow: 0 14px 26px rgba(0, 0, 0, 0.08);
    }

    .compare-tool-actions {
        margin-top: 18px;
        display: flex;
        justify-content: flex-end;
    }

    .compare-tool-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        text-decoration: none;
        font-weight: 700;
        border: 1px solid rgba(255, 255, 255, 0.16);
        transition: transform 0.18s ease, background 0.18s ease;
    }

    .compare-tool-link:hover {
        transform: translateY(-1px);
        background: rgba(255, 255, 255, 0.18);
        color: #fff;
        text-decoration: none;
    }

    .compare-tool-link i {
        font-size: 13px;
    }

    .section-copy {
        margin: 14px 0 0;
        max-width: 58ch;
    }

    .bullet-list {
        margin: 18px 0 0;
        padding: 0;
        list-style: none;
        display: grid;
        gap: 12px;
    }

    .bullet-list li {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        color: var(--lp-ink);
        font-size: 14px;
        line-height: 1.55;
    }

    .bullet-list li::before {
        content: "";
        flex: 0 0 auto;
        width: 10px;
        height: 10px;
        margin-top: 6px;
        border-radius: 50%;
        background: var(--lp-brand);
        box-shadow: 0 0 0 6px rgba(43, 106, 69, 0.20);
    }

    .dashboard-stack {
        display: grid;
        gap: 14px;
    }

    .mini-stat .head {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        color: var(--lp-muted);
        font-size: 12px;
        margin-bottom: 8px;
    }

    .mini-stat .metric {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.05em;
    }

    .mini-stat .metric small {
        font-size: 14px;
        color: var(--lp-muted);
    }

    .mini-card {
        background: linear-gradient(180deg, #ffffff 0%, #f5f7f2 100%);
    }

    .mini-card.dark {
        background: linear-gradient(180deg, #1f4f3a 0%, #183929 100%);
        color: #fff;
        border: none;
    }

    .mini-card .card-title {
        font-size: 21px;
        line-height: 1.1;
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .mini-card .card-desc {
        margin-top: 10px;
        font-size: 14px;
        line-height: 1.55;
        color: inherit;
        opacity: 0.72;
    }

    .mini-card .chip-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 14px;
    }

    .simple-grid .grid-wrap {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .grid-card {
        min-height: 340px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .grid-card .icon-stack {
        width: 92px;
        height: 92px;
        border-radius: 24px;
        background: linear-gradient(135deg, rgba(43, 106, 69, 0.36), rgba(126, 162, 127, 0.22));
        display: grid;
        place-items: center;
        font-size: 30px;
        font-weight: 900;
        color: #20382c;
    }

    .grid-card h3 {
        margin: 18px 0 0;
        font-size: 24px;
        line-height: 1.04;
        letter-spacing: -0.05em;
    }

    .grid-card p {
        margin: 14px 0 0;
        color: var(--lp-muted);
        line-height: 1.65;
        font-size: 14px;
    }

    .grid-card .card-foot {
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .card-link {
        color: #102017;
        text-decoration: none;
        font-weight: 800;
    }

    .card-link:hover {
        text-decoration: underline;
    }

    .split-callout .callout-grid,
    .testimonial-inner {
        display: grid;
        grid-template-columns: minmax(0, 1.25fr) minmax(260px, 0.75fr);
        gap: 16px;
        align-items: stretch;
    }

    .world-card {
        position: relative;
        overflow: hidden;
        min-height: 300px;
        padding-bottom: 28px;
        background: linear-gradient(180deg, #f7f7f3 0%, #eef2eb 100%);
    }

    .world-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 24% 40%, rgba(17, 19, 21, 0.12) 0 1.2px, transparent 1.4px),
            radial-gradient(circle at 58% 34%, rgba(17, 19, 21, 0.12) 0 1.2px, transparent 1.4px),
            radial-gradient(circle at 76% 62%, rgba(17, 19, 21, 0.12) 0 1.2px, transparent 1.4px);
        background-size: 220px 220px;
        opacity: 0.55;
        pointer-events: none;
    }

    .world-pill {
        position: absolute;
        right: 24px;
        bottom: 24px;
        width: 128px;
        padding: 14px;
        border-radius: 22px;
        background: #214f3a;
        color: #fff;
        box-shadow: 0 18px 36px rgba(17, 19, 21, 0.16);
    }

    .world-pill .big {
        font-size: 36px;
        font-weight: 800;
        line-height: 1;
    }

    .world-pill .small {
        margin-top: 6px;
        font-size: 12px;
        opacity: 0.75;
    }

    .content-section {
        width: 100%;
        max-width: 1360px;
        margin: 0 auto;
        padding: 0 24px 26px;
    }

    .section-shell {
        border: 1px solid var(--lp-line);
        background: rgba(255, 255, 255, 0.82);
        border-radius: 28px;
        box-shadow: 0 18px 48px rgba(24, 29, 25, 0.08);
        padding: 24px;
    }

    .section-shell.dark {
        background: linear-gradient(180deg, #15271f 0%, #0f1814 100%);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.06);
    }

    .section-head {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: end;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .section-kicker {
        display: inline-flex;
        align-items: center;
        padding: 7px 12px;
        border-radius: 999px;
        background: rgba(17, 19, 21, 0.06);
        color: rgba(17, 19, 21, 0.72);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.10em;
        margin-bottom: 12px;
    }

    .section-shell.dark .section-kicker {
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.78);
    }

    .section-head h2 {
        margin: 0;
        font-size: clamp(28px, 3vw, 40px);
        line-height: 1;
        letter-spacing: -0.05em;
    }

    .section-head p {
        margin: 8px 0 0;
        max-width: 68ch;
        color: var(--lp-muted);
        line-height: 1.65;
    }

    .section-shell.dark .section-head p {
        color: rgba(255, 255, 255, 0.68);
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .card-grid.two {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .card-grid.four {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .section-card {
        border-radius: 24px;
        background: linear-gradient(180deg, #ffffff 0%, #f5f7f2 100%);
        border: 1px solid rgba(17, 19, 21, 0.08);
        box-shadow: 0 16px 32px rgba(17, 19, 21, 0.08);
        padding: 18px;
        min-height: 100%;
    }

    .section-card.dark {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.07);
        color: #fff;
    }

    .section-card .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(17, 19, 21, 0.06);
        color: rgba(17, 19, 21, 0.72);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 12px;
    }

    .section-card.dark .eyebrow {
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.78);
    }

    .section-card h3 {
        margin: 0;
        font-size: 22px;
        line-height: 1.06;
        letter-spacing: -0.04em;
    }

    .section-card p {
        margin: 12px 0 0;
        color: var(--lp-muted);
        line-height: 1.65;
        font-size: 14px;
    }

    .section-card.dark p {
        color: rgba(255, 255, 255, 0.72);
    }

    .section-card .foot {
        margin-top: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .section-link {
        color: #102017;
        text-decoration: none;
        font-weight: 800;
    }

    .section-card.dark .section-link {
        color: #fff;
    }

    .section-link:hover {
        text-decoration: underline;
    }

    .list-rail {
        display: grid;
        gap: 12px;
    }

    .mini-row {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr) auto;
        gap: 14px;
        align-items: center;
        padding: 14px 16px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.72);
        border: 1px solid rgba(17, 19, 21, 0.08);
    }

    .mini-row.dark {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(255, 255, 255, 0.08);
    }

    .mini-dot {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2b6a45 0%, #7ea27f 100%);
    }

    .mini-row h4 {
        margin: 0;
        font-size: 16px;
        line-height: 1.2;
    }

    .mini-row .desc {
        margin-top: 4px;
        color: var(--lp-muted);
        font-size: 13px;
        line-height: 1.45;
    }

    .mini-row.dark .desc {
        color: rgba(255, 255, 255, 0.68);
    }

    .pill-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pill-link {
        display: inline-flex;
        align-items: center;
        min-height: 38px;
        padding: 0 14px;
        border-radius: 999px;
        background: rgba(17, 19, 21, 0.06);
        color: rgba(17, 19, 21, 0.76);
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid rgba(17, 19, 21, 0.08);
    }

    .pill-link.dark {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.08);
    }

    .testimonial-card {
        padding: 0;
        overflow: hidden;
    }

    .testimonial-visual {
        min-height: 340px;
        background:
            radial-gradient(circle at 40% 20%, rgba(43, 106, 69, 0.18), transparent 24%),
            linear-gradient(180deg, #223c30 0%, #0f1c16 100%);
        display: grid;
        place-items: end center;
        padding: 18px;
    }

    .testimonial-visual .profile {
        width: min(200px, 100%);
        height: 260px;
        border-radius: 34px 34px 0 0;
        background: linear-gradient(180deg, #f3f5f1 0%, #dfe6dc 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        position: relative;
        overflow: hidden;
    }

    .testimonial-visual .profile::before {
        content: "";
        position: absolute;
        left: 50%;
        top: 22px;
        width: 108px;
        height: 108px;
        transform: translateX(-50%);
        border-radius: 50%;
        background: radial-gradient(circle at 45% 40%, #29342e 0 18px, #f0c4a3 19px 42px, #18211d 43px 48px, transparent 49px),
            linear-gradient(180deg, #4a4a4a 0%, #272727 100%);
        box-shadow: 0 18px 34px rgba(0, 0, 0, 0.18);
        opacity: 0.9;
    }

    .testimonial-copy {
        padding: 28px;
        background: linear-gradient(180deg, #f7f8f3 0%, #eef1eb 100%);
    }

    .testimonial-copy h3 {
        font-size: clamp(28px, 3.4vw, 40px);
    }

    .testimonial-copy .quote {
        margin-top: 18px;
        line-height: 1.75;
    }

    .testimonial-copy .name {
        margin-top: 22px;
        font-size: 20px;
        font-weight: 800;
    }

    .partner-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 12px;
        align-items: center;
        justify-content: center;
    }

    .partner-row .mark {
        color: rgba(17, 19, 21, 0.70);
        background: rgba(255, 255, 255, 0.82);
        border: 1px solid rgba(17, 19, 21, 0.08);
    }

    .cta-card {
        background:
            radial-gradient(circle at center, rgba(43, 106, 69, 0.14), transparent 24%),
            linear-gradient(180deg, #1a4e39 0%, #183728 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .cta-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        background-size: 40px 40px;
        opacity: 0.24;
        pointer-events: none;
    }

    .cta-card .inner {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 640px;
        margin: 0 auto;
    }

    .cta-card h3 {
        font-size: clamp(30px, 4vw, 52px);
    }

    .cta-card p {
        margin: 14px auto 0;
        max-width: 50ch;
        color: rgba(255, 255, 255, 0.72);
    }

    .cta-card .actions {
        margin-top: 22px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
    }

    .footer-card {
        background: rgba(255, 255, 255, 0.84);
    }

    .footer-partners {
        display: flex;
        flex-direction: column;
        gap: 14px;
        align-items: center;
        margin-bottom: 18px;
    }

    .footer-partners .label {
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--lp-muted);
    }

    .partner-logos {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 12px 18px;
    }

    .partner-logos span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 0 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(17, 19, 21, 0.08);
        color: var(--lp-ink);
        font-weight: 700;
        font-size: 13px;
    }

    .download-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
    }

    .download-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 0 14px;
        border-radius: 12px;
        background: #111315;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .download-badge.light {
        background: #fff;
        color: var(--lp-ink);
        border: 1px solid rgba(17, 19, 21, 0.08);
    }

    .footer-brand {
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }

    .footer-brand img {
        width: 108px;
        height: auto;
    }

    .footer-brand p {
        margin: 10px 0 0;
        max-width: 34ch;
    }

    .footer-col h4 {
        margin: 0 0 14px;
        font-size: 16px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .footer-col ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: grid;
        gap: 10px;
    }

    .footer-col a {
        color: var(--lp-muted);
        text-decoration: none;
        font-size: 14px;
    }

    .footer-col a:hover {
        color: var(--lp-ink);
    }

    .footer-bottom {
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid rgba(17, 19, 21, 0.10);
        color: var(--lp-muted);
        font-size: 13px;
    }

    .footer-bottom a {
        color: inherit;
        text-decoration: none;
    }

    .footer-bottom a:hover {
        color: var(--lp-ink);
    }

    @media (max-width: 991px) {
        .tools_grid_cards {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .cta-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .compare-shell {
            padding: 26px 20px 22px;
        }

        .compare-tools-grid {
            grid-template-columns: 1fr;
        }

        .landing-nav {
            flex-wrap: wrap;
            padding-left: 18px;
            padding-right: 18px;
        }

        .landing-menu {
            order: 3;
            width: 100%;
        }

        .hero-grid,
        .split-callout .callout-grid,
        .testimonial-inner {
            grid-template-columns: 1fr;
        }

        .hero-art {
            min-height: 460px;
        }

        .hero-card {
            position: relative;
            right: auto;
            top: auto;
            margin-left: auto;
            margin-right: auto;
        }

        .market-heatmap {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .market-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .hero-floating {
            position: relative;
            left: auto;
            bottom: auto;
            width: min(340px, 100%);
            margin: 16px auto 0;
            transform: none;
        }

        .metrics-grid,
        .simple-grid .grid-wrap,
        .card-grid,
        .card-grid.two,
        .card-grid.four {
            grid-template-columns: 1fr;
        }

        .content-section,
        .landing-top,
        .landing-hero,
        .metrics-strip,
        .two-column-section,
        .simple-grid,
        .split-callout,
        .testimonial-section,
        .resource-section,
        .cta-section,
        .footer-landing {
            padding-left: 14px;
            padding-right: 14px;
        }

        .footer-landing {
            padding-left: 0;
            padding-right: 0;
        }

        .landing-brand img {
            width: 118px;
        }
    }

    @media (max-width: 640px) {
        .tools_showcase_section {
            padding-top: 4px;
        }

        .tools_showcase_copy {
            padding-left: 14px;
            padding-right: 14px;
        }

        .tools_showcase_title {
            font-size: clamp(34px, 10vw, 52px);
            max-width: none;
        }

        .tools_showcase_copytext {
            font-size: 16px;
        }

        .tools_grid_cards {
            grid-template-columns: 1fr;
        }

        .tool-mini-card {
            min-height: 0;
            padding: 18px 16px 16px;
        }

        .cta-bar {
            padding: 18px 18px;
        }

        .compare-shell {
            padding: 22px 16px 18px;
        }

        .compare-tool-card {
            padding: 20px;
            border-radius: 24px;
        }

        .compare-tool-top {
            gap: 12px;
        }

        .compare-tool-icon {
            width: 62px;
            height: 62px;
            border-radius: 18px;
            font-size: 24px;
        }

        .compare-tool-card h3 {
            font-size: 21px;
        }

        .compare-tool-field select {
            min-height: 52px;
            font-size: 14px;
        }

        .hero-panel,
        .surface-card,
        .footer-card,
        .cta-card {
            padding: 20px;
            border-radius: 24px;
        }

        .hero-title {
            max-width: 10ch;
        }

        .hero-card {
            width: 100%;
        }

        .hero-card .details {
            grid-template-columns: 1fr;
        }

        .market-marquee {
            margin-bottom: 12px;
        }

        .market-track {
            padding: 8px 0;
        }

        .market-mover {
            flex-direction: column;
            align-items: flex-start;
        }

        .hero-card {
            min-height: auto;
        }
    }
</style>

<section class="landing-shell">
    <div class="landing-top">
        <div class="landing-nav">
            <a href="{{ url('/') }}" class="landing-brand">
                <img src="{{ asset('themes/frontend/assets/v1/img/Logo_v2-03-white.png') }}" alt="myplex logo">
            </a>
            <div class="landing-menu">
                <a href="/compare-scheme">Compare</a>
                <a href="/monthly-ranking">Rankings</a>
                <a href="/performance-snapshot">Snapshots</a>
                <a href="/new-fundwatch-list">Fund Watch</a>
                <a href="/calculators">Calculators</a>
            </div>
            <div class="landing-auth-actions">
                <a href="/login" class="landing-signin">Login</a>
                <a href="/register" class="landing-signup">Register</a>
            </div>
        </div>
    </div>

    <div class="landing-hero">
        <div class="hero-panel">
            <div class="hero-grid">
                <div>
                    <div class="hero-eyebrow">MyPlex market intelligence</div>
                    <h1 class="hero-title">Invest in the Freedom of choose</h1>
                    <p class="hero-copy">
                        Bring the core MyPlex experience into a single polished landing page. The layout keeps the visual weight of the reference while staying aligned with our fund research, market views and planning tools.
                    </p>
                    <div class="hero-actions">
                        <a href="/compare-scheme" class="hero-btn primary">Start exploring</a>
                        <a href="/fund-performance" class="hero-btn secondary">View performance</a>
                    </div>

                    <div class="hero-trust">
                        <div class="hero-avatars" aria-hidden="true">
                            <div class="hero-avatar">MP</div>
                            <div class="hero-avatar">FM</div>
                            <div class="hero-avatar">RP</div>
                            <div class="hero-avatar">QA</div>
                        </div>
                        <div>
                            <strong>{{ number_format($fundCount ?: 0) }}+ research items</strong>
                            <span>Live funds, snapshots, watchlists and articles ready to explore.</span>
                        </div>
                    </div>

                </div>

                <div class="hero-art">
                    <div class="hero-card">
                        <div class="market-marquee" aria-hidden="true">
                            <div class="market-track">
                                @foreach ($heroSignals as $signal)
                                    <span class="market-pill"><b>{{ $signal['label'] }}</b> {{ $signal['value'] }}</span>
                                @endforeach
                                @foreach ($heroSignals as $signal)
                                    <span class="market-pill"><b>{{ $signal['label'] }}</b> {{ $signal['value'] }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="market-board">
                            <div class="market-header">
                                <div class="label">Market pulse</div>
                                <div class="brand-name">Live stock watch</div>
                            </div>

                            <div class="market-index">
                                <div class="topline">
                                    <div>
                                        <div class="name">NIFTY 50</div>
                                        <div class="price">22,391.25</div>
                                    </div>
                                    <div class="change">+0.84%</div>
                                </div>
                                <svg class="market-spark" viewBox="0 0 340 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M0 70C22 68 29 38 51 39C74 40 82 61 107 60C130 59 139 20 166 18C188 17 197 40 220 41C244 42 252 24 276 25C298 26 308 9 340 10" stroke="#7ea27f" stroke-width="4" stroke-linecap="round"/>
                                    <path d="M0 84H340" stroke="rgba(17,19,21,0.10)" />
                                </svg>
                            </div>

                            <div class="market-heatmap">
                                <div class="market-tile up">BANK<small>+1.6%</small></div>
                                <div class="market-tile flat">IT<small>+0.2%</small></div>
                                <div class="market-tile up-soft">AUTO<small>+1.1%</small></div>
                                <div class="market-tile down">PHARMA<small>-0.4%</small></div>
                                <div class="market-tile up-soft">FMCG<small>+0.7%</small></div>
                                <div class="market-tile flat">ENERGY<small>+0.0%</small></div>
                                <div class="market-tile up">MIDCAP<small>+1.3%</small></div>
                                <div class="market-tile down">METAL<small>-0.8%</small></div>
                            </div>

                            <div class="market-movers">
                                <div class="market-mover">
                                    <div>
                                        <div class="symbol">RELIANCE</div>
                                        <div class="meta">Energy & retail leader</div>
                                    </div>
                                    <div class="price">2,576.10</div>
                                </div>
                                <div class="market-mover">
                                    <div>
                                        <div class="symbol">HDFCBANK</div>
                                        <div class="meta">Banking heavy weight</div>
                                    </div>
                                    <div class="price">1,455.25</div>
                                </div>
                                <div class="market-mover">
                                    <div>
                                        <div class="symbol">INFY</div>
                                        <div class="meta">IT momentum watch</div>
                                    </div>
                                    <div class="price">1,160.00</div>
                                </div>
                            </div>

                            <div class="market-radar">
                                <div class="label">Breadth running</div>
                                <div class="running" aria-hidden="true"><span></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-floating">
                        <div class="brand-row">
                            <div>
                                <div class="label">Sector snapshot</div>
                                <div class="brand-name">{{ data_get($heroFund, 'fund_name', 'Fund market overview') }}</div>
                            </div>
                            <div class="mini-badge">Live</div>
                        </div>
                        <div class="rowline">
                            <div>
                                <div class="big">{{ number_format($performanceCount ?: 0) }}</div>
                                <div class="small">performance reports</div>
                            </div>
                            <div class="small">updated now</div>
                        </div>
                        <div class="rowline" style="margin-bottom:0;">
                            <div>
                                <div class="big">{{ number_format($fundCount ?: 0) }}</div>
                                <div class="small">funds in view</div>
                            </div>
                            <div class="small">{{ number_format($watchCount ?: 0) }} watch items</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="tools_showcase_section">
        <div class="tools_showcase_shell">
            <div class="tools_showcase_grid">
                <div class="tools_showcase_copy" data-aos="fade-up" data-aos-duration="900">

                    <h2 class="tools_showcase_title"><span class="title-line">Everything you need to</span><span class="title-line"><span class="accent">compare, track</span>, and research stocks.</span></h2>
                    <p class="tools_showcase_copytext">
                        From live market snapshots and ranking views to fund watchlists and planning calculators,
                    <div class="tools_grid_cards">
                        <div class="tool-mini-card">
                            <div>
                                <div class="icon"><i class="fa fa-exchange" aria-hidden="true"></i></div>
                                <h3>Compare</h3>
                                <p>Compare funds, ETFs and stocks side by side with key metrics.</p>
                            </div>
                            <div class="go"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                        </div>
                        <div class="tool-mini-card">
                            <div>
                                <div class="icon"><i class="fa fa-bar-chart" aria-hidden="true"></i></div>
                                <h3>Rankings</h3>
                                <p>Explore top ranked funds and stocks across multiple categories.</p>
                            </div>
                            <div class="go"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                        </div>
                        <div class="tool-mini-card">
                            <div>
                                <div class="icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
                                <h3>Snapshots</h3>
                                <p>Get real-time market snapshots and key insights at a glance.</p>
                            </div>
                            <div class="go"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                        </div>
                        <div class="tool-mini-card">
                            <div>
                                <div class="icon"><i class="fa fa-star-o" aria-hidden="true"></i></div>
                                <h3>Watchlists</h3>
                                <p>Create and manage custom watchlists to track what matters.</p>
                            </div>
                            <div class="go"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                        </div>
                        <div class="tool-mini-card">
                            <div>
                                <div class="icon"><i class="fa fa-line-chart" aria-hidden="true"></i></div>
                                <h3>Research</h3>
                                <p>Deep dive into detailed research, trends, and expert analysis.</p>
                            </div>
                            <div class="go"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                        </div>
                        <div class="tool-mini-card">
                            <div>
                                <div class="icon"><i class="fa fa-calculator" aria-hidden="true"></i></div>
                                <h3>Calculators</h3>
                                <p>Plan smarter with SIP calculators and return projections.</p>
                            </div>
                            <div class="go"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="cta-bar">
                <div>
                    <h3>Powerful tools. Smarter decisions.</h3>
                    <p>All your stock research essentials in one place.</p>
                </div>
                <a href="/compare-scheme">Subscribe Now <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>

    <section class="compare_section section">
        <div class="container">
            <div class="compare-shell">
                <div class="row">
                    <div class="col-lg-12 mb-3 mb-md-4">
                        <div class="compare_titile text-center" data-aos="fade-up" data-aos-duration="1000">
                            <h2>Powerful Tools For Mutual Fund Research</h2>
                            <p>Move through compare, ranking and composition views inside a more polished research experience.</p>
                        </div>
                    </div>
                </div>

                <div class="compare-tools-grid">
                    <div class="compare-tool-card" data-aos="fade-up" data-aos-duration="900">
                        <div class="compare-tool-top">
                            <div class="compare-tool-icon">
                                <i class="fa fa-trophy" aria-hidden="true"></i>
                            </div>
                            <h3>Category wise Return & Risk Ranking</h3>
                        </div>
                        <p>Performance parameters and recommendations of fund rankings in terms of quality of return, volatility and risk incurred.</p>
                        <div class="compare-tool-field">
                            <select aria-label="Daily price compare select">
                                <option value="" selected>Select An Item</option>
                                @forelse($fundTypeOptions as $fundType)
                                    <option value="{{ data_get($fundType, 'ft_id') }}">{{ data_get($fundType, 'name') }}</option>
                                @empty
                                    <option value="">No fund types available</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="compare-tool-actions">
                            <a href="/compare-scheme?compare_price_type=scheme_scheme" class="compare-tool-link">
                                Compare <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>

                    <div class="compare-tool-card" data-aos="fade-up" data-aos-duration="1000">
                        <div class="compare-tool-top">
                            <div class="compare-tool-icon">
                                <i class="fa fa-line-chart" aria-hidden="true"></i>
                            </div>
                            <h3>Category Performance Snapshot</h3>
                        </div>
                        <p>Categorizing and indexing fund performance over multiple time frames to understand risk-adjusted returns, ratios and portfolios.</p>
                        <div class="compare-tool-field">
                            <select aria-label="Ratio compare select">
                                <option value="" selected>Select An Item</option>
                                @forelse($benchmarkOptions as $benchmark)
                                    <option value="{{ $benchmark }}">{{ $benchmark }}</option>
                                @empty
                                    <option value="">No benchmark options available</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="compare-tool-actions">
                            <a href="/compare-scheme?compare_ratio_type=information_ratio" class="compare-tool-link">
                                Compare <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>

                    <div class="compare-tool-card" data-aos="fade-up" data-aos-duration="1100">
                        <div class="compare-tool-top">
                            <div class="compare-tool-icon">
                                <i class="fa fa-pie-chart" aria-hidden="true"></i>
                            </div>
                            <h3>Scheme Performance, Ratios & Highlights</h3>
                        </div>
                        <p>A detailed insight into scheme performance, the asset allocation of the scheme and how it has been constructed over time.</p>
                        <div class="compare-tool-field">
                            <select aria-label="Composition compare select">
                                <option value="" selected>Select An Item</option>
                                @forelse($classificationOptions as $classification)
                                    <option value="{{ $classification }}">{{ $classification }}</option>
                                @empty
                                    <option value="">No classification options available</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="compare-tool-actions">
                            <a href="/compare-scheme?compare_composition_type=top_industry" class="compare-tool-link">
                                Compare <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="money_seriously_section section">
        <div class="container">
            <div class="row">
                <div class="money_seriously_title mb-4 mb-md-5">
                    <div class="col-md-12" data-aos="fade-up" data-aos-duration="1000">
                        <div class="money_seriously_title d-block d-sm-flex align-items-center">
                            <h4 style="display: inline-flex;">Money, Seriously!!
                                <img src="{{ asset('themes/frontend/assets/v1/img/blog-image.png') }}" style="width: 40%;"/>
                            </h4>
                            <p>
                                Mutual funds have become a popular investment option in recent years, as they offer the potential for higher returns than more traditional investments such as savings accounts or bonds.
                                However, merely tracking the historical returns and fund rankings will not help you choose the right fund. Here, we discuss topics such as investment objectives, levels of financial freedom, performance parameters, and how they will help you understand what to look for in a fund. We will also cover some key concepts such as risk and return, asset allocation, and diversification.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                @foreach($blogResponses as $value)
                <div class="col-md-4 mb-4">
                    <div class="money_left_sec" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ $value['img'] }}" class="img-fluid" />
                    </div>
                    <div class="money_right_section" data-aos="fade-up" data-aos-duration="1000">
                        <h4>{{ $value['title'] }}</h4>
                        <p>
                            {{ Str::limit(strip_tags($value['short_desc']), 200, '...') }}
                        </p>
                        <a href="{{ $value['link'] }}" target="_blank">Read More</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <a href="https://blog.myplexus.com/" class="money_title_btn type2">View All Articles</a>
                </div>
            </div>
        </div>
    </section>

    <section class="calulator_section section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 mb-4">
                    <div class="calculator_title text-center">
                        <h4 data-aos="fade-up" data-aos-duration="500">Calculator</h4>
                        <p data-aos="fade-up" data-aos-duration="1000">Our financial calculators can help you determine the best investment strategy for your needs taking into account your investment objective, level of financial freedom, and other performance parameters.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills justify-content-center calculator_nav_pills mb-4" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="Planner-tab" data-bs-toggle="tab" data-bs-target="#Planner" type="button" role="tab" aria-controls="Planner" aria-selected="true">Planner</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Planner" role="tabpanel" aria-labelledby="Planner-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="calculator_inner d-md-flex d-block align-items-center-between justify-content-center w-100">
                                        <div class="single_calculator">
                                            <span class="right_circle d-none d-sm-block"></span>
                                            <div data-aos="zoom-in" data-aos-duration="500">
                                                <a href="https://myplexus.com/calctest?cal=sip">
                                                    <img src="{{ asset('themes/frontend/assets/v1/img/lumpsum.png') }}" />
                                                    <h4>SIP Planner</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="single_calculator have_before">
                                            <span class="left_circle d-none d-sm-block"></span>
                                            <span class="right_circle d-none d-sm-block"></span>
                                            <div data-aos="zoom-in" data-aos-duration="1000">
                                                <a href="https://myplexus.com/calctest?cal=lump">
                                                    <img src="{{ asset('themes/frontend/assets/v1/img/sip.png') }}" />
                                                    <h4>Lumpsum Fund Planner</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="single_calculator have_before">
                                            <span class="left_circle d-none d-sm-block"></span>
                                            <span class="right_circle d-none d-sm-block"></span>
                                            <div data-aos="zoom-in" data-aos-duration="1000">
                                                <a href="https://myplexus.com/calctest?cal=retire">
                                                    <img src="{{ asset('themes/frontend/assets/v1/img/calculator-icon2.png') }}" />
                                                    <h4>Retirement Planner</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="single_calculator have_before">
                                            <span class="left_circle d-none d-sm-block"></span>
                                            <span class="right_circle d-none d-sm-block"></span>
                                            <div data-aos="zoom-in" data-aos-duration="1000">
                                                <a href="{{ route('web.calculators') }}?tab=risk-tol-eval">
                                                    <img src="{{ asset('themes/frontend/assets/v1/img/calculator-icon4.png') }}" />
                                                    <h4>Risk Tolerance Evaluator</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="single_calculator have_before">
                                            <span class="left_circle d-none d-sm-block"></span>
                                            <span class="right_circle d-none d-sm-block"></span>
                                            <div data-aos="zoom-in" data-aos-duration="1000">
                                                <a href="https://myplexus.com/calctest?cal=inflation">
                                                    <img src="{{ asset('themes/frontend/assets/v1/img/calculator-icon1.png') }}" />
                                                    <h4>Inflation Calculator</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="single_calculator have_before">
                                            <span class="left_circle d-none d-sm-block"></span>
                                            <div data-aos="zoom-in" data-aos-duration="500">
                                                <a href="https://myplexus.com/calctest?cal=pills-goal1">
                                                    <img src="{{ asset('themes/frontend/assets/v1/img/calculator-icon2.png') }}" />
                                                    <h4>Goal Planner</h4>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="money_seriously_section fund_watch_setion_home section">
        <div class="container">
            <div class="row">
                <div class="money_seriously_title mb-4">
                    <div class="col-md-12" data-aos="fade-down" data-aos-duration="1000">
                        <div class="money_seriously_title d-block d-sm-flex align-items-center">
                            <h4>Fund Watch</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                @if(count($fndWtchMdl) > 0)
                @php $i =1; @endphp
                @if($i <= 2)
                    @foreach($fndWtchMdl as $newfndWtchMdl)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="{{500*$i}}">
                    @if($newfndWtchMdl->logo)
                        <div class="money_left_sec">
                            <div class="fund_watch_home_sec_single_img">
                                <img src="{{ env('ADMIN_SITE') }}/assets/images/{{ $newfndWtchMdl->logo }}" />
                            </div>
                        </div>
                    @endif
                        <div class="money_right_section">
                            @php
                               $fid =base64_encode($newfndWtchMdl->fundDetails->fund_code);
                            @endphp
                            <h4><a href="{{ url('new-fundwatch') }}/{{$fid}}" target="_blank">{{ $newfndWtchMdl->fundDetails->fund_name }}</a></h4>
                        </div>
                    </div>
                    @endforeach
                @endif
                @else
                <p style="color: white; font-weight:bold;">No Data Found</p>
                @endif
                <div class="col-md-12 text-center">
                @if(count($fndWtchMdl) > 0)
                    <a href="{{ url('new-fundwatch-list') }}" class="money_title_btn type2">View More</a>
                @endif
                </div>
            </div>
        </div>
    </section>

    <section class="Paathshaala_NFO section">
        <div class="patshala-new">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 patshala-left pl-0">
                        <h3>Paathshaala</h3>
                        <div class="patshala-new-lft br-5 ml-3">
                            <ul>
                                <li><a href="/mutual-fund-taxation">Mutual Fund Taxation</a></li>
                                <li><a href="/mutual-fund-classifications">Mutual Fund Classifications</a></li>
                                <li><a href="/know-the-ratio">Know The Ratio</a></li>
                                <li><a href="/#">Thoughts and Opinion on Funds</a></li>
                                <li><a href="/mutual-fund-dictionary">Mutual Fund Dictionary</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 patshala-right pl-0">
                        <h3>NFO Monitor</h3>
                        <div class="patshala-new-rgt ml-3">
                            <ul>
                                @if($nfoMdl)
                                @foreach ($nfoMdl as $key => $val)
                                <li><a href="{{url('/nfo-monitor').'/'.$val->no_id}}">{{$val->fund_name}}</a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta_section section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="fund_man_expert_home">
                        <h2>Performance Synopsis</h2>
                        <p>You can access performance data for all of our funds on our website. In addition,
                            we also offer a range of analytical tools that can help you evaluate a fund's performance and choose the right one for your clients.</p>
                        <a href="performance-synopsis" class="money_title_btn type2 me-3 ms-0">Discover</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faq_section section">
        @include('web.common.faq_section')
    </section>

    <section class="scheme_cta section">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-lg-5">
                    <div class="fund_man_expert_home">
                        <h2>Know Your Scheme</h2>
                        <p>When considering schemes, it's vital to know the risk levels, returns, and other parameters, like asset allocation and periodic rebalancing, for the respective fund categories.</p>
                        <a href="{{ route('web.know.your.scheme') }}" class="money_title_btn ms-0 type2">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="footer-landing section">
        <div class="container">
            <div class="footer-partners">
                <div class="label">Meet Our Esteemed Partners & Affiliates</div>
                <div class="partner-logos" aria-label="Partners">
                    <span>Stripe</span>
                    <span>Mastercard</span>
                    <span>PayPal</span>
                    <span>G Pay</span>
                    <span>Skrill</span>
                    <span>Payoneer</span>
                </div>
            </div>

            <div class="footer-card section-shell">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-brand">
                            <div>
                                <a href="{{ url('/') }}" class="d-inline-block">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/Logo_v2-03-white.png') }}" alt="myplex logo">
                                </a>
                                <p>Do you support international transactions? Yes, with multi-currency support.</p>
                                <div class="download-badges">
                                    <a href="#" class="download-badge">Google Play</a>
                                    <a href="#" class="download-badge light">App Store</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-col">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="/compare-scheme">Compare</a></li>
                            <li><a href="/monthly-ranking">Rankings</a></li>
                            <li><a href="/performance-snapshot">Snapshots</a></li>
                            <li><a href="/calculators">Calculators</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-col">
                        <h4>Services</h4>
                        <ul>
                            <li><a href="/new-fundwatch-list">Fund Watch</a></li>
                            <li><a href="/mutual-fund-taxation">Taxation</a></li>
                            <li><a href="/mutual-fund-classifications">Classifications</a></li>
                            <li><a href="/know-the-ratio">Know The Ratio</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-col">
                        <h4>Community</h4>
                        <ul>
                            <li><a href="#">Community hub</a></li>
                            <li><a href="#">Invite a Friend</a></li>
                            <li><a href="#">News & Blog</a></li>
                            <li><a href="#">Affiliates</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-col">
                        <h4>Social Media</h4>
                        <ul>
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">YouTube</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Instagram</a></li>
                        </ul>
                    </div>
                </div>

                <div class="footer-bottom d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>© {{ date('Y') }} MyPlexus. All rights reserved.</div>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="/privacy-policy">Privacy Policy</a>
                        <a href="/terms-and-conditions">Terms</a>
                        <a href="/contact-us">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@stop
