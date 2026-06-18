@extends('web.layout.app')

@if (isset($dataArr['meta_title']))
@section('page-title'){{ $dataArr['meta_title'] }}@stop
@else
@section('page-title'){{ $dataArr['title'] }}@stop
@endif

@if (isset($dataArr['meta_descp']))
@section('meta-description'){{ $dataArr['meta_descp'] }}@stop
@endif

@if (isset($dataArr['full_url']))
@section('cur-url'){{ $dataArr['full_url'] }}@stop
@endif

@section('content')
@php
    $request = $dataArr['request'];
    $summary = $dataArr['summary'];
    $items = $dataArr['items'];
    $fundTypes = $dataArr['fund_types'];
    $featuredFunds = $dataArr['featured_funds'];
    $heatmapGroups = $dataArr['heatmap_groups'];
    $heatmapGroupsCollection = collect($heatmapGroups);
    $classificationGroups = $dataArr['classification_groups'];
    $classificationCatalog = $dataArr['classification_catalog'];
    $selectedFund = $dataArr['selected_fund'];
    $timeFrames = $dataArr['time_frames'];
    $timeFrame = $dataArr['time_frame'];
    $startDate = $dataArr['start_date'];
    $endDate = $dataArr['end_date'];
    $disclaimer = $dataArr['disclaimer'];
    $selectedClassification = $dataArr['selected_classification'] ?? '';
    $currentParams = $request->except(['page', 'time_frame']);
    $sort = $request->input('sort', 'change_desc');
    $selectedFundCode = $selectedFund['fund_code'] ?? '';
    $heatmapUrl = url('market-heatmap');
    $overviewUrl = url('market-overview');
@endphp

