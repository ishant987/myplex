<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.indices_report')); ?>">indices report</a></li>
                        <li>Indices History</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="<?php echo e(route('user.indices-history')); ?>" method="get" id="searchForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select class="select2 multiple index_select" multiple name="indices[]"
                                            data-placeholder="Select Indices" id="select_fund_multiple" data-max="6"
                                            onchange='fund_multiple(this)'>
                                            <option value="">Select Indices</option>
                                            <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($index->corelation); ?>"
                                                    <?php if(isset($request['indices']) && in_array($index->corelation, $request['indices'])): ?> selected <?php endif; ?>><?php echo e($index->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <span class="text-danger" id="fund_msgg"></span>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="text" class="form-control datepicker indices-history-datepicker"
                                            placeholder="Start Date" name="start_date"
                                            value="<?php echo e($request['start_date'] ?? ''); ?>">
                                        <button type="button" class="datepicker-trigger indices-history-trigger"
                                            aria-label="Open calendar" data-target="start_date">
                                                <i class="fa-solid fa-calendar-days"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="text" class="form-control datepicker indices-history-datepicker"
                                            placeholder="End Date" name="end_date"
                                            value="<?php echo e($request['end_date'] ?? ''); ?>">
                                        <button type="button" class="datepicker-trigger indices-history-trigger"
                                            aria-label="Open calendar" data-target="end_date">
                                                <i class="fa-solid fa-calendar-days"></i>
                                        </button>
                                        <input type="hidden" id="indices_graph" value="<?php echo e(json_encode($indices_vals)); ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="bttn_grp">
                                        <button type="submit" id="submit_btn">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    

                    <div class="share_pdf">
                                
                        <div class="sharethis-inline-share-buttons" ></div>
                        
                    </div>

                    <?php if(count($indices_vals) != 0): ?>
                        <div class="graph_section">
                            <div id="chartContainer" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>
                        </div>
                    <?php else: ?>
                        <div class="graph_section">
                            <p style="text-align: center;">Please search above to show the results</p>
                        </div>
                    <?php endif; ?>

                    

                </div>
                <?php if(isset($indices_vals)): ?>
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                </div>
              <?php endif; ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script>
        function initIndicesHistoryDatepickers() {
            var $dateInputs = $('#searchForm .indices-history-datepicker');

            if (!window.jQuery || !$dateInputs.length) {
                return;
            }

            if ($.fn.datepicker) {
                $dateInputs.attr('readonly', true);
                $dateInputs.datepicker('destroy').datepicker({
                    dateFormat: 'dd-mm-yy',
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 1,
                    showButtonPanel: true,
                    yearRange: '-100:+20',
                    constrainInput: false
                });

                $dateInputs.off('focus.indicesHistory click.indicesHistory').on('focus.indicesHistory click.indicesHistory', function() {
                    $(this).datepicker('show');
                });
            }

            $('#searchForm .indices-history-trigger').off('click.indicesHistory').on('click.indicesHistory', function(event) {
                event.preventDefault();

                var inputName = $(this).data('target');
                var $input = $('#searchForm input[name="' + inputName + '"]');

                if ($input.length) {
                    if ($.fn.datepicker) {
                        $input.datepicker('show');
                        $input.trigger('focus');
                    } else if ($input[0].showPicker) {
                        $input[0].showPicker();
                    } else {
                        $input.trigger('focus');
                    }
                }
            });

            $dateInputs.off('mousedown.indicesHistory').on('mousedown.indicesHistory', function() {
                if ($.fn.datepicker) {
                    $(this).datepicker('show');
                }
            });
        }

        function initIndicesHistoryPage() {
            initIndicesHistoryDatepickers();

            var indicesGraphField = document.getElementById('indices_graph');

            if (!indicesGraphField) {
                return;
            }

            var indicesGraphData = indicesGraphField.value;

            if (indicesGraphData !== '') {
                indicesGraphData = JSON.parse(indicesGraphData);

                var seriesData = [];

                for (var index in indicesGraphData) {
                    if (Object.prototype.hasOwnProperty.call(indicesGraphData, index)) {
                        var series = {
                            name: index,
                            data: [],
                            dataLabels: {
                                enabled: false
                            }
                        };

                        indicesGraphData[index].forEach(function(item) {
                            var date = new Date(item[0]).getTime();
                            var value = parseFloat(item[1]);

                            if (!isNaN(value)) {
                                series.data.push([date, value]);
                            }
                        });

                        seriesData.push(series);
                    }
                }

                Highcharts.chart('chartContainer', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Indices History'
                    },
                    xAxis: {
                        type: 'datetime',
                        title: {
                            text: 'Date'
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Value'
                        },
                        min: 0
                    },
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: false
                            }
                        }
                    },
                    series: seriesData
                });
            }

            if (window.jQuery) {
                $('.highcharts-credits').hide();
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initIndicesHistoryPage);
        } else {
            initIndicesHistoryPage();
        }
    </script>
<?php $__env->stopPush(); ?>

<style type="text/css">
    
.highcharts-label.highcharts-series-label{
    display: none;
}

</style>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/indices-reports/indices-history.blade.php ENDPATH**/ ?>