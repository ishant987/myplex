<?php if(isset($dataArr['meta_title'])): ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['meta_title']); ?><?php $__env->stopSection(); ?>
<?php else: ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['title']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_key'])): ?>
<?php $__env->startSection('meta-keywords'); ?><?php echo e($dataArr['meta_key']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_descp'])): ?>
<?php $__env->startSection('meta-description'); ?><?php echo e($dataArr['meta_descp']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['image_path'])): ?>
<?php $__env->startSection('meta-image'); ?><?php echo e($dataArr['image_path']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if($dataArr['full_url']): ?>
<?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>


<?php $__env->startSection('content'); ?>
<div class="custom-banner no-bg fw-banner <?php if(!$dataArr['image_path']): ?> fund-portfolio-banner  <?php endif; ?>" <?php if($dataArr['image_path']): ?> style="background-image:url(<?php echo e($dataArr['image_path']); ?>)"  <?php endif; ?>>

<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4><?php echo e($dataArr['title']); ?></h4>
					
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<div>
	<section>
		<div clas="container">
			<!--- <h3>Fund</h3> --->
			<div class="container mt-4">
				<h3>Fund</h3>
				<div class="row">
					<div class="col-md-3">
						<label>State Date:</label>
						<input type="date" name="frm_date" id="frm_date" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label>End Date:</label>
						<input type="date" name="to_date" id="to_date" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label>Fund</label>
						<select class="form-select select2" name="fund" id="fund">
                                        <option value="">Select Fund</option>
										<?php if($fundReponses['success']): ?>
											<?php $__currentLoopData = $fundReponses['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundResponse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($fundResponse['fund_code']); ?>"><?php echo e($fundResponse['fund_name']); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
                                    </select>								
					</div>
					<div class="col-md-3">
						<label>Return</label>
						<select class="form-select select2" name="option" id="option">
							<option value="">Select Return</option>
							<option value="Absolute Return">Absolute Return</option>
							<option value="Annualized Return">Annualized Return</option>
							<option value="Compound annual Growth Rate">Compound annual Growth Rate</option>
						</select>
					</div>
				</div>
				<div class="col-12 my-4">
					<button id="submit_fund_calculation" onclick="showFundIndex()" class="btn btn-success">Submit</button>
				</div>
			</div>	
			
			<!-- Index  -->			
			<!-- <h3>Index</h3> -->		
			<div class="rows d-none">
				<div class="cols-md-12">
					<div class="cols-md-3">
						<label>State Date:</label>
						<input type="date" name="frm_date" id="index_frm_date" />
					</div>
					<div class="cols-md-3">
						<label>End Date:</label>
						<input type="date" name="to_date" id="index_to_date" />
					</div>
					<div class="cols-md-3">
						<label>Index</label>
						<select class="form-select select2" name="index" id="index">
                                        <option value="">Select Index</option>
										<?php if($index_fundReponses['success']): ?>
											<?php $__currentLoopData = $index_fundReponses['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index_fundReponse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($index_fundReponse['name']); ?>"><?php echo e($index_fundReponse['name']); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
                                    </select>								
					</div>
					<div class="cols-md-3">
						<label>Return</label>
						<select name="option" id="index_option">
							<option value="">Select Return</option>
							<option value="Absolute Return">Absolute Return</option>
							<option value="Annualized Return">Annualized Return</option>
							<option value="Compound annual Growth Rate">Compound annual Growth Rate</option>
						</select>
					</div>
				</div>
				<div class="cols-12">
					<button id="submit_index_calculation"  class="primary-btn">Submit</button>
				</div>
			</div>
			
		</div>
		<div class="container" id="return">
			<div class="cols-3" id="st_date"></div>
			<div class="cols-3" id="ed_date"></div>
			<div class="cols-6" id="fund_result"></div>
			<div class="cols-6" id="index_result"></div>
		</div>
	</section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
	
async function showFundIndex()
{
	const start_date = $('#frm_date').val();
	const end_date = $('#to_date').val();
	const fund = $('#fund').val();
	const return_type = $('#option').val();
	
	//console.log(start_date,end_date,fund,return_type);
	
	const start_date_split = start_date.split('-');
	const end_date_split = end_date.split('-');
	//console.log(start_date.split('-'));
	const print_format_start_date = start_date_split[2]+"-"+start_date_split[1]+"-"+start_date_split[0];
	const print_format_end_date = end_date_split[2]+"-"+end_date_split[1]+"-"+end_date_split[0];
	
	let find_index;
	let fund_result;
	let index_result;
	let index;
	let fund_url = "";
	let index_url = "";
	let fund_value = 0;
	let index_value = 0;
	
	let index_name_url = 'https://www.myplexus.com/api/v1/index-name';
	
	if(return_type == 'Absolute Return')
	{
		fund_url = "https://www.myplexus.com/api/v1/absolute-return";
		index_url = "https://www.myplexus.com/api/v1/index-absolute-return";
		
	} else if( return_type == 'Annualized Return' )
	{
		fund_url = "https://www.myplexus.com/api/v1/annualised-return";
		index_url = "https://www.myplexus.com/api/v1/index-annualised-return"; 
		
	} else if( return_type == 'Compound annual Growth Rate' )
	{
		 fund_url = "https://www.myplexus.com/api/v1/compound-return";
		index_url = "https://www.myplexus.com/api/v1/index-compound-return";		
	}	
	
	try {
		
			find_index = await $.ajax({
                       type: 'GET',
                       url: index_name_url,
						data: {						
						fund_code: fund
						},                              
                   });
		
			console.log(find_index);				
				
			fund_result = await $.ajax({
                       type: 'GET',
                       url: fund_url,
						data: {
						start_date: start_date,
						end_date: end_date,
						fund_code: fund,
						return_type: return_type
						},                              
                   });
		
		
		//console.log(result);
		
			if(find_index.success)
			{
				index = find_index.data.indices_name;
				
				index_result = await $.ajax({
                       type: 'GET',
                       url: index_url,
						data: {
						start_date: start_date,
						end_date: end_date,
						index: index,
						return_type: return_type
						},                              
                   });
			}
		
		if(fund_result.success && index_result.success)
		{
			$('#st_date').html('');
			$('#ed_date').html('');
			$('#fund_result').html('');
			$('#index_result').html('');
											
			$('#st_date').html('<strong>Start Date: </strong>'+print_format_start_date);
			$('#ed_date').html('<strong>End Date: </strong>'+print_format_end_date);
			
			if( return_type == 'Absolute Return' || return_type == 'Annualized Return' )
			{
				fund_value = fund_result.data[0].a != null ? fund_result.data[0].a.toFixed(2) : 0;
				index_value = index_result.data[0].a != null ? index_result.data[0].a.toFixed(2) : 0;
				
			} else if( return_type == 'Compound annual Growth Rate' )
			{
				fund_value = fund_result.data[0].CAGR != null ? fund_result.data[0].CAGR.toFixed(2) : 0;
				index_value = index_result.data[0].CAGR != null ? index_result.data[0].CAGR.toFixed(2) : 0;
			}			
			
			if(return_type == 'Absolute Return')
			{				
				$('#fund_result').html('<strong>Fund Absolute Return: </strong>'+fund_value);	
				$('#index_result').html('<strong>Index Absolute Return: </strong>'+index_value);
				
			} else if( return_type == 'Annualized Return' )
			{
				$('#fund_result').html('<strong>Fund Annualised Return: </strong>'+fund_value);	
				$('#index_result').html('<strong>Index Annualised Return: </strong>'+index_value);
				
			} else if( return_type == 'Compound annual Growth Rate' )
			{
				$('#fund_result').html('<strong>Fund Annualised Return: </strong>'+fund_value);	
				$('#index_result').html('<strong>Index Annualised Return: </strong>'+index_value);
			}
				
			
		} else if( fund_result.success && !index_result.success ) {
			
			$('#st_date').html('');
			$('#ed_date').html('');
			$('#fund_result').html('');
			$('#index_result').html('');
											
			$('#st_date').html('<strong>Start Date: </strong>'+print_format_start_date);
			$('#ed_date').html('<strong>End Date: </strong>'+print_format_end_date);
			
			if( return_type == 'Absolute Return' || return_type == 'Annualized Return' )
			{
				fund_value = fund_result.data[0].CAGR != null ? fund_result.data[0].CAGR.toFixed(2) : 0;				
				
			} else if( return_type == 'Compound annual Growth Rate' )
			{
				fund_value = fund_result.data[0].CAGR != null ? fund_result.data[0].CAGR.toFixed(2) : 0;
			}		
			
			if(return_type == 'Absolute Return')
			{
				$('#fund_result').html('<strong>Fund Absolute Return: </strong>'+fund_value);
				
			} else if( return_type == 'Annualized Return' )
			{
				$('#fund_result').html('<strong>Fund Annualised Return: </strong>'+fund_value);
			}
			
		} else if( !fund_result.success && index_result.success ) {
			
			$('#st_date').html('');
			$('#ed_date').html('');
			$('#fund_result').html('');
			$('#index_result').html('');
											
			$('#st_date').html('<strong>Start Date: </strong>'+print_format_start_date);
			$('#ed_date').html('<strong>End Date: </strong>'+print_format_end_date);
			
			if( return_type == 'Absolute Return' || return_type == 'Annualized Return' )
			{
				index_value = index_result.data[0].CAGR != null ? index_result.data[0].CAGR.toFixed(2) : 0;				
				
			} else if( return_type == 'Compound annual Growth Rate' )
			{
				index_value = index_result.data[0].CAGR != null ? index_result.data[0].CAGR.toFixed(2) : 0;
			}		
			
			if( return_type == 'Absolute Return' )
			{
				$('#index_result').html('<strong>Index Absolute Return: </strong>'+index_value);
				
			} else if( return_type == 'Annualized Return' )
			{
				$('#index_result').html('<strong>Index Annualized Return: </strong>'+index_value);
			}				
			
		}
		
		
		
		//console.log(result);
	
	} catch (error) {
        console.error(error);
    }
}
		
		

	
	
	
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/return-calculator.blade.php ENDPATH**/ ?>