<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\RatioController;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\BaseController;
use App\Http\Controllers\Web\JensonsalphaAPIController;

use App\Models\CorpusEntry;
use App\Models\User;
use App\Models\FundMaster;
use App\Models\FundType;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use DB;
use App\Lib\Core\Useful;


class RatioAnalysisController extends Controller
{
    // public function risk_ratio(){

    //     $user = Auth::user();
    //     $userId = $user->u_id;
    //     //  dd($userId);
    //     $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    //     $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    //     $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
       
    //     $currentDateTime = Carbon::now();
    //     //  dd($expiry_date);
    //     $data['current_date'] = $current_date = $currentDateTime->toDateString();
    //     // $data['current_date']= '2024-04-20';
    //     //dd($current_date);
    //     $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    //     // dd($fiveDaysBeforeExpiryDate);
  
    //     $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();
  
    //       $data['fund_type'] = FundType::get();
  
    //       $data['fund_master'] = FundMaster::where('status',1)->get();
    //     return view('web.auth.ratio_analysis.risk_ratio',$data);

    // }

    public function return_ratio(Request $request){

      $data= RatioController::loggedInUserData();
      // dd($userData);
      $jensonAlphaController = new JensonsalphaAPIController;
      $data['browser_title'] = 'return ratio';
      $data['active_menu'] = 'dashboard';
      $data['all_funds'] = FundMaster::where('status',1)->orderBy('fund_name','asc')->get();
      // dd($data['all_funds']);
      $data['all_fund_types'] = FundType::where('active_passive','A')->get();
      $data['quartile_set'] =  $request->quartile_set;
      // dd($request->all());
      //search block..........
      $quartile_result = [];

      $data['indices'] = DB::table('indices_master')->whereNotIn('name', ['Gold', 'S&P 500 Index', 'MSCI Emerging Market'])->where('status',1)->get();

      //for searching with fund classification
      if($request->has('Category') && $request->Category=='by_category'){
          // dd('search_by_classification');
          //validation
          $request->validate([
              'ranking' => 'required'
          ],
          [
              'ranking'.'required' => 'Please Select Range Or As on for Searching'
          ]);

          if($request->ranking == 'range'){
              //validation for range
              $request->validate([
                  'start_date' => 'required',
                  'end_date' => 'required',
                  'fund_type_id' => 'required',
                  'report_category' => 'required',
                  'index_id'  =>  'required'

              ],
              [
                  'ranking'.'start_date' => 'Please Select the Start Date',
                  'ranking'.'end_date' => 'Please Select the End Date',
                  'ranking'.'fund_type_id' => 'Please Select the Fund Type',
                  'ranking'.'report_category' => 'Please Select the Report Category',
                  'ranking'.'index_id' => 'Please Select an index',

              ]);
              // dd($request->report_category);

              $data['fund_type_id'] = $request->fund_type_id;
              $fund_type = FundType::where('ft_id', $request->fund_type_id)->first();
              // dd($fund_type->name);
              $data['fund_type_name'] = $fund_type->name;
              // dd($data['fund_type']);

              
              $index_id = $request->index_id;

              $data['index_name'] = DB::table('indices_master')->select('name')->where('idc_id',$request->index_id)->where('status',1)->first();

              
              if($request->report_category == 'one_month_rolling_return'){

                $data['start_date'] =  $start_date = date('Y-m-d', strtotime('-1 month', strtotime($request->end_date)));
                
                $data['end_date'] =  $end_date = date('Y-m-d', strtotime($request->end_date));

                // dd($start_date."    ".$end_date);

            }else{

                $start_date = date('Y-m-d', strtotime($request->start_date));
                $data['start_date'] = $start_date;
                $end_date = date('Y-m-d', strtotime($request->end_date));
                $data['end_date'] = $end_date;

            }

              $fund_type_id = $request->fund_type_id;
              $fund_code_in = FundMaster::where('fund_type_id',$fund_type_id)->get();
              $data['report_category'] = $request->report_category;
             
              
              if($request->report_category == 'returns'){
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::jensenalphaApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['fund_return_absolute'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'jensens_alpha'){
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::jensenalphaApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['jensens_alpha'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'sharpe'){
                  // dd('sharpe');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::sharpeApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['sharpe'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'treynor'){
                  // dd('sharpe');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::treynorApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['treynor'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'information_ratio'){
                  // dd('information_ratio');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::informationRatioApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['information_ratio'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'skewness'){
                  // dd('information_ratio');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::skewnessApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['skewness'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'kurtosis'){
                  // dd('information_ratio');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::kurtosisApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['kurtosis'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'r_square'){
                  // dd('information_ratio');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::r_squareApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['r_squere'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'one_month_rolling_return'){
                  // dd('information_ratio');
                //   $f_code_arr = [];
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::oneMonthRollingReturnApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                    //   array_push($f_code_arr,$fund_individual->fund_code);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['one_month_interval_percentage_change'];
                          // dd($fund_absolute_return);
                      }
                  }
                //   dd(implode(',',$f_code_arr));
              }
              
              // dd($quartile);
              $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return)>0? $fund_absolute_return:[];
             
              
          }elseif($request->ranking == 'as_on'){
              // dd('category_as_on')
;                $request->validate([
                  'as_on_date' => 'required',
                  'as_on_time_frame' => 'required',
                  'fund_type_id' => 'required',
                  'report_category' => 'required',
                  'index_id' => 'required',

              ],
              [
                  'ranking'.'as_on_date' => 'Please Select the Date',
                  'ranking'.'as_on_time_frame' => 'Please Select the Time Period',
                  'ranking'.'fund_type_id' => 'Please Select the Fund Type',
                  'ranking'.'report_category' => 'Please Select the Report Category',
                  'ranking'.'index_id' => 'Please Select an index',

              ]);

              $data['fund_type_id'] = $request->fund_type_id;
              $fund_type = FundType::where('ft_id', $request->fund_type_id)->first();
              // dd($fund_type->name);
              $data['fund_type_name'] = $fund_type->name;
              // dd($data['fund_type']);

              $index_id = $request->index_id;

              $data['index_name'] = DB::table('indices_master')->select('name')->where('idc_id',$request->index_id)->where('status',1)->first();
              
              // $start_date = date('Y-m-d', strtotime($request->start_date));
              // $data['start_date'] = $start_date;
              // $end_date = date('Y-m-d', strtotime($request->end_date));
              // $data['end_date'] = $end_date;

              if($request->report_category == 'one_month_rolling_return'){

                $data['start_date'] =  $start_date =  date('Y-m-d', strtotime('-1 month', strtotime($request->as_on_date)));
                
                $data['end_date'] =  $end_date =date('Y-m-d', strtotime($request->as_on_date));

               $data['as_on_time_frame_data'] = $request->as_on_time_frame;


            }else{

            $end_date = date('Y-m-d', strtotime($request->as_on_date));
            $data['as_on_time_frame_data'] = $request->as_on_time_frame;

            $data['end_date'] = $end_date;
            // dd($request->as_on_time_frame);
            switch($request->as_on_time_frame) {
                case '1_month':
                    $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                    break;
                case '3_months':
                    $start_date = date('Y-m-d', strtotime('-3 months', strtotime($end_date)));
                    break;
                case '6_months':
                    $start_date = date('Y-m-d', strtotime('-6 months', strtotime($end_date)));
                    break;
                case '1_year':
                    $start_date = date('Y-m-d', strtotime('-1 year', strtotime($end_date)));
                    break;
                case '2_year':
                    $start_date = date('Y-m-d', strtotime('-2 year', strtotime($end_date)));
                    break;
                case '3_years':
                    $start_date = date('Y-m-d', strtotime('-3 years', strtotime($end_date)));
                    break;
                case '5_years':
                    $start_date = date('Y-m-d', strtotime('-5 years', strtotime($end_date)));
                    break;
                default:
                    // Handle unexpected values or set a default interval
                    // For example, set the start date to one month before by default
                    $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                    break;
            }
            
            $data['start_date'] = $start_date;
            }


              $fund_type_id = $request->fund_type_id;
              $fund_code_in = FundMaster::where('fund_type_id',$fund_type_id)->get();
              $data['report_category'] = $request->report_category;
             
              if($request->report_category == 'returns'){
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::jensenalphaApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['fund_return_absolute'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'jensens_alpha'){
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::jensenalphaApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['jensens_alpha'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'sharpe'){
                  // dd('sharpe');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::sharpeApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['sharpe'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'treynor'){
                  // dd('sharpe');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::treynorApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['treynor'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'information_ratio'){
                  // dd('sharpe');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::informationRatioApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['information_ratio'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'skewness'){
                  // dd('sharpe');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::skewnessApi($fund_individual->fund_code, $start_date, $end_date);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['skewness'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'kurtosis'){
                  // dd('sharpe');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::kurtosisApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['kurtosis'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'r_square'){
                  // dd('sharpe');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::r_squareApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['r_squere'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'one_month_rolling_return'){
                  // dd('sharpe');
                  foreach($fund_code_in as $fund_individual){
                      $fund_return = self::oneMonthRollingReturnApi($fund_individual->fund_code, $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual->fund_id] = $fund_return['one_month_interval_percentage_change'];
                          // dd($fund_absolute_return);
                      }
                  }
              }
              // dd($fund_absolute_return);
              // dd($quartile);
              $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return)>0? $fund_absolute_return:[];
             
          }
      }
      // dd($quartile_result);
      if($request->has('Category') && $request->Category=='by_fund'){
          // dd('search by fund');
          //validation
          $request->validate([
              'ranking' => 'required'
          ],
          [
              'ranking'.'required' => 'Please Select Range Or As on for Searching'
          ]);

          if($request->ranking == 'range'){
              //validation for range
              $request->validate([
                  'start_date' => 'required',
                  'end_date' => 'required',
                  'fund_id' => 'required',
                  'report_category' => 'required',
                  'index_id' => 'required',

              ],
              [
                  'ranking'.'start_date' => 'Please Select the Start Date',
                  'ranking'.'end_date' => 'Please Select the End Date',
                  'ranking'.'fund_id' => 'Please Select the Fund',
                  'ranking'.'report_category' => 'Please Select the Report Category',
                  'ranking'.'index_id' => 'Please Select an index',

              ]);

             
              $index_id = $request->index_id;

              $data['index_name'] = DB::table('indices_master')->select('name')->where('idc_id',$request->index_id)->where('status',1)->first();
              // dd($data['fund_id']);

              $fundMaterData = FundMaster::whereIn('fund_id', $request->fund_id)->get();
              // dd($fundMaterData);
              // $fund_type_id = $fundMaterData->fund_type_id;
              // $fund_code = $fundMaterData->fund_code;

              $fund_type_id =[];
              $fund_code =[];
              $fund_id =[];

              $fund_code_id_arra = [];
              $fund_name_array =[];

              foreach($fundMaterData as $funds){

                  array_push($fund_id,$funds->fund_id);
                  array_push($fund_name_array,$funds->fund_name);


                  array_push($fund_type_id,$funds->fund_type_id);
                  array_push($fund_code,$funds->fund_code);

                  // $fund_code_id_arra['fund_id'] = $funds->fund_id;
                  // $fund_code_id_arra['fund_code'] = $funds->fund_code;

                  $fund_code_id = array(
                      'fund_id' => $funds->fund_id,
                      'fund_code' => $funds->fund_code
                  );
                  
                  array_push($fund_code_id_arra,$fund_code_id);

              }

              $data['fund_id'] = $fund_id;

              $fund_type = FundType::whereIn('ft_id', $fund_type_id)->get();
              
              $fund_type_name_arr = [];

              foreach($fund_type as $f_type){
                  array_push($fund_type_name_arr,$f_type->name);
              }
              $data['fund_type_name'] = $fund_type_name_arr;

              //test end
              if($request->report_category == 'one_month_rolling_return'){

                $data['start_date'] =  $start_date = date('Y-m-d', strtotime('-1 month', strtotime($request->end_date)));
                
                $data['end_date'] =  $end_date = date('Y-m-d', strtotime($request->end_date));

            }else{
                $start_date = date('Y-m-d', strtotime($request->start_date));
                $data['start_date'] = $start_date;
                $end_date = date('Y-m-d', strtotime($request->end_date));
                $data['end_date'] = $end_date;
            }


              $data['report_category'] = $request->report_category;
              
              if($request->report_category == 'returns'){
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::jensenalphaApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['fund_return_absolute'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'jensens_alpha'){
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::jensenalphaApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['jensens_alpha'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'sharpe'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::sharpeApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['sharpe'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'treynor'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::treynorApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['treynor'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'information_ratio'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::informationRatioApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['information_ratio'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'skewness'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::skewnessApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['skewness'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'kurtosis'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::kurtosisApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['kurtosis'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'r_square'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::r_squareApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['r_squere'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'one_month_rolling_return'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::oneMonthRollingReturnApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['one_month_interval_percentage_change'];
                          // dd($fund_absolute_return);
                      }
                  }
              }
              $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return)>0? $fund_absolute_return:[];
            
              
          }elseif($request->ranking == 'as_on'){
              // dd($as_on);
              $request->validate([
                  'as_on_date' => 'required',
                  'as_on_time_frame' => 'required',
                  'fund_id' => 'required',
                  'report_category' => 'required',
                  'index_id' => 'required',

              ],
              [
                  'ranking'.'as_on_date' => 'Please Select the Date',
                  'ranking'.'as_on_time_frame' => 'Please Select the Time Period',
                  'ranking'.'fund_id' => 'Please Select the Fund',
                  'ranking'.'report_category' => 'Please Select the Report Category',
                  'ranking'.'index_id' => 'Please Select an index',

              ]);

              $index_id = $request->index_id;

              $data['index_name'] = DB::table('indices_master')->select('name')->where('idc_id',$request->index_id)->where('status',1)->first();
              
              $data['fund_id'] = $request->fund_id;

              // dd($data['fund_id']);

              $fundMaterData = FundMaster::whereIn('fund_id', $request->fund_id)->get();
             

              $fund_type_id =[];
              $fund_code =[];
              $fund_id =[];

              $fund_code_id_arra = [];
              $fund_name_array=[];

              foreach($fundMaterData as $funds){

                  array_push($fund_id,$funds->fund_id);
                  array_push($fund_name_array,$funds->fund_name);


                  array_push($fund_type_id,$funds->fund_type_id);
                  array_push($fund_code,$funds->fund_code);

                  $fund_code_id = array(
                      'fund_id' => $funds->fund_id,
                      'fund_code' => $funds->fund_code
                  );
                  
                  array_push($fund_code_id_arra,$fund_code_id);

              }

              // dd($fund_type_id);
              $fund_type = FundType::whereIn('ft_id', $fund_type_id)->get();
              // dd($fund_type->name);
              $fund_type_name_arr = [];

              foreach($fund_type as $f_type){
                  array_push($fund_type_name_arr,$f_type->name);
              }
              $data['fund_type_name'] = $fund_type_name_arr;
             

             
             

              if($request->report_category == 'one_month_rolling_return'){

                $data['start_date'] =  $start_date =  date('Y-m-d', strtotime('-1 month', strtotime($request->as_on_date)));
                
                $data['end_date'] =  $end_date =date('Y-m-d', strtotime($request->as_on_date));
            $data['as_on_time_frame_data'] = $request->as_on_time_frame;


            }else{
                $end_date = date('Y-m-d', strtotime($request->as_on_date));
                $data['as_on_time_frame_data'] = $request->as_on_time_frame;

                $data['end_date'] = $end_date;
                // dd($request->as_on_time_frame);
                switch($request->as_on_time_frame) {
                    case '1_month':
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                    case '3_months':
                        $start_date = date('Y-m-d', strtotime('-3 months', strtotime($end_date)));
                        break;
                    case '6_months':
                        $start_date = date('Y-m-d', strtotime('-6 months', strtotime($end_date)));
                        break;
                    case '1_year':
                        $start_date = date('Y-m-d', strtotime('-1 year', strtotime($end_date)));
                        break;
                    case '2_year':
                        $start_date = date('Y-m-d', strtotime('-2 year', strtotime($end_date)));
                        break;
                    case '3_years':
                        $start_date = date('Y-m-d', strtotime('-3 years', strtotime($end_date)));
                        break;
                    case '5_years':
                        $start_date = date('Y-m-d', strtotime('-5 years', strtotime($end_date)));
                        break;
                    default:
                        // Handle unexpected values or set a default interval
                        // For example, set the start date to one month before by default
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                }
                
                $data['start_date'] = $start_date;
            }

              // dd($start_date."---".$end_date);
              
              $data['report_category'] = $request->report_category;

             
            //   $fund_return = self::jensenalphaApi($fund_code, $start_date, $end_date);
              // dd($call_sp);
              if($request->report_category == 'returns'){
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::jensenalphaApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['fund_return_absolute'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'jensens_alpha'){
                
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::jensenalphaApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['jensens_alpha'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'sharpe'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::sharpeApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['sharpe'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'treynor'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::treynorApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['treynor'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'information_ratio'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::informationRatioApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['information_ratio'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'skewness'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::skewnessApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['skewness'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'kurtosis'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::kurtosisApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['kurtosis'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'r_square'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::r_squareApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['r_squere'];
                          // dd($fund_absolute_return);
                      }
                  }
              }elseif($request->report_category == 'one_month_rolling_return'){
                  // dd('sharpe');
                  foreach($fund_code_id_arra as $fund_individual){
                      $fund_return = self::oneMonthRollingReturnApi($fund_individual['fund_code'], $start_date, $end_date,$index_id);

                    //   echo"<pre>";print_r($fund_return);
                      // dd($call_sp);
                      // dd($fund_return);
                      if(!empty($fund_return)){
                          $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['one_month_interval_percentage_change'];
                          // dd($fund_absolute_return);
                      }
                  }

            //   dd($fund_absolute_return);

              }
              
              $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return)>0? $fund_absolute_return:[];
             
          }
          // dd($quartile_result);
          $data['fund_names'] = implode(", ",$fund_name_array);

      }

      // Pass the request parameters back to the view for form repopulation
      $data['request'] = $request;
      $data['stat_result'] = $quartile_result;
        //  dd($data); 
        return view('web.auth.ratio_analysis.return_ratio',$data);
    }

    public function sortino_ratio(Request $request){

        $data = RatioController::loggedInUserData();

        $user = Auth::user();
        $userId = $user->u_id;
        $fund_all_return =[];
        //  dd($userId);
        $data['browser_title'] = 'Sortino Ratio';
        $data['active_menu'] = 'ratio_analysis_list';
        $jensonAlphaController = new JensonsalphaAPIController;

        $data['all_funds'] = FundMaster::where('status',1)->orderBy('fund_name','asc')->get();
        // dd($data['all_funds']);
        $data['all_fund_types'] = FundType::where('active_passive','A')->get();
        $data['quartile_set'] =  $request->quartile_set;
        // dd($request->all());
        //search block..........
        $quartile_result = [];
        //for searching with fund classification
        // dd($request->all());
        if($request->has('Category') && $request->Category=='by_category'){
            // dd('search_by_classification');
            //validation
            $request->validate([
                'ranking' => 'required'
            ],
            [
                'ranking'.'required' => 'Please Select Range Or As on for Searching'
            ]);

            if($request->ranking == 'range'){
                //validation for range
                $request->validate([
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'fund_type_id' => 'required',
                    'report_category' => 'required',
                    'limit'           => 'required',  
                ],
                [
                    'ranking'.'start_date' => 'Please Select the Start Date',
                    'ranking'.'end_date' => 'Please Select the End Date',
                    'ranking'.'fund_type_id' => 'Please Select the Fund Type',
                    'ranking'.'report_category' => 'Please Select the Report Category',
                    'ranking'.'limit' => 'Please enter Acceptable Return',
                    
                ]);
                // dd($request->report_category);

                $data['fund_type_id'] = $request->fund_type_id;
                $fund_type = FundType::where('ft_id', $request->fund_type_id)->first();
                // dd($fund_type->name);
                $data['fund_type_name'] = $fund_type->name;
                // dd($data['fund_type']);

                
                $start_date = date('Y-m-d', strtotime($request->start_date));
                $data['start_date'] = $start_date;
                $end_date = date('Y-m-d', strtotime($request->end_date));
                $data['end_date'] = $end_date;
                $fund_type_id = $request->fund_type_id;
                $fund_code_in = FundMaster::where('fund_type_id',$fund_type_id)->get();
                $data['report_category'] = $request->report_category;
               
                
                if($request->report_category == 'sortino'){
                    foreach($fund_code_in as $fund_individual){
                        $fund_return = self::sortinoApi($fund_individual->fund_code, $start_date, $end_date, $request->limit);
                        // dd($call_sp);
                        if(!empty($fund_return)){
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['sortino'];
                            // dd($fund_absolute_return);
                            $fund_all_return[$fund_individual['fund_id']] = $fund_return;
                        }
                    }
                }
                // elseif($request->report_category == 'downside_risk'){
                //     foreach($fund_code_in as $fund_individual){
                //         $fund_return = self::jensenalphaApi($fund_individual->fund_code, $start_date, $end_date);
                //         // dd($call_sp);
                //         if(!empty($fund_return)){
                //             $fund_absolute_return[$fund_individual->fund_id] = $fund_return['downside_risk'];
                //             // dd($fund_absolute_return);
                //         }
                //     }
                // }
                //elseif($request->report_category == 'sharpe'){
                //     // dd('sharpe');
                //     foreach($fund_code_in as $fund_individual){
                //         $fund_return = self::sharpeApi($fund_individual->fund_code, $start_date, $end_date);
                //         // dd($call_sp);
                //         // dd($fund_return);
                //         if(!empty($fund_return)){
                //             $fund_absolute_return[$fund_individual->fund_id] = $fund_return['sharpe'];
                //             // dd($fund_absolute_return);
                //         }
                //     }
                // }
                
                // dd($fund_absolute_return);
                // dd($quartile);
                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return)>0? $fund_absolute_return:[];
               
                
            }elseif($request->ranking == 'as_on'){
                // dd('category_as_on')
;                $request->validate([
                    'as_on_date' => 'required',
                    'as_on_time_frame' => 'required',
                    'fund_type_id' => 'required',
                    'report_category' => 'required',
                    'limit'           =>  'required' 
                ],
                [
                    'ranking'.'as_on_date' => 'Please Select the Date',
                    'ranking'.'as_on_time_frame' => 'Please Select the Time Period',
                    'ranking'.'fund_type_id' => 'Please Select the Fund Type',
                    'ranking'.'report_category' => 'Please Select the Report Category',
                    'ranking'.'limit' => 'Please enter Acceptable Return',

                ]);

                $data['fund_type_id'] = $request->fund_type_id;
                $fund_type = FundType::where('ft_id', $request->fund_type_id)->first();
                // dd($fund_type->name);
                $data['fund_type_name'] = $fund_type->name;
                // dd($data['fund_type']);

                
                // $start_date = date('Y-m-d', strtotime($request->start_date));
                // $data['start_date'] = $start_date;
                // $end_date = date('Y-m-d', strtotime($request->end_date));
                // $data['end_date'] = $end_date;

                $end_date = date('Y-m-d', strtotime($request->as_on_date));
                $data['end_date'] = $end_date;
                $data['as_on_time_frame_data'] = $request->as_on_time_frame;
                // dd($request->as_on_time_frame);
                switch($request->as_on_time_frame) {
                    case '1_month':
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                    case '3_months':
                        $start_date = date('Y-m-d', strtotime('-3 months', strtotime($end_date)));
                        break;
                    case '6_months':
                        $start_date = date('Y-m-d', strtotime('-6 months', strtotime($end_date)));
                        break;
                    case '1_year':
                        $start_date = date('Y-m-d', strtotime('-1 year', strtotime($end_date)));
                        break;
                    case '2_year':
                        $start_date = date('Y-m-d', strtotime('-2 year', strtotime($end_date)));
                        break;
                    case '3_years':
                        $start_date = date('Y-m-d', strtotime('-3 years', strtotime($end_date)));
                        break;
                    case '5_years':
                        $start_date = date('Y-m-d', strtotime('-5 years', strtotime($end_date)));
                        break;
                    default:
                        // Handle unexpected values or set a default interval
                        // For example, set the start date to one month before by default
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                }
                
                $data['start_date'] = $start_date;


                $fund_type_id = $request->fund_type_id;
                $fund_code_in = FundMaster::where('fund_type_id',$fund_type_id)->get();
                $data['report_category'] = $request->report_category;

                // dd($fund_code_in);
               
                if($request->report_category == 'sortino'){
                    foreach($fund_code_in as $fund_individual){
                        $fund_return = self::sortinoApi($fund_individual->fund_code, $start_date, $end_date,$request->limit);
                        // dd($call_sp);
                        if(!empty($fund_return)){
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['sortino'];
                            // dd($fund_absolute_return);
                            $fund_all_return[$fund_individual['fund_id']] = $fund_return;
                        }
                    }

                            // dd($fund_absolute_return);

                }
                // elseif($request->report_category == 'downside_risk'){
                //     foreach($fund_code_in as $fund_individual){
                //         $fund_return = self::sortinoApi($fund_individual->fund_code, $start_date, $end_date);
                //         // dd($call_sp);
                //         if(!empty($fund_return)){
                //             $fund_absolute_return[$fund_individual->fund_id] = $fund_return['downside_risk'];
                //             // dd($fund_absolute_return);
                //         }
                //     }
                // }
                // elseif($request->report_category == 'jensens_alpha'){
                //     foreach($fund_code_in as $fund_individual){
                //         $fund_return = self::jensenalphaApi($fund_individual->fund_code, $start_date, $end_date);
                //         // dd($call_sp);
                //         if(!empty($fund_return)){
                //             $fund_absolute_return[$fund_individual->fund_id] = $fund_return['jensens_alpha'];
                //             // dd($fund_absolute_return);
                //         }
                //     }
                // }elseif($request->report_category == 'sharpe'){
                //     // dd('sharpe');
                //     foreach($fund_code_in as $fund_individual){
                //         $fund_return = self::sharpeApi($fund_individual->fund_code, $start_date, $end_date);
                //         // dd($call_sp);
                //         // dd($fund_return);
                //         if(!empty($fund_return)){
                //             $fund_absolute_return[$fund_individual->fund_id] = $fund_return['sharpe'];
                //             // dd($fund_absolute_return);
                //         }
                //     }
                // }
              
                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return)>0? $fund_absolute_return:[];
               
            }
        }
        // dd($quartile_result);
        if($request->has('Category') && $request->Category=='by_fund'){
            // dd('search by fund');
            //validation
            $request->validate([
                'ranking' => 'required'
            ],
            [
                'ranking'.'required' => 'Please Select Range Or As on for Searching'
            ]);

            if($request->ranking == 'range'){
                //validation for range
                $request->validate([
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'fund_id' => 'required',
                    'report_category' => 'required',
                    'limit'     => 'required',
                ],
                [
                    'ranking'.'start_date' => 'Please Select the Start Date',
                    'ranking'.'end_date' => 'Please Select the End Date',
                    'ranking'.'fund_id' => 'Please Select the Fund',
                    'ranking'.'report_category' => 'Please Select the Report Category',
                    'ranking'.'limit' => 'Please enter Acceptable Return',

                    
                ]);

               

                // dd($data['fund_id']);

                $fundMaterData = FundMaster::whereIn('fund_id', $request->fund_id)->get();
                // dd($fundMaterData);
                // $fund_type_id = $fundMaterData->fund_type_id;
                // $fund_code = $fundMaterData->fund_code;

                $fund_type_id =[];
                $fund_code =[];
                $fund_id =[];

                $fund_code_id_arra = [];
                $fund_name_array =[];
                foreach($fundMaterData as $funds){

                    array_push($fund_id,$funds->fund_id);
                    array_push($fund_name_array,$funds->fund_name);

                    array_push($fund_type_id,$funds->fund_type_id);
                    array_push($fund_code,$funds->fund_code);

                    // $fund_code_id_arra['fund_id'] = $funds->fund_id;
                    // $fund_code_id_arra['fund_code'] = $funds->fund_code;

                    $fund_code_id = array(
                        'fund_id' => $funds->fund_id,
                        'fund_code' => $funds->fund_code
                    );
                    
                    array_push($fund_code_id_arra,$fund_code_id);

                }

                $data['fund_id'] = $fund_id;

                $fund_type = FundType::whereIn('ft_id', $fund_type_id)->get();
                
                $fund_type_name_arr = [];

                foreach($fund_type as $f_type){
                    array_push($fund_type_name_arr,$f_type->name);
                }
                $data['fund_type_name'] = $fund_type_name_arr;

                //test end
                $start_date = date('Y-m-d', strtotime($request->start_date));
                $data['start_date'] = $start_date;
                $end_date = date('Y-m-d', strtotime($request->end_date));
                $data['end_date'] = $end_date;
                $data['report_category'] = $request->report_category;
                
                if($request->report_category == 'sortino'){
                    foreach($fund_code_id_arra as $fund_individual){
                        $fund_return = self::sortinoApi($fund_individual['fund_code'], $start_date, $end_date, $request->limit);
                        // dd($fund_return);
                        // dd($call_sp);
                        if(!empty($fund_return)){
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['sortino'];
                            // dd($fund_absolute_return);
                            $fund_all_return[$fund_individual['fund_id']] = $fund_return;
                        }
                    }
                }
                // elseif($request->report_category == 'downside_risk'){
                //     foreach($fund_code_id_arra as $fund_individual){
                //         $fund_return = self::sortinoApi($fund_individual['fund_code'], $start_date, $end_date);
                //         // dd($call_sp);
                //         if(!empty($fund_return)){
                //             $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['downside_risk'];
                //             // dd($fund_absolute_return);
                //         }
                //     }
                //  }
                // elseif($request->report_category == 'jensens_alpha'){
                //     foreach($fund_code_id_arra as $fund_individual){
                //         $fund_return = self::jensenalphaApi($fund_individual['fund_code'], $start_date, $end_date);
                //         // dd($call_sp);
                //         if(!empty($fund_return)){
                //             $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['jensens_alpha'];
                //             // dd($fund_absolute_return);
                //         }
                //     }
                // }elseif($request->report_category == 'sharpe'){
                //     // dd('sharpe');
                //     foreach($fund_code_id_arra as $fund_individual){
                //         $fund_return = self::sharpeApi($fund_individual['fund_code'], $start_date, $end_date);
                //         // dd($call_sp);
                //         // dd($fund_return);
                //         if(!empty($fund_return)){
                //             $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['sharpe'];
                //             // dd($fund_absolute_return);
                //         }
                //     }
                // }
                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return)>0? $fund_absolute_return:[];
              
                
            }elseif($request->ranking == 'as_on'){
                // dd($as_on);
                $request->validate([
                    'as_on_date' => 'required',
                    'as_on_time_frame' => 'required',
                    'fund_id' => 'required',
                    'report_category' => 'required',
                    'limit'     => 'required'
                ],
                [
                    'ranking'.'as_on_date' => 'Please Select the Date',
                    'ranking'.'as_on_time_frame' => 'Please Select the Time Period',
                    'ranking'.'fund_id' => 'Please Select the Fund',
                    'ranking'.'report_category' => 'Please Select the Report Category',
                    'ranking'.'limit' => 'Please enter Acceptable Return',

                ]);

                
                $data['fund_id'] = $request->fund_id;

                // dd($data['fund_id']);

                $fundMaterData = FundMaster::whereIn('fund_id', $request->fund_id)->get();
               

                $fund_type_id =[];
                $fund_code =[];
                $fund_id =[];

                $fund_code_id_arra = [];
                $fund_name_array = [];
                foreach($fundMaterData as $funds){

                    array_push($fund_id,$funds->fund_id);
                    array_push($fund_name_array,$funds->fund_name);

                    array_push($fund_type_id,$funds->fund_type_id);
                    array_push($fund_code,$funds->fund_code);

                    $fund_code_id = array(
                        'fund_id' => $funds->fund_id,
                        'fund_code' => $funds->fund_code
                    );
                    
                    array_push($fund_code_id_arra,$fund_code_id);

                }

                // dd($fund_type_id);
                $fund_type = FundType::whereIn('ft_id', $fund_type_id)->get();
                // dd($fund_type->name);
                $fund_type_name_arr = [];

                foreach($fund_type as $f_type){
                    array_push($fund_type_name_arr,$f_type->name);
                }
                $data['fund_type_name'] = $fund_type_name_arr;
               

               
               

                $end_date = date('Y-m-d', strtotime($request->as_on_date));
                $data['end_date'] = $end_date;

                $data['as_on_time_frame_data'] = $request->as_on_time_frame;
               
                switch($request->as_on_time_frame) {
                    case '1_month':
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                    case '3_months':
                        $start_date = date('Y-m-d', strtotime('-3 months', strtotime($end_date)));
                        break;
                    case '6_months':
                        $start_date = date('Y-m-d', strtotime('-6 months', strtotime($end_date)));
                        break;
                    case '1_year':
                        $start_date = date('Y-m-d', strtotime('-1 year', strtotime($end_date)));
                        break;
                    case '2_year':
                        $start_date = date('Y-m-d', strtotime('-2 year', strtotime($end_date)));
                        break;
                    case '3_years':
                        $start_date = date('Y-m-d', strtotime('-3 years', strtotime($end_date)));
                        break;
                    case '5_years':
                        $start_date = date('Y-m-d', strtotime('-5 years', strtotime($end_date)));
                        break;
                    default:
                        // Handle unexpected values or set a default interval
                        // For example, set the start date to one month before by default
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                }
                
                $data['start_date'] = $start_date;

                // dd($start_date."---".$end_date);
                
                $data['report_category'] = $request->report_category;

               
                // $fund_return = self::jensenalphaApi($fund_code, $start_date, $end_date);
                // dd($call_sp);
                if($request->report_category == 'sortino'){
                    foreach($fund_code_id_arra as $fund_individual){
                        $fund_return = self::sortinoApi($fund_individual['fund_code'], $start_date, $end_date, $request->limit);
                        // dd($fund_return);
                        // dd($call_sp);
                        if(!empty($fund_return)){
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['sortino'];
                            // dd($fund_absolute_return);
                            $fund_all_return[$fund_individual['fund_id']] = $fund_return;
                        }
                    }
                }
                // elseif($request->report_category == 'downside_risk'){
                //     foreach($fund_code_id_arra as $fund_individual){
                //         $fund_return = self::sortinoApi($fund_individual['fund_code'], $start_date, $end_date);
                //         // dd($call_sp);
                //         if(!empty($fund_return)){
                //             $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['downside_risk'];
                //             // dd($fund_absolute_return);
                //         }
                //     }
                //  }
                //elseif($request->report_category == 'sharpe'){
                //     // dd('sharpe');
                //     foreach($fund_code_id_arra as $fund_individual){
                //         $fund_return = self::sharpeApi($fund_individual['fund_code'], $start_date, $end_date);
                //         // dd($call_sp);
                //         // dd($fund_return);
                //         if(!empty($fund_return)){
                //             $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['sharpe'];
                //             // dd($fund_absolute_return);
                //         }
                //     }
                // }
                
                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return)>0? $fund_absolute_return:[];
               
            }
            // dd($quartile_result);
            $data['fund_names'] = implode(", ",$fund_name_array);

        }
        // dd($fund_all_return);
        // Pass the request parameters back to the view for form repopulation
        $data['fund_all_return'] = $fund_all_return;
        $data['request'] = $request;
        $data['stat_result'] = $quartile_result;

        // dd($data);
        

        return view('web.auth.ratio_analysis.sortino_ratio',$data);
    }




    public static function jensenalphaApi($fund_code, $start_date, $end_date,$index_id){
      $baseUrl = URL::to('/');
      $endpoint = 'report-jensens-alpla-api-mar';
      
      // Construct the full URL
      $url = $baseUrl . '/' . $endpoint;
      
      $params = [
          'search_fund_name' => $fund_code,
          'search_from_date' => $start_date,
          'search_to_date' => $end_date,
          'search_index'   => $index_id, 
          'search' => 'Search'
      ];
  
      // Send a GET request to the URL with the query parameters
      $response = Http::get($url, $params);
  
      // Check if the request was successful
      if ($response->successful()) {
          // Get the data from the response
          $ratioData = $response->json();
      } else {
          $ratioData = [];
      }
      return $ratioData;
  }


  public static function sharpeApi($fund_code, $start_date, $end_date,$index_id){
    $baseUrl = URL::to('/');
    $endpoint = 'report-sharpe-api-mar';

    // Construct the full URL
    $url = $baseUrl . '/' . $endpoint;

    $params = [
        'search_fund_name' => $fund_code,
        'search_from_date' => $start_date,
        'search_to_date' => $end_date,
        'search_index'   => $index_id, 

        'search' => 'Search'
    ];

    // Send a GET request to the URL with the query parameters
    $response = Http::get($url, $params);

    // Check if the request was successful
    if ($response->successful()) {
        // Get the data from the response
        $ratioData = $response->json();
    } else {
        $ratioData = [];
    }
    return $ratioData;
}

public static function treynorApi($fund_code, $start_date, $end_date,$index_id){
  $baseUrl = URL::to('/');
  $endpoint = 'report-treynor-api-mar';

  // Construct the full URL
  $url = $baseUrl . '/' . $endpoint;

  $params = [
  'search_fund_name' => $fund_code,
  'search_from_date' => $start_date,
  'search_to_date' => $end_date,
  'search_index'   => $index_id, 

  'search' => 'Search'
  ];

  // Send a GET request to the URL with the query parameters
  $response = Http::get($url, $params);

  // Check if the request was successful
  if ($response->successful()) {
      // Get the data from the response
      $ratioData = $response->json();
  } else {
      $ratioData = [];
  }
  return $ratioData;
}


public static function informationRatioApi($fund_code, $start_date, $end_date,$index_id){
  // dd('informationRatioApi');
  $baseUrl = URL::to('/');
  $endpoint = 'report-information-ratio-api-mar';

  // Construct the full URL
  $url = $baseUrl . '/' . $endpoint;
  // dd($url);

  $params = [
  'search_fund_name' => $fund_code,
  'search_from_date' => $start_date,
  'search_to_date' => $end_date,
  'search_index'   => $index_id, 

  'search' => 'Search'
  ];
  $fullUrl = $url . '?' . http_build_query($params);
  // dd($fullUrl);
  // Send a GET request to the URL with the query parameters
  $response = Http::get($url, $params);
  // dd($response);
  // Check if the request was successful
  if ($response->successful()) {
      // Get the data from the response
      $ratioData = $response->json();
  } else {
      $ratioData = [];
  }
  return $ratioData;
}


public static function skewnessApi($fund_code, $start_date, $end_date,$index_id){
  // dd('informationRatioApi');
  $baseUrl = URL::to('/');
  $endpoint = 'report-skewness-api-mar';

  // Construct the full URL
  $url = $baseUrl . '/' . $endpoint;
  // dd($url);

  $params = [
  'search_fund_name' => $fund_code,
  'search_from_date' => $start_date,
  'search_to_date' => $end_date,
  'search_index'   => $index_id, 

  'search' => 'Search'
  ];
  $fullUrl = $url . '?' . http_build_query($params);
  // dd($fullUrl);
  // Send a GET request to the URL with the query parameters
  $response = Http::get($url, $params);
  // dd($response);
  // Check if the request was successful
  if ($response->successful()) {
      // Get the data from the response
      $ratioData = $response->json();
  } else {
      $ratioData = [];
  }
  return $ratioData;
}

public static function kurtosisApi($fund_code, $start_date, $end_date,$index_id){
  // dd('informationRatioApi');
  $baseUrl = URL::to('/');
  $endpoint = 'report-kurtosis-api-mar';

  // Construct the full URL
  $url = $baseUrl . '/' . $endpoint;
  // dd($url);

  $params = [
  'search_fund_name' => $fund_code,
  'search_from_date' => $start_date,
  'search_to_date' => $end_date,
  'search_index'   => $index_id, 

  'search' => 'Search'
  ];
  $fullUrl = $url . '?' . http_build_query($params);
  // dd($fullUrl);
  // Send a GET request to the URL with the query parameters
  $response = Http::get($url, $params);
  // dd($response);
  // Check if the request was successful
  if ($response->successful()) {
      // Get the data from the response
      $ratioData = $response->json();
  } else {
      $ratioData = [];
  }
  return $ratioData;
}

public static function r_squareApi($fund_code, $start_date, $end_date,$index_id){
  // dd('informationRatioApi');
  $baseUrl = URL::to('/');
  $endpoint = 'report-r-squere-api-mar';

  // Construct the full URL
  $url = $baseUrl . '/' . $endpoint;
  // dd($url);

  $params = [
  'search_fund_name' => $fund_code,
  'search_from_date' => $start_date,
  'search_to_date' => $end_date,
  'search_index'   => $index_id, 

  'search' => 'Search'
  ];
  $fullUrl = $url . '?' . http_build_query($params);
  // dd($fullUrl);
  // Send a GET request to the URL with the query parameters
  $response = Http::get($url, $params);
  // dd($response);
  // Check if the request was successful
  if ($response->successful()) {
      // Get the data from the response
      $ratioData = $response->json();
  } else {
      $ratioData = [];
  }
  return $ratioData;
}

public static function oneMonthRollingReturnApi($fund_code, $start_date, $end_date,$index_id){
  // dd('informationRatioApi');
  $baseUrl = URL::to('/');
  $endpoint = 'report-rolling-return-api';

  // Construct the full URL
  $url = $baseUrl . '/' . $endpoint;
  // dd($url);

  $params = [
  'search_fund_name' => $fund_code,
  'search_from_date' => $start_date,
  'search_to_date' => $end_date,
  'search_index'   => $index_id, 

  'search' => 'Search'
  ];
  $fullUrl = $url . '?' . http_build_query($params);
  // dd($fullUrl);
  // Send a GET request to the URL with the query parameters
  $response = Http::get($url, $params);
  // dd($response);
  // Check if the request was successful
  if ($response->successful()) {
      // Get the data from the response
      $ratioData = $response->json();
  } else {
      $ratioData = [];
  }
  return $ratioData;
}


public static function sortinoApi($fund_code, $start_date, $end_date, $mar_return){
    // dd('informationRatioApi');
    $baseUrl = URL::to('/');
    $endpoint = 'report-sortino-api';

    // Construct the full URL
    $url = $baseUrl . '/' . $endpoint;

    // dd($url);

    $params = [
    'search_fund_name' => $fund_code,
    'search_from_date' => $start_date,
    'search_to_date' => $end_date,
    'mar_return'     => $mar_return,   
    'search' => 'Search'
    ];
    $fullUrl = $url . '?' . http_build_query($params);
    // dd($fullUrl);
    // Send a GET request to the URL with the query parameters
    $response = Http::get($url, $params);
    // dd($response);
    // Check if the request was successful
    if ($response->successful()) {
        // Get the data from the response
        $ratioData = $response->json();
    } else {
        $ratioData = [];
    }
    return $ratioData;
}

}
