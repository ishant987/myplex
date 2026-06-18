<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.indices_report')); ?>">indices report</a></li>
                        <li>Index vs NAV</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>Index vs NAV</h2>
                    </div>
                    <form action="" method="get">
                        <div class="index_nav">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="nav_in">
                                        <div class="wm_tab">
                                            <ul class="">
                                                <li>
                                                    <a href="javascript:void(0)" id="main_select_scheme"
                                                        onclick="main_select('scheme')"
                                                        class="<?php echo e((isset($request['main_select']) && $request['main_select'] == 'scheme') || !isset($request['main_select']) ? 'active' : ''); ?>">Schemes</a>
                                                    <input type="hidden" id="main_select" name="main_select"
                                                        value="<?php echo e(isset($request['main_select']) ? $request['main_select'] : ''); ?>">
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" id="main_select_index"
                                                        onclick="main_select('index')"
                                                        class="<?php echo e(isset($request['main_select']) && $request['main_select'] == 'index' ? 'active' : ''); ?>">Index</a>
                                                </li>



                                            </ul>
                                        </div>

                                        <div class="">

                                            <div id="main_scheme" class="tab"
                                                style="<?php echo e(isset($request['main_select']) && $request['main_select'] == 'index' ? 'display:none' : ''); ?>">
                                                <div class="form_group">
                                                    <select name="scheme_main" class="select2"
                                                        data-placeholder="Select Scheme" onchange="main_drpdown('scheme')">
                                                        <option value="">Select Scheme</option>
                                                        <?php if(isset($schemes)): ?>
                                                            <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($scheme->fund_code); ?>"
                                                                    <?php if(isset($request['scheme_main']) && $scheme->fund_code == $request['scheme_main']): ?> selected <?php endif; ?>>
                                                                    <?php echo e($scheme->fund_name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="main_index" class="tab"
                                                style="<?php echo e((isset($request['main_select']) && $request['main_select'] == 'scheme') || !isset($request['main_select']) ? 'display:none' : ''); ?>">
                                                <div class="form_group">
                                                    <select name="index_main" class="select2"
                                                        data-placeholder="Select Index" onchange="main_drpdown('index')">
                                                        <option value="">Select Index</option>
                                                        <?php if(isset($indices)): ?>
                                                            <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($index->corelation); ?>"
                                                                    <?php if(isset($request['index_main']) && $index->corelation == $request['index_main']): ?> selected <?php endif; ?>>
                                                                    <?php echo e($index->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <div class="col-md-6">
                                            <label>From date</label>
                                            <div class="form_group">
                                                <input type="text" name="from_date" class="datepicker"
                                                    value="<?php echo e(isset($request['from_date']) ? $request['from_date'] : ''); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>To date</label>
                                            <div class="form_group">
                                                <input type="text" name="to_date" class="datepicker"
                                                    value="<?php echo e(isset($request['to_date']) ? $request['to_date'] : ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="index_five">

                                        <div class="single_index">
                                            <div class="wm_tab">
                                                <ul class="">
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_1('scheme')"
                                                            id="select_scheme_1"
                                                            class="<?php echo e((isset($request['select_1']) && $request['select_1'] == 'scheme') || !isset($request['select_1']) ? 'active' : ''); ?>">Schemes</a>
                                                        <input type="hidden" id="select_1" name="select_1"
                                                            value="<?php echo e(isset($request['select_1']) ? $request['select_1'] : ''); ?>">
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_1('index')"
                                                            id="select_index_1"
                                                            class="<?php echo e(isset($request['select_1']) && $request['select_1'] == 'index' ? 'active' : ''); ?>">Index</a>
                                                    </li>

                                                </ul>
                                            </div>

                                            <div class="tabsct">

                                                <div id="scheme_1" class=""
                                                    style="<?php echo e(isset($request['select_1']) && $request['select_1'] == 'index' ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="scheme_1" class="select2"
                                                            data-placeholder="Select Scheme" onchange="drpdown_1('scheme')">
                                                            <option value="">Select Scheme</option>
                                                            <?php if(isset($schemes)): ?>
                                                                <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($scheme->fund_code); ?>"
                                                                        <?php if(isset($request['scheme_1']) && $scheme->fund_code == $request['scheme_1']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($scheme->fund_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="" id="index_1"
                                                    style="<?php echo e((isset($request['select_1']) && $request['select_1'] == 'scheme') || !isset($request['select_1']) ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="index_1" class="select2"
                                                            onchange="drpdown_1('index')">
                                                            <option value="">Select Index</option>
                                                            <?php if(isset($indices)): ?>
                                                                <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($index->corelation); ?>"
                                                                        <?php if(isset($request['index_1']) && $index->corelation == $request['index_1']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($index->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="single_index">
                                            <div class="wm_tab">
                                                <ul class="">
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_2('scheme')"
                                                            id="select_scheme_2"
                                                            class="<?php echo e((isset($request['select_2']) && $request['select_2'] == 'scheme') || !isset($request['select_2']) ? 'active' : ''); ?>">Schemes</a>
                                                        <input type="hidden" id="select_2" name="select_2"
                                                            value="<?php echo e(isset($request['select_2']) ? $request['select_2'] : ''); ?>">
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_2('index')"
                                                            id="select_index_2"
                                                            class="<?php echo e(isset($request['select_2']) && $request['select_2'] == 'index' ? 'active' : ''); ?>">Index</a>
                                                    </li>
                                                </ul>

                                            </div>

                                            <div class="tabsct">
                                                <div class="" id="scheme_2"
                                                    style="<?php echo e(isset($request['select_2']) && $request['select_2'] == 'index' ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="scheme_2" class="select2"
                                                            data-placeholder="Select Scheme"
                                                            onchange="drpdown_2('scheme')">
                                                            <option value="">Select Scheme</option>
                                                            <?php if(isset($schemes)): ?>
                                                                <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($scheme->fund_code); ?>"
                                                                        <?php if(isset($request['scheme_2']) && $scheme->fund_code == $request['scheme_2']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($scheme->fund_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="" id="index_2"
                                                    style="<?php echo e((isset($request['select_2']) && $request['select_2'] == 'scheme') || !isset($request['select_2']) ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="index_2" class="select2"
                                                            onchange="drpdown_2('index')">
                                                            <option value="">Select Index</option>
                                                            <?php if(isset($indices)): ?>
                                                                <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($index->corelation); ?>"
                                                                        <?php if(isset($request['index_2']) && $index->corelation == $request['index_2']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($index->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        

                                        <div class="single_index">
                                            <div class="wm_tab">
                                                <ul class="">
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_3('scheme')"
                                                            id="select_scheme_3"
                                                            class="<?php echo e((isset($request['select_3']) && $request['select_3'] == 'scheme') || !isset($request['select_3']) ? 'active' : ''); ?>">Schemes</a>
                                                        <input type="hidden" id="select_3" name="select_3"
                                                            value="<?php echo e(isset($request['select_3']) ? $request['select_3'] : ''); ?>">
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_3('index')"
                                                            id="select_index_3"
                                                            class="<?php echo e(isset($request['select_3']) && $request['select_3'] == 'index' ? 'active' : ''); ?>">Index</a>
                                                    </li>
                                                </ul>

                                            </div>

                                            <div class="tabsct">
                                                <div class="" id="scheme_3"
                                                    style="<?php echo e(isset($request['select_3']) && $request['select_3'] == 'index' ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="scheme_3" class="select2"
                                                            data-placeholder="Select Scheme"
                                                            onchange="drpdown_3('scheme')">
                                                            <option value="">Select Scheme</option>
                                                            <?php if(isset($schemes)): ?>
                                                                <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($scheme->fund_code); ?>"
                                                                        <?php if(isset($request['scheme_3']) && $scheme->fund_code == $request['scheme_3']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($scheme->fund_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="" id="index_3"
                                                    style="<?php echo e((isset($request['select_3']) && $request['select_3'] == 'scheme') || !isset($request['select_3']) ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="index_3" class="select2"
                                                            onchange="drpdown_3('index')">
                                                            <option value="">Select Index</option>
                                                            <?php if(isset($indices)): ?>
                                                                <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($index->corelation); ?>"
                                                                        <?php if(isset($request['index_3']) && $index->corelation == $request['index_3']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($index->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        

                                        <div class="single_index">
                                            <div class="wm_tab">
                                                <ul class="">
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_4('scheme')"
                                                            id="select_scheme_4"
                                                            class="<?php echo e((isset($request['select_4']) && $request['select_4'] == 'scheme') || !isset($request['select_4']) ? 'active' : ''); ?>">Schemes</a>
                                                        <input type="hidden" id="select_4" name="select_4"
                                                            value="<?php echo e(isset($request['select_4']) ? $request['select_4'] : ''); ?>">
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_4('index')"
                                                            id="select_index_4"
                                                            class="<?php echo e(isset($request['select_4']) && $request['select_4'] == 'index' ? 'active' : ''); ?>">Index</a>
                                                    </li>
                                                </ul>

                                            </div>

                                            <div class="tabsct">
                                                <div class="" id="scheme_4"
                                                    style="<?php echo e(isset($request['select_4']) && $request['select_4'] == 'index' ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="scheme_4" class="select2"
                                                            data-placeholder="Select Scheme"
                                                            onchange="drpdown_4('scheme')">
                                                            <option value="">Select Scheme</option>
                                                            <?php if(isset($schemes)): ?>
                                                                <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($scheme->fund_code); ?>"
                                                                        <?php if(isset($request['scheme_4']) && $scheme->fund_code == $request['scheme_4']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($scheme->fund_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="" id="index_4"
                                                    style="<?php echo e((isset($request['select_4']) && $request['select_4'] == 'scheme') || !isset($request['select_4']) ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="index_4" class="select2"
                                                            onchange="drpdown_4('index')">
                                                            <option value="">Select Index</option>
                                                            <?php if(isset($indices)): ?>
                                                                <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($index->corelation); ?>"
                                                                        <?php if(isset($request['index_4']) && $index->corelation == $request['index_4']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($index->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        

                                        <div class="single_index">
                                            <div class="wm_tab">
                                                <ul class="">
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_5('scheme')"
                                                            id="select_scheme_5"
                                                            class="<?php echo e((isset($request['select_5']) && $request['select_5'] == 'scheme') || !isset($request['select_5']) ? 'active' : ''); ?>">Schemes</a>
                                                        <input type="hidden" id="select_5" name="select_5"
                                                            value="<?php echo e(isset($request['select_5']) ? $request['select_5'] : ''); ?>">
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_5('index')"
                                                            id="select_index_5"
                                                            class="<?php echo e(isset($request['select_5']) && $request['select_5'] == 'index' ? 'active' : ''); ?>">Index</a>
                                                    </li>
                                                </ul>

                                            </div>

                                            <div class="tabsct">
                                                <div class="" id="scheme_5"
                                                    style="<?php echo e(isset($request['select_5']) && $request['select_5'] == 'index' ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="scheme_5" class="select2"
                                                            data-placeholder="Select Scheme"
                                                            onchange="drpdown_5('scheme')">
                                                            <option value="">Select Scheme</option>
                                                            <?php if(isset($schemes)): ?>
                                                                <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($scheme->fund_code); ?>"
                                                                        <?php if(isset($request['scheme_5']) && $scheme->fund_code == $request['scheme_5']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($scheme->fund_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="" id="index_5"
                                                    style="<?php echo e((isset($request['select_5']) && $request['select_5'] == 'scheme') || !isset($request['select_5']) ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="index_5" class="select2"
                                                            onchange="drpdown_5('index')">
                                                            <option value="">Select Index</option>
                                                            <?php if(isset($indices)): ?>
                                                                <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($index->corelation); ?>"
                                                                        <?php if(isset($request['index_5']) && $index->corelation == $request['index_5']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($index->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        

                                        <div class="single_index">
                                            <div class="wm_tab">
                                                <ul class="">
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_6('scheme')"
                                                            id="select_scheme_6"
                                                            class="<?php echo e((isset($request['select_6']) && $request['select_6'] == 'scheme') || !isset($request['select_6']) ? 'active' : ''); ?>">Schemes</a>
                                                        <input type="hidden" id="select_6" name="select_6"
                                                            value="<?php echo e(isset($request['select_6']) ? $request['select_6'] : ''); ?>">
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="select_6('index')"
                                                            id="select_index_6"
                                                            class="<?php echo e(isset($request['select_6']) && $request['select_6'] == 'index' ? 'active' : ''); ?>">Index</a>
                                                    </li>
                                                </ul>

                                            </div>

                                            <div class="tabsct">
                                                <div class="" id="scheme_6"
                                                    style="<?php echo e(isset($request['select_6']) && $request['select_6'] == 'index' ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="scheme_6" class="select2"
                                                            data-placeholder="Select Scheme"
                                                            onchange="drpdown_6('scheme')">
                                                            <option value="">Select Scheme</option>
                                                            <?php if(isset($schemes)): ?>
                                                                <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($scheme->fund_code); ?>"
                                                                        <?php if(isset($request['scheme_6']) && $scheme->fund_code == $request['scheme_6']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($scheme->fund_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="" id="index_6"
                                                    style="<?php echo e((isset($request['select_6']) && $request['select_6'] == 'scheme') || !isset($request['select_6']) ? 'display:none' : ''); ?>">
                                                    <div class="form_group">
                                                        <select name="index_6" class="select2"
                                                            onchange="drpdown_6('index')">
                                                            <option value="">Select Index</option>
                                                            <?php if(isset($indices)): ?>
                                                                <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($index->corelation); ?>"
                                                                        <?php if(isset($request['index_6']) && $index->corelation == $request['index_6']): ?> selected <?php endif; ?>>
                                                                        <?php echo e($index->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <input type="hidden" id="indices_graph_1"
                                            value="<?php echo e(isset($indices_vals_1) ? json_encode($indices_vals_1) : ''); ?>">
                                        <input type="hidden" id="indices_graph_2"
                                            value="<?php echo e(isset($indices_vals_2) ? json_encode($indices_vals_2) : ''); ?>">
                                        <input type="hidden" id="indices_graph_3"
                                            value="<?php echo e(isset($indices_vals_3) ? json_encode($indices_vals_3) : ''); ?>">
                                        <input type="hidden" id="indices_graph_4"
                                            value="<?php echo e(isset($indices_vals_4) ? json_encode($indices_vals_4) : ''); ?>">
                                        <input type="hidden" id="indices_graph_5"
                                            value="<?php echo e(isset($indices_vals_5) ? json_encode($indices_vals_5) : ''); ?>">
                                        <input type="hidden" id="indices_graph_6"
                                            value="<?php echo e(isset($indices_vals_6) ? json_encode($indices_vals_6) : ''); ?>">


                                        <button class="btn btn-success" type="submit">Compare</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    
                    <?php if(isset($indices_vals_1) || isset($request['scheme_2']) || isset($request['scheme_3']) || isset($request['scheme_4']) || isset($request['scheme_5']) || isset($request['scheme_6'])   ): ?>
                    <div class="share_pdf">
                        <div class="sharethis-inline-share-buttons" ></div>
                        

                    </div>
                    <?php endif; ?>

                    <?php if(isset($indices_vals_1) && count($indices_vals_1) != 0): ?>
                        <div class="graph_section">
                            <div id="chartContainer_1" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>
                        </div>
                    <?php else: ?>
                        <div class="graph_section">
                            <p style="text-align: center;">Please search above to show the results</p>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($request['scheme_2']) && !empty($request['scheme_2']) || isset($request['index_2']) && !empty($request['index_2'])): ?>
                        <div class="graph_section">
                            <div id="chartContainer_2" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($request['scheme_3']) && !empty($request['scheme_3']) || isset($request['index_3']) && !empty($request['index_3'])): ?>
                        <div class="graph_section">
                            <div id="chartContainer_3" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($request['scheme_4']) && !empty($request['scheme_4']) || isset($request['index_4']) && !empty($request['index_4'])): ?>
                        <div class="graph_section">
                            <div id="chartContainer_4" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($request['scheme_5']) && !empty($request['scheme_5']) || isset($request['index_5']) && !empty($request['index_5'])): ?>
                        <div class="graph_section">
                            <div id="chartContainer_5" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($request['scheme_6']) && !empty($request['scheme_6']) || isset($request['index_6']) && !empty($request['index_6'])): ?>
                        <div class="graph_section">
                            <div id="chartContainer_6" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>
                        </div>
                    <?php endif; ?>


                </div>
                <?php if(isset($indices_vals_6)): ?>
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                </div>
              <?php endif; ?>
            </div>
        </div>

    </div>

    <script>
        function main_select(val) {
            // alert(val);

            $("#main_select").val(val);
            if (val == 'index') {
                $("#main_index").show();
                $("#main_select_index").addClass('active');
                $("#main_select_scheme").removeClass('active');
                $("#main_scheme").hide();
            } else {
                $("#main_scheme").show();
                $("#main_select_index").removeClass('active');
                $("#main_select_scheme").addClass('active');
                $("#main_index").hide();
            }

        }

        function select_1(val) {
            // alert(val);
            $("#select_1").val(val);
            if (val == 'index') {
                $("#index_1").show();
                $("#select_index_1").addClass('active');
                $("#select_scheme_1").removeClass('active');
                $("#scheme_1").hide();
            } else {
                $("#scheme_1").show();
                $("#select_index_1").removeClass('active');
                $("#select_scheme_1").addClass('active');
                $("#index_1").hide();
            }
        }

        function select_2(val) {
            // alert("select 2");
            $("#select_2").val(val);
            if (val == 'index') {
                $("#index_2").show();
                $("#select_index_2").addClass('active');
                $("#select_scheme_2").removeClass('active');
                $("#scheme_2").hide();
            } else {
                $("#scheme_2").show();
                $("#select_index_2").removeClass('active');
                $("#select_scheme_2").addClass('active');
                $("#index_2").hide();
            }
        }

        function select_3(val) {
            // alert("select 3");
            $("#select_3").val(val);
            if (val == 'index') {
                $("#index_3").show();
                $("#select_index_3").addClass('active');
                $("#select_scheme_3").removeClass('active');
                $("#scheme_3").hide();
            } else {
                $("#scheme_3").show();
                $("#select_index_3").removeClass('active');
                $("#select_scheme_3").addClass('active');
                $("#index_3").hide();
            }
        }

        function select_4(val) {
            // alert(val);
            $("#select_4").val(val);
            if (val == 'index') {
                $("#index_4").show();
                $("#select_index_4").addClass('active');
                $("#select_scheme_4").removeClass('active');
                $("#scheme_4").hide();
            } else {
                $("#scheme_4").show();
                $("#select_index_4").removeClass('active');
                $("#select_scheme_4").addClass('active');
                $("#index_4").hide();
            }
        }

        function select_5(val) {
            // alert(val);
            $("#select_5").val(val);
            if (val == 'index') {
                $("#index_5").show();
                $("#select_index_5").addClass('active');
                $("#select_scheme_5").removeClass('active');
                $("#scheme_5").hide();
            } else {
                $("#scheme_5").show();
                $("#select_index_5").removeClass('active');
                $("#select_scheme_5").addClass('active');
                $("#index_5").hide();
            }
        }

        function select_6(val) {
            // alert(val);
            $("#select_6").val(val);
            if (val == 'index') {
                $("#index_6").show();
                $("#select_index_6").addClass('active');
                $("#select_scheme_6").removeClass('active');
                $("#scheme_6").hide();
            } else {
                $("#scheme_6").show();
                $("#select_index_6").removeClass('active');
                $("#select_scheme_6").addClass('active');
                $("#index_6").hide();
            }
        }

        function main_drpdown(val) {
            if (val == 'index') {
                $("#main_select").val('index');
            } else if (val == 'scheme') {
                $("#main_select").val('scheme');
            }
        }

        function drpdown_1(val) {
            if (val == 'index') {
                $("#select_1").val('index');
            } else if (val == 'scheme') {
                $("#select_1").val('scheme');
            }
        }

        function drpdown_2(val) {
            if (val == 'index') {
                $("#select_2").val('index');
            } else if (val == 'scheme') {
                $("#select_2").val('scheme');
            }
        }

        function drpdown_3(val) {
            if (val == 'index') {
                $("#select_3").val('index');
            } else if (val == 'scheme') {
                $("#select_3").val('scheme');
            }
        }

        function drpdown_4(val) {
            if (val == 'index') {
                $("#select_4").val('index');
            } else if (val == 'scheme') {
                $("#select_4").val('scheme');
            }
        }

        function drpdown_5(val) {
            if (val == 'index') {
                $("#select_5").val('index');
            } else if (val == 'scheme') {
                $("#select_5").val('scheme');
            }
        }

        function drpdown_6(val) {
            if (val == 'index') {
                $("#select_6").val('index');
            } else if (val == 'scheme') {
                $("#select_6").val('scheme');
            }
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <script>
        $(document).ready(function() {
            function validPoints(points) {
                return (points || [])
                    .filter((item) => Array.isArray(item) && item.length > 1 && !isNaN(parseFloat(item[1])))
                    .map((item) => [Date.parse(item[0]), parseFloat(item[1])])
                    .sort((left, right) => left[0] - right[0]);
            }

            function initializeChart(graphId, containerId) {
                const graphInput = document.getElementById(graphId);
                const container = document.getElementById(containerId);

                if (!graphInput || !container || !graphInput.value) {
                    return;
                }

                try {
                    const graphData = JSON.parse(graphInput.value);
                    const names = Object.keys(graphData);
                    const primaryName = names[0];
                    const comparisonName = names[1] || '';
                    const primaryPoints = validPoints(graphData[primaryName]);
                    const comparisonPoints = comparisonName ? validPoints(graphData[comparisonName]) : [];

                    if (!primaryName || !primaryPoints.length) {
                        return;
                    }

                    // NAV data has one closing value per period. Previous close is used as the next candle's open.
                    const candles = primaryPoints.map((point, index) => {
                        const open = index === 0 ? point[1] : primaryPoints[index - 1][1];
                        const close = point[1];
                        return [point[0], open, Math.max(open, close), Math.min(open, close), close];
                    });
                    const latest = candles[candles.length - 1];
                    const previousClose = candles.length > 1 ? candles[candles.length - 2][4] : latest[1];
                    const movement = latest[4] - previousClose;
                    const movementPercent = previousClose ? (movement / previousClose) * 100 : 0;
                    const graphSection = container.closest('.graph_section');

                    graphSection.classList.add('ivn-trading-card');
                    graphSection.insertAdjacentHTML('afterbegin', `
                        <div class="ivn-trading-head">
                            <div>
                                <div class="ivn-trading-name">${primaryName}</div>
                                <div class="ivn-trading-meta">NAV movement ${comparisonName ? `· Compared with ${comparisonName}` : ''}</div>
                            </div>
                            <div class="ivn-trading-quote ${movement >= 0 ? 'positive' : 'negative'}">
                                <strong>${Highcharts.numberFormat(latest[4], 2)}</strong>
                                <span>${movement >= 0 ? '+' : ''}${Highcharts.numberFormat(movement, 2)} (${movementPercent >= 0 ? '+' : ''}${Highcharts.numberFormat(movementPercent, 2)}%)</span>
                            </div>
                        </div>
                    `);

                    Highcharts.stockChart(containerId, {
                        accessibility: { enabled: false },
                        chart: {
                            backgroundColor: '#ffffff',
                            height: 510,
                            spacing: [14, 18, 10, 12],
                            style: { fontFamily: '"Manrope", "Avenir Next", sans-serif' }
                        },
                        title: { text: null },
                        credits: { enabled: false },
                        rangeSelector: {
                            selected: 4,
                            inputEnabled: false,
                            buttonSpacing: 6,
                            buttons: [
                                { type: 'month', count: 1, text: '1M' },
                                { type: 'month', count: 3, text: '3M' },
                                { type: 'month', count: 6, text: '6M' },
                                { type: 'year', count: 1, text: '1Y' },
                                { type: 'all', text: 'All' }
                            ],
                            buttonTheme: {
                                width: 38,
                                height: 24,
                                r: 6,
                                fill: '#f5f7fa',
                                stroke: '#dfe5ec',
                                style: { color: '#667085', fontSize: '10px', fontWeight: '700' },
                                states: {
                                    hover: { fill: '#e8f7f3', style: { color: '#087f6b' } },
                                    select: { fill: '#16a085', style: { color: '#ffffff' } }
                                }
                            }
                        },
                        navigator: {
                            enabled: true,
                            height: 38,
                            maskFill: 'rgba(22, 160, 133, 0.08)',
                            outlineColor: '#dfe5ec',
                            handles: { backgroundColor: '#ffffff', borderColor: '#16a085' },
                            series: {
                                type: 'areaspline',
                                color: '#16a085',
                                fillOpacity: 0.08,
                                lineWidth: 1
                            }
                        },
                        scrollbar: { enabled: false },
                        xAxis: {
                            ordinal: false,
                            lineColor: '#dfe5ec',
                            tickColor: '#dfe5ec',
                            gridLineWidth: 1,
                            gridLineColor: '#eef1f5',
                            labels: {
                                format: '{value:%b %Y}',
                                style: { color: '#667085', fontSize: '11px' }
                            }
                        },
                        yAxis: [{
                            opposite: true,
                            gridLineColor: '#edf1f5',
                            lineWidth: 1,
                            lineColor: '#dfe5ec',
                            labels: {
                                align: 'left',
                                x: 8,
                                format: '{value:,.2f}',
                                style: { color: '#667085', fontSize: '11px' }
                            },
                            title: { text: null }
                        }, {
                            opposite: false,
                            gridLineWidth: 0,
                            visible: comparisonPoints.length > 0,
                            labels: {
                                format: '{value:,.2f}',
                                style: { color: '#3b82f6', fontSize: '11px' }
                            },
                            title: { text: null }
                        }],
                        time: { useUTC: false },
                        plotOptions: {
                            candlestick: {
                                color: '#ff5b68',
                                lineColor: '#ff5b68',
                                upColor: '#22b5a2',
                                upLineColor: '#22b5a2',
                                pointPadding: 0.12,
                                groupPadding: 0.08
                            },
                            series: {
                                dataGrouping: { enabled: false },
                                states: { inactive: { opacity: 0.3 } }
                            }
                        },
                        legend: {
                            enabled: comparisonPoints.length > 0,
                            align: 'left',
                            verticalAlign: 'top',
                            itemStyle: { color: '#344054', fontSize: '11px', fontWeight: '700' }
                        },
                        tooltip: {
                            split: false,
                            shared: true,
                            useHTML: true,
                            borderWidth: 0,
                            borderRadius: 10,
                            backgroundColor: 'rgba(255,255,255,0.97)',
                            shadow: {
                                color: 'rgba(15,23,42,0.16)',
                                offsetX: 0,
                                offsetY: 7,
                                opacity: 0.18,
                                width: 14
                            },
                            style: {
                                color: '#172033',
                                width: '225px',
                                fontSize: '11px'
                            },
                            formatter: function() {
                                const hoveredPoints = this.points || [];
                                const candlePoint = hoveredPoints.find((point) => point.series.type === 'candlestick');
                                const linePoint = hoveredPoints.find((point) => point.series.type !== 'candlestick');
                                let html = `<div class="ivn-market-tooltip"><div class="date">${Highcharts.dateFormat('%d %b %Y', this.x)}</div>`;

                                if (candlePoint) {
                                    const point = candlePoint.point;
                                    const change = point.close - point.open;
                                    html += `<div class="name">${primaryName}</div>
                                        <div class="ohlc">
                                            <span>O <b>${Highcharts.numberFormat(point.open, 2)}</b></span>
                                            <span>H <b>${Highcharts.numberFormat(point.high, 2)}</b></span>
                                            <span>L <b>${Highcharts.numberFormat(point.low, 2)}</b></span>
                                            <span>C <b>${Highcharts.numberFormat(point.close, 2)}</b></span>
                                        </div>
                                        <div class="move ${change >= 0 ? 'positive' : 'negative'}">${change >= 0 ? '+' : ''}${Highcharts.numberFormat(change, 2)}</div>`;
                                }

                                if (linePoint) {
                                    html += `<div class="compare"><i style="background:${linePoint.color}"></i><span>${linePoint.series.name}</span><b>${Highcharts.numberFormat(linePoint.y, 2)}</b></div>`;
                                }

                                return html + '</div>';
                            }
                        },
                        series: [{
                            type: 'candlestick',
                            name: primaryName,
                            yAxis: 0,
                            data: candles,
                            showInLegend: false
                        }].concat(comparisonPoints.length ? [{
                            type: 'spline',
                            name: comparisonName,
                            yAxis: 1,
                            data: comparisonPoints,
                            color: '#3b82f6',
                            lineWidth: 2.5,
                            marker: {
                                enabled: true,
                                radius: 3,
                                fillColor: '#3b82f6',
                                lineColor: '#ffffff',
                                lineWidth: 1
                            }
                        }] : [])
                    });
                } catch (error) {
                    console.error('Error parsing or processing graph data:', error);
                }
            }

            initializeChart('indices_graph_1', 'chartContainer_1');
            initializeChart('indices_graph_2', 'chartContainer_2');
            initializeChart('indices_graph_3', 'chartContainer_3');
            initializeChart('indices_graph_4', 'chartContainer_4');
            initializeChart('indices_graph_5', 'chartContainer_5');
            initializeChart('indices_graph_6', 'chartContainer_6');
        });
    </script>
    <style type="text/css">
        .share_pdf {
            position: static;
            display: flex;
            align-items: center;
            justify-content: end;
            gap: 10px;
            padding-bottom: 10px;
        }

        .ivn-trading-card {
            overflow: hidden;
            margin: 20px 0;
            border: 1px solid #dfe5ec;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        }

        .ivn-trading-head {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 16px 18px 10px;
            border-bottom: 1px solid #edf1f5;
        }

        .ivn-trading-name {
            color: #172033;
            font-size: 18px;
            font-weight: 800;
        }

        .ivn-trading-meta {
            margin-top: 3px;
            color: #7b8797;
            font-size: 11px;
        }

        .ivn-trading-quote {
            text-align: right;
        }

        .ivn-trading-quote strong,
        .ivn-trading-quote span {
            display: block;
        }

        .ivn-trading-quote strong {
            color: #172033;
            font-size: 18px;
        }

        .ivn-trading-quote span {
            margin-top: 2px;
            font-size: 12px;
            font-weight: 800;
        }

        .ivn-trading-quote.positive span,
        .ivn-market-tooltip .positive {
            color: #15977f;
        }

        .ivn-trading-quote.negative span,
        .ivn-market-tooltip .negative {
            color: #e34f5d;
        }

        .ivn-market-tooltip {
            box-sizing: border-box;
            width: 205px;
            max-width: 205px;
            padding: 4px 5px;
        }

        .ivn-trading-card .highcharts-tooltip,
        .ivn-trading-card .highcharts-tooltip > span {
            width: 225px !important;
            max-width: 225px !important;
        }

        .ivn-market-tooltip .date {
            color: #8591a2;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .ivn-market-tooltip .name {
            overflow: hidden;
            margin: 5px 0 8px;
            color: #172033;
            font-size: 12px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ivn-market-tooltip .ohlc {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 5px 8px;
            color: #7b8797;
            font-size: 9px;
        }

        .ivn-market-tooltip .ohlc span {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            padding: 5px 6px;
            border-radius: 6px;
            background: #f4f7fa;
        }

        .ivn-market-tooltip .ohlc b {
            color: #344054;
            font-size: 10px;
        }

        .ivn-market-tooltip .move {
            margin-top: 7px;
            font-size: 11px;
            font-weight: 800;
        }

        .ivn-market-tooltip .compare {
            display: grid;
            grid-template-columns: 8px minmax(0, 1fr) auto;
            gap: 7px;
            align-items: center;
            margin-top: 8px;
            padding-top: 7px;
            border-top: 1px solid #edf1f5;
            color: #667085;
            font-size: 10px;
        }

        .ivn-market-tooltip .compare i {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .ivn-market-tooltip .compare span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ivn-market-tooltip .compare b {
            color: #172033;
            font-size: 11px;
        }

        @media (max-width: 767px) {
            .ivn-trading-head {
                display: block;
            }

            .ivn-trading-quote {
                margin-top: 8px;
                text-align: left;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/indices-reports/index-vs-NAV.blade.php ENDPATH**/ ?>