<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\BaseController;
use App\Models\CorpusEntry;
use Illuminate\Http\Request;
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
use App\Models\FundComposition;

class NewScripsNewIndustryController extends Controller
{
  public function __construct()
  {
    $this->Useful = new Useful;
  }

  // ********************************************** New Script New Industry ***************************************************************** /

  public function new_script_new_industry(Request $request)
  {

    $data = RatioController::loggedInUserData();
    $getdata = $request->all();

    if (isset($getdata) && count($getdata) > 0) {

      $request->validate(
        [
          'month' => 'required',
          'year' => 'required',
          'month_second' => 'required',
          'year_second' => 'required',

        ],
        [
          'month' . 'required' => 'Please Select 1st period Month for Searching',
          'year' . 'required' => 'Please Select 1st period Year for Searching',

          'month_second' . 'required' => 'Please Select 2nd period Month for Searching',
          'year_second' . 'required' => 'Please Select 2nd period Year for Searching',
        ]
      );

      $data['month'] = $month = $getdata['month'];
      $data['year'] = $year = $getdata['year'];
      $data['month_second'] = $month_second = $getdata['month_second'];
      $data['year_second'] = $year_second = $getdata['year_second'];

      $data['Category'] = $getdata['Category'];
      $p_one_lastDate = Carbon::create($data['year'], $data['month'])->endOfMonth()->toDateString();
      $data['lastDate'] = $p_two_lastDate = Carbon::create($data['year_second'], $data['month_second'])->endOfMonth()->toDateString();
      $data['active_tab'] = $request->active_tab;

      if ($getdata['Category'] == 'by_fund') {

        $request->validate([
          'fund_id' => 'required',
        ], [
          'fund_id.required' => 'Please select fund'
        ]);


        $data['fund_id'] = $request->fund_id;

        $data['fundCodes'] = $fundCodes = FundMaster::whereIn('fund_id', $request->fund_id)->select('fund_code')->orderBy('fund_name', 'asc')->get()->pluck('fund_code')->toArray();
      }

      if ($getdata['Category'] == 'by_category') {


        $request->validate([
          'fund_type' => 'required',
        ], [
          'fund_type.required' => 'Please select fund type'
        ]);

        $data['fund_type_id']   = $getdata['fund_type'];
        $fund_type              = FundType::where('ft_id', $request->fund_type)->first();
        $data['fund_type_name'] = $fund_type->name;
        $data['fundCodes'] =  $fundCodes = FundMaster::where('fund_type_id', $getdata['fund_type'])->select('fund_code')->orderBy('fund_name', 'asc')->get()->pluck('fund_code')->toArray();
      }


      $total_corpus_entry = DB::table('corpus_entry')
        ->whereIn('fund_code', $fundCodes)
        ->where('entry_date', $p_two_lastDate)
        ->select(
          DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
        )->first()->total_corpus_entry;


      $data['scrips'] = DB::table('view_corpus_with_allocation')
        ->whereIn('fund_code', $fundCodes)
        ->where('corpus_entry_date', $p_two_lastDate)
        ->where('composition_entry_date', $p_two_lastDate)
        ->where('category', 'Equity')
        ->whereNotIn('scrip_name', function ($query) use ($p_one_lastDate, $fundCodes) {
          $query->select('scrip_name')
            ->from(DB::raw('mpx_view_corpus_with_allocation'))
            ->where('composition_entry_date', $p_one_lastDate)
            ->whereIn('fund_code', $fundCodes);
        })
        ->select(
          'scrip_name',
          'industry',
          DB::raw('SUM(calculated_amount/100) as amount'),
          DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
        )
        ->orderBy('content_per', 'desc')
        ->groupBy('scrip_name')
        ->get();



      $data['industry'] = DB::table('view_corpus_with_allocation')
        ->whereIn('fund_code', $fundCodes)
        ->where('corpus_entry_date', $p_two_lastDate)
        ->where('composition_entry_date', $p_two_lastDate)
        ->where('category', 'Equity')
        ->whereNotIn('industry', function ($query) use ($p_one_lastDate, $fundCodes) {
          $query->select('industry')
            ->from(DB::raw('mpx_view_corpus_with_allocation'))
            ->where('composition_entry_date', $p_one_lastDate)
            ->whereIn('fund_code', $fundCodes);
        })
        ->select(
          'industry',
          'category',
          DB::raw('SUM(calculated_amount/100) as amount'),
          DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
        )
        ->orderBy('content_per', 'desc')
        ->groupBy('industry')
        ->get();
    }

    $data['browser_title'] = 'New Scrips New Industries';
    $data['active_menu'] = 'composition_report_list';
    $data['all_fund_types'] = FundType::get();
    $data['all_funds'] = FundMaster::where('status', 1)->orderBy('fund_name', 'asc')->get();
    $data['request'] = $request;

    $months = [];
    $years = [];
    for ($i = 1; $i <= 12; $i++) {
      // $months_array = $i .'=>'. date('F', mktime(0, 0, 0, $i, 10));
      $months_array = $i;

      array_push($months, $months_array);
    }

    $start_year = intval(date('Y')) - 5;

    for ($i = date('Y'); $i >= $start_year; $i--) {
      $year_array = $i;
      array_push($years, $year_array);
    }

    $data['months'] = $months;
    $data['years'] = $years;

    $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();

    // dd($disclaimerQuery->disclaimer);

    $data['disclaimer'] = $disclaimerQuery->disclaimer;

    return view('web.composition_report.new_script_new_industry', $data);
  }


  // ********************************************** New Script New Industry ***************************************************************** //









  function getlastdate($month, $year)
  {
    $date = Carbon::create($year, $month, 1);

    // Get the last day of the month
    $lastDayOfMonth = $date->endOfMonth()->toDateString();

    return date('Y-m-d', strtotime($lastDayOfMonth));
  }
}