<style>
    :root {
        --mh-bg: #f3f6fa;
        --mh-panel: #ffffff;
        --mh-panel-2: #f7f9fc;
        --mh-panel-3: #edf2f7;
        --mh-border: rgba(15, 23, 42, 0.10);
        --mh-text: #172033;
        --mh-muted: #667085;
        --mh-green: #1f9e67;
        --mh-green-2: #0dbf8a;
        --mh-red: #d64b4b;
        --mh-red-2: #ff5f5f;
        --mh-blue: #3b82f6;
    }

    .stock-heatmap-shell {
        background:
            radial-gradient(circle at top left, rgba(59, 130, 246, 0.10), transparent 28%),
            radial-gradient(circle at bottom right, rgba(16, 185, 129, 0.08), transparent 30%),
            linear-gradient(180deg, #ffffff 0%, #eef3f8 100%);
        min-height: 100vh;
        color: var(--mh-text);
        padding: 34px 0 52px;
    }

    .stock-heatmap-head {
        display: grid;
        grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.35fr);
        gap: 22px;
        margin-bottom: 22px;
        align-items: end;
    }

    .market-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #344054;
        background: rgba(255, 255, 255, 0.78);
        font-size: 12px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .stock-heatmap-head h1 {
        margin: 0;
        font-size: clamp(30px, 3vw, 46px);
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .stock-heatmap-head .sub {
        margin-top: 12px;
        color: var(--mh-muted);
        font-size: 15px;
        max-width: 760px;
    }

    .stock-heatmap-head .actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }

    .mh-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        border: 1px solid var(--mh-border);
        background: rgba(255, 255, 255, 0.82);
        color: var(--mh-text);
        text-decoration: none;
        font-size: 13px;
        transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
    }

    .mh-pill:hover {
        transform: translateY(-1px);
        background: #ffffff;
        color: var(--mh-text);
        text-decoration: none;
    }

    .mh-pill.active {
        background: rgba(59, 130, 246, 0.20);
        border-color: rgba(59, 130, 246, 0.55);
        color: #fff;
    }

    .mh-subtle-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 12px 0 18px;
    }

    .mh-subtle-chip {
        padding: 8px 12px;
        border-radius: 999px;
        border: 1px solid var(--mh-border);
        background: rgba(255, 255, 255, 0.80);
        color: var(--mh-muted);
        font-size: 12px;
        letter-spacing: 0.02em;
    }

    .mh-classify-strip {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 4px;
        margin-bottom: 16px;
        scrollbar-width: thin;
    }

    .mh-classify-strip::-webkit-scrollbar {
        height: 7px;
    }

    .mh-classify-strip::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.14);
        border-radius: 999px;
    }

    .mh-classify-tab {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.82);
        color: #263247;
        text-decoration: none;
        transition: transform 0.18s ease, background 0.18s ease, border-color 0.18s ease;
        white-space: nowrap;
    }

    .mh-classify-tab:hover {
        transform: translateY(-1px);
        background: #fff;
        color: #172033;
        text-decoration: none;
    }

    .mh-classify-tab.active {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.26), rgba(13, 191, 138, 0.18));
        border-color: rgba(59, 130, 246, 0.52);
        box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.12) inset;
    }

    .mh-classify-tab .name {
        font-weight: 800;
        font-size: 13px;
    }

    .mh-classify-tab .count {
        color: #9ea3a8;
        font-size: 12px;
    }

    .mh-filter-bar {
        background: rgba(255, 255, 255, 0.86);
        border: 1px solid var(--mh-border);
        border-radius: 20px;
        padding: 14px;
        margin-bottom: 18px;
    }

    .mh-filter-bar label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: var(--mh-muted);
        margin-bottom: 6px;
    }

    .mh-filter-bar .form-control,
    .mh-filter-bar .form-select {
        background: #fff;
        border-color: #d7dee8;
        color: #172033;
        min-height: 44px;
        border-radius: 14px;
    }

    .mh-filter-bar .btn {
        min-height: 44px;
        border-radius: 14px;
        font-weight: 700;
    }

    .mh-layout {
        display: grid;
        grid-template-columns: minmax(280px, 0.68fr) minmax(0, 1.52fr);
        gap: 20px;
        align-items: start;
    }

    .mh-panel {
        background: var(--mh-panel);
        border: 1px solid var(--mh-border);
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 20px 55px rgba(44, 62, 80, 0.12);
    }

    .mh-panel-head {
        padding: 20px 20px 0;
    }

    .mh-panel-head h2 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .mh-panel-head p {
        margin: 8px 0 0;
        color: var(--mh-muted);
        font-size: 14px;
    }

    .mh-chart-shell {
        padding: 12px 18px 0;
    }

    .mh-chart-frame {
        border: 1px solid rgba(15, 23, 42, 0.10);
        background:
            linear-gradient(180deg, #ffffff, #f8fafc),
            radial-gradient(circle at 30% 20%, rgba(59, 130, 246, 0.10), transparent 24%);
        border-radius: 18px;
        position: relative;
        overflow: hidden;
        min-height: 300px;
    }

    .mh-chart-frame canvas {
        display: block;
        width: 100%;
        height: 300px;
    }

    .mh-chart-meta {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        padding: 14px 18px 0;
    }

    .mh-mini {
        background: var(--mh-panel-2);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 12px 14px;
        min-height: 88px;
    }

    .mh-mini .label {
        color: var(--mh-muted);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 8px;
    }

    .mh-mini .value {
        font-size: 24px;
        font-weight: 800;
        line-height: 1.05;
    }

    .mh-mini .sub {
        margin-top: 6px;
        font-size: 12px;
        color: var(--mh-muted);
    }

    .mh-time-tabs {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 18px 0;
    }

    .mh-time-tabs a {
        color: #475467;
        text-decoration: none;
        font-size: 13px;
        padding: 8px 14px;
        border-radius: 12px;
        border: 1px solid transparent;
        background: transparent;
    }

    .mh-time-tabs a.active {
        background: #172033;
        color: #fff;
        border-color: rgba(255, 255, 255, 0.08);
    }

    .mh-list {
        margin-top: 14px;
        padding: 0 18px 18px;
        display: grid;
        gap: 10px;
        max-height: 420px;
        overflow: auto;
    }

    .mh-list button {
        width: 100%;
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 18px;
        background: var(--mh-panel-2);
        color: inherit;
        padding: 14px;
        text-align: left;
        display: grid;
        grid-template-columns: 52px minmax(0, 1fr) auto;
        gap: 12px;
        align-items: center;
        transition: transform 0.2s ease, border-color 0.2s ease, background 0.2s ease;
    }

    .mh-list button:hover {
        transform: translateY(-1px);
        border-color: rgba(59, 130, 246, 0.25);
    }

    .mh-list button.active {
        background: rgba(13, 191, 138, 0.10);
        border-color: rgba(13, 191, 138, 0.45);
    }

    .mh-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
        font-weight: 800;
        letter-spacing: 0.04em;
    }

    .mh-list .name {
        font-size: 16px;
        font-weight: 800;
        line-height: 1.2;
    }

    .mh-list .meta {
        margin-top: 4px;
        color: var(--mh-muted);
        font-size: 13px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .mh-list .metric {
        text-align: right;
    }

    .mh-list .metric .nav {
        font-size: 18px;
        font-weight: 800;
        line-height: 1.05;
    }

    .mh-list .metric .chg {
        margin-top: 4px;
        font-size: 13px;
        font-weight: 700;
    }

    .mh-list .chg.positive,
    .mh-mini .positive {
        color: #31d98a;
    }

    .mh-list .chg.negative,
    .mh-mini .negative {
        color: #ff6d6d;
    }

    .mh-list .chg.flat,
    .mh-mini .flat {
        color: #667085;
    }

    .mh-heatmap-panel {
        background: transparent;
        border: none;
        box-shadow: none;
        display: grid;
        gap: 18px;
    }

    .mh-group {
        background: var(--mh-panel);
        border: 1px solid var(--mh-border);
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 24px 65px rgba(0, 0, 0, 0.30);
    }

    .mh-group-head {
        padding: 18px 20px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .mh-group-head .title {
        font-size: 18px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .mh-group-head .info {
        color: var(--mh-muted);
        font-size: 13px;
    }

    .mh-legend {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 0 18px 18px;
    }

    .mh-scale {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        color: #a9afb5;
        font-size: 12px;
    }

    .mh-scale-bar {
        width: 280px;
        max-width: 100%;
        height: 10px;
        border-radius: 999px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: linear-gradient(90deg, #dc2626 0%, #fb7185 18%, #2f2f2f 50%, #34d399 82%, #059669 100%);
    }

    .mh-mosaic {
        padding: 0 18px 18px;
        display: grid;
        grid-template-columns: repeat(18, minmax(0, 1fr));
        grid-auto-rows: 20px;
        gap: 8px;
        grid-auto-flow: dense;
    }

    .mh-tile {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #fff;
        text-decoration: none;
        padding: 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: var(--mh-panel-2);
        min-height: 104px;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease, filter 0.2s ease;
        cursor: pointer;
    }

    .mh-tile:hover {
        transform: translateY(-2px);
        border-color: rgba(255, 255, 255, 0.14);
        filter: saturate(1.05);
        text-decoration: none;
        color: #fff;
    }

    .mh-tile.active {
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.42) inset, 0 18px 30px rgba(0, 0, 0, 0.18);
        border-color: rgba(59, 130, 246, 0.7);
    }

    .mh-tile::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.08), transparent 34%);
        pointer-events: none;
    }

    .mh-tile .topline {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        align-items: flex-start;
        position: relative;
        z-index: 1;
    }

    .mh-tile .code {
        font-size: clamp(18px, 2vw, 30px);
        font-weight: 900;
        letter-spacing: -0.03em;
        line-height: 1;
    }

    .mh-tile .code.small {
        font-size: 16px;
    }

    .mh-tile .pct {
        font-size: 16px;
        font-weight: 800;
        white-space: nowrap;
    }

    .mh-tile .name {
        position: relative;
        z-index: 1;
        margin-top: 10px;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.82);
        line-height: 1.3;
    }

    .mh-tile .meta {
        position: relative;
        z-index: 1;
        margin-top: 12px;
        display: flex;
        justify-content: space-between;
        gap: 10px;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.78);
    }

    .mh-tile .movement {
        margin-top: 10px;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.9);
    }

    .mh-tile .movement .amt {
        font-weight: 800;
        letter-spacing: 0.01em;
    }

    .mh-note {
        margin-top: 18px;
        padding: 14px 18px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--mh-border);
        color: var(--mh-muted);
        font-size: 13px;
    }

    .mh-treemap-wrap {
        min-width: 0;
    }

    .mh-treemap-title {
        margin: 0 0 16px;
        font-size: clamp(28px, 2.8vw, 42px);
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .mh-treemap-frame {
        position: relative;
        height: clamp(620px, 67vw, 840px);
        min-height: 620px;
        overflow: hidden;
        border: 1px solid #ccd5e1;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 20px 55px rgba(44, 62, 80, 0.14);
    }

    .mh-treemap-stage {
        position: absolute;
        inset: 0 0 34px;
        overflow: hidden;
        background: #e7edf4;
    }

    .mh-tree-group {
        position: absolute;
        overflow: hidden;
        background: #eef2f6;
        border: 2px solid #ffffff;
    }

    .mh-tree-group-title {
        position: absolute;
        inset: 0 0 auto;
        height: 28px;
        padding: 3px 8px 0;
        overflow: hidden;
        color: #253044;
        background: #f8fafc;
        font-size: clamp(11px, 1vw, 16px);
        line-height: 24px;
        text-overflow: ellipsis;
        white-space: nowrap;
        z-index: 3;
    }

    .mh-tree-group-title::after {
        content: "›";
        padding-left: 6px;
        color: #667085;
        font-size: 20px;
        vertical-align: -1px;
    }

    .mh-tree-fund {
        position: absolute;
        appearance: none;
        border: 1px solid rgba(255, 255, 255, 0.72);
        border-radius: 0;
        color: #fff;
        padding: 5px;
        overflow: hidden;
        cursor: pointer;
        text-align: center;
        font: inherit;
        transition: filter 0.15s ease, box-shadow 0.15s ease;
    }

    .mh-tree-fund:hover {
        filter: brightness(1.16);
        z-index: 5;
    }

    .mh-tree-fund.active {
        box-shadow: inset 0 0 0 3px #3b82f6;
        z-index: 6;
    }

    .mh-tree-fund-name,
    .mh-tree-fund-change {
        position: absolute;
        left: 5px;
        right: 5px;
        overflow: hidden;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
    }

    .mh-tree-fund-name {
        top: 50%;
        transform: translateY(-72%);
        font-size: 12px;
        font-weight: 800;
        line-height: 1.15;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .mh-tree-fund-change {
        top: 50%;
        transform: translateY(20%);
        font-size: 11px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .mh-tree-fund.large .mh-tree-fund-name {
        font-size: clamp(15px, 1.55vw, 23px);
    }

    .mh-tree-fund.large .mh-tree-fund-change {
        font-size: clamp(16px, 1.7vw, 26px);
    }

    .mh-tree-fund.medium .mh-tree-fund-name {
        font-size: clamp(12px, 1.05vw, 16px);
    }

    .mh-tree-fund.medium .mh-tree-fund-change {
        font-size: clamp(12px, 1.1vw, 17px);
    }

    .mh-tree-fund.tiny .mh-tree-fund-change {
        display: none;
    }

    .mh-tree-fund.micro {
        padding: 0;
    }

    .mh-tree-fund.micro .mh-tree-fund-name,
    .mh-tree-fund.micro .mh-tree-fund-change {
        display: none;
    }

    .mh-treemap-axis {
        position: absolute;
        inset: auto 8px 7px;
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        height: 20px;
        color: #344054;
        font-size: 11px;
        text-align: center;
    }

    .mh-treemap-axis span {
        position: relative;
        padding-top: 2px;
    }

    .mh-treemap-axis span::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -7px;
        height: 7px;
        background: var(--axis-color);
    }

    @media (max-width: 1280px) {
        .mh-layout,
        .stock-heatmap-head {
            grid-template-columns: 1fr;
        }

        .stock-heatmap-head .actions {
            justify-content: flex-start;
        }
    }

    @media (max-width: 991px) {
        .mh-chart-meta {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .mh-mosaic {
            grid-template-columns: repeat(8, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .stock-heatmap-shell {
            padding-top: 22px;
        }

        .mh-chart-meta {
            grid-template-columns: 1fr;
        }

        .mh-mosaic {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .mh-treemap-frame {
            height: 620px;
            min-height: 620px;
        }

        .mh-list button {
            grid-template-columns: 48px minmax(0, 1fr);
        }

        .mh-list .metric {
            grid-column: 1 / -1;
            text-align: left;
            padding-left: 60px;
        }
    }
</style>

<section class="stock-heatmap-shell">
    <div class="container-fluid px-3 px-xl-4">
        <div class="stock-heatmap-head">
            <div>
                <h1>Market Overview</h1>
                <div class="sub">A dark, split-screen market wall built from live fund data in the local MyPlex database.</div>
            </div>
            <div class="actions">
                <a href="{{ $overviewUrl }}" class="mh-pill">Open classic overview</a>
                <a href="{{ $heatmapUrl }}?{{ http_build_query(array_merge($currentParams, ['time_frame' => 'ALL'])) }}" class="mh-pill {{ $timeFrame === 'ALL' ? 'active' : '' }}">All data</a>
            </div>
        </div>

        <div class="market-badge">Classification First</div>

        <div class="mh-subtle-bar">
            <div class="mh-subtle-chip">Window: {{ $startDate }} to {{ $endDate }}</div>
            <div class="mh-subtle-chip">Funds: {{ number_format($summary['total_funds']) }}</div>
            <div class="mh-subtle-chip">Positive: {{ number_format($summary['positive_count']) }}</div>
            <div class="mh-subtle-chip">Negative: {{ number_format($summary['negative_count']) }}</div>
            <div class="mh-subtle-chip">Average: {{ number_format($summary['average_change_percent'], 2) }}%</div>
        </div>

        <div class="mh-classify-strip">
            @php
                $allClassUrl = $heatmapUrl . '?' . http_build_query(array_merge($currentParams, ['classification' => '', 'time_frame' => $timeFrame]));
            @endphp
            <a href="{{ $allClassUrl }}" class="mh-classify-tab {{ $selectedClassification === '' ? 'active' : '' }}">
                <span class="name">All Funds</span>
                <span class="count">{{ number_format(count($items)) }}</span>
            </a>
            @foreach ($dataArr['classification_options'] as $option)
                @php
                    $tabUrl = $heatmapUrl . '?' . http_build_query(array_merge($currentParams, ['classification' => $option, 'time_frame' => $timeFrame]));
                    $tabGroup = collect($classificationCatalog)->firstWhere('name', $option);
                @endphp
                <a href="{{ $tabUrl }}" class="mh-classify-tab {{ $selectedClassification === $option ? 'active' : '' }}">
                    <span class="name">{{ $option }}</span>
                    <span class="count">{{ number_format((int) ($tabGroup['count'] ?? 0)) }}</span>
                </a>
            @endforeach
        </div>

        <div class="mh-filter-bar">
            <form method="GET" action="{{ $heatmapUrl }}">
                <input type="hidden" name="time_frame" value="{{ $timeFrame }}">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-lg-3">
                        <label for="q">Search</label>
                        <input type="text" name="q" id="q" class="form-control" value="{{ $request->input('q') }}" placeholder="Fund code, name, classification">
                    </div>
                    <div class="col-6 col-lg-2">
                        <label for="fund_type_id">Fund Type</label>
                        <select id="fund_type_id" name="fund_type_id" class="form-select">
                            <option value="">All</option>
                            @foreach ($fundTypes as $fundType)
                                <option value="{{ $fundType->ft_id }}" @selected((string) $request->input('fund_type_id') === (string) $fundType->ft_id)>{{ $fundType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <label for="classification">Classification</label>
                        <select id="classification" name="classification" class="form-select">
                            <option value="">All</option>
                            @foreach ($dataArr['classification_options'] as $option)
                                <option value="{{ $option }}" @selected($request->input('classification') === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <label for="fund_manager">Manager</label>
                        <select id="fund_manager" name="fund_manager" class="form-select">
                            <option value="">All</option>
                            @foreach ($dataArr['manager_options'] as $option)
                                <option value="{{ $option }}" @selected($request->input('fund_manager') === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <label for="sort">Sort</label>
                        <select id="sort" name="sort" class="form-select">
                            <option value="change_desc" @selected($sort === 'change_desc')>Biggest movers</option>
                            <option value="positive_first" @selected($sort === 'positive_first')>Positive first</option>
                            <option value="negative_first" @selected($sort === 'negative_first')>Negative first</option>
                            <option value="corpus_desc" @selected($sort === 'corpus_desc')>Largest corpus</option>
                            <option value="name_asc" @selected($sort === 'name_asc')>Name A-Z</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-1 d-grid">
                        <button type="submit" class="btn btn-primary">View</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mh-layout">
            <div>
                <div class="mh-panel">
                    <div class="mh-panel-head">
                        <h2>Market Overview</h2>
                        <p>
                            @if ($selectedClassification !== '')
                                Showing <strong style="color:#172033;">{{ $selectedClassification }}</strong>
                            @else
                                Showing the full market universe
                            @endif
                            · selected fund: <span id="selectedFundName">{{ $selectedFund['fund_name'] ?? 'No funds found' }}</span>
                        </p>
                    </div>

                    <div class="mh-chart-shell">
                        <div class="mh-chart-frame">
                            <canvas id="marketChart"></canvas>
                        </div>
                    </div>

                    <div class="mh-chart-meta">
                        <div class="mh-mini">
                            <div class="label">Current NAV</div>
                            <div class="value" id="selectedNav">{{ $selectedFund ? number_format((float) $selectedFund['nav'], 2) : '0.00' }}</div>
                            <div class="sub" id="selectedCode">{{ $selectedFund['classification'] ?? '-' }}</div>
                        </div>
                        <div class="mh-mini">
                            <div class="label">Change</div>
                            <div class="value {{ ($selectedFund['change_percent'] ?? 0) >= 0 ? 'positive' : 'negative' }}" id="selectedChange">
                                {{ $selectedFund ? number_format((float) $selectedFund['change_amount'], 2) . ' / ' . number_format((float) $selectedFund['change_percent'], 2) . '%' : '0.00' }}
                            </div>
                            <div class="sub">Latest movement in the window</div>
                        </div>
                        <div class="mh-mini">
                            <div class="label">Corpus</div>
                            <div class="value">{{ $selectedFund ? number_format((float) $selectedFund['corpus'], 2) : '0.00' }}</div>
                            <div class="sub">{{ $selectedFund['fund_type_name'] ?? 'Unclassified' }}</div>
                        </div>
                        <div class="mh-mini">
                            <div class="label">Last Update</div>
                            <div class="value" style="font-size: 19px;">{{ $selectedFund['last_updated_at'] ?? $endDate }}</div>
                            <div class="sub">{{ $selectedFund['fund_house'] ?? 'MyPlex data' }}</div>
                        </div>
                    </div>

                    <div class="mh-time-tabs">
                        @foreach ($timeFrames as $frame)
                            @php
                                $frameUrl = $heatmapUrl . '?' . http_build_query(array_merge($currentParams, ['time_frame' => $frame['value'], 'classification' => $selectedClassification]));
                            @endphp
                            <a href="{{ $frameUrl }}" class="{{ $timeFrame === $frame['value'] ? 'active' : '' }}">{{ $frame['label'] }}</a>
                        @endforeach
                    </div>

                    <div class="mh-list" id="fundList">
                        @forelse ($featuredFunds as $fund)
                            @php
                                $isActive = ($selectedFundCode !== '' && $selectedFundCode === $fund['fund_code']) || ($selectedFundCode === '' && ($loop->first || ($selectedFund['fund_code'] ?? '') === $fund['fund_code']));
                                $changeClass = $fund['change_percent'] > 0 ? 'positive' : ($fund['change_percent'] < 0 ? 'negative' : 'flat');
                                $initials = collect(explode(' ', trim($fund['fund_name'])))->filter()->map(function ($part) {
                                    return strtoupper(substr($part, 0, 1));
                                })->take(2)->implode('');
                            @endphp
                            <button
                                type="button"
                                class="{{ $isActive ? 'active' : '' }}"
                                data-fund-code="{{ $fund['fund_code'] }}"
                                data-fund-name="{{ e($fund['fund_name']) }}"
                                data-fund-code-label="{{ e($fund['classification']) }}"
                                data-nav="{{ number_format((float) $fund['nav'], 2) }}"
                                data-change="{{ number_format((float) $fund['change_amount'], 2) }} / {{ number_format((float) $fund['change_percent'], 2) }}%"
                                data-history='@json($fund["history"])'
                            >
                                <div class="mh-avatar">{{ $initials ?: substr($fund['fund_code'], 0, 2) }}</div>
                                <div>
                                    <div class="name">{{ $fund['fund_name'] }} <span style="color: #b26f00; font-size: 13px;">{{ $fund['fund_type_name'] !== 'Unclassified' ? '• ' . $fund['fund_type_name'] : '' }}</span></div>
                                    <div class="meta">
                                        <span>{{ $fund['fund_house'] }}</span>
                                        <span>{{ $fund['classification'] }}</span>
                                    </div>
                                </div>
                                <div class="metric">
                                    <div class="nav">{{ number_format((float) $fund['nav'], 2) }}</div>
                                    <div class="chg {{ $changeClass }}">
                                        {{ $fund['change_percent'] > 0 ? '+' : '' }}{{ number_format((float) $fund['change_percent'], 2) }}%
                                    </div>
                                </div>
                            </button>
                        @empty
                            <div class="mh-note">No funds matched the current filters.</div>
                        @endforelse
                    </div>
                </div>

                <div class="mh-note">
                    <strong style="color:#172033;">Disclaimer:</strong> {{ $disclaimer }}
                </div>
            </div>

            <div class="mh-treemap-wrap">
                <h2 class="mh-treemap-title">Stock Heatmap</h2>
                <div class="mh-treemap-frame">
                    <div
                        class="mh-treemap-stage"
                        id="fundTreemap"
                        role="group"
                        aria-label="Fund performance heatmap"
                    ></div>
                    <div class="mh-treemap-axis" aria-hidden="true">
                        <span style="--axis-color:#ef3340;">-5.5%</span>
                        <span style="--axis-color:#c12732;">-3.5%</span>
                        <span style="--axis-color:#8e1c26;">-1.5%</span>
                        <span style="--axis-color:#454545;">0%</span>
                        <span style="--axis-color:#174c37;">1.5%</span>
                        <span style="--axis-color:#087a4a;">3.5%</span>
                        <span style="--axis-color:#08a65c;">5.5%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const buttons = Array.from(document.querySelectorAll('#fundList button[data-history]'));
        const heatmapGroups = @json($heatmapGroups);
        const treemapStage = document.getElementById('fundTreemap');
        let tiles = [];
        const canvas = document.getElementById('marketChart');
        const context = canvas ? canvas.getContext('2d') : null;
        const selectedName = document.getElementById('selectedFundName');
        const selectedCode = document.getElementById('selectedCode');
        const selectedNav = document.getElementById('selectedNav');
        const selectedChange = document.getElementById('selectedChange');
        let activeButton = buttons.find((button) => button.classList.contains('active')) || buttons[0] || null;

        function itemWeight(item) {
            const corpus = Number(item.size_metric || item.corpus || item.nav || 0);
            return Math.max(Math.sqrt(Math.max(corpus, 0)), 1);
        }

        function splitNearHalf(items) {
            const total = items.reduce((sum, item) => sum + Number(item.__weight || 0), 0);
            let running = 0;
            let bestIndex = 1;
            let bestDifference = Number.POSITIVE_INFINITY;

            for (let index = 1; index < items.length; index += 1) {
                running += Number(items[index - 1].__weight || 0);
                const difference = Math.abs((total / 2) - running);

                if (difference < bestDifference) {
                    bestDifference = difference;
                    bestIndex = index;
                }
            }

            return bestIndex;
        }

        function layoutWeighted(items, rectangle, depth) {
            if (!items.length) {
                return [];
            }

            if (items.length === 1) {
                return [{ item: items[0], rectangle: rectangle }];
            }

            const splitIndex = splitNearHalf(items);
            const first = items.slice(0, splitIndex);
            const second = items.slice(splitIndex);
            const firstWeight = first.reduce((sum, item) => sum + Number(item.__weight || 0), 0);
            const totalWeight = items.reduce((sum, item) => sum + Number(item.__weight || 0), 0) || 1;
            const ratio = Math.max(0.08, Math.min(firstWeight / totalWeight, 0.92));
            const splitVertically = rectangle.width > rectangle.height
                || (rectangle.width === rectangle.height && depth % 2 === 0);
            let firstRectangle;
            let secondRectangle;

            if (splitVertically) {
                const firstWidth = rectangle.width * ratio;
                firstRectangle = {
                    x: rectangle.x,
                    y: rectangle.y,
                    width: firstWidth,
                    height: rectangle.height,
                };
                secondRectangle = {
                    x: rectangle.x + firstWidth,
                    y: rectangle.y,
                    width: rectangle.width - firstWidth,
                    height: rectangle.height,
                };
            } else {
                const firstHeight = rectangle.height * ratio;
                firstRectangle = {
                    x: rectangle.x,
                    y: rectangle.y,
                    width: rectangle.width,
                    height: firstHeight,
                };
                secondRectangle = {
                    x: rectangle.x,
                    y: rectangle.y + firstHeight,
                    width: rectangle.width,
                    height: rectangle.height - firstHeight,
                };
            }

            return layoutWeighted(first, firstRectangle, depth + 1)
                .concat(layoutWeighted(second, secondRectangle, depth + 1));
        }

        function heatColor(changePercent) {
            const change = Number(changePercent || 0);
            const strength = Math.min(Math.abs(change) / 5.5, 1);

            if (change > 0) {
                const red = Math.round(20 - (14 * strength));
                const green = Math.round(62 + (110 * strength));
                const blue = Math.round(45 + (40 * strength));
                return `rgb(${red}, ${green}, ${blue})`;
            }

            if (change < 0) {
                const red = Math.round(111 + (133 * strength));
                const green = Math.round(27 + (27 * strength));
                const blue = Math.round(36 + (33 * strength));
                return `rgb(${red}, ${green}, ${blue})`;
            }

            return '#454545';
        }

        function positionElement(element, rectangle) {
            element.style.left = `${rectangle.x}px`;
            element.style.top = `${rectangle.y}px`;
            element.style.width = `${Math.max(rectangle.width, 0)}px`;
            element.style.height = `${Math.max(rectangle.height, 0)}px`;
        }

        function renderTreemap() {
            if (!treemapStage) {
                return;
            }

            const width = treemapStage.clientWidth;
            const height = treemapStage.clientHeight;
            const selectedCodeValue = activeButton ? activeButton.dataset.fundCode : '';
            treemapStage.innerHTML = '';

            if (!heatmapGroups.length || width < 1 || height < 1) {
                treemapStage.innerHTML = '<div class="mh-note" style="margin:18px;">No funds matched the selected filters.</div>';
                tiles = [];
                return;
            }

            const groups = heatmapGroups.map((group) => {
                const groupItems = (group.items || []).map((item) => Object.assign({}, item, {
                    __weight: itemWeight(item),
                })).sort((left, right) => right.__weight - left.__weight);

                return Object.assign({}, group, {
                    items: groupItems,
                    __weight: groupItems.reduce((sum, item) => sum + item.__weight, 0),
                });
            }).filter((group) => group.items.length)
                .sort((left, right) => right.__weight - left.__weight);

            const groupLayouts = layoutWeighted(groups, {
                x: 0,
                y: 0,
                width: width,
                height: height,
            }, 0);

            groupLayouts.forEach(({ item: group, rectangle: groupRectangle }) => {
                const groupElement = document.createElement('section');
                groupElement.className = 'mh-tree-group';
                positionElement(groupElement, groupRectangle);

                const title = document.createElement('div');
                title.className = 'mh-tree-group-title';
                title.textContent = group.name;
                title.title = `${group.name} · ${group.count} funds`;
                groupElement.appendChild(title);

                const contentHeight = Math.max(groupRectangle.height - 28, 0);
                const fundLayouts = layoutWeighted(group.items, {
                    x: 0,
                    y: 28,
                    width: groupRectangle.width,
                    height: contentHeight,
                }, 0);

                fundLayouts.forEach(({ item, rectangle }) => {
                    const tile = document.createElement('button');
                    const area = rectangle.width * rectangle.height;
                    let sizeClass = 'micro';

                    if (rectangle.width >= 150 && rectangle.height >= 105) {
                        sizeClass = 'large';
                    } else if (rectangle.width >= 90 && rectangle.height >= 68) {
                        sizeClass = 'medium';
                    } else if (rectangle.width >= 48 && rectangle.height >= 38) {
                        sizeClass = 'tiny';
                    }

                    tile.type = 'button';
                    tile.className = `mh-tree-fund ${sizeClass}`;
                    tile.style.background = heatColor(item.change_percent);
                    tile.title = `${item.fund_name}\n${item.change_percent > 0 ? '+' : ''}${Number(item.change_percent || 0).toFixed(2)}%\nNAV ${Number(item.nav || 0).toFixed(2)}`;
                    tile.dataset.fundCode = item.fund_code || '';
                    tile.dataset.fundName = item.fund_name || '';
                    tile.dataset.fundCodeLabel = item.classification || '';
                    tile.dataset.nav = Number(item.nav || 0).toFixed(2);
                    tile.dataset.change = `${Number(item.change_amount || 0).toFixed(2)} / ${Number(item.change_percent || 0).toFixed(2)}%`;
                    tile.dataset.history = JSON.stringify(item.history || []);
                    tile.setAttribute('aria-label', tile.title.replace(/\n/g, ', '));
                    positionElement(tile, rectangle);

                    if (area >= 950) {
                        const name = document.createElement('span');
                        name.className = 'mh-tree-fund-name';
                        name.textContent = item.fund_name || '';
                        tile.appendChild(name);
                    }

                    if (area >= 1700) {
                        const change = document.createElement('span');
                        change.className = 'mh-tree-fund-change';
                        change.textContent = `${Number(item.change_percent || 0) > 0 ? '+' : ''}${Number(item.change_percent || 0).toFixed(2)}%`;
                        tile.appendChild(change);
                    }

                    if (selectedCodeValue && selectedCodeValue === item.fund_code) {
                        tile.classList.add('active');
                    }

                    groupElement.appendChild(tile);
                });

                treemapStage.appendChild(groupElement);
            });

            tiles = Array.from(treemapStage.querySelectorAll('.mh-tree-fund[data-history]'));
            tiles.forEach((tile) => {
                tile.addEventListener('click', () => setActiveTile(tile));
            });
        }

        function parseSeries(button) {
            if (!button) {
                return [];
            }

            try {
                return JSON.parse(button.dataset.history || '[]');
            } catch (error) {
                return [];
            }
        }

        function resizeCanvas() {
            if (!canvas || !context) {
                return;
            }

            const rect = canvas.getBoundingClientRect();
            const ratio = window.devicePixelRatio || 1;
            canvas.width = Math.max(rect.width * ratio, 1);
            canvas.height = Math.max(rect.height * ratio, 1);
            context.setTransform(ratio, 0, 0, ratio, 0, 0);
        }

        function drawChart(series) {
            if (!canvas || !context) {
                return;
            }

            resizeCanvas();

            const width = canvas.clientWidth;
            const height = canvas.clientHeight;
            context.clearRect(0, 0, width, height);

            context.fillStyle = '#ffffff';
            context.fillRect(0, 0, width, height);

            if (!series.length) {
                context.fillStyle = '#667085';
                context.font = '600 16px Arial, sans-serif';
                context.fillText('No market history available for this fund.', 24, height / 2);
                return;
            }

            const points = series.map((entry) => Number(entry.nav || 0));
            const min = Math.min.apply(null, points);
            const max = Math.max.apply(null, points);
            const range = max - min || 1;
            const paddingX = 20;
            const paddingY = 28;
            const usableWidth = width - (paddingX * 2);
            const usableHeight = height - (paddingY * 2);
            const stepX = series.length > 1 ? usableWidth / (series.length - 1) : 0;

            // Grid
            context.strokeStyle = 'rgba(15, 23, 42, 0.08)';
            context.lineWidth = 1;
            for (let i = 0; i < 4; i += 1) {
                const y = paddingY + (usableHeight / 3) * i;
                context.beginPath();
                context.moveTo(paddingX, y);
                context.lineTo(width - paddingX, y);
                context.stroke();
            }

            const baseY = height - paddingY;
            const gradient = context.createLinearGradient(0, paddingY, 0, height - paddingY);
            gradient.addColorStop(0, 'rgba(13, 191, 138, 0.30)');
            gradient.addColorStop(1, 'rgba(13, 191, 138, 0.02)');

            context.beginPath();
            series.forEach((entry, index) => {
                const nav = Number(entry.nav || 0);
                const x = paddingX + (index * stepX);
                const y = baseY - (((nav - min) / range) * usableHeight);

                if (index === 0) {
                    context.moveTo(x, y);
                } else {
                    context.lineTo(x, y);
                }
            });

            const lastPoint = series.length > 0 ? series[series.length - 1] : null;
            const lastX = paddingX + ((series.length - 1) * stepX);
            const lastY = baseY - (((Number(lastPoint.nav || 0) - min) / range) * usableHeight);

            context.lineTo(lastX, baseY);
            context.lineTo(paddingX, baseY);
            context.closePath();
            context.fillStyle = gradient;
            context.fill();

            context.beginPath();
            series.forEach((entry, index) => {
                const nav = Number(entry.nav || 0);
                const x = paddingX + (index * stepX);
                const y = baseY - (((nav - min) / range) * usableHeight);

                if (index === 0) {
                    context.moveTo(x, y);
                } else {
                    context.lineTo(x, y);
                }
            });
            context.strokeStyle = '#18efb3';
            context.lineWidth = 3;
            context.shadowColor = 'rgba(24, 239, 179, 0.65)';
            context.shadowBlur = 12;
            context.stroke();
            context.shadowBlur = 0;

            series.forEach((entry, index) => {
                if (index !== 0 && index !== series.length - 1 && index % Math.max(Math.floor(series.length / 4), 1) !== 0) {
                    return;
                }

                const nav = Number(entry.nav || 0);
                const x = paddingX + (index * stepX);
                const y = baseY - (((nav - min) / range) * usableHeight);
                context.beginPath();
                context.fillStyle = '#ffffff';
                context.arc(x, y, 2.5, 0, Math.PI * 2);
                context.fill();
            });

            if (lastPoint) {
                context.beginPath();
                context.fillStyle = '#ffffff';
                context.arc(lastX, lastY, 6, 0, Math.PI * 2);
                context.fill();
                context.beginPath();
                context.strokeStyle = '#18efb3';
                context.lineWidth = 2;
                context.arc(lastX, lastY, 11, 0, Math.PI * 2);
                context.stroke();
            }

            context.fillStyle = '#667085';
            context.font = '12px Arial, sans-serif';
            const startLabel = series[0] ? series[0].entry_date : '';
            const middleLabel = series[Math.floor(series.length / 2)] ? series[Math.floor(series.length / 2)].entry_date : '';
            const endLabel = lastPoint ? lastPoint.entry_date : '';
            context.fillText(startLabel, paddingX, height - 8);
            context.fillText(middleLabel, width / 2 - 30, height - 8);
            context.fillText(endLabel, width - paddingX - 40, height - 8);
        }

        function setActiveButton(button) {
            if (!button) {
                return;
            }

            activeButton = button;
            buttons.forEach((item) => item.classList.remove('active'));
            tiles.forEach((item) => item.classList.remove('active'));
            button.classList.add('active');

            const series = parseSeries(button);
            const change = button.dataset.change || '';
            const nav = button.dataset.nav || '';

            if (selectedName) {
                selectedName.textContent = button.dataset.fundName || '';
            }

            if (selectedCode) {
                selectedCode.textContent = button.dataset.fundCodeLabel || '';
            }

            if (selectedNav) {
                selectedNav.textContent = nav;
            }

            if (selectedChange) {
                selectedChange.textContent = change;
                selectedChange.classList.remove('positive', 'negative', 'flat');
                const positive = series.length > 1 && Number(series[series.length - 1].change_percent || 0) > 0;
                const negative = series.length > 1 && Number(series[series.length - 1].change_percent || 0) < 0;
                selectedChange.classList.add(positive ? 'positive' : (negative ? 'negative' : 'flat'));
            }

            drawChart(series);
        }

        function setActiveTile(tile) {
            if (!tile) {
                return;
            }

            activeButton = tile;
            tiles.forEach((item) => item.classList.remove('active'));
            buttons.forEach((item) => item.classList.remove('active'));
            tile.classList.add('active');

            const series = parseSeries(tile);
            const change = tile.dataset.change || '';
            const nav = tile.dataset.nav || '';

            if (selectedName) {
                selectedName.textContent = tile.dataset.fundName || '';
            }

            if (selectedCode) {
                selectedCode.textContent = tile.dataset.fundCodeLabel || '';
            }

            if (selectedNav) {
                selectedNav.textContent = nav;
            }

            if (selectedChange) {
                selectedChange.textContent = change;
                selectedChange.classList.remove('positive', 'negative', 'flat');
                const positive = series.length > 1 && Number(series[series.length - 1].change_percent || 0) > 0;
                const negative = series.length > 1 && Number(series[series.length - 1].change_percent || 0) < 0;
                selectedChange.classList.add(positive ? 'positive' : (negative ? 'negative' : 'flat'));
            }

            drawChart(series);
        }

        renderTreemap();

        if (buttons.length) {
            buttons.forEach((button) => {
                button.addEventListener('click', () => setActiveButton(button));
            });
            setActiveButton(activeButton || buttons[0]);
        } else if (tiles.length) {
            setActiveTile(tiles[0]);
        } else {
            drawChart([]);
        }

        let resizeTimer = null;
        window.addEventListener('resize', () => {
            window.clearTimeout(resizeTimer);
            resizeTimer = window.setTimeout(() => {
                renderTreemap();

                if (activeButton) {
                    const matchingTile = tiles.find((tile) => tile.dataset.fundCode === activeButton.dataset.fundCode);

                    if (matchingTile) {
                        matchingTile.classList.add('active');
                    }

                    drawChart(parseSeries(activeButton));
                }
            }, 120);
        });
    })();
</script>
@endsection
