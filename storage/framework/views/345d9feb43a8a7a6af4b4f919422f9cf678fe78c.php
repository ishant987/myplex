<?php $__env->startSection('content'); ?>
    <?php
        $hasProjection = count($graph_date ?? []) > 1
            && count($nav_value ?? []) === count($graph_date ?? [])
            && count($closing_value ?? []) === count($graph_date ?? []);
        $actualCount = $hasProjection ? count($graph_date) - 1 : 0;
        $currentNav = $hasProjection ? (float) $nav_value[$actualCount - 1] : null;
        $projectedNav = $hasProjection ? (float) end($nav_value) : null;
    ?>

    <style>
        .ja-simple {
            --ja-green: #168c4a;
            --ja-green-dark: #0d6537;
            --ja-lime: #79b82a;
            --ja-soft: #eff9f1;
            --ja-line: #d9eadf;
            --ja-ink: #22352a;
            --ja-muted: #718078;
        }

        .ja-simple .new_page {
            border-radius: 18px;
        }

        .ja-simple .perform_head {
            margin-bottom: 18px;
        }

        .ja-filter {
            padding: 20px;
            border: 1px solid var(--ja-line);
            border-radius: 14px;
            background: var(--ja-soft);
        }

        .ja-filter-grid {
            display: grid;
            grid-template-columns: minmax(240px, 1.7fr) repeat(3, minmax(145px, 1fr)) minmax(180px, 1fr) auto;
            gap: 14px;
            align-items: end;
        }

        .ja-field label,
        .ja-info small {
            display: block;
            margin-bottom: 6px;
            color: #65756c;
            font-size: 11px;
            font-weight: 700;
        }

        .ja-info {
            min-height: 48px;
            padding: 8px 12px;
            border: 1px solid #d8e7dd;
            border-radius: 8px;
            background: #fff;
        }

        .ja-info small {
            margin-bottom: 2px;
        }

        .ja-info strong {
            display: block;
            overflow: hidden;
            color: var(--ja-ink);
            font-size: 13px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ja-field input {
            width: 100%;
            min-height: 48px;
            padding: 10px 12px;
            border: 1px solid #cddfd3;
            border-radius: 8px;
            outline: none;
            background: #fff;
            color: var(--ja-ink);
        }

        .ja-field input:focus {
            border-color: var(--ja-green);
            box-shadow: 0 0 0 3px rgba(22, 140, 74, .1);
        }

        .ja-simple .select2-container .select2-selection--single {
            min-height: 48px;
            border: 1px solid #cddfd3;
            border-radius: 8px;
        }

        .ja-simple .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 46px;
        }

        .ja-simple .select2-container .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }

        .ja-actions {
            display: flex;
            gap: 7px;
        }

        .ja-actions button {
            min-width: 55px;
            min-height: 48px;
            border: 1px solid var(--ja-green);
            border-radius: 8px;
            background: #fff;
            color: var(--ja-green);
            font-weight: 700;
        }

        .ja-actions button:hover,
        .ja-actions button.active {
            background: var(--ja-green);
            color: #fff;
        }

        .ja-error {
            margin-top: 5px;
            color: #c94343;
            font-size: 11px;
        }

        .ja-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin: 16px 0;
        }

        .ja-summary-item {
            padding: 14px 16px;
            border: 1px solid var(--ja-line);
            border-radius: 11px;
            background: #fff;
        }

        .ja-summary-item span {
            display: block;
            margin-bottom: 4px;
            color: var(--ja-muted);
            font-size: 11px;
        }

        .ja-summary-item strong {
            color: var(--ja-green-dark);
            font-size: 20px;
        }

        .ja-chart {
            margin-top: 16px;
            padding: 18px;
            border: 1px solid #e1e8e3;
            border-radius: 14px;
            background: #fff;
        }

        .ja-chart-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 8px;
        }

        .ja-chart-head h3 {
            margin: 0;
            color: var(--ja-ink);
            font-size: 18px;
            font-weight: 700;
        }

        .ja-legend {
            display: flex;
            gap: 14px;
            color: var(--ja-muted);
            font-size: 11px;
        }

        .ja-legend span::before {
            display: inline-block;
            width: 18px;
            height: 3px;
            margin-right: 6px;
            border-radius: 3px;
            background: var(--legend-color);
            vertical-align: middle;
            content: "";
        }

        #container1 {
            min-height: 460px;
        }

        .ja-chart .highcharts-tooltip,
        .ja-chart .highcharts-tooltip > span {
            width: 270px !important;
            max-width: 270px !important;
        }

        .ja-empty {
            display: grid;
            min-height: 320px;
            place-items: center;
            color: var(--ja-muted);
            text-align: center;
        }

        .ja-note {
            margin-top: 12px;
            color: #7d8982;
            font-size: 11px;
            line-height: 1.5;
        }

        @media (max-width: 1100px) {
            .ja-filter-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .ja-filter-grid,
            .ja-summary {
                grid-template-columns: 1fr;
            }

            .ja-chart-head {
                display: block;
            }

            .ja-legend {
                margin-top: 8px;
            }

            #container1 {
                min-height: 380px;
            }
        }
    </style>

    <div class="inner_main ja-simple">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.predictive')); ?>">Predictive</a></li>
                        <li>By Jensen Alpha</li>
                    </ul>
                </div>

                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>By Jensen Alpha</h2>
                    </div>

                    <div class="ja-filter">
                        <form action="<?php echo e(route('user.predictive.jensen-alpha')); ?>" method="GET">
                            <div class="ja-filter-grid">
                                <div class="ja-field">
                                    <label for="allocation_select_fund">Fund</label>
                                    <select name="fund_id" class="select2" id="allocation_select_fund"
                                        onchange="set_fund_select_val(this.value)">
                                        <?php $__currentLoopData = $fundMasterData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fund->fund_id); ?>"
                                                @selected($fund->fund_id == old('fund_id', $getData['fund_id'] ?? null))>
                                                <?php echo e($fund->fund_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['fund_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="ja-error"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="ja-info">
                                    <small>Date</small>
                                    <strong id="date"><?php echo e($hasProjection ? \Carbon\Carbon::parse($graph_date[$actualCount - 1])->format('d M Y') : 'N/A'); ?></strong>
                                </div>

                                <div class="ja-info">
                                    <small>Index</small>
                                    <strong id="indices_name"><?php echo e($indices_details->name ?? 'N/A'); ?></strong>
                                </div>

                                <div class="ja-info">
                                    <small>Index value</small>
                                    <strong id="indices_value"><?php echo e($hasProjection ? number_format($closing_value[$actualCount - 1], 2) : '0.00'); ?></strong>
                                </div>

                                <div class="ja-field">
                                    <label for="expected_index">Expected index</label>
                                    <input id="expected_index" type="number" name="expected_index"
                                        placeholder="Expected future index" value="<?php echo e($expected_index ?? ''); ?>"
                                        step="0.01" min="0.01">
                                    <?php $__errorArgs = ['expected_index'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="ja-error"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <input type="hidden" name="current_date" id="current_date"
                                    value="<?php echo e(request('current_date')); ?>">

                                <div class="ja-actions">
                                    <button type="submit" name="duration" value="6"
                                        class="<?php echo e((string) request('duration', '6') === '6' ? 'active' : ''); ?>">6m</button>
                                    <button type="submit" name="duration" value="1"
                                        class="<?php echo e((string) request('duration') === '1' ? 'active' : ''); ?>">1y</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if($hasProjection): ?>
                        <div class="ja-summary">
                            <div class="ja-summary-item">
                                <span>Jensen Alpha</span>
                                <strong><?php echo e(($average_jensen_alpha ?? 0) >= 0 ? '+' : ''); ?><?php echo e(number_format($average_jensen_alpha ?? 0, 2)); ?>%</strong>
                            </div>
                            <div class="ja-summary-item">
                                <span>Current NAV</span>
                                <strong><?php echo e(number_format($currentNav, 2)); ?></strong>
                            </div>
                            <div class="ja-summary-item">
                                <span>Projected NAV</span>
                                <strong><?php echo e(number_format($projectedNav, 2)); ?></strong>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="ja-chart">
                        <div class="ja-chart-head">
                            <h3>Fund and Index Performance</h3>
                            <?php if($hasProjection): ?>
                                <div class="ja-legend">
                                    <span style="--legend-color: #1677ff">Fund NAV</span>
                                    <span style="--legend-color: #ef6a5b">Index</span>
                                    <span style="--legend-color: #08b7c9">Dashed = projected</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if($hasProjection): ?>
                            <div id="container1"></div>
                        <?php else: ?>
                            <div class="ja-empty">Select a fund and expected index value to view the graph.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($hasProjection && $disclaimer): ?>
                    <div class="ja-note"><strong>Disclaimer:</strong> <?php echo e($disclaimer); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script>
        function set_fund_select_val(fundId) {
            $.ajax({
                url: '<?php echo e(route('user.predictive.fund_details')); ?>?id=' + fundId,
                type: 'GET',
                success: function(data) {
                    $('#date').html(data.entry_date || 'N/A');
                    $('#indices_name').html(data.name || 'N/A');
                    $('#indices_value').html(data.closing_value || '0.00');
                    $('#current_date').val(data.current_date || '');
                },
                error: function() {
                    $('#date').html('N/A');
                    $('#indices_name').html('N/A');
                    $('#indices_value').html('0.00');
                    $('#current_date').val('');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            var fundSelect = document.getElementById('allocation_select_fund');
            var currentDate = document.getElementById('current_date');

            if (fundSelect && currentDate && !currentDate.value) {
                set_fund_select_val(fundSelect.value);
            }
        });

        var graphDates = <?php echo json_encode($graph_date ?? [], 15, 512) ?>;
        var navValues = <?php echo json_encode($nav_value ?? [], 15, 512) ?>;
        var indexValues = <?php echo json_encode($closing_value ?? [], 15, 512) ?>;
        var fundName = <?php echo json_encode($fund_details->fund_name ?? 'Fund NAV', 15, 512) ?>;
        var indexName = <?php echo json_encode($indices_details->name ?? 'Index', 15, 512) ?>;

        if (graphDates.length > 1 && graphDates.length === navValues.length && graphDates.length === indexValues.length) {
            var actualCount = graphDates.length - 1;
            var actualDates = graphDates.slice(0, actualCount);
            var projectedDates = graphDates.slice(actualCount - 1);
            var forecastStart = Date.parse(graphDates[actualCount - 1]);

            function points(dates, values) {
                return dates.map(function(date, index) {
                    return [Date.parse(date), Number(values[index])];
                });
            }

            Highcharts.chart('container1', {
                chart: {
                    type: 'areaspline',
                    zoomType: 'x',
                    height: 460,
                    backgroundColor: 'transparent',
                    spacing: [22, 18, 14, 12],
                    style: {
                        fontFamily: '"Manrope", "Avenir Next", sans-serif'
                    }
                },
                title: { text: null },
                credits: { enabled: false },
                exporting: {
                    buttons: {
                        contextButton: {
                            symbolStroke: '#738199',
                            theme: {
                                fill: '#f4f8fc',
                                stroke: '#dce5f0',
                                r: 8
                            }
                        }
                    }
                },
                xAxis: {
                    type: 'datetime',
                    lineColor: '#dce5f0',
                    tickColor: '#dce5f0',
                    gridLineWidth: 1,
                    gridLineColor: 'rgba(109, 125, 150, 0.08)',
                    labels: {
                        style: { color: '#738199', fontSize: '11px' },
                        formatter: function() {
                            return Highcharts.dateFormat('%b %Y', this.value);
                        }
                    },
                    plotBands: [{
                        from: forecastStart,
                        to: Date.parse(graphDates[graphDates.length - 1]),
                        color: 'rgba(8, 183, 201, 0.07)',
                        label: {
                            text: 'PREDICTED ZONE',
                            align: 'center',
                            y: 18,
                            style: {
                                color: '#08879a',
                                fontSize: '10px',
                                fontWeight: '700',
                                letterSpacing: '0.08em'
                            }
                        }
                    }],
                    plotLines: [{
                        value: forecastStart,
                        width: 1,
                        color: '#08a7b8',
                        dashStyle: 'ShortDash',
                        zIndex: 4
                    }]
                },
                yAxis: [{
                    gridLineColor: 'rgba(109, 125, 150, 0.10)',
                    title: {
                        text: indexName,
                        style: { color: '#ef6a5b', fontSize: '11px', fontWeight: '700' }
                    },
                    labels: {
                        format: '{value:,.0f}',
                        style: { color: '#ef6a5b', fontSize: '11px' }
                    }
                }, {
                    title: {
                        text: fundName,
                        style: { color: '#1677ff', fontSize: '11px', fontWeight: '700' }
                    },
                    labels: {
                        format: '{value:,.2f}',
                        style: { color: '#1677ff', fontSize: '11px' }
                    },
                    opposite: true,
                    gridLineWidth: 0
                }],
                legend: { enabled: false },
                tooltip: {
                    shared: true,
                    useHTML: true,
                    backgroundColor: 'rgba(18, 35, 63, 0.96)',
                    borderWidth: 0,
                    borderRadius: 12,
                    shadow: {
                        color: 'rgba(18, 35, 63, 0.20)',
                        offsetX: 0,
                        offsetY: 8,
                        opacity: 0.2,
                        width: 16
                    },
                    style: {
                        color: '#ffffff',
                        width: '270px'
                    },
                    formatter: function() {
                        var content = '<div style="box-sizing:border-box;width:250px;max-width:250px;padding:4px 3px;">'
                            + '<div style="margin-bottom:8px;color:#a9bed8;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;">'
                            + Highcharts.dateFormat('%d %b %Y', this.x)
                            + '</div>';

                        this.points.forEach(function(point) {
                            content += '<div style="display:grid;grid-template-columns:minmax(0,1fr) auto;gap:12px;margin:6px 0;">'
                                + '<span style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><i style="display:inline-block;width:7px;height:7px;margin-right:7px;border-radius:50%;background:' + point.color + ';"></i>'
                                + point.series.name + '</span>'
                                + '<strong>' + Highcharts.numberFormat(point.y, point.series.yAxis.options.opposite ? 2 : 0) + '</strong>'
                                + '</div>';
                        });

                        return content + '</div>';
                    }
                },
                plotOptions: {
                    series: {
                        lineWidth: 3,
                        animation: { duration: 850 },
                        states: {
                            inactive: { opacity: 0.35 }
                        },
                        marker: {
                            enabled: true,
                            radius: 4,
                            lineWidth: 2,
                            lineColor: '#fff'
                        }
                    },
                    areaspline: {
                        fillOpacity: 0.12
                    }
                },
                series: [{
                    name: indexName,
                    yAxis: 0,
                    color: '#ef6a5b',
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, 'rgba(239,106,91,0.24)'],
                            [1, 'rgba(239,106,91,0.01)']
                        ]
                    },
                    data: points(actualDates, indexValues.slice(0, actualCount))
                }, {
                    name: indexName + ' projected',
                    yAxis: 0,
                    type: 'spline',
                    color: '#ef6a5b',
                    dashStyle: 'ShortDash',
                    marker: { enabled: true, symbol: 'diamond', radius: 5 },
                    data: points(projectedDates, indexValues.slice(actualCount - 1))
                }, {
                    name: fundName,
                    yAxis: 1,
                    color: '#1677ff',
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, 'rgba(22,119,255,0.22)'],
                            [1, 'rgba(22,119,255,0.01)']
                        ]
                    },
                    data: points(actualDates, navValues.slice(0, actualCount))
                }, {
                    name: fundName + ' projected',
                    yAxis: 1,
                    type: 'spline',
                    color: '#1677ff',
                    dashStyle: 'ShortDash',
                    marker: { enabled: true, symbol: 'diamond', radius: 5 },
                    data: points(projectedDates, navValues.slice(actualCount - 1))
                }]
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/predictive/jensen_alpha.blade.php ENDPATH**/ ?>