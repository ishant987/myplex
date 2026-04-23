<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="perform">
                    <div class="head_brdcm">
                        <!-- subscription test start -->
                       

                        <!-- subscription test end -->
                    </div>
                    <div class="perform_head">
                        <h2>Performance Statistics</h2>
                    </div>
                    <div class="fund_section">
                        <div class="perform_right">
                            <select>
                                <option>Select Fund</option>
                                <option>Fund 1</option>
                                <option>Fund 2</option>
                            </select>
                            <input type="text" id="datepicker" value="As on" class="hasDatepicker">
                        </div>
                        
                        <ul>
                            <li><p>Type Of Fund :</p> <span>Open Ended FoF Domestic</span>&nbsp;</li>
                            <li><p>Benchmark : </p> <span>S&amp;P CNX 500</span>&nbsp;</li>
                            <li><p>Fund Manager  :</p><span>Vinod Bhat</span>&nbsp;</li>
                            <li><p>Fund Opening Date : </p> <span>02/04/2016&nbsp;</span>&nbsp;</li>
                        </ul>
                    </div>

                    <div class="return">
                        <h3>Performance Statistics - Returns</h3>

                        <div class="table_scroll">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ratio</th>
                                        <th>6 Month</th>
                                        <th>1 Year </th>
                                        <th>2 Year </th>
                                        <th>3 Year</th>
                                        <th>5Yrs/<br>
                                            Inception</th>
                                    </tr>                                                                                             
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Returns</td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                    </tr>
                                    <tr>
                                        <td>Returns - Index</td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                    </tr>
                                    <tr>
                                        <td>Jensen’s Alpha</td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                    </tr>
                                    <tr>
                                        <td>Sharpe</td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                    </tr>
                                    <tr>
                                        <td>Treynorr</td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="return risk">
                        <h3>Performance Statistics - Risks</h3>

                        <div class="table_scroll">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ratio</th>
                                        <th>6 Month</th>
                                        <th>1 Year </th>
                                        <th>2 Year </th>
                                        <th>3 Year</th>
                                        <th>5Yrs/<br>
                                            Inception</th>
                                    </tr>                                                                                             
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Beta</td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                    </tr>
                                    <tr>
                                        <td>Volatility</td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                    </tr>
                                    <tr>
                                        <td>Traking Error</td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                        <td><span>000</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="graph">
                        <h4>Relation to Index</h4>
                        <div class="single_graph">
                            <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/c1.png')); ?>" alt="">
                        </div>
                        <h4>Returns Symetry</h4>
                        <div class="two_graph">
                            <ul>
                                <li><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/c2.png')); ?>" alt=""></li>
                                <li><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/c3.png')); ?>" alt=""></li> 
                            </ul>
                        </div>
                    </div>

                    <div class="portfolio">
                        <h4>Portfolio</h4>
                        <div class="graph">
                            <div class="two_graph">
                                <h5>Top Holdings</h5>
                                <ul>
                                    <li><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/bg4.png')); ?>" alt=""></li>
                                    <li><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/bg5.png')); ?>" alt=""></li>
                                </ul>
                            </div>
                            <div class="two_graph graph_table">
                                <h5>Portfolio Bias</h5>
                                <ul>
                                    <li>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Stock</th>
                                                    <th>Index</th>
                                                    <th>Bias</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                    <li>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Stock</th>
                                                    <th>Index</th>
                                                    <th>Bias</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                            </div>

                            <h5 class="text_center">AAUM/Corpus</h5>
                            <div class="single_graph">
                                <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/c4.png')); ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
            

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/ratio.blade.php ENDPATH**/ ?>