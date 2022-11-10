<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FrontDataController;
use App\Http\Controllers\API\SnapShotController;
use App\Http\Controllers\API\CompareSchemeController;
use App\Http\Controllers\API\MutualFundController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
  'prefix' => 'v1'
], function () {
    Route::get('fund-houses', [FrontDataController::class, 'getFundHouses']);
    Route::get('indices', [FrontDataController::class, 'getIndices']);
    Route::get('currencies', [FrontDataController::class, 'getCurrencies']);
    Route::get('fund-classifications', [FrontDataController::class, 'getFundClassifications']);
    Route::get('funds', [FrontDataController::class, 'getFunds']);
    Route::get('fund-portfolio', [FrontDataController::class, 'getFundComposition']);
    Route::get('fund-composition-snapshot/{type_id}', [FrontDataController::class, 'getFundCompositionSnapshot']);
    Route::get('snapshot-dates', [FrontDataController::class, 'getSnapshotDates']);
    Route::get('weekly-changes-fund-type', [FrontDataController::class, 'getWeeklyChangesFundType']);
    Route::get('monthly-changes-fund-type', [FrontDataController::class, 'getMonthlyChangesFundType']);
    Route::get('weekly-best-funds', [FrontDataController::class, 'getWeeklyBestFunds']);
    Route::get('monthly-best-funds', [FrontDataController::class, 'getMonthlyBestFunds']);
    Route::get('changes-fund', [FrontDataController::class, 'getChangesFund']);
    Route::get('changes-index', [FrontDataController::class, 'getChangesIndex']);
    Route::get('changes-currency', [FrontDataController::class, 'getChangesCurrency']);
    Route::get('changes-commodity', [FrontDataController::class, 'getChangesCommodity']);
    Route::get('monthly-ranking-date', [FrontDataController::class, 'getMonthlyRankingDate']);
    Route::get('monthly-ranking/{type_id}', [FrontDataController::class, 'monthlyRanking']);
    Route::get('fund-return-scheme', [FrontDataController::class, 'fundReturnScheme']);
    Route::get('fund-return-benchmark', [FrontDataController::class, 'fundReturnBenchmark']);
    Route::get('fund-performance-compare-category', [FrontDataController::class, 'fundPerformanceCompareToCategory']);
    Route::get('fund-performance-scheme-sip', [FrontDataController::class, 'fundPerformanceSchemeSIP']);
    Route::get('fund-performance-benchmark-sip', [FrontDataController::class, 'fundPerformanceBenchmarkSIP']);
    Route::get('fund-details', [FrontDataController::class, 'fundDetails']);
    Route::get('fund-index-currency', [FrontDataController::class, 'getFundIndexCurrency']);
    Route::get('fund-performance-benchmark-high-low', [FrontDataController::class, 'fundPerformanceBenchmarkHighLow']);
    Route::get('fund-performance-scheme-high-low', [FrontDataController::class, 'fundPerformanceSchemeHighLow']);
    Route::get('fund-performance-jensenalpha-beta-volatility', [FrontDataController::class, 'fundPerformanceJensenalphaBetaVolatility']);
    Route::get('fund-performance-aaum', [FrontDataController::class, 'getFundPerformanceAAUM']);
    Route::get('fund-portfolio-details', [FrontDataController::class, 'getFundPortfolioDetails']);
    Route::get('fund-portfolio-top-scripts', [FrontDataController::class, 'getFundPortfolioTopScripts']);
    Route::get('fund-portfolio-top-industries', [FrontDataController::class, 'getFundPortfolioTopIndustries']);
    Route::get('compare-price', [FrontDataController::class, 'getComparePrice']);
    Route::get('compare-ratios', [FrontDataController::class, 'getCompareRatios']);
    Route::get('compare-compositions', [FrontDataController::class, 'getCompareComposition']);
    Route::get('performance-snapshot', [FrontDataController::class, 'getPerformanceSnapshot']);
    Route::post('send-sip-planner-email', [FrontDataController::class, 'sendSipPlannerEmail']);
    Route::post('calculate-risk-tolerance-portfolio', [FrontDataController::class, 'calculateRiskTolerancePortfolio']);
    Route::post('send-inflation-calculator-email', [FrontDataController::class, 'sendInflationCalculatorEmail']);
    Route::post('send-retirement-calculator-email', [FrontDataController::class, 'sendRetirementCalulatorEmail']);
    Route::post('sip-performance-calculator', [FrontDataController::class, 'sipPerformanceCalculator']);
    Route::post('send-sip-calculator-email', [FrontDataController::class, 'sipCalculatorEmail']);
});
Route::group([
  'prefix' => 'v2'
], function () {
    Route::get('mutual-fund-directory', [MutualFundController::class, 'getDirectory']);
    Route::get('fund-houses', [FrontDataController::class, 'getFundHouses']);
    Route::get('indices', [FrontDataController::class, 'getIndices']);
    Route::get('currencies', [FrontDataController::class, 'getCurrencies']);
    Route::get('fund-classifications', [FrontDataController::class, 'getFundClassifications']);
    Route::get('funds', [FrontDataController::class, 'getFunds']);
    Route::get('fund-portfolio', [FrontDataController::class, 'getFundComposition']);
    Route::get('fund-composition-snapshot/{type_id}', [FrontDataController::class, 'getFundCompositionSnapshot']);
    Route::get('snapshot-dates', [FrontDataController::class, 'getSnapshotDates']);
    Route::get('weekly-changes-fund-type', [FrontDataController::class, 'getWeeklyChangesFundType']);
    Route::get('monthly-changes-fund-type', [FrontDataController::class, 'getMonthlyChangesFundType']);
    Route::get('weekly-best-funds', [FrontDataController::class, 'getWeeklyBestFunds']);
    Route::get('monthly-best-funds', [SnapShotController::class, 'getMonthlyBestFunds']);
    Route::get('monthly-bad-funds', [SnapShotController::class, 'getMonthlyBadFunds']);
    Route::get('changes-fund', [FrontDataController::class, 'getChangesFund']);
    Route::get('changes-index', [FrontDataController::class, 'getChangesIndex']);
    Route::get('changes-currency', [FrontDataController::class, 'getChangesCurrency']);
    Route::get('changes-commodity', [FrontDataController::class, 'getChangesCommodity']);
    Route::get('monthly-ranking-date', [FrontDataController::class, 'getMonthlyRankingDate']);
    Route::get('monthly-ranking/{type_id}', [FrontDataController::class, 'monthlyRanking']);
    Route::get('fund-return-scheme', [FrontDataController::class, 'fundReturnScheme']);
    Route::get('fund-return-benchmark', [FrontDataController::class, 'fundReturnBenchmark']);
    Route::get('fund-performance-compare-category', [FrontDataController::class, 'fundPerformanceCompareToCategory']);
    Route::get('fund-performance-scheme-sip', [FrontDataController::class, 'fundPerformanceSchemeSIP']);
    Route::get('fund-performance-benchmark-sip', [FrontDataController::class, 'fundPerformanceBenchmarkSIP']);
    Route::get('fund-details', [FrontDataController::class, 'fundDetails']);
    Route::get('fund-index-currency', [FrontDataController::class, 'getFundIndexCurrency']);
    Route::get('fund-performance-benchmark-high-low', [FrontDataController::class, 'fundPerformanceBenchmarkHighLow']);
    Route::get('fund-performance-scheme-high-low', [FrontDataController::class, 'fundPerformanceSchemeHighLow']);
    Route::get('fund-performance-jensenalpha-beta-volatility', [FrontDataController::class, 'fundPerformanceJensenalphaBetaVolatility']);
    Route::get('fund-performance-aaum', [FrontDataController::class, 'getFundPerformanceAAUM']);
    Route::get('fund-portfolio-details', [FrontDataController::class, 'getFundPortfolioDetails']);
    Route::get('fund-portfolio-top-scripts', [FrontDataController::class, 'getFundPortfolioTopScripts']);
    Route::get('fund-portfolio-top-industries', [FrontDataController::class, 'getFundPortfolioTopIndustries']);
    Route::get('compare-price', [CompareSchemeController::class, 'getComparePrice']);
    Route::get('compare-ratios', [CompareSchemeController::class, 'getCompareRatios']);
    Route::get('compare-compositions', [CompareSchemeController::class, 'getCompareComposition']);
    Route::get('performance-snapshot', [FrontDataController::class, 'getPerformanceSnapshot']);
    Route::post('send-sip-planner-email', [FrontDataController::class, 'sendSipPlannerEmail']);
    Route::post('calculate-risk-tolerance-portfolio', [FrontDataController::class, 'calculateRiskTolerancePortfolio']);
    Route::post('send-inflation-calculator-email', [FrontDataController::class, 'sendInflationCalculatorEmail']);
    Route::post('send-retirement-calculator-email', [FrontDataController::class, 'sendRetirementCalulatorEmail']);
    Route::post('sip-performance-calculator', [FrontDataController::class, 'sipPerformanceCalculator']);
    Route::post('send-sip-calculator-email', [FrontDataController::class, 'sipCalculatorEmail']);
});