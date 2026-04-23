<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="#">dashboard</a></li>
                        <li><a href="#">filters</a></li>
                        <li>By Jensen’s</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>By Jensen’s</h2>
                    </div>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <select name="fund_id" class="select2" id="allocation_select_fund"
                                            onchange="set_fund_select_val(this.value)">
                                            <?php $__currentLoopData = $fundMasterData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($fund->fund_id); ?>"
                                                    <?php if($fund->fund_id == old('fund_id', isset($getData) ? $getData['fund_id'] : null)): ?> selected <?php endif; ?>>
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
                                        <input type="number" placeholder="Expected Future Index">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="bttn_grp alpha_btn">
                                        <button type="submit">6m</button>
                                        <button type="submit">1y</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="fund_section new_fund_section">
                        <ul>
                            <li>
                                <p>Current daye :</p>
                                <span>00/00/0000</span>
                            </li>
                            <li>
                                <p>Index name :</p>
                                <span>abc</span>
                            </li>
                            <li>
                                <p>Current value :</p>
                                <span>11.5</span>
                            </li>
                        </ul>
                    </div>

                    <div class="graph_section">
                        <img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/graph.png"
                            alt="">
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script>
        function set_fund_select_val(fundId) {

            $.ajax({
                url: 'fund-details' + '?id=' + fundId,
                type: 'GET',
                success: function(data) {
                    $('#date').html(data.entry_date);
                    $('#indices_name').html(data.name);
                    $('#indices_value').html(data.closing_value);
                },
                error: function(xhr, status, error) {
                    // console.error('AJAX Error: ' + error);
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/new_predictive/new_jensen_alpha.blade.php ENDPATH**/ ?>