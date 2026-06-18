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
    $classificationGroups = $dataArr['classification_groups'];
    $topGainers = $dataArr['top_gainers'];
    $topLosers = $dataArr['top_losers'];
    $fundTypes = $dataArr['fund_types'];
    $classificationOptions = $dataArr['classification_options'];
    $benchmarkOptions = $dataArr['benchmark_options'];
    $managerOptions = $dataArr['manager_options'];
    $startDate = $dataArr['start_date'];
    $endDate = $dataArr['end_date'];
    $timeFrame = $dataArr['time_frame'];
@endphp

<style>
    :root {
        --mo-bg: #eef3ef;
        --mo-ink: #112a22;
        --mo-muted: #6d7f78;
        --mo-card: rgba(255, 255, 255, 0.86);
        --mo-border: rgba(17, 42, 34, 0.08);
        --mo-shadow: 0 18px 45px rgba(17, 42, 34, 0.08);
        --mo-radius: 24px;
    }

    .market-overview-shell {
        background:
            radial-gradient(circle at top left, rgba(34, 197, 94, 0.12), transparent 28%),
            radial-gradient(circle at top right, rgba(14, 165, 233, 0.12), transparent 30%),
            linear-gradient(180deg, #f7faf8 0%, var(--mo-bg) 100%);
        padding: 40px 0 70px;
    }

    .market-hero {
        background: linear-gradient(135deg, #0f2a22 0%, #133d31 52%, #164d3f 100%);
        color: #fff;
        border-radius: 32px;
        padding: 34px;
        box-shadow: var(--mo-shadow);
        overflow: hidden;
        position: relative;
    }

    .market-hero::after {
        content: "";
        position: absolute;
        inset: auto -120px -140px auto;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        filter: blur(14px);
    }

    .market-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.88);
        font-size: 12px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .market-hero h1 {
        margin: 0;
        font-size: clamp(28px, 4vw, 48px);
        line-height: 1.05;
        font-weight: 800;
    }

    .market-hero p {
        margin: 14px 0 0;
        max-width: 760px;
        color: rgba(255, 255, 255, 0.82);
        font-size: 16px;
    }

    .market-window {
        margin-top: 22px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .market-chip {
        border: 1px solid rgba(255, 255, 255, 0.15);
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        border-radius: 999px;
        padding: 8px 12px;
        font-size: 13px;
    }

    .mo-summary-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 14px;
        margin-top: 20px;
    }

    .mo-summary-card {
        background: var(--mo-card);
        border: 1px solid var(--mo-border);
        border-radius: 22px;
        padding: 18px;
        box-shadow: var(--mo-shadow);
        backdrop-filter: blur(8px);
        min-height: 126px;
    }

    .mo-summary-card .label {
        color: var(--mo-muted);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 10px;
    }

    .mo-summary-card .value {
        font-size: 28px;
        font-weight: 800;
        color: var(--mo-ink);
        line-height: 1;
    }

    .mo-summary-card .subtext {
        margin-top: 10px;
        color: var(--mo-muted);
        font-size: 13px;
    }

    .mo-panel {
        background: rgba(255, 255, 255, 0.82);
        border: 1px solid var(--mo-border);
        border-radius: 28px;
        box-shadow: var(--mo-shadow);
        backdrop-filter: blur(10px);
        padding: 24px;
        margin-top: 18px;
    }

    .mo-filter-grid {
        display: grid;
        grid-template-columns: 1.1fr repeat(4, minmax(0, 1fr)) 0.8fr 0.8fr 0.8fr;
        gap: 12px;
        align-items: end;
    }

    .mo-filter-grid .form-group {
        margin-bottom: 0;
    }

    .mo-filter-grid label {
        font-size: 12px;
        font-weight: 700;
        color: var(--mo-ink);
        margin-bottom: 7px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .mo-filter-grid .form-control,
    .mo-filter-grid .form-select {
        min-height: 46px;
        border-radius: 14px;
        border-color: rgba(17, 42, 34, 0.14);
        box-shadow: none;
    }

    .mo-filter-grid .btn {
        min-height: 46px;
        border-radius: 14px;
        font-weight: 700;
    }

    .mo-layout {
        display: grid;
        grid-template-columns: 320px minmax(0, 1fr);
        gap: 18px;
        margin-top: 18px;
        align-items: start;
    }

    .mo-sidebar {
        position: sticky;
        top: 20px;
    }

    .mo-section-title {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        align-items: center;
        margin-bottom: 14px;
    }

    .mo-section-title h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: var(--mo-ink);
    }

    .mo-section-title p {
        margin: 0;
        color: var(--mo-muted);
        font-size: 13px;
    }

    .mo-group-list {
        display: grid;
        gap: 12px;
    }

    .mo-group-card {
        border: 1px solid var(--mo-border);
        border-radius: 18px;
        background: #fff;
        padding: 16px;
    }

    .mo-group-card .topline {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 10px;
    }

    .mo-group-card .name {
        font-size: 15px;
        font-weight: 800;
        color: var(--mo-ink);
    }

    .mo-group-card .stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px;
        margin-top: 12px;
    }

    .mo-mini {
        background: #f5f8f6;
        border-radius: 14px;
        padding: 10px;
        min-height: 64px;
    }

    .mo-mini span {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        color: var(--mo-muted);
        letter-spacing: 0.04em;
        margin-bottom: 4px;
    }

    .mo-mini strong {
        font-size: 15px;
        color: var(--mo-ink);
    }

    .mo-heatmap-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
    }

    .mo-heat-card {
        border: 1px solid var(--mo-border);
        border-radius: 22px;
        padding: 16px;
        background: #fff;
        box-shadow: 0 12px 30px rgba(17, 42, 34, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-align: left;
        width: 100%;
        min-height: 180px;
    }

    .mo-heat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 38px rgba(17, 42, 34, 0.10);
    }

    .mo-heat-card .fund-code {
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.08em;
        color: var(--mo-muted);
        text-transform: uppercase;
    }

    .mo-heat-card .fund-name {
        font-size: 18px;
        font-weight: 800;
        line-height: 1.25;
        color: var(--mo-ink);
        margin-top: 8px;
        min-height: 46px;
    }

    .mo-heat-card .fund-meta {
        margin-top: 10px;
        color: var(--mo-muted);
        font-size: 13px;
        line-height: 1.5;
    }

    .mo-heat-card .metric-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .mo-pill {
        border-radius: 999px;
        padding: 7px 10px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .mo-pill.positive {
        background: rgba(34, 197, 94, 0.12);
        color: #15803d;
    }

    .mo-pill.negative {
        background: rgba(239, 68, 68, 0.12);
        color: #b91c1c;
    }

    .mo-pill.flat {
        background: rgba(100, 116, 139, 0.14);
        color: #475569;
    }

    .mo-pill.neutral {
        background: rgba(15, 23, 42, 0.06);
        color: #334155;
    }

    .mo-note {
        margin-top: 16px;
        border-radius: 18px;
        padding: 14px 16px;
        background: rgba(15, 23, 42, 0.04);
        color: #334155;
        font-size: 13px;
    }

    .mo-empty {
        padding: 42px 24px;
        border: 1px dashed rgba(17, 42, 34, 0.20);
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.80);
        color: var(--mo-muted);
        text-align: center;
    }

    .mo-toplists {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 18px;
    }

    .mo-toplist {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 22px;
        padding: 16px;
    }

    .mo-toplist h4 {
        margin: 0 0 12px;
        font-size: 16px;
        font-weight: 800;
    }

    .mo-toplist ol {
        margin: 0;
        padding-left: 18px;
    }

    .mo-toplist li {
        margin-bottom: 8px;
        color: rgba(255, 255, 255, 0.88);
    }

    .mo-toplist small {
        display: block;
        color: rgba(255, 255, 255, 0.72);
    }

    @media (max-width: 1199px) {
        .mo-summary-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .mo-filter-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .mo-layout {
            grid-template-columns: 1fr;
        }

        .mo-sidebar {
            position: static;
        }
    }

    @media (max-width: 767px) {
        .market-hero,
        .mo-panel {
            padding: 18px;
            border-radius: 22px;
        }

        .mo-summary-grid,
        .mo-toplists {
            grid-template-columns: 1fr;
        }

        .mo-filter-grid {
            grid-template-columns: 1fr;
        }

        .mo-heatmap-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="market-overview-shell">
    <div class="container">
        <div class="market-hero">
            <div class="market-eyebrow">Market Overview</div>
            <h1>Fund Heatmap</h1>
            <p>Live fund data from the local MyPlex tables. Use the filters to narrow by fund type, classification, benchmark, manager, and time frame, then open any tile for a detail view.</p>

            <div class="market-window">
                <span class="market-chip">Window: {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}</span>
                <span class="market-chip">Time frame: {{ $timeFrame }}</span>
                <span class="market-chip">Records: {{ number_format($summary['total_funds']) }}</span>
                <span class="market-chip">Updated: {{ date('d M Y', strtotime($summary['last_updated_at'])) }}</span>
            </div>

            <div class="mo-toplists">
                <div class="mo-toplist">
                    <h4>Top Gainers</h4>
                    <ol>
                        @forelse ($topGainers as $item)
                            <li>
                                {{ $item['fund_name'] }}
                                <small>{{ $item['fund_code'] }} · {{ number_format($item['change_percent'], 2) }}%</small>
                            </li>
                        @empty
                            <li>No gainers available.</li>
                        @endforelse
                    </ol>
                </div>
                <div class="mo-toplist">
                    <h4>Top Losers</h4>
                    <ol>
                        @forelse ($topLosers as $item)
                            <li>
                                {{ $item['fund_name'] }}
                                <small>{{ $item['fund_code'] }} · {{ number_format($item['change_percent'], 2) }}%</small>
                            </li>
                        @empty
                            <li>No losers available.</li>
                        @endforelse
                    </ol>
                </div>
            </div>
        </div>

        <div class="mo-summary-grid">
            <div class="mo-summary-card">
                <div class="label">Total Funds</div>
                <div class="value">{{ number_format($summary['total_funds']) }}</div>
                <div class="subtext">Active records in the filtered set</div>
            </div>
            <div class="mo-summary-card">
                <div class="label">Positive</div>
                <div class="value">{{ number_format($summary['positive_count']) }}</div>
                <div class="subtext">Funds moving above the previous NAV</div>
            </div>
            <div class="mo-summary-card">
                <div class="label">Negative</div>
                <div class="value">{{ number_format($summary['negative_count']) }}</div>
                <div class="subtext">Funds moving below the previous NAV</div>
            </div>
            <div class="mo-summary-card">
                <div class="label">Flat</div>
                <div class="value">{{ number_format($summary['flat_count']) }}</div>
                <div class="subtext">Funds with no movement in the window</div>
            </div>
            <div class="mo-summary-card">
                <div class="label">Average Change</div>
                <div class="value">{{ number_format($summary['average_change_percent'], 2) }}%</div>
                <div class="subtext">Mean change percent across the set</div>
            </div>
            <div class="mo-summary-card">
                <div class="label">Last Updated</div>
                <div class="value" style="font-size: 20px;">{{ date('d M Y', strtotime($summary['last_updated_at'])) }}</div>
                <div class="subtext">As of the current market window</div>
            </div>
        </div>

        <div class="mo-panel">
            <form method="GET" action="{{ route('web.market-overview') }}">
                <div class="mo-filter-grid">
                    <div class="form-group">
                        <label for="q">Search</label>
                        <input type="text" id="q" name="q" class="form-control" value="{{ $request->input('q') }}" placeholder="Fund code, name, classification">
                    </div>
                    <div class="form-group">
                        <label for="fund_type_id">Fund Type</label>
                        <select id="fund_type_id" name="fund_type_id" class="form-select">
                            <option value="">All Types</option>
                            @foreach ($fundTypes as $fundType)
                                <option value="{{ $fundType->ft_id }}" @selected((string) $request->input('fund_type_id') === (string) $fundType->ft_id)>{{ $fundType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="classification">Classification</label>
                        <select id="classification" name="classification" class="form-select">
                            <option value="">All Classifications</option>
                            @foreach ($classificationOptions as $option)
                                <option value="{{ $option }}" @selected($request->input('classification') === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="benchmark">Benchmark</label>
                        <select id="benchmark" name="benchmark" class="form-select">
                            <option value="">All Benchmarks</option>
                            @foreach ($benchmarkOptions as $option)
                                <option value="{{ $option }}" @selected($request->input('benchmark') === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fund_manager">Fund Manager</label>
                        <select id="fund_manager" name="fund_manager" class="form-select">
                            <option value="">All Managers</option>
                            @foreach ($managerOptions as $option)
                                <option value="{{ $option }}" @selected($request->input('fund_manager') === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="time_frame">Time Frame</label>
                        <select id="time_frame" name="time_frame" class="form-select">
                            @php
                                $frames = ['1D' => '1D', '1W' => '1W', '1M' => '1M', '3M' => '3M', '1Y' => '1Y', 'YTD' => 'YTD'];
                            @endphp
                            @foreach ($frames as $value => $label)
                                <option value="{{ $value }}" @selected($timeFrame === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="as_on_date">As On</label>
                        <input type="date" id="as_on_date" name="as_on_date" class="form-control" value="{{ $request->input('as_on_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="sort">Sort</label>
                        <select id="sort" name="sort" class="form-select">
                            <option value="change_desc" @selected($dataArr['sort'] === 'change_desc')>Biggest movers</option>
                            <option value="negative_first" @selected($dataArr['sort'] === 'negative_first')>Most negative first</option>
                            <option value="name_asc" @selected($dataArr['sort'] === 'name_asc')>Name A-Z</option>
                            <option value="corpus_desc" @selected($dataArr['sort'] === 'corpus_desc')>Corpus high to low</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark w-100">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mo-layout">
            <aside class="mo-sidebar">
                <div class="mo-panel">
                    <div class="mo-section-title">
                        <div>
                            <h3>Fund Type Breakdown</h3>
                            <p>Grouped from the current filtered set</p>
                        </div>
                    </div>

                    <div class="mo-group-list">
                        @forelse ($classificationGroups as $group)
                            <div class="mo-group-card">
                                <div class="topline">
                                    <div>
                                        <div class="name">{{ $group['name'] }}</div>
                                        <div style="color: var(--mo-muted); font-size: 13px;">{{ $group['count'] }} funds</div>
                                    </div>
                                    <span class="mo-pill {{ $group['average_change_percent'] > 0 ? 'positive' : ($group['average_change_percent'] < 0 ? 'negative' : 'flat') }}">
                                        {{ number_format($group['average_change_percent'], 2) }}%
                                    </span>
                                </div>
                                <div class="stats">
                                    <div class="mo-mini">
                                        <span>Total Corpus</span>
                                        <strong>{{ number_format($group['total_corpus'], 2) }}</strong>
                                    </div>
                                    <div class="mo-mini">
                                        <span>Top Fund</span>
                                        <strong style="display:block; font-size: 13px; line-height: 1.35;">{{ $group['top_fund']['fund_code'] ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="mo-mini">
                                        <span>Top Change</span>
                                        <strong>{{ isset($group['top_fund']) ? number_format($group['top_fund']['change_percent'], 2) . '%' : '0.00%' }}</strong>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="mo-empty">No fund type groups found for the current filters.</div>
                        @endforelse
                    </div>

                    <div class="mo-note">
                        <strong>Note:</strong> The heatmap uses the latest published NAV window for each fund and falls back to the most recent available history in the database.
                    </div>
                </div>
            </aside>

            <main>
                <div class="mo-panel">
                    <div class="mo-section-title">
                        <div>
                            <h3>Heatmap</h3>
                            <p>Click any fund tile to inspect the details drawer</p>
                        </div>
                        <span class="mo-pill neutral">{{ count($items) }} visible funds</span>
                    </div>

                    @if (count($items) > 0)
                        <div class="mo-heatmap-grid">
                            @foreach ($items as $item)
                                <button
                                    type="button"
                                    class="mo-heat-card"
                                    onclick="openFundTile(this)"
                                    data-fund-id="{{ $item['fund_id'] }}"
                                    data-fund-code="{{ $item['fund_code'] }}"
                                    data-fund-name="{{ e($item['fund_name']) }}"
                                    data-fund-type="{{ e($item['fund_type_name']) }}"
                                    data-classification="{{ e($item['classification']) }}"
                                    data-benchmark="{{ e($item['benchmark']) }}"
                                    data-manager="{{ e($item['fund_manager']) }}"
                                    data-house="{{ e($item['fund_house']) }}"
                                    data-nav="{{ number_format($item['nav'], 2, '.', '') }}"
                                    data-change-amount="{{ number_format($item['change_amount'], 2, '.', '') }}"
                                    data-change-percent="{{ number_format($item['change_percent'], 2, '.', '') }}"
                                    data-corpus="{{ number_format($item['corpus'], 2, '.', '') }}"
                                    data-size-metric="{{ number_format($item['size_metric'], 2, '.', '') }}"
                                    data-updated="{{ $item['last_updated_at'] }}"
                                    style="min-height: {{ $item['tile_height'] }}px; background: linear-gradient(180deg, rgba(255,255,255,0.98) 0%, {{ $item['accent_color'] }} 100%);">

                                    <div class="fund-code">{{ $item['fund_code'] }}</div>
                                    <div class="fund-name">{{ $item['fund_name'] }}</div>
                                    <div class="fund-meta">
                                        <div><strong>Type:</strong> {{ $item['fund_type_name'] }}</div>
                                        <div><strong>Benchmark:</strong> {{ $item['benchmark'] }}</div>
                                        <div><strong>Manager:</strong> {{ $item['fund_manager'] }}</div>
                                    </div>
                                    <div class="metric-row">
                                        <span class="mo-pill {{ $item['heat_class'] }}">
                                            {{ number_format($item['change_percent'], 2) }}%
                                        </span>
                                        <span class="mo-pill neutral">
                                            NAV {{ number_format($item['nav'], 2) }}
                                        </span>
                                        <span class="mo-pill neutral">
                                            Corpus {{ number_format($item['corpus'], 2) }}
                                        </span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @else
                        <div class="mo-empty">
                            No funds matched the current filters. Try clearing the search or selecting a different fund type.
                        </div>
                    @endif
                </div>

                <div class="mo-panel">
                    <div class="mo-section-title">
                        <div>
                            <h3>Data Note</h3>
                            <p>Source disclaimer from the live database</p>
                        </div>
                    </div>
                    <div class="mo-note" style="margin-top: 0;">
                        {{ $dataArr['disclaimer'] }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>

<div class="modal fade" id="fundDetailModal" tabindex="-1" aria-labelledby="fundDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #102922 0%, #174235 100%); color: #fff; border-bottom: 0;">
                <div>
                    <h5 class="modal-title" id="fundDetailModalLabel" style="font-weight: 800;">Fund Details</h5>
                    <div id="fundDetailSub" style="opacity: 0.8; font-size: 13px;"></div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mo-mini">
                            <span>Fund Code</span>
                            <strong id="detailFundCode"></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mo-mini">
                            <span>Fund Type</span>
                            <strong id="detailFundType"></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mo-mini">
                            <span>Classification</span>
                            <strong id="detailClassification"></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mo-mini">
                            <span>Benchmark</span>
                            <strong id="detailBenchmark"></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mo-mini">
                            <span>Fund Manager</span>
                            <strong id="detailManager"></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mo-mini">
                            <span>Fund House</span>
                            <strong id="detailHouse"></strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mo-mini">
                            <span>NAV</span>
                            <strong id="detailNav"></strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mo-mini">
                            <span>Change</span>
                            <strong id="detailChangeAmount"></strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mo-mini">
                            <span>Change %</span>
                            <strong id="detailChangePercent"></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mo-mini">
                            <span>Corpus / AUM</span>
                            <strong id="detailCorpus"></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mo-mini">
                            <span>Last Updated</span>
                            <strong id="detailUpdated"></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function formatNumber(value, digits = 2) {
        var num = Number(value || 0);
        return num.toLocaleString(undefined, {
            minimumFractionDigits: digits,
            maximumFractionDigits: digits
        });
    }

    function openFundTile(el) {
        const modalEl = document.getElementById('fundDetailModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

        document.getElementById('fundDetailModalLabel').textContent = el.dataset.fundName;
        document.getElementById('fundDetailSub').textContent = el.dataset.fundCode + ' · ' + el.dataset.fundType;
        document.getElementById('detailFundCode').textContent = el.dataset.fundCode;
        document.getElementById('detailFundType').textContent = el.dataset.fundType;
        document.getElementById('detailClassification').textContent = el.dataset.classification;
        document.getElementById('detailBenchmark').textContent = el.dataset.benchmark;
        document.getElementById('detailManager').textContent = el.dataset.manager;
        document.getElementById('detailHouse').textContent = el.dataset.house;
        document.getElementById('detailNav').textContent = formatNumber(el.dataset.nav);
        document.getElementById('detailChangeAmount').textContent = formatNumber(el.dataset.changeAmount);
        document.getElementById('detailChangePercent').textContent = formatNumber(el.dataset.changePercent) + '%';
        document.getElementById('detailCorpus').textContent = formatNumber(el.dataset.corpus);
        document.getElementById('detailUpdated').textContent = el.dataset.updated ? new Date(el.dataset.updated).toLocaleDateString() : 'N/A';

        modal.show();
    }
</script>
@endsection
