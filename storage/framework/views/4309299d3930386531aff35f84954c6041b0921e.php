<?php $__env->startSection('content'); ?>

<div class="banner" style="background: url(https://myplexus.com/themes/frontend/assets/v1/img/inner_banner.png)">
    <div class="container">
        <h1>fund watch</h1>
        <h4><?php echo e($fundMaster->fund_name); ?></h4>
    </div>
</div>

<div class="body_main">
    <div class="container">
        <div class="body_content">
            <div class="content_left">
                <h2>Preamble</h2>
                <p class="pre_text"><?php echo $fundWatch->preamble; ?></p>

                <div class="fund_detail mt_15">
                    <div class="single_fund">
                        <h3>Fund Details</h3>
                        <ul>
                            <li><p>Starting Date</p> <i>:</i> <span><?php echo e($schemenamei); ?></span></li>
                            <li><p>Fund Type</p> <i>:</i> <span><?php echo e($fundMaster->classification); ?></span></li>
                            <li><p>Benchmark</p> <i>:</i> <span><?php echo e($fundMaster->indices_name); ?></span></li>
                        </ul>
                    </div>
                    <div class="single_fund">
                        <h3>Management Details</h3>
                        <ul>
                            <li><p>Fund Manager</p> <i>:</i> <span><?php echo e($fundMaster->fund_manager); ?></span></li>
                            <li><p>Schemes Managed</p> <i>:</i> <span><?php echo e($snm); ?></span></li>
                            <li><p>Total Asset Size</p> <i>:</i> <span><?php echo e($crore); ?> Crores</span></li>
                        </ul>
                    </div>
                </div>

                <div class="aaum mt_15">
                    <h3>AAUM Growth</h3>
                    <div class="" id="aaum_chart_div" style="height: 500px;">
                        
                    </div>
                </div>

                <div class="member mt_15">
                    <div class="member_left">
                        <span style="font-size: 15px;">Research Team members</span>
                    </div>
                    <div class="member_right">
                        <ul>
                            <?php 
                                $team = $fundWatch->team;
                                $teamArray = explode(',', $team);
                                $i = 1;
                            ?>
                            <?php $__currentLoopData = $teamArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teamMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="#"><?php echo e($i.'. '.$teamMember); ?></a></li>
                                <?php $i++; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>                                      
                    </div>
                </div>

                <div class="philo mt_15">
                    <div class="philo_single">
                        <h3>Fund Philosophy</h3>
                        <p><?php echo $fundWatch->philosophy; ?></p>
                    </div>
                    <div class="philo_single">
                        <h3>Investment Style</h3>
                        <p><?php echo $fundWatch->investment_style; ?></p>
                    </div>
                </div>

                <div class="perform mt_15">
                    <h2>Performance Parameter</h2>
                    <div class="perform_in">
                        <div class="perform_single">
                            <h5>Lumpsum (Amount Invested | Rs. 1,00,000/-)</h5>
                            <table class="cmn_table">
                                <thead>
                                    <tr>
                                        <th>Time Frame</th>
                                        <th>Amount</th>
                                        <th>Percentage(%)</th>
                                    </tr>
                                </thead>
                                <tbody class="lumsum_table_body">
                                    
                                </tbody>
                            </table>
                            <p>for <= 1 year- absolute returns; for > 1 year- returns using CAGR</p>
                        </div>
                        <div class="perform_single">
                            <h5>SIP (Amount Invested | Rs. 10,000/- Per Month)</h5>
                            <table class="cmn_table">
                                <thead>
                                    <tr>
                                        <th>Amount Invested</th>
                                        <th>Amount</th>
                                        <th>Percentage(%)</th>
                                    </tr>
                                </thead>
                                <tbody class="sip_body">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="perform_in perform_return mt_15">
                        <div class="perform_single">
                            <h5>Return (Continuous)</h5>
                            <table class="cmn_table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="padding: -2px 16px;"><?php echo e($return_date_6_month.' - '.$return_date); ?></th>
                                        <th><?php echo e($return_date_1.' - '.$return_date); ?></th>
                                        <th><?php echo e($return_date_2.' - '.$return_date); ?></th>
                                        <th><?php echo e($return_date_3.' - '.$return_date); ?></th>
                                        <th><?php echo e($return_date_5.' - '.$return_date); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="retunr_continus_table">
                                      
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="perform_single">
                            <h5>Return (Noncontinuous)</h5>
                            <table class="cmn_table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th><?php echo e($return_date_1); ?></th>
                                        <th><?php echo e($return_date_3); ?></th>
                                        <th><?php echo e($return_date_5); ?></th>
                                    </tr>   
                                </thead>
                                <tbody class="retunr_discontinus_table">
                                      
                                </tbody>
                            </table>
                        </div> -->
                    </div>

                    <div class="perform_in perform_return mt_15">
                        <div class="perform_single">
                            <h5>Return (Noncontinuous)</h5>
                            <table class="cmn_table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th><?php echo e($return_date_6_month.' - '.$return_date); ?></th>
                                        <th><?php echo e($return_date_odd_1.' - '.$return_date_6_month); ?></th>
                                        <th><?php echo e($return_date_odd_2.' - '.$return_date_odd_1); ?></th>
                                    </tr>
                                </thead>
                                <tbody class="retunr_discontinus_table">
                                      
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt_15">
                    <p><?php echo $fundWatch->performance_parameter_bottom; ?></p>
                </div>

                <div class="return_less mt_15">
                    <div class="return_less_in">
                        <figure>
                            <div>
                            <h3>Return Less Index</h3>
                            </div>
                            <div id="returnLessIndex_chart_div" style=" border-radius:14px; overflow:hidden; height:300px;">

                            </div>
                        </figure>
                        <figure>
                            <h3>Return Less Index Rank</h3>
                            <div id="index_rank_chart_div" style=" border-radius:14px; overflow:hidden; height:300px;">

                            </div>
                        </figure>
                    </div>
                    <p><?php echo $fundWatch->index_rank_bottom; ?></p>
                </div>

                <div class="rank mt_15">
                    <h3>Quartile, Decile</h3>
                    <div class="rank_in">
                        <div class="rank_left">
                        <div id="rank_quartile_decile_chart_div">

                        </div>
                        </div>
                        <div class="rank_right" style="width: 30%;">
                            <p><?php echo $fundWatch->rank_side; ?></p>
                        </div>
                    </div>
                </div>

                <div class="risk_adjust mt_15">
                    <div class="rist_table_top">
                        <h5>Risk Adjusted Alpha (Jensen's) and The Risk Ratio</h5>
                    </div>
                    <div class="rist_adjust_in">
                    <table class="cmn_table">
                        <thead>
                            <tr>
                                <th>Ratios</th>
                                <th>Jensen’s Alpha</th>
                                <th>Beta</th>
                                <th>Votality</th>
                            </tr>      
                        </thead>
                        <tbody class="risk_alpha_table">
                            
                        </tbody>
                    </table>
                    </div>
                    <p><?php echo $fundWatch->risk_adjust_bottom; ?></p>
                </div>

                <div class="fund_compo mt_15">
                    <h2>Fund Composition Analysis</h2>
                    <p><?php echo $fundWatch->composition_analysis_top; ?></p>
                    <div class="fund_compo_in">
                    <table class="cmn_table">
                        <thead>
                            <tr>
                                <th>Scrip</th>
                                <th><?php echo e($dayn); ?></th>
                                <th><?php echo e($day1n); ?></th>
                                <th><?php echo e($day2n); ?></th>
                                <th><?php echo e($day3n); ?></th>
                                <th><?php echo e($day4n); ?></th>
                            </tr>              
                        </thead>
                        <tbody>
                        <?php if(!empty($fund_scrips) || !empty($fund_scrips1) || !empty($fund_scrips2) || !empty($fund_scrips3) || !empty($fund_scrips4)): ?>
                            <?php for($i = 0; $i<10; $i++): ?>
                            <tr>
                                <td><?php echo e(!empty($fund_scrips[$i]) ? $fund_scrips[$i]->scrip_name : 'NA'); ?></td>
                                <td><?php echo e(!empty($fund_scrips[$i]) ? $fund_scrips[$i]->qty:'NA'); ?></td>
                                <td><?php echo e(!empty($fund_scrips1[$i]) ? $fund_scrips1[$i]->qty:'NA'); ?></td>
                                <td><?php echo e(!empty($fund_scrips2[$i]) ? $fund_scrips2[$i]->qty:'NA'); ?></td>
                                <td><?php echo e(!empty($fund_scrips3[$i]) ? $fund_scrips3[$i]->qty:'NA'); ?></td>
                                <td><?php echo e(!empty($fund_scrips[$i]) ? $fund_scrips4[$i]->qty:'NA'); ?></td>
                            </tr>
                            <?php endfor; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    </div>
                    <p><?php echo $fundWatch->composition_analysis_bottom; ?></p>
                </div>

                <div class="portfolio mt_15">
                    <h3>Portfolio Breakup</h3>
                    <div class="portfolio_in">
                    <!-- <table class="cmn_table port_table">
                        <thead>
                            <tr>
                                <th>Equity</th>
                                <th>Debt</th>
                                <th>SOV</th>
                                <th>Cash</th>
                                <th>Others Currency</th>
                            </tr>          
                        </thead>
                        <tbody class="portfolio_break_up">
                            
                        </tbody>
                    </table> -->

                    <table id="example" class="cmn_table port_up_table" role="grid" style="width: 100%;">
                    <thead class="">
                        <tr>
                            <th colspan="2" rowspan="1" style="background-color: #00665E !important;"></th>
                            <th colspan="2" rowspan="1" style="background-color: #00665E !important;"> Debt </th>
                            <th colspan="4" rowspan="1" style="background-color: #00665E !important;"> Equity </th>
                            <th colspan="2" rowspan="1" style="background-color: #00665E !important;"></th>
                        </tr>
                        <tr>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Name of the Fund : activate to sort column descending" width="20%" style="text-align: left; width: 257px;" aria-sort="ascending"> Name of the Fund</th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Cash% : activate to sort column ascending" width="9%" style="text-align: left; width: 100px;"> Cash% </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Sov% : activate to sort column ascending" width="9%" style="text-align: left; width: 100px;"> Sov% </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Corp Debt% : activate to sort column ascending" style="text-align: left; width: 102px;"> Corp <br>Debt% </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Small Cap% : activate to sort column ascending" style="text-align: left; width: 93px;"> Small <br>Cap% </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Mid Cap% : activate to sort column ascending" style="text-align: left; width: 93px;"> Mid <br>Cap% </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Large Cap% : activate to sort column ascending" style="text-align: left; width: 93px;"> Large<br> Cap% </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Very Large Cap&amp;nbsp;% : activate to sort column ascending" style="text-align: left; width: 103px;"> Very Large<br> Cap&nbsp;% </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Others : activate to sort column ascending" width="9%" style="text-align: left; width: 100px;"> Others </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Wt&amp;nbsp;PE : activate to sort column ascending" width="9%" style="text-align: left; width: 100px;"> Wt&nbsp;PE </th>
                        </tr>
                    </thead>
                        <tbody class="portfolio_break_up">
                        
                        </tbody>
                    </table>

                    </div>
                </div>

                <div class="feedback mt_15">
                    <h3 style="text-transform: math-auto;">myplexus.com Feedback</h3>
                    <p><?php echo $fundWatch->feedback; ?></p>
                </div>

                <p class="discl"><strong>Disclaimer :</strong> <?php echo $disclaimer_text; ?></p>
            </div>     <!--CONTENT LEFT-->    



            <div class="content_right">
                <h2 class="arc">Recent Posts</h2>
                <div class="m_fund">
                    <ul>
                        <?php $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recentPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                        <?php $fund_code_encoded = base64_encode($recentPost->fundDetails->fund_code);  ?>
                        <a href="<?php echo e(url('new-fundwatch')); ?>/<?php echo e($fund_code_encoded); ?>">
                            <?php echo e($recentPost->fundDetails->fund_name); ?>

                        </a>

                            <figure>
                            <a href="<?php echo e(url('new-fundwatch')); ?>/<?php echo e($fund_code_encoded); ?>"><img src="<?php echo e(env('ADMIN_SITE')); ?>/assets/images/<?php echo e($recentPost->logo); ?>" alt=""></a>
                            </figure>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <h2 class="arc arc_new">Archives</h2>
                <div class="m_fund arc_yr">
                    <?php $__currentLoopData = $archiveData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="#"><?php echo e($archive->creation_year); ?> <span>(<?php echo e($archive->record_count); ?>)</span></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="<?php echo e($AAUMValue); ?>" id="aaum_values">
                        <input type="hidden" value="<?php echo e($returnLessIndex); ?>" id="returnLessIndex">
                        <input type="hidden" value="<?php echo e($returnLessIndexRank); ?>" id="returnLessIndexRank">
                        <input type="hidden" value="<?php echo e($getRankQuartileDecile); ?>" id="getRankQuartileDecile">
                        <input type="hidden" value="<?php echo e($fundMaster->fund_code); ?>" id="fund_code">
                        <input type="hidden" value="<?php echo e($fundMaster->fund_type_id); ?>" id="fund_type">
                        <input type="hidden" value="<?php echo e($fundMaster->indices_name); ?>" id="indices_name">
                        <div id="loaging_image" class="d-none">
                            <img  class="text-center mt-3" src="<?php echo e(asset('themes/frontend/assets/v1/img/loading.gif')); ?>" alt="">
                        </div>
<?php $__env->startPush('scripts'); ?>
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
                        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                        <script type="text/javascript">
                        let loadingImage='<img  class="text-center mt-3" src="<?php echo e(asset('themes/frontend/assets/v1/img/loading.gif')); ?>" alt="">';
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawVisualization);
                            google.charts.setOnLoadCallback(drawreturnLessIndex);
                            google.charts.setOnLoadCallback(drawReturnLessIndexRank);
                            google.charts.setOnLoadCallback(drawRankQuartileDecile);

                            let fund_code = $('#fund_code').val();
                            let indices_name = $('#indices_name').val();
                            let fund_type = $('#fund_type').val();
                            getReturnLessRank();
                            getFundCompostion();
                            schemeSIP();
                            getLumSum();
                            getRiskAdjustedAlpha();
                            getReturnContinus();
							getReturndisContinus();
                            getPortfolioBreakUp();

                            

                            function drawVisualization() {
                                // Some raw data (not necessarily accurate)\
                                let aaum_data = $('#aaum_values').val();
								console.log('aaum_data : ',aaum_data);
                                var data = google.visualization.arrayToDataTable(JSON.parse(aaum_data));
								
								
								var minYWithOffset = JSON.parse(aaum_data)[1][1] - (0.2 * JSON.parse(aaum_data)[1][1]);
								var maxYWithOffset = JSON.parse(aaum_data)[1][1] + (0.2 * JSON.parse(aaum_data)[1][1]);
								var decodedTitleElement = document.createElement('div');
                                decodedTitleElement.innerHTML = "<?php echo e($fundMaster->fund_name); ?>";
                                var decodedTitle = decodedTitleElement.innerText;
                                var options = {
                                    title: decodedTitle,
									// chartArea: { backgroundColor: '#dcf1ef' }, 
									// backgroundColor: 'white',
									vAxis: {
                                         format: "0.##"+"' Cr'",
										baseline: 0,
										topline:maxYWithOffset
                                     },
									legend: {position: 'bottom'},
                                    // vAxis: {
                                    //     title: 'Cups'
                                    // },
                                    // hAxis: {
                                    //     title: 'Month'//
                                    // },
                                    seriesType: 'bars',
                                    colors: ['#16AB6C'],
                                    is3D:true,
                                    series: {
                                        5: {
                                            type: 'line'
                                        }
                                    }
                                };

                                var chart = new google.visualization.ComboChart(document.getElementById('aaum_chart_div'));
                                chart.draw(data, options);
                            }

                            function drawreturnLessIndex() {
                                // Some raw data (not necessarily accurate)\
                                let returnLessIndex = $('#returnLessIndex').val();
                                var data = google.visualization.arrayToDataTable(JSON.parse(returnLessIndex));
                                console.log('return less index data : ', data);
                                var decodedTitleElement = document.createElement('div');
                                decodedTitleElement.innerHTML = "<?php echo e($fundMaster->fund_name); ?>";
                                var decodedTitle = decodedTitleElement.innerText;
                                var options = {
                                    title: decodedTitle,
                                     vAxis: {
                                         format: "0.##"+"'%'",
                                         title: 'Value'
                                     },
									// chartArea: { backgroundColor: '#dcf1ef' }, 
									// backgroundColor: 'white',
									legend: {position: 'bottom'},
                                    hAxis: {
                                         title: 'Years',
                                    },
                                    seriesType: 'bars',
                                    colors: ['#16AB6C'],
                                    is3D:true,
                                    series: {
                                        5: {
                                            type: 'column'
                                        }
                                    }
                                };

                                var chartContainer = document.getElementById('returnLessIndex_chart_div');
                                var chart = new google.visualization.ComboChart(document.getElementById('returnLessIndex_chart_div'));
                                chart.draw(data, options);

                                chartContainer.style.borderRadius = '15px';
                            }


                            //new chart starts here.....
                            // function drawReturnLessIndexRank() {
                            //     let returnLessIndexRank = $('#returnLessIndexRank').val();
                            //     console.log('returnLessIndexRank : ',returnLessIndexRank);

                            //     var data = new google.visualization.DataTable();
                            //     data.addColumn('string', 'Time Span');
                            //     data.addColumn('number', 'Rank');
                            //     // data.addRows([
                            //     //     ['6 Months', 4],
                            //     //     ['1 Year', 1],
                            //     //     ['2 Years', 3],
                            //     //     ['3 Years', 2],
                            //     //     ['5 Years', 10]
                            //     // ]);
                            //     returnLessIndexRank.forEach(function(row) {
                            //         console.log('row: ', row);
                            //         data.addRow([row[0], row[1]]);
                            //     });
                            
                            //     // Set chart options
                            //     var options = {
                            //         title: '<?php echo e($fundMaster->fund_name); ?>',
                            //         curveType: 'function',
                            //         legend: { position: 'none' },
                            //         hAxis: {
                            //         title: 'Time Span'
                            //         },
                            //         vAxis: {
                            //         title: 'Rank',
                            //         direction: -1 // Reverse the direction of the vertical axis
                            //         },
                            //         lineWidth: 2.5
                            //     };

                            //     // Instantiate and draw the chart
                            //     var chart = new google.visualization.LineChart(document.getElementById('index_rank_chart_div'));
                            //     chart.draw(data, options);
                            // }

                            function drawReturnLessIndexRank() {
                                let returnLessIndexRankJson = $('#returnLessIndexRank').val();
                                let returnLessIndexRank = JSON.parse(returnLessIndexRankJson);
                                console.log('returnLessIndexRank : ', returnLessIndexRank);

                                var data = new google.visualization.DataTable();
                                data.addColumn('string', 'Time Span');
                                data.addColumn('number', 'Rank');

                                // Iterate over the JSON-encoded data
                                for (let key in returnLessIndexRank) {
                                    if (returnLessIndexRank.hasOwnProperty(key)) {
                                        let value = returnLessIndexRank[key];
                                        data.addRow([key, value]);
                                    }
                                }

                                // Set chart options
                                var decodedTitleElement = document.createElement('div');
                                decodedTitleElement.innerHTML = "<?php echo e($fundMaster->fund_name); ?>";
                                var decodedTitle = decodedTitleElement.innerText;
                                var options = {
                                    title: decodedTitle,
                                    curveType: 'function',
                                    legend: { position: 'none' },
                                    hAxis: {
                                        title: 'Years'
                                    },
                                    vAxis: {
                                        title: 'Rank',
                                        baseline: 0,
                                        // direction: -1, // Reverse the direction of the vertical axis
                                    },
                                    // lineWidth: 2.5,
                                    colors: ['#16AB6C'],
                                };

                                // Instantiate and draw the chart
                                var chart = new google.visualization.ColumnChart(document.getElementById('index_rank_chart_div'));
                                chart.draw(data, options);
                            }

                            // function drawRankQuartileDecile() {
                            //     // Parse the JSON data
                            //     var jsonData = JSON.parse($('#getRankQuartileDecile').val());
                            //     console.log('Quartile decile Data: ', jsonData);
                            //     // Create the data table.
                            //     var data = new google.visualization.DataTable();
                            //     data.addColumn('string', 'Time Span');
                            //     // data.addColumn('number', 'Rank');
                            //     data.addColumn('number', 'Quartile');
                            //     data.addColumn('number', 'Decile');

                            //     // Add rows to the data table.
                            //     for (var timeSpan in jsonData) {
                            //         if (jsonData.hasOwnProperty(timeSpan)) {
                            //             data.addRow([timeSpan, jsonData[timeSpan].quartile, jsonData[timeSpan].decile]);
                            //         }
                            //     }
                            //     // console.log('jsonData : ', data);
                            //     // Set chart options.
                            //     var decodedTitleElement = document.createElement('div');
                            //     decodedTitleElement.innerHTML = "<?php echo e($fundMaster->fund_name); ?>";
                            //     var decodedTitle = decodedTitleElement.innerText;
                            //     var options = {
                            //         title: decodedTitle,
                            //         width: 600,
                            //         height: 300,
                            //         legend: { position: 'top' },
                            //         bars: 'vertical', // vertical bars
                            //         colors: ['#16AB6C', '#fcd303'] // specify custom colors for each series
                            //     };

                            //     // Instantiate and draw the chart.
                            //     var chart = new google.visualization.ColumnChart(document.getElementById('rank_quartile_decile_chart_div'));
                            //     chart.draw(data, options);
                            // }

                            function drawRankQuartileDecile() {
                                // Parse the JSON data
                                var jsonData = JSON.parse($('#getRankQuartileDecile').val());
                                console.log('Quartile decile Data: ', jsonData);
                                // Create the data table.
                                var data = new google.visualization.DataTable();
                                data.addColumn('number', 'Quartile');
                                data.addColumn('number', 'Decile');

                                // Add rows to the data table.
                                for (var timeSpan in jsonData) {
                                    if (jsonData.hasOwnProperty(timeSpan)) {
                                        data.addRow([jsonData[timeSpan].quartile, jsonData[timeSpan].decile]);
                                    }
                                }

                                // Set chart options.
                                var decodedTitleElement = document.createElement('div');
                                decodedTitleElement.innerHTML = "<?php echo e($fundMaster->fund_name); ?>";
                                var decodedTitle = decodedTitleElement.innerText;
                                var options = {
                                    title: decodedTitle,
                                    width: 600,
                                    height: 300,
                                    legend: { position: 'top' },
                                    colors: ['#16AB6C', '#fcd303'] // specify custom colors for each series
                                };

                                // Instantiate and draw the chart as a Histogram.
                                var chart = new google.visualization.Histogram(document.getElementById('rank_quartile_decile_chart_div'));
                                chart.draw(data, options);
                            }

                            

                            //new chart ends here.....

                            function getFundCompostion() {
                                $('.comp_html').html(loadingImage);
                                axios.get('https://myplexus.com/fund-watch/fund-compositon/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.comp_html').html(res.data.html);
                                        }
                                    })
                            }

                            function getLumSum() {
                                $('.lumsum_table_body').html(loadingImage);
                                axios.get('https://myplexus.com/fund-watch/fund-lumsum/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.lumsum_table_body').html(res.data.html);
                                        }
                                    })
                            }

                            function getRiskAdjustedAlpha() {
                                $('.risk_alpha_table').html(loadingImage);
                                axios.get('https://myplexus.com/fund-watch/fund-risk-alpha/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.risk_alpha_table').html(res.data.html);
                                        }
                                    })
                            }

                            /*
                            function getPortfolioBreakUp() {
                                $('.portfolio_break_up').html(loadingImage);
                                axios.get('/fund-watch/fund-portfolio-break-up/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.portfolio_break_up').html(res.data.html);
                                        }
                                    })
                            }
                            */

                            
                            function getPortfolioBreakUp() {
                                $('.portfolio_break_up').html(loadingImage);
                                axios.get('https://www.myplexus.com/api/v1/fund-composition-snapshot-fund-watch/' +fund_code)
                                    .then(res => {
                                        //console.log(res.data.success);
                                        if (res.data.success == true) {
                                            let html = "";
                                           html += `<tr role="row">`;
                                            html += `<td data-label="Name of the Fund" class="sorting_1">${res.data.data.composition_snapshot_fundwatch[0].fund_name}</td>`;
                                            html += `<td data-label="Cash %">${res.data.data.composition_snapshot_fundwatch[0].cash.toFixed(2)}</td>`;
                                            html += `<td data-label="Sov %">${res.data.data.composition_snapshot_fundwatch[0].sov.toFixed(2)}</td>`;
                                            html += `<td data-label="Corp Debt %">${res.data.data.composition_snapshot_fundwatch[0].debt.toFixed(2)}</td>`;
                                            html += `<td data-label="Small Cap %">${res.data.data.composition_snapshot_fundwatch[0].eq_small.toFixed(2)}</td>`;
                                            html += `<td data-label="Mid Cap %">${res.data.data.composition_snapshot_fundwatch[0].eq_mid.toFixed(2)}</td>`;
                                            html += `<td data-label="Large Cap %">${res.data.data.composition_snapshot_fundwatch[0].eq_large.toFixed(2)}</td>`;
                                            html += `<td data-label="Very Large Cap %">${res.data.data.composition_snapshot_fundwatch[0].eq_very_large.toFixed(2)}</td>`;
                                            html += `<td data-label="Others value">${res.data.data.composition_snapshot_fundwatch[0].others_val.toFixed(2)}</td>`;
                                            html += `<td data-label="Wt . PE">${res.data.data.composition_snapshot_fundwatch[0].wt_pe.toFixed(2)}</td>`;
                                            html += `</tr>`;
											
											//console.log(html);

                                            $('.portfolio_break_up').html(html);
                                        } 
                                    })
                            }
                        

                            function getReturnContinus() {
                                $('#retunr_continus_table').html(loadingImage);
                                axios.get('https://myplexus.com/fund-watch/fund-return-continus/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            // alert('Continious data fetched!');
                                            $('#retunr_continus_table').html(res.data.html);
                                        }
                                    })
                            }
                            

							function getReturndisContinus() {
                                $('.retunr_discontinus_table').html(loadingImage);
                                axios.get('https://myplexus.com/fund-watch/fund-return-discontinus/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.retunr_discontinus_table').html(res.data.html);
                                        }
                                    })
                            }

                            function getReturnLessRank() {
                                $('.return_less_rank_table').html(loadingImage);
                                axios.get('https://myplexus.com/fund-watch/fund-return-less-rank/' + fund_code + '/' + fund_type + '/' + indices_name)
                                    .then(res => {
										console.log(fund_type + indices_name);
                                        if (res.data.status == 'success') {
                                            $('.return_less_rank_table').html(res.data.html);
                                        }
                                    })
                            }
                            async function schemeSIP() {
                                $('.sip_body').html(loadingImage);
                                await axios.get('https://myplexus.com/fund-watch/fund-sip/' + fund_code)
                                    .then(response => {
                                        let sipDataArr = response.data.scheme_sip_data
                                        for (var keyDur of Object.keys(sipDataArr)) {

                                            let all_values = JSON.parse(sipDataArr[keyDur].ALLVALUES)
                                            let all_dates = JSON.parse(sipDataArr[keyDur].ALLDATES)
                                            let sip_return = calculate_sip(all_dates, all_values)
                                            if (isNaN(sip_return)) {
                                                sip_return = '';
                                            } else {
                                                sip_return = parseFloat(sip_return).toFixed(2);
                                            }
											console.log(sip_return);
                                            sipDataArr[keyDur].sip_return = sip_return
                                        }
                                        let SIPHTML = '';
                                        $.each(sipDataArr, function(key, val) {
                                            SIPHTML += '<tr>';
                                            SIPHTML += '<td data-label="Time Frame">' + key + '</td>';
                                            SIPHTML += '<td data-label="Amount">' + parseFloat(val.CURRENTVALUE).toFixed(0) + '</td>';
                                            SIPHTML += '<td data-label="Percentage %"> ' + val.sip_return + '%</td>';
                                            SIPHTML += '</tr>';
                                        });
                                        $('.sip_body').html(SIPHTML);
                                        // console.log(sipDataArr, SIPHTML);
                                    })
                                    .catch(error => {
                                        //var message = error.response.data.message || error.message
                                        //console.log(error);
                                    })
                                    .finally(() => {
                                        // that.process = false
                                    })
                            }

                            function calculate_sip(dates, values) {
                                //alert(dates+' '+values);
                                var x = XIRR(values, dates, 0.1);
                                //alert(x);
                                x = x * 100;
                                //document.write(x);
                                return x;
                            }

                            function XIRR(values, dates, guess) {
                                // Credits: algorithm inspired by Apache OpenOffice

                                // Calculates the resulting amount
                                var irrResult = function(values, dates, rate) {
                                    var r = rate + 1;
                                    var result = values[0];
                                    for (var i = 1; i < values.length; i++) {
                                        result += values[i] / Math.pow(r, moment(dates[i]).diff(moment(dates[0]), 'days') / 365);
                                    }
                                    return result;
                                }

                                // Calculates the first derivation
                                var irrResultDeriv = function(values, dates, rate) {
                                    var r = rate + 1;
                                    var result = 0;
                                    for (var i = 1; i < values.length; i++) {
                                        var frac = moment(dates[i]).diff(moment(dates[0]), 'days') / 365;
                                        result -= frac * values[i] / Math.pow(r, frac + 1);
                                    }
                                    return result;
                                }

                                // Check that values contains at least one positive value and one negative value
                                var positive = false;
                                var negative = false;
                                for (var i = 0; i < values.length; i++) {
                                    if (values[i] > 0) positive = true;
                                    if (values[i] < 0) negative = true;
                                }

                                // Return error if values does not contain at least one positive value and one negative value
                                if (!positive || !negative) return '#NUM!';

                                // Initialize guess and resultRate
                                var guess = (typeof guess === 'undefined') ? 0.1 : guess;
                                var resultRate = guess;

                                // Set maximum epsilon for end of iteration
                                var epsMax = 1e-10;

                                // Set maximum number of iterations
                                var iterMax = 60;

                                // Implement Newton's method
                                var newRate, epsRate, resultValue;
                                var iteration = 0;
                                var contLoop = true;
                                do {
                                    resultValue = irrResult(values, dates, resultRate);
                                    newRate = resultRate - resultValue / irrResultDeriv(values, dates, resultRate);
                                    epsRate = Math.abs(newRate - resultRate);
                                    resultRate = newRate;
                                    contLoop = (epsRate > epsMax) && (Math.abs(resultValue) > epsMax);
                                } while (contLoop && (++iteration < iterMax));
                                if (contLoop) return '#NUM!';
                                // Return internal rate of return
                                return resultRate;
                            }
                        </script>
                    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/new-fundwatch.blade.php ENDPATH**/ ?>