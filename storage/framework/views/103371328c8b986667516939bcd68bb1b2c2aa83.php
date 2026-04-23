<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.filters')); ?>">filters</a></li>
                        <li>By Volatility</li>
                    </ul>
                </div>

                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="<?php echo e(route('user.filters.volatility')); ?>" method="GET">
                            <input type="hidden" name="duration" id="duration_input" value="<?php echo e($duration ?? '6'); ?>">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form_group">
                                        <select name="fund_id" class="select2" id="allocation_select_fund">
                                            <?php $__currentLoopData = $fundMasterData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($fund->fund_id); ?>"
                                                    <?php echo e((int) $selected_fund_id === (int) $fund->fund_id ? 'selected' : ''); ?>>
                                                    <?php echo e($fund->fund_name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form_group">
                                        <input type="text" name="return_value" placeholder="Return"
                                            value="<?php echo e(old('return_value', request('return_value'))); ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="bttn_grp alpha_btn">
                                        <button type="submit" data-duration="6"
                                            <?php echo e(($duration ?? '6') === '6' ? 'style=background:#379962;color:#fff;' : ''); ?>>
                                            6m
                                        </button>
                                        <button type="submit" data-duration="1"
                                            <?php echo e(($duration ?? '6') === '1' ? 'style=background:#379962;color:#fff;' : ''); ?>>
                                            1y
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="fund_section new_fund_section">
                        <ul>
                            <li>
                                <p>Current date :</p>
                                <input type="text" id="current_date_display" class="form-control"
                                    value="<?php echo e($current_date ?? 'N/A'); ?>" readonly>
                            </li>
                            <li>
                                <p>Index name :</p>
                                <input type="text" id="index_name_display" class="form-control"
                                    value="<?php echo e($indices_details->name ?? ($fund_details->indices_name ?? 'N/A')); ?>" readonly>
                            </li>
                            <li>
                                <p>Current value :</p>
                                <input type="text" id="current_value_display" class="form-control"
                                    value="<?php echo e(isset($current_value) ? printValue($current_value) : 'N/A'); ?>" readonly>
                            </li>
                        </ul>
                    </div>

                    <?php if(!empty($message)): ?>
                        <div class="graph_table">
                            <p><?php echo e($message); ?></p>
                        </div>
                    <?php elseif(!empty($fund_series) || !empty($index_series)): ?>
                        <div class="graph_section">
                            <div id="volatility-chart" style="width: 100%; min-height: 420px;"></div>
                        </div>
                    <?php else: ?>
                        <div class="graph_table">
                            <p>Select a scheme and period to view the graph.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if(!empty($fund_series) || !empty($index_series)): ?>
                    <div class="disclaimer">
                        <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fundSelect = document.getElementById('allocation_select_fund');

            function updateFundMeta(fundId) {
                if (!fundId) {
                    return;
                }

                $.ajax({
                    url: '<?php echo e(url('fund-details')); ?>?id=' + fundId,
                    type: 'GET',
                    success: function(data) {
                        $('#current_date_display').val(data.entry_date || 'N/A');
                        $('#index_name_display').val(data.name || 'N/A');
                        $('#current_value_display').val(data.closing_value || '0.0');
                    },
                    error: function() {
                        $('#current_date_display').val('N/A');
                        $('#index_name_display').val('N/A');
                        $('#current_value_display').val('N/A');
                    }
                });
            }

            if (fundSelect) {
                updateFundMeta(fundSelect.value);
                fundSelect.addEventListener('change', function() {
                    updateFundMeta(this.value);
                });
            }

            document.querySelectorAll('.alpha_btn button[data-duration]').forEach(function(button) {
                button.addEventListener('click', function() {
                    var durationInput = document.getElementById('duration_input');
                    if (durationInput) {
                        durationInput.value = this.getAttribute('data-duration');
                    }
                });
            });
        });
    </script>

    <?php if(!empty($fund_series) || !empty($index_series)): ?>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var indexSeries = <?php echo json_encode($index_series, 15, 512) ?>;
                var fundSeries = <?php echo json_encode($fund_series, 15, 512) ?>;

                indexSeries = (indexSeries || []).map(function(point) {
                    return [Date.parse(point[0]), point[1]];
                }).filter(function(point) {
                    return !isNaN(point[0]) && point[1] !== null;
                });

                fundSeries = (fundSeries || []).map(function(point) {
                    return [Date.parse(point[0]), point[1]];
                }).filter(function(point) {
                    return !isNaN(point[0]) && point[1] !== null;
                });

                Highcharts.chart('volatility-chart', {
                    chart: {
                        type: 'spline',
                        zoomType: 'x'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        type: 'datetime'
                    },
                    yAxis: [{
                        title: {
                            text: '<?php echo e(addslashes($indices_details->name ?? ($fund_details->indices_name ?? 'Index'))); ?>'
                        }
                    }, {
                        title: {
                            text: '<?php echo e(addslashes($fund_details->fund_name ?? 'Fund NAV')); ?>'
                        },
                        opposite: true
                    }],
                    time: {
                        useUTC: false
                    },
                    tooltip: {
                        shared: true
                    },
                    series: [{
                        name: '<?php echo e(addslashes($indices_details->name ?? ($fund_details->indices_name ?? 'Index'))); ?>',
                        yAxis: 0,
                        data: indexSeries,
                        color: '#d94f30'
                    }, {
                        name: '<?php echo e(addslashes($fund_details->fund_name ?? 'Fund NAV')); ?>',
                        yAxis: 1,
                        data: fundSeries,
                        color: '#1f5f99'
                    }]
                });
            });
        </script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/filters/volatility.blade.php ENDPATH**/ ?>