<style>
.select2-container {
    width: 100% !important;
}
</style>
<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <div class="three_btn mb-2">
                                                <div class="row align-items-center justify-content-end">
                                                    <div class="col-lg-4">
                                                        <div
                                                            class="middle_a d-flex align-items-center justify-content-md-end justify-content-center">
                                                            <a href="javascript:void(0)" onclick="ratioSetYearSelect('1M', this)" class="rset">1M</a>
                                                            <a href="javascript:void(0)" onclick="ratioSetYearSelect('3M', this)" class="rset">3M</a>
                                                            <a href="javascript:void(0)" onclick="ratioSetYearSelect('6M', this)" class="rset">6M</a>
                                                            <a href="javascript:void(0)" onclick="ratioSetYearSelect('1Y', this)" class="rset active">1Y</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table_scc compare_section_div_str">
                                                <div class="row mb-1">
                                                    <div class="col-md-12 col-lg-4 pe-lg-1 mb-2 mb-sm-0">
                                                        <div class="form_select border_top_left">
                                                            <label for="">Schemes, Index, Currency, Commodity</label>
                                                   <select class="form-select form-select-lg js-example-basic-single" id="ratio_main_list">
														<option value="">Select Fund</option>
                                                    </select>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 pe-lg-1 ps-lg-0 mb-2 mb-sm-0">
                                                        <div class="form_select">
                                                            <label for="">Return Ratio</label>
                                                            <select class="w-100" id="return_ratio" >
                                                                <option value="">Select</option>
                                                                <option value="cagr">Returns</option>
                                                                <option value="jensen_alpha">Jensen</option>
                                                                <option value="information_ratio">Information Ratio </option>
                                                                <option value="rolling_return">Rolling Return </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 pe-lg-1 ps-lg-0 mb-2 mb-sm-0">
                                                        <div class="form_select">
                                                            <label for="">Risk Ratio</label>
                                                            <select class="w-100" id="risk_ratio">
                                                                <option value="">Select</option>
                                                                <option value="beta">Beta</option>
                                                                <option value="tracking_error">Tracking Error </option>
                                                                <option value="volatality">Volatility</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 pe-lg-1 ps-lg-0">
                                                        <div class="form_select top_bg_right_black">
                                                            <label for="">From Date</label>
                                                            <input class="form-date" id="ratio_frm_date" type="date">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 ps-lg-0">
                                                        <div class="form_select top_bg_right_black border_top_right">
                                                            <label for="">To Date</label>
                                                            <input class="form-date" id="ratio_to_date" type="date">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 pe-lg-1 col-12 col-md-12 mb-1">
                                                        <div class="form_select bg_green border_bottom_left">
                                                            <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <select class="form-select form-select-lg js-example-basic-single" id="ratio_2nd_list">
														  <option value="">Select Fund</option>
                                                      </select>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 ps-lg-0 pe-lg-1 col-12 col-md-12">
                                                        <div class="form_select bg_green">
                                                            <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <select class="form-select form-select-lg js-example-basic-single" id="ratio_3rd_list">
														 <option value="">Select Fund</option>
                                                     </select>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 pe-lg-1 ps-lg-0 col-12 col-md-12">
                                                        <div class="form_select bg_green">
                                                            <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <select class="form-select form-select-lg js-example-basic-single" id="ratio_4th_list">
														  <option value="">Select Fund</option>
                                                      </select>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 ps-lg-0 col-12">
                                                        <div class="form_select bg_green border_bottom_right">
                                                            <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <select class="form-select form-select-lg js-example-basic-single" id="ratio_5th_list">
														  <option value="">Select Fund</option>
                                                      </select>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="three_btn mt-3">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-2">
                                                        <div class="middle_left 2">
                                                            <button class="btn btn-success" onclick="ratioCompare()">Compare</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="text-center mt-3">
                                                <!--v-if-->
												<figure class="highcharts-figure">
													<div id="container" class="showrslt"></div>  
												</figure>
                                            </div>
                                            <!--v-if-->
                                        </div>

<?php $__env->startPush('scripts'); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
	let ratio_from_date = ratio_to_date = "";
	let ratio_compare_type = "";
	let ratio_value1 = ratio_value2 = ratio_value3 = ratio_value4 = ratio_value5 = "";
	let ratio_value1_text = ratio_value2_text = ratio_value3_text = ratio_value4_text = ratio_value5_text = "";
	let fundData = [];
	
	$(document).ready(function() {
	
		showFunds();	
		ratio_from_date = new Date();
        ratio_from_date.setFullYear(ratio_from_date.getFullYear() - 1);
        ratio_from_date = ratio_from_date.getFullYear() + '-' + (ratio_from_date.getMonth() + 1) + '-' + ratio_from_date.getDate();
                                //console.log(from_date);

        ratio_to_date = new Date();
        ratio_to_date = ratio_to_date.getFullYear() + '-' + (ratio_to_date.getMonth() + 1) + '-' + ratio_to_date.getDate();
                                //console.log(to_date);
		
		console.log("From Date: "+ratio_from_date+" To Date: "+ratio_to_date);
	
	});
	
	async function ratioCompare()
	{
		if($('#ratio_frm_date').val() != "" && $('#ratio_to_date').val() != "")
        {
			ratio_to_date = $('#ratio_to_date').val();
            ratio_from_date = $('#ratio_frm_date').val();
			
			$('.rset').each(function() {
				this.classList.remove('active');
			});
         }
		
		//console.log('From Date: '+ratio_from_date+' To Date: '+ratio_to_date);		
		//console.log('Compare Type: '+ratio_compare_type);
		
		ratio_value1 = $('#ratio_main_list option:selected').val() != "" ? $('#ratio_main_list option:selected').val() : "";
		ratio_value1_text = $('#ratio_main_list option:selected').val() != "" ? $('#ratio_main_list option:selected').text() : "";
		
		ratio_value2 = $('#ratio_2nd_list option:selected').val() != "" ? $('#ratio_2nd_list option:selected').val() : "";		
		ratio_value2_text = $('#ratio_2nd_list option:selected').val() != "" ? $('#ratio_2nd_list option:selected').text() : "";
		
		ratio_value3 = $('#ratio_3rd_list option:selected').val() != "" ? $('#ratio_3rd_list option:selected').val() : "";		
		ratio_value3_text = $('#ratio_3rd_list option:selected').val() != "" ? $('#ratio_3rd_list option:selected').text() : "";
		
		ratio_value4 = $('#ratio_4th_list option:selected').val() != "" ? $('#ratio_4th_list option:selected').val() : "";		
		ratio_value4_text = $('#ratio_4th_list option:selected').val() != "" ? $('#ratio_4th_list option:selected').text() : "";
		
		ratio_value5 = $('#ratio_5th_list option:selected').val() != "" ? $('#ratio_5th_list option:selected').val() : "";		
		ratio_value5_text = $('#ratio_5th_list option:selected').val() != "" ? $('#ratio_5th_list option:selected').text() : "";
		
		//console.log('Value 1: '+ratio_value1+'Value 2: '+ratio_value2);
		
		if( $('#ratio_frm_date').val() == "" || $('#ratio_to_date').val() == "" )
		{
			if( $('.rset').hasClass('active') )
			{
				const active_text = ($('a.rset.active').text());

				let api_url = 'https://www.myplexus.com/api/v1/get-dates';

				const result_dates = await $.ajax({
					url: api_url,
					type: 'GET',
					data: {					
						value1: ratio_value1,
						duration: active_text					
					}
				});
				
				if( result_dates.success )
				{
					ratio_to_date = result_dates.data.end_date;
					ratio_from_date = result_dates.data.start_date;
					
				}
				
				//console.log(result_dates);
			}			
		}
		
		if(ratio_value1 != "" && (ratio_value2 != "" || ratio_value3 != "" || ratio_value4 != "" || ratio_value5 != "") && ratio_compare_type != "" && ratio_from_date != "" && ratio_to_date != "")
		{
			let ratio_url = 'https://www.myplexus.com/api/v1/compare-ratios';
			
			const data = await $.ajax({			
				url: ratio_url,
				type: 'GET',
				data: {
					compare_type: ratio_compare_type, 
					value1: ratio_value1, 
					value2: ratio_value2,
					value3: ratio_value3,
					value4: ratio_value4,
					value5: ratio_value5,
					from_date: ratio_from_date, 
					to_date: ratio_to_date
				}
			});
			
			//console.log(ratio_compare_type);
			//console.log(data.data.graph_data[0][ratio_compare_type]);
			var length = Object.keys(data.data.graph_data).length;
			//console.log(length);
			
			
			
			if(data.success)
			{
				let label_data = [];
				let drill_data = [];
				
				if(Object.keys(data.data.graph_data).length >= 1)
				{			
					for(var i=0; i<Object.keys(data.data.graph_data).length; i++)
					{
						
						let fundName = fetchFundName(data.data.graph_data[i]['fund_code']);
						
							label_data.push({
								name: fundName,
								y: data.data.graph_data[i][ratio_compare_type],
								drilldown: fundName
							});	
						
							drill_data.push({
								name: fundName,
								id: fundName,
								data: data.data.graph_data[i][ratio_compare_type]
							});
					}
					
					//console.log(label_data);
				}
				$('.showrslt').html();
				$('#container').html();
					showChart('container', label_data, drill_data);
				
				
				/*if( ratio_value2_text != "" && ratio_value3_text != "" && ratio_value4_text != "" && ratio_value5_text != "" )
				{
					$('#container').html();
					showChart('container', data, ratio_compare_type, ratio_value1_text, ratio_value2_text, ratio_value3_text, ratio_value4_text, ratio_value5_text);
					
				} else if( ratio_value2_text != "" && ratio_value3_text != "" && ratio_value4_text != "" && ratio_value5_text == "" )
				{
					$('#container').html();					
					showChartRestFive('container', data, ratio_compare_type, ratio_value1_text, ratio_value2_text, ratio_value3_text, ratio_value4_text);
					
				} else if( ratio_value2_text != "" && ratio_value3_text != "" && ratio_value4_text == "" && ratio_value5_text == "" )
				{
				
				
				}*/
				
			}
		}	
		
	}
	
	function fetchFundName(fund_code)
	{
		let filteredFund = fundData.filter((fund) => {
			return fund.fund_code == fund_code;
		});
		
		return filteredFund[0].fund_name;
		//console.log(filteredFund);
	}
	
	async function showFunds()
	{
		let basePath = "https://myplexus.com/api/v1/";
		let url = basePath + 'funds';
		
		const result = await $.ajax({		
			 type: 'GET',
             url: url		
		});
		
		if(result.success)
		{
			let html = "";
			
			if(result.data.length >= 1)
			{
				html += '<option value="">Select a Scheme</option>';
				for(var i=0; i<result.data.length; i++)
				{
					fundData.push({
						fund_code: result.data[i].fund_code,
						fund_name: result.data[i].fund_name
					});
					
					html += '<option value="'+result.data[i].fund_code+'">'+result.data[i].fund_name+'</option>';
				}
				
				$('#ratio_main_list').html(html);				
				$('#ratio_2nd_list').html(html);
				$('#ratio_3rd_list').html(html);
				$('#ratio_4th_list').html(html);
				$('#ratio_5th_list').html(html);
			}
			
		}
		//console.log("Ratio Result: ", result);
	}
	
	function ratioSetYearSelect(id, e)
	{
		$('.rset').each(function() {
           this.classList.remove('active');
        });
								
								 $('#ratio_frm_date').val('');
                                $('#ratio_to_date').val('');

                                var today = new Date();
                                var dd = String(today.getDate());
                                var mm = String(today.getMonth() + 1); //January is 0!
                                var yyyy = today.getFullYear();

                                ratio_to_date = yyyy+'-'+mm+'-'+dd;

                                if(id == '1M')
                                {
                                    ratio_from_date = getToDate(1, 'M', to_date);
                                    e.classList.add('active');

                                } else if(id == '3M')
                                {
                                    ratio_from_date = getToDate(3, 'M', to_date);
                                    e.classList.add('active');

                                } else if(id == '6M')
                                {
                                    ratio_from_date = getToDate(6, 'M', to_date);
                                    e.classList.add('active');

                                } else if(id == '1Y')
                                {
                                    ratio_from_date = getToDate(12, 'M', to_date);
                                    e.classList.add('active');
                                }

                                console.log(ratio_from_date+'####'+ratio_to_date);
	}
	
	function getToDate(duration, duration_type, frm_date)
    {
								console.log(frm_date);
								
                                toDate = new Date(frm_date);
                                let dd = mm = yyyy = "";
								
								console.log(toDate);

                                if(duration_type == 'M')
                                {
                                    if(duration == 1)
                                    {
                                        dd = String(toDate.getDate());                                        
                                        mm = String(toDate.getMonth()); //January is 0!
                                        yyyy = toDate.getFullYear();
										
										//console.log(yyyy);

                                    } else 
                                    {
                                        dd = String(toDate.getDate());
                                        toDate.setMonth((toDate.getMonth() + 1) - duration);
                                        mm = String(toDate.getMonth()); //January is 0!
                                        yyyy = toDate.getFullYear();
                                    }                                   

                                } 

                                toDate = yyyy+'-'+mm+'-'+dd;

                                return toDate;

    }
	
	$('#return_ratio').on('change', function() {
		
		if($('#return_ratio option:selected').val() != "")
		{
			$('#risk_ratio').attr('disabled', true);
			
			ratio_compare_type = $('#return_ratio option:selected').val();
		
		} else {
			
			$('#risk_ratio').attr('disabled', false);
			
			ratio_compare_type = "";
		
		}	
	});
	
	
	$('#risk_ratio').on('change', function() {
		
		if($('#risk_ratio option:selected').val() != "")
		{
			$('#return_ratio').attr('disabled', true);
			
			ratio_compare_type = $('#risk_ratio option:selected').val();
		
		} else {
			
			$('#return_ratio').attr('disabled', false);
			
			ratio_compare_type = "";		
		}	
	});
	
	

</script>

<script>
	

	
function showChart(container_id, label_data, drill_data)
{
		
	Highcharts.chart(container_id, {
					chart: {
						type: 'column'
					},
					title: {
						align: 'center',
						text: 'Ratio Compare'
					},
					subtitle: {
						align: 'center',
						text: ''
					},
					accessibility: {
						announceNewData: {
							enabled: true
						}
					},
					xAxis: {
						type: 'category'
					},
					yAxis: {
						title: {
							text: 'Ratio Value'
						}

					},
					legend: {
						enabled: false
					},
					plotOptions: {
						series: {
							borderWidth: 0,
							dataLabels: {
								enabled: true,
								format: '{point.y:.2f}%'
							}
						}
					},

					tooltip: {
						headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
						pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.3f}%</b> of total<br/>'
					},		
		
						series: [
							{
								name: "Ratio Compare",
								colorByPoint: true,
								data: label_data
							}
						],					
		
					drilldown: {
						breadcrumbs: {
							position: {
								align: 'right'
							}
						},
							
						series: drill_data
					}		
				});		
	}
	
	
    
	
</script>


<?php $__env->stopPush(); ?>
                                        <?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/pages/ratio-calculation.blade.php ENDPATH**/ ?>