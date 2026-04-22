<?php $__env->startSection('content'); ?>

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
        <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="#">dashboard</a></li>
                    <li><a href="#">filters</a></li>
                    <li>By Composition</li>
                </ul>
            </div>
            <div class="new_page">
            <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                <div class="perform_head">
                    <h2>By Composition</h2>
                </div>
                
                <div class="light_green_bg">
                    <form action=""> 
                            <div class="row">
                            <div class="col-md-3">
                            <div class="form_group radio_btn">
                                    <label>
                                        <input type="radio" name="by" value="return" checked="">
                                        by industry
                                    </label>
                                   </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form_group">
                                    <select>
                                        <option value="">Return</option>
                                        <option value="">Bse 200</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <div class="form_group radio_btn">
                                    <label>
                                        <input type="radio" name="by" value="risk">
                                        by category
                                    </label>
                                   </div>
                            </div>
                           
                            <div class="col-md-3">
                                <div class="form_group">
                                <select>
                                        <option value="">By function</option>
                                        <option value="">Open ended</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <div class="form_group radio_btn">
                                    <label>
                                        <input type="radio" name="by" value="return" checked="">
                                        by AUM (in lacs)
                                    </label>
                                   </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form_group">
                                    <select>
                                        <option value="">Return</option>
                                        <option value="">Bse 200</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <div class="form_group radio_btn">
                                    <label>
                                        <input type="radio" name="by" value="risk">
                                        by scrip
                                    </label>
                                   </div>
                            </div>
                           
                            <div class="col-md-3">
                                <div class="form_group">
                                <select>
                                        <option value="">By function</option>
                                        <option value="">Open ended</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <input type="text" placeholder="Return">
                                </div>
                            </div>
                            
                            <!-- <div class="col-md-12">
                                <div class="bttn_grp">
                                    <button type="submit" id="classification" disabled="">show by classification</button>
                                    <button type="submit" id="fund_type" disabled="">show by fund</button>
                                </div>
                            </div> -->
                        </div>
                    </form>
                </div>

                <div class="fund_section new_fund_section">
                    <ul>
                        <li>
                            <p>Industry report as on  :</p>
                            <span>00/00/0000</span>
                        </li>
                        <li>
                            <p>Fund industry :</p>
                            <span>Return</span>
                        </li>
                        <li>
                            <p>Fund category :</p>
                            <span>abc</span>
                        </li>
                        <li>
                            <p>by AUM (in lacs) :</p>
                            <span>Volatility</span>
                        </li>
                        <li>
                            <p>Top fund :</p>
                            <span>10</span>
                        </li>
                    </ul>
                </div>

                <div class="graph_table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text_left">fund name</th>
                                <th class="text_center">Value</th>
                                <th class="text_center">rank</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text_left">abc</td>
                                <td class="text_right">99.8</td>
                                <td class="text_right">1</td>
                            </tr>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
              
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/filters/composition.blade.php ENDPATH**/ ?>