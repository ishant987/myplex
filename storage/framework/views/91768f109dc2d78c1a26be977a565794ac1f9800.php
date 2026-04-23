<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.indices_report')); ?>">indices report</a></li>
                        <li>Boomers</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form_group">
                                        <select class="select2" name="indices[]" data-placeholder="Select Indices">
                                            <option value="">Select Indices</option>
                                            <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($index->corelation); ?>"
                                                    <?php if(isset($indices_name) && in_array($index->corelation, $indices_name)): ?> selected <?php endif; ?>>
                                                    <?php echo e($index->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php $__errorArgs = ['indices'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form_group">
                                        <input type="number" name="limit" placeholder="Limit" value="<?php echo e(isset($limit)?$limit:''); ?>">

                                        <?php $__errorArgs = ['limit'];
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

                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>1st period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="month" id="month" required data-placeholder="Select month">
                                                    <option value="">select month</option>
                                                    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($m); ?>"
                                                            <?php echo e(isset($month) && $month == $m ? 'selected' : ''); ?>>
                                                            <?php echo e(date('F', mktime(0, 0, 0, $m, 10))); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__errorArgs = ['month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="year" id="year" required onchange="get_second_month_year(this.value)" data-placeholder="Select Year">
                                                    <option value="">select year</option>
                                                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($y); ?>"<?php echo e(isset($year) && $year == $y ? 'selected' : ''); ?>>
                                                            <?php echo e($y); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>2nd period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="month_second" id="month_second" required
                                                    onchange="get_second_period(this.value)" data-placeholder="Select Month">
                                                    <option value="">select month</option>
                                                    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($m); ?>"
                                                            <?php echo e(isset($month_second) && $month_second == $m ? 'selected' : ''); ?>>
                                                            <?php echo e(date('F', mktime(0, 0, 0, $m, 10))); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__errorArgs = ['month_second'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="year_second" id="year_second" required data-placeholder="Select Year">
                                                    <option value="">select year</option>
                                                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($y); ?>"<?php echo e(isset($year_second) && $year_second == $y ? 'selected' : ''); ?>>
                                                            <?php echo e($y); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__errorArgs = ['year_second'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>

                <?php if(isset($month) && isset($month_second) && isset($year) && isset($year_second) && isset($limit)): ?>
                <div class="wm_tab">
                    <ul class="tabs">
                        <li>
                            <a class="active" href="javascript:void(0)">Scrip</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">Industry</a>
                        </li>
                    </ul>
                </div>

                <div class="tabsct">
                    <div class="tab">
                        <div class="fund_section new_fund_section">
                            <ul>
                                <?php if(isset($month) && isset($month_second) && isset($year) && isset($year_second) ): ?>
                                <li>
                                    <p>Scrips Boomers :</p>
                                    <span>For the month of
                                        <?php echo e(isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A'); ?>,
                                        <?php echo e(isset($year) ? $year : 'N/A'); ?> to
                                        <?php echo e(isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A'); ?>,
                                        <?php echo e(isset($year_second) ? $year_second : 'N/A'); ?></span>
                                </li>
                                <?php endif; ?>

                                <?php if(isset($limit)): ?>
                                <li>
                                    <p>Limit :</p>
                                    <span><?php echo e($limit ?? ''); ?></span>
                                </li>
                                <?php endif; ?>

                                <?php if(isset($indices_records) && count($indices_records)>0): ?>
                                <li>
                                    <p>Indices :</p>
                                    <?php $__currentLoopData = $indices_records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><?php echo e($val->name." , "); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </li>
                                <?php endif; ?>
                              
                            </ul>
                        </div>

                        <div class="graph_table">
                            <div class="share_pdf">
                                
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF-indices-scrip" class="pdf"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>" ></a>
                                
                            </div>
                            <table class="table datatable" id="pdfData-indices-scrip">
                                <thead>
                                    <tr>
                                        <th class="text_left">name of the Scrip </th>
                                        <th class="text_center">Percentage change</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($results_scrips)): ?>
                                        <?php $__currentLoopData = $results_scrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php if($item->percentage_new !=0 && $item->percentage_old !=0): ?>
                                        <?php                                        

                                          $scrip_percentage = (((floatval($item->percentage_new)) - (floatval($item->percentage_old)))/(floatval($item->percentage_old)))*100;
                                        ?>

                                           <?php if(($scrip_percentage >0) && ($scrip_percentage >= $limit)): ?> 
                                            <tr>
                                                

                                                <td class="text_left" correlation_new = <?php echo e($item->correlation_new); ?>><?php echo e($item->scrip_name); ?></td>
                                                <td class="text_right"><?php echo e(number_format($scrip_percentage,2)); ?></td>
                                            </tr>                                            
                                            <?php endif; ?>
                                           <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="2">No information available for this search</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>



                        


                        <!-- <div class="popup-overlay"></div> -->
                        

                    </div>
                    <div class="tab">
                        <div class="fund_section new_fund_section">
                            <ul>
                                <?php if(isset($month) && isset($month_second) && isset($year) && isset($year_second) ): ?>
                                <li>
                                    <p>Industries Boomers :</p>
                                    <span>For the month of
                                        <?php echo e(isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A'); ?>,
                                        <?php echo e(isset($year) ? $year : 'N/A'); ?> to
                                        <?php echo e(isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A'); ?>,
                                        <?php echo e(isset($year_second) ? $year_second : 'N/A'); ?></span>
                                </li>
                                <?php endif; ?>

                                <?php if(isset($limit)): ?>
                                <li>
                                    <p>Limit :</p>
                                    <span><?php echo e($limit ?? ''); ?></span>
                                </li>
                                <?php endif; ?>

                                <?php if(isset($indices_records) && count($indices_records)>0): ?>
                                <li>
                                    <p>Indices :</p>
                                    <?php $__currentLoopData = $indices_records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><?php echo e($val->name." , "); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </li>
                                <?php endif; ?>
                              
                            </ul>
                        </div>

                        <div class="graph_table">

                            <div class="share_pdf">
                                
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF-indices-industry" class="pdf"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>" ></a>
                                
                            </div>
                            <table class="table datatable" id="pdfData-indices-industry">
                                <thead>
                                    <tr>
                                        <th class="text_left">name of the Industry </th>
                                        <th class="text_center">Percentage change</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($results_industry)): ?>
                                        <?php $__currentLoopData = $results_industry; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($item->percentage_new !=0 && $item->percentage_old !=0): ?>
                                        <?php
                                        $industry_percentage = (((floatval($item->percentage_new)) - (floatval($item->percentage_old)))/(floatval($item->percentage_old)))*100;
                                      ?>

                                        <?php if(($industry_percentage > 0) && ($industry_percentage >= $limit)): ?>

                                            

                                            <tr>
                                                <td class="text_left" correlation_new = <?php echo e($item->correlation_new); ?>><?php echo e($item->industry); ?></td>
                                                <td class="text_right"><?php echo e(number_format($industry_percentage,2)); ?></td>
                                            </tr>
                                       
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2">No information available for this search</td>
                                        </tr>
                                    <?php endif; ?>


                                </tbody>
                            </table>
                        </div>

                        


                        <!-- <div class="popup-overlay"></div> -->
                        
                    </div>
                </div>
                <?php else: ?>
                <?php echo printNoData(); ?>

                <?php endif; ?>


            </div>
            <?php if(isset($results_industry)): ?>
            <div class="disclaimer">
                <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
            </div>
          <?php endif; ?>
        </div>
    </div>

    </div>
<?php $__env->stopSection(); ?>

<script>
    function get_classification(thiss) {

        if (thiss == 'classification') {

            $('#fund_type_div').removeAttr('style');
            $('#fund_type').prop('required', true);


            $('#fund_master').prop('required', false);
            $('#fund_master').val('0');


            $('#fund_name_div').attr('style', 'display:none');

        } else if (thiss == 'fund') {

            $('#fund_type_div').attr('style', 'display:none');
            $('#fund_type').prop('required', false);

            $('#fund_type').val('0');


            $('#fund_master').prop('required', true);

            $('#fund_name_div').removeAttr('style');


        }


    }


    function get_second_month_year(thiss){

        console.log(thiss);

var first_year = thiss;

var first_month = parseInt($('#month').val());

console.log(first_month);


var currentDate = new Date();

// Get the current year
var currentYear = currentDate.getFullYear();

// Get the current month number (0-11, where 0 is January and 11 is December)
var currentMonth = currentDate.getMonth() + 1; //
console.log(currentYear+'  '+currentMonth);
var month_opt = '';
var year_opt ='';

if((first_year == currentYear) && (first_month == currentMonth)){     //for 2nd month//

    

        month_opt += '<option value="">Please select proper first period month</option>';

        year_opt += '<option value="">Please select proper first period year</option>';



    } else if((first_year < currentYear) && (first_month <= currentMonth)){

    for(var i =currentYear ; i >= first_year; i--) {
        
        year_opt += '<option value="' + i + '">' + i + '</option>';
    }


    for(var m = 1; m<=12; m++){

        month_opt += '<option value="' + m + '">' + getMonthName(m) + '</option>';

        }




}else if((first_year == currentYear) && (first_month <= currentMonth)){

    
        
        year_opt += '<option value="' + first_year + '">' + first_year + '</option>';
    


    for(var m = (first_month+1); m<= currentMonth; m++){

        month_opt += '<option value="' + m + '">' + getMonthName(m) + '</option>';

        }


}

$('#month_second').html(month_opt);

$('#year_second').html(year_opt);




}



function get_second_period(second_month) 
{

var first_month = parseInt($('#month').val());
var first_year = parseInt($('#year').val());

 var currentDate = new Date();

// Get the current year
var currentYear = currentDate.getFullYear();

// Get the current month number (0-11, where 0 is January and 11 is December)
var currentMonth = currentDate.getMonth() + 1; //

var options = '';

if(second_month > first_month) {
    for(var i = currentYear; i >= (first_year); i--) {
        
        options += '<option value="' + i + '">' + i + '</option>';
    }

}

else{

    for(var i =currentYear ; i >= (first_year+1); i--) {
        options += '<option value="' + i + '">' + i + '</option>';
    }

}

$('#year_second').html(options);

}

function getMonthName(monthNumber) {

var monthNames = [
"January", "February", "March", "April", "May", "June",
"July", "August", "September", "October", "November", "December"
];
// Subtract 1 from monthNumber to get the correct index (0-11)
return monthNames[monthNumber - 1];
}





    document.addEventListener('DOMContentLoaded', function() 
    {
        var exportButton = document.getElementById('exportPDF-indices-scrip');

        exportButton.addEventListener('click', function() 
        {
            var { jsPDF } = window.jspdf;
            var doc = new jsPDF();

            // Add Image (Logo)
            var img = new Image();
            img.src = "<?php echo e(asset('themes/frontend/assets/infosolz/images/small_logo.png')); ?>";
            img.onload = function() 
            {
                var pageWidth = doc.internal.pageSize.getWidth();
                var imgWidth = 50;
                var imgHeight = 20;
                var centerX = (pageWidth - imgWidth) / 2;

                doc.addImage(img, 'PNG', centerX, 10, imgWidth, imgHeight);

                // Add Title below the logo
                doc.setFontSize(16);
                doc.setTextColor(45, 135, 23);
                doc.text('Indices Boomers Scrip', pageWidth / 2, 40, { align: 'center' });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                var lineHeight = 10;
                var yPosition = 70;

                <?php if(isset($month) && isset($month_second) && isset($year) && isset($year_second)): ?>
                    var scripsBoomersText = `Scrips Boomers: For the month of <?php echo e(date('F', mktime(0, 0, 0, $month, 10))); ?>, <?php echo e($year); ?> to <?php echo e(date('F', mktime(0, 0, 0, $month_second, 10))); ?>, <?php echo e($year_second); ?>`;
                    doc.text(scripsBoomersText, 15, yPosition);
                <?php endif; ?>

                yPosition += lineHeight;

                // Limit
                <?php if(isset($limit)): ?>
                    var limitText = `Limit: <?php echo e($limit); ?>`;
                    doc.text(limitText, 15, yPosition);
                    yPosition += lineHeight;
                <?php endif; ?>

                // Indices Records
                <?php if(isset($indices_records) && count($indices_records) > 0): ?>
                    var indicesText = 'Indices: ';
                    <?php $__currentLoopData = $indices_records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        indicesText += '<?php echo e($val->name); ?>' + ', ';
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    indicesText = indicesText.slice(0, -2);
                    doc.text(indicesText, 15, yPosition);
                    yPosition += lineHeight;
                <?php endif; ?>

                // Extract the table data and add it to the PDF
                var table = document.querySelector('#pdfData-indices-scrip');
                if (table) 
                {
                    var tableRows = [];
                    var tableHead = ['Name of the Scrip', 'Percentage change'];

                    table.querySelectorAll('tbody tr').forEach(function(row) 
                    {
                        var rowData = [];
                        row.querySelectorAll('td').forEach(function(cell) 
                        {
                            rowData.push(cell.textContent);
                        });
                        tableRows.push(rowData);
                    });

                    doc.autoTable({
                        head: [tableHead],
                        body: tableRows,
                        startX: 15,
                        startY: yPosition + 10,
                        headStyles: { fillColor: [45, 135, 23] }
                    });
                }

                var currentDate = new Date();
                var fileName = 'Indices_Boomers-Scrip-' + currentDate.toISOString().split('T')[0] + '.pdf';
                doc.save(fileName);
            };
        });
    });




   

    document.addEventListener('DOMContentLoaded', function() 
    {
        var exportButton = document.getElementById('exportPDF-indices-industry');

        exportButton.addEventListener('click', function() {
        

            var jsPDF = window.jspdf.jsPDF;
            var doc = new jsPDF();

            var img = new Image();
            img.src = "<?php echo e(asset('themes/frontend/assets/infosolz/images/small_logo.png')); ?>";

            img.onload = function() {
                var pageWidth = doc.internal.pageSize.getWidth();
                var imgWidth = 50;
                var imgHeight = 20;
                var centerX = (pageWidth - imgWidth) / 2;

                doc.addImage(img, 'PNG', centerX, 10, imgWidth, imgHeight);

                // Add Title
                doc.setFontSize(16);
                doc.setTextColor(45, 135, 23);
                doc.text('Indices Boomers Industry', pageWidth / 2, 40, { align: 'center' });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                var lineHeight = 10;
                var yPosition = 70;

                // Add the date range for industries
                <?php if(isset($month) && isset($month_second) && isset($year) && isset($year_second)): ?>
                    var industriesBoomersText = `Industries Boomers: For the month of <?php echo e(isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A'); ?>, <?php echo e(isset($year) ? $year : 'N/A'); ?> to <?php echo e(isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A'); ?>, <?php echo e(isset($year_second) ? $year_second : 'N/A'); ?>`;
                    doc.text(industriesBoomersText, 15, yPosition);
                <?php endif; ?>

                yPosition += lineHeight; // Adjust for next text

                // Add limit text if available
                <?php if(isset($limit)): ?>
                    var limitText = `Limit: <?php echo e(isset($limit) ? $limit : ''); ?>`;
                    doc.text(limitText, 15, yPosition);
                    yPosition += lineHeight;
                <?php endif; ?>

               
                <?php if(isset($indices_records) && count($indices_records) > 0): ?>
                    var indicesText = 'Indices: ';
                    <?php $__currentLoopData = $indices_records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        indicesText += '<?php echo e($val->name); ?>' + ', ';
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    indicesText = indicesText.slice(0, -2);  // Remove trailing comma
                    doc.text(indicesText, 15, yPosition);
                    yPosition += lineHeight;
                <?php endif; ?>

                // Extract the table data and add it to the PDF
                var table = document.querySelector('#pdfData-indices-industry');
                if (table) {
                    var tableRows = [];
                    var tableHead = ['Name of the Industry', 'Percentage change'];

                    // Loop through table rows to extract data
                    table.querySelectorAll('tbody tr').forEach(function(row) {
                        var rowData = [];
                        row.querySelectorAll('td').forEach(function(cell) {
                            rowData.push(cell.textContent);
                        });
                        tableRows.push(rowData);
                    });

                    // Add the table content to the PDF using autoTable
                    doc.autoTable({
                        head: [tableHead],
                        body: tableRows,
                        startX: 15,
                        startY: yPosition + 10,
                        headStyles: { fillColor: [45, 135, 23] }
                    });
                }

                // Save the PDF file
                var currentDate = new Date();
                var fileName = 'Indices_Boomers-Industry-' + currentDate.toISOString().split('T')[0] + '.pdf';
                doc.save(fileName);
            };
        });
    });


    


</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/indices-reports/boomers.blade.php ENDPATH**/ ?>