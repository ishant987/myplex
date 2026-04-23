<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.ratio_dashboard')); ?>">Ratio Reports</a></li>
                        <li>Fund Factsheet</li>
                    </ul>
                </div>
                <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                <div class="perform">

                    <h1 class="page_heading">Fund Factsheet</h1>
                    <div class="perform_head">
                        <h2>Fund Factsheet</h2>
                    </div>
                    <div class="fund_section new_fund_section fund_fact">
                        <form method="GET" action="<?php echo e(route('user.fund_factsheet')); ?>">
                            <div class="light_green_bg">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form_group">
                                            <select class="select2" name="fund_id">
                                                <option>Select Fund</option>
                                                <?php $__currentLoopData = $all_funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($fund->fund_id); ?>"
                                                        <?php echo e(isset($fund_details) && $fund->fund_id == $fund_details->fund_id ? 'selected' : ''); ?>>
                                                        <?php echo e($fund->fund_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form_group">
                                            <input type="date" id="from" class="form-control" name="to_date"
                                                value="<?php echo e(!empty($_GET['to_date']) ? \Carbon\Carbon::parse($_GET['to_date'])->format('Y-m-d') : ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="bttn_grp">
                                            <button type="submit"
                                                class="perform-submit money_title_btn btn">Search</button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </form>

                        <?php if(isset(
                                $top_industries,
                                $AAUMValue,
                                $top_scrips,
                                $fund_details,
                                $jensonAlphaData,
                                $sharpeData,
                                $trackingErrorData,
                                $r_square,
                                $scrip_bias,
                                $industry_bias)): ?>
                            <input type="hidden" value="<?php echo e($top_industries); ?>" id="topIndustriesJson">
                            <input type="hidden" value="<?php echo e($AAUMValue); ?>" id="aaum_values">
                            <input type="hidden" value="<?php echo e($top_scrips); ?>" id="scrip_values">

                            <input type="hidden" value="<?php echo e($fund_details->fund_code); ?>" id="fund_code">
                            <input type="hidden" value="<?php echo e($closest_entry_date); ?>" id="closest_entry_date">
                            <input type="hidden" value="<?php echo e($fund_details->indices_name); ?>" id="indices_name">

                            <ul>
                                <li>
                                    <p>Name Of The Fund :</p>
                                    <span><strong><?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $_GET['fund_id'])); ?></strong></span>
                                </li>
                                <li>
                                    <p>As on :</p> <span>
                                        <?php echo e(isset($_GET['to_date']) ? date('jS F, Y', strtotime($_GET['to_date'])) : ''); ?></span>
                                </li>
                                <li>
                                    <p>Type Of Fund :</p> <span><?php echo e($fund_details->fundtype->name); ?></span>
                                </li>
                                <li>
                                    <p>Fund Opening Date : </p> <span>
                                        <?php echo e(date('jS F, Y', strtotime($fund_details->fund_opened))); ?> </span>
                                </li>
                                <li>
                                    <p>Benchmark : </p> <span><?php echo e($index_name); ?></span>
                                </li>
                                <li>
                                    <p>Fund Manager :</p><span><?php echo e($fund_details->fund_manager); ?></span>
                                </li>
                            </ul>
                    </div>

                    <div class="perform_head no_bg">
                        <h2>Performance Statistics</h2>
                        <div class="share_pdf">
                            <div class="sharethis-inline-share-buttons" style="padding-top: 38px;"></div>
                        </div>
                    </div>

                    <div class="return risk">
                        <h3>Performance Statistics - Returns </h3>

                        <div class="table_scroll">
                            <table class="table return_table">
                                <thead>
                                    <tr>
                                        <th>Ratio</th>
                                        <th class="text_center">6 Month</th>
                                        <th class="text_center">1 Year </th>
                                        <th class="text_center">2 Year </th>
                                        <th class="text_center">3 Year</th>
                                        <th class="text_center">5Yrs/<br>
                                            Inception</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Returns-Scheme</td>
                                        <td>
                                            <span>
                                                <?php echo e(printValue($jensonAlphaData['six_months']['fund_return_absolute'])); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <?php echo e(printValue($jensonAlphaData['one_year']['fund_return_absolute'])); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <?php echo e(printValue($jensonAlphaData['two_year']['fund_return_absolute'])); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <?php echo e(printValue($jensonAlphaData['three_year']['fund_return_absolute'])); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <?php echo e(printValue($jensonAlphaData['five_year']['fund_return_absolute'])); ?>

                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Returns - Index</td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['six_months']['index_return_absolute'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['one_year']['index_return_absolute'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['two_year']['index_return_absolute'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['three_year']['index_return_absolute'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['five_year']['index_return_absolute'])); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jensen’s Alpha</td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['six_months']['jensens_alpha'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['one_year']['jensens_alpha'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['two_year']['jensens_alpha'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['three_year']['jensens_alpha'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['five_year']['jensens_alpha'])); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sharpe</td>
                                        <td><span><?php echo e(printValue($sharpeData['six_months']['sharpe'])); ?></span></td>
                                        <td><span><?php echo e(printValue($sharpeData['one_year']['sharpe'])); ?></span></td>
                                        <td><span><?php echo e(printValue($sharpeData['two_year']['sharpe'])); ?></span></td>
                                        <td><span><?php echo e(printValue($sharpeData['three_year']['sharpe'])); ?></span></td>
                                        <td><span><?php echo e(printValue($sharpeData['five_year']['sharpe'])); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Treynor</td>
                                        <td><span><?php echo e(printValue($treynorData['six_months']['treynor'])); ?></span></td>
                                        <td><span><?php echo e(printValue($treynorData['one_year']['treynor'])); ?></span></td>
                                        <td><span><?php echo e(printValue($treynorData['two_year']['treynor'])); ?></span></td>
                                        <td><span><?php echo e(printValue($treynorData['three_year']['treynor'])); ?></span></td>
                                        <td><span><?php echo e(printValue($treynorData['five_year']['treynor'])); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Information Ratio</td>
                                        <td><span><?php echo e(printValue($information_ratio['six_months'])); ?></span></td>
                                        <td><span><?php echo e(printValue($information_ratio['one_year'])); ?></span></td>
                                        <td><span><?php echo e(printValue($information_ratio['two_year'])); ?></span></td>
                                        <td><span><?php echo e(printValue($information_ratio['three_year'])); ?></span></td>
                                        <td><span><?php echo e(printValue($information_ratio['five_year'])); ?></span></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="return">
                        <h3>Performance Statistics - Risks </h3>

                        <div class="table_scroll">
                            <table class="table return_table">
                                <thead>
                                    <tr>
                                        <th>Ratio</th>
                                        <th class="text_center">6 Month</th>
                                        <th class="text_center">1 Year </th>
                                        <th class="text_center">2 Year </th>
                                        <th class="text_center">3 Year</th>
                                        <th class="text_center">5Yrs/<br>
                                            Inception</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Beta</td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['six_months']['beta'])); ?></span></td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['one_year']['beta'])); ?></span></td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['two_year']['beta'])); ?></span></td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['three_year']['beta'])); ?></span></td>
                                        <td><span><?php echo e(printValue($jensonAlphaData['five_year']['beta'])); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Volatility</td>
                                        <td><span><?php echo e(printValue($sharpeData['six_months']['volatility'])); ?></span></td>
                                        <td><span><?php echo e(printValue($sharpeData['one_year']['volatility'])); ?></span></td>
                                        <td><span><?php echo e(printValue($sharpeData['two_year']['volatility'])); ?></span></td>
                                        <td><span><?php echo e(printValue($sharpeData['three_year']['volatility'])); ?></span></td>
                                        <td><span><?php echo e(printValue($sharpeData['five_year']['volatility'])); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Tracking Error</td>
                                        <td><span><?php echo e(printValue($trackingErrorData['six_months']['tracking_error'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($trackingErrorData['one_year']['tracking_error'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($trackingErrorData['two_year']['tracking_error'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($trackingErrorData['three_year']['tracking_error'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($trackingErrorData['five_year']['tracking_error'])); ?></span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="return risk">
                        <h3>Symmetry </h3>

                        <div class="table_scroll">
                            <table class="table return_table">
                                <thead>
                                    <tr>
                                        <th>Ratio</th>
                                        <th class="text_center">6 Month</th>
                                        <th class="text_center">1 Year </th>
                                        <th class="text_center">2 Year </th>
                                        <th class="text_center">3 Year</th>
                                        <th class="text_center">5Yrs/<br>
                                            Inception</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Skewness</td>
                                        <td><span><?php echo e(printValue($skewness['six_months'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($skewness['one_year'])); ?></span></td>
                                        <td><span><?php echo e(printValue($skewness['two_year'])); ?></span></td>
                                        <td><span><?php echo e(printValue($skewness['three_year'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($skewness['five_year'])); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Kurtosis</td>
                                        <td><span><?php echo e(printValue($kurtosis['six_months'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($kurtosis['one_year'])); ?></span></td>
                                        <td><span><?php echo e(printValue($kurtosis['two_year'])); ?></span></td>
                                        <td><span><?php echo e(printValue($kurtosis['three_year'])); ?></span>
                                        </td>
                                        <td><span><?php echo e(printValue($kurtosis['five_year'])); ?></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="return">
                        <h3>Relation to Index </h4>
                            <div class="table_scroll">
                                <table class="table return_table index_table">
                                    <thead>
                                        <tr>
                                            <th>Ratio</th>
                                            <th>1 Year </th>
                                            <th>2 Year </th>
                                            <th>3 Year</th>
                                            <th>5Yrs/<br>
                                                Inception</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>R Square</td>
                                            <td><span><?php echo e(printValue($r_square['1_year_report']['r_squere'])); ?></span>
                                            </td>
                                            <td><span><?php echo e(printValue($r_square['2_year_report']['r_squere'])); ?></span>
                                            </td>
                                            <td><span><?php echo e(printValue($r_square['3_year_report']['r_squere'])); ?></span>
                                            </td>
                                            <td><span><?php echo e(printValue($r_square['5_year_report']['r_squere'])); ?></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                    </div>

                    <div class="portfolio">
                        <h4>Portfolio</h4>
                        <div class="graph">
                            <div class="two_graph">
                                <h5>Top 10 Holdings (as on
                                    <?php echo e(isset($closest_entry_date) ? date('jS F, Y', strtotime($closest_entry_date)) : ''); ?>)
                                </h5>
                                
                                <ul>

                                    <li id="scrip-chart" style="width:50%; max-width:600px; height:500px;"><img
                                            src="images/bg5.png" alt=""></li>
                                    <li id="myChart" style="width:50%; max-width:600px; height:500px;"></li>
                                </ul>
                            </div>
                            <div class="two_graph graph_table">
                                <h5>Portfolio Bias (as on
                                    <?php echo e(isset($closest_entry_date) ? date('jS F, Y', strtotime($closest_entry_date)) : ''); ?>)
                                </h5>
                                <ul>
                                    <li>
                                        
                                        

                                        <table class="">
                                            <thead>
                                                <tr>
                                                    <th>Scrips</th>
                                                    <th class="text_center">Bias</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="open-popup-factsheet" data-type="scrip"
                                                        data-bias="<?php echo e(printValue($scrip_bias['top_ten_bias'])); ?>"
                                                        data-offset="top_ten">Top Ten(1-10)</td>
                                                    <td class="text_right">
                                                        <?php echo e($scrip_bias['top_ten_bias'] != 0 ? printValue($scrip_bias['top_ten_bias']) : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="open-popup-factsheet" data-type="scrip"
                                                        data-bias="<?php echo e(printValue($scrip_bias['top_twenty_bias'])); ?>"
                                                        data-offset="eleven_to_twenty">Eleven To Twenty(11-20)</td>
                                                    <td class="text_right">
                                                        <?php echo e($scrip_bias['top_twenty_bias'] != null ? printValue($scrip_bias['top_twenty_bias']) : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="open-popup-factsheet" data-type="scrip"
                                                        data-bias="<?php echo e(printValue($scrip_bias['rest_of_bias'])); ?>"
                                                        data-offset="remaining">Bias of remaining</td>
                                                    <td class="text_right">
                                                        <?php echo e($scrip_bias['rest_of_bias'] != null ? printValue($scrip_bias['rest_of_bias']) : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                    <li>
                                        
                                        
                                        <table class="">
                                            <thead>
                                                <tr>
                                                    <th>Industry</th>
                                                    <th class="text_center">Bias</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="open-popup-factsheet" data-type="industry"
                                                        data-bias="<?php echo e(printValue($industry_bias['top_ten_bias'])); ?>"
                                                        data-offset="top_ten">Top Ten(1-10)</td>
                                                    <td class="text_right">
                                                        <?php echo e($industry_bias['top_ten_bias'] != null ? printValue($industry_bias['top_ten_bias']) : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="open-popup-factsheet" data-type="industry"
                                                        data-bias="<?php echo e(printValue($industry_bias['top_twenty_bias'])); ?>"
                                                        data-offset="eleven_to_twenty">Eleven To Twenty(11-20)</td>
                                                    <td class="text_right">
                                                        <?php echo e($industry_bias['top_twenty_bias'] != null ? printValue($industry_bias['top_twenty_bias']) : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="open-popup-factsheet" data-type="industry"
                                                        data-bias="<?php echo e(printValue($industry_bias['rest_of_bias'])); ?>"
                                                        data-offset="remaining">Bias of remaining</td>
                                                    <td class="text_right">
                                                        <?php echo e($industry_bias['rest_of_bias'] != null ? printValue($industry_bias['rest_of_bias']) : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                            </div>

                            <h5 class="text_center">AAUM/Corpus</h5>
                            <div class="single_graph">
                                <div class="aaum mt_15">
                                    <div class="" id="aaum_chart_div" style="height: 500px;">

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="popup-overlay"></div>
            <div class="table_popup">
                <div class="graph_table">
                    <h4 id="popup_title"> Bias </h4>
                    <div class="table_overflow table_height">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Fund Name </th>
                                    <th>% Change </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Equity</td>
                                    <td>Fund</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="close_popup"><i class="fa-solid fa-xmark"></i></button>
            </div>


            <?php if(isset($fund_details) && isset($closest_entry_date)): ?>
                <div class="disclaimer">
                    <p><strong>Note : </strong>For the calculations, the first working day is considered in case of Starting and Ending day.</p>
                </div>
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                </div>
            <?php else: ?>
                <!-- <div class="disclaimer">
                        <p style="text-align: center"><strong>No data found</strong> for that fund on specific date.</p>
                    </div> -->
                <?php echo printNoData(); ?>

            <?php endif; ?>
        </div>
    </div>
    </div>

    <!-- <style>

                    table.table th, table.table tr td:first-child {
                        background: #F39C1A;
                        height: 55px;
                        border-radius: 8px;
                        border: 0;
                        line-height: 18px;
                        font-size: 20px;
                        color: #000;
                        font-weight: 400;
                        padding: 0 20px;
                        display: flex;
                        align-items: center;
                    }

                    table.table tr th:first-child, table.table tr td:first-child {
                            width: 20%;
                        }

                        @media  only screen and (max-width: 1500px) {
                            table.table th, table.table tr td:first-child {
                                height: 36px;
                                border-radius: 6px;
                                line-height: 14px;
                                font-size: 14px;
                                padding: 0 15px;
                            }
                        }

                        table.table th, table.table td {
                            vertical-align: middle;
                            white-space: nowrap;
                            border: 0;
                            width: 15%;
                        }

                    </style> -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart', 'bar']
        });
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawVisualization);
        google.charts.setOnLoadCallback(drawScripChart);

        function drawChart() {

            let topIndustriesJson = $('#topIndustriesJson').val();


            if (topIndustriesJson !== '') {
                let topIndustries = JSON.parse(topIndustriesJson);

                const data = new google.visualization.DataTable();
                data.addColumn('string', 'Industry');
                data.addColumn('number', 'Holdings');

                topIndustries.forEach(industry => {
                    data.addRow([industry.industry, industry.holdings]);
                });

                var decodedTitleElement = document.createElement('div');
                decodedTitleElement.innerHTML = "Top Industry";
                var decodedTitle = decodedTitleElement.innerText;

                const options = {
                    title: decodedTitle,
                    hAxis: {
                        title: 'Industry'
                    },
                    vAxis: {
                        title: 'Holdings'
                    },
                    legend: 'none',
                    colors: ['#16AB6C', '#fcd303']
                };

                const chart = new google.visualization.ColumnChart(document.getElementById('myChart'));
                chart.draw(data, options);
            }
        }

        function drawVisualization() {
            // Some raw data (not necessarily accurate)\
            let aaum_data = $('#aaum_values').val();

            if (aaum_data !== '') {
                var data = google.visualization.arrayToDataTable(JSON.parse(aaum_data));


                var minYWithOffset = JSON.parse(aaum_data)[1][1] - (0.2 * JSON.parse(aaum_data)[1][1]);
                var maxYWithOffset = JSON.parse(aaum_data)[1][1] + (0.2 * JSON.parse(aaum_data)[1][1]);
                var decodedTitleElement = document.createElement('div');
                decodedTitleElement.innerHTML = "<?php echo e($fund_details->fund_name ?? ''); ?>";
                var decodedTitle = decodedTitleElement.innerText;
                var options = {
                    title: decodedTitle,
                    // chartArea: { backgroundColor: '#dcf1ef' }, 
                    // backgroundColor: 'white',
                    vAxis: {
                        format: "0.##" + "' Cr'",
                        baseline: 0,
                        topline: maxYWithOffset
                    },
                    legend: {
                        position: 'bottom'
                    },
                    // vAxis: {
                    //     title: 'Cups'
                    // },
                    // hAxis: {
                    //     title: 'Month'//
                    // },
                    seriesType: 'bars',
                    colors: ['#16AB6C'],
                    is3D: true,
                    series: {
                        5: {
                            type: 'line'
                        }
                    }
                };

                var chart = new google.visualization.ComboChart(document.getElementById('aaum_chart_div'));
                chart.draw(data, options);
            }

        }

        function drawScripChart() {
            let scripJson = $('#scrip_values').val();

            if (scripJson !== '') {
                let scrip = JSON.parse(scripJson);

                const data = new google.visualization.DataTable();
                data.addColumn('string', 'scrip_name');
                data.addColumn('number', 'Holdings');

                scrip.forEach(val => {
                    data.addRow([val.scrip_name, val.content_per]);
                });

                var decodedTitleElement = document.createElement('div');
                decodedTitleElement.innerHTML = "Top Scrips";
                var decodedTitle = decodedTitleElement.innerText;

                const options = {
                    title: decodedTitle,
                    hAxis: {
                        title: 'Scrip Name'
                    },
                    vAxis: {
                        title: 'Holdings'
                    },
                    legend: 'none',
                    colors: ['#16AB6C', '#fcd303']
                };

                const chart = new google.visualization.ColumnChart(document.getElementById('scrip-chart'));
                chart.draw(data, options);
            }

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/ratio-reports/fund_factsheet.blade.php ENDPATH**/ ?>