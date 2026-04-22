<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.predictive')); ?>">Predictive</a></li>
                        <li>By Jensen’s</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <select name="fund_id" class="select2" id="allocation_select_fund"
                                            onchange="set_fund_select_val(this.value)">
                                            <?php $__currentLoopData = $fundMasterData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($fund->fund_id); ?>"
                                                    <?php if($fund->fund_id == old('fund_id', data_get($getData ?? [], 'fund_id'))): ?> selected <?php endif; ?>>
                                                    <?php echo e($fund->fund_name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['fund_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <p>Date : <span id="date">N/A</span></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <p>Index Name : <span id="indices_name">N/A</span></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <p>Index Value : <span id="indices_value">0.0</span></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="number" name="expected_index" placeholder="Expected Future Index"
                                            value="<?php echo e($expected_index ?? ''); ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="current_date" id="current_date">
                                <div class="col-md-2">
                                    <div class="bttn_grp alpha_btn">
                                        <button type="submit" name="duration" value="6">6m</button>
                                        <button type="submit" name="duration" value="1">1y</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="share_pdf">
                                
                        <div class="sharethis-inline-share-buttons" ></div>
                        
                    </div>

                    <input type="hidden" name="indices_name" id="indices_details_name"
                        value="<?php echo e(isset($indices_details) ? $indices_details->name : ''); ?>">
                    <input type="hidden" name="fund_name" id="fund_details_name"
                        value="<?php echo e(isset($fund_details) ? $fund_details->fund_name : ''); ?>">
                    <input type="hidden" name="graph_date[]" id="graph_date"
                        value="<?php echo e(isset($graph_date) ? json_encode($graph_date) : ''); ?>">
                    <input type="hidden" name="nav_value[]" id="nav_value"
                        value="<?php echo e(isset($nav_value) ? json_encode($nav_value) : ''); ?>">
                    <input type="hidden" name="closing_value[]" id="closing_value"
                        value="<?php echo e(isset($closing_value) ? json_encode($closing_value) : ''); ?>">

                    

                    <?php if(!empty($message)): ?>
                        <div class="graph_table">
                            <p><?php echo e($message); ?></p>
                        </div>
                    <?php elseif(!empty($fund_series) || !empty($index_series)): ?>
                        <div class="graph_section">
                            <div id="container1"></div>
                        </div>
                    <?php else: ?>
                        <div class="graph_table">
                            <p>Select a scheme and period to view the graph.</p>
                        </div>
                    <?php endif; ?>

                </div>

                <?php if(isset($indices_details)): ?>
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                </div>
              <?php endif; ?>
            </div>
        </div>

    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script>
        function set_fund_select_val(fundId) {

            $.ajax({
                url: '<?php echo e(url('fund-details')); ?>?id=' + fundId,
                type: 'GET',
                success: function(data) {
                    $('#date').html(data.entry_date);
                    $('#indices_name').html(data.name);
                    $('#indices_value').html(data.closing_value);
                    $('#current_date').val(data.entry_date);
                },
                error: function(xhr, status, error) {
                    // console.error('AJAX Error: ' + error);
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            var fund_id = document.getElementById('allocation_select_fund').value;
            set_fund_select_val(fund_id);
        });
    </script>

    <?php if(!empty($fund_series) || !empty($index_series)): ?>
        <script>
            var indexSeries = <?php echo json_encode($index_series ?? [], 15, 512) ?>;
            var fundSeries = <?php echo json_encode($fund_series ?? [], 15, 512) ?>;

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

            Highcharts.chart('container1', {
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
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/predictive/jensen_alpha.blade.php ENDPATH**/ ?>