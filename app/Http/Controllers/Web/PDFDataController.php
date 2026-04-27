<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\FundType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use DB;
use PDF;


class PDFDataController extends BaseController
{
    protected function brandingData(): array
    {
        $defaultLogo = public_path('images/myplexus-footer-logo.png');
        $defaultCompanyName = 'myplexus.com';

        $branding = [
            'company_name' => $defaultCompanyName,
            'headline' => $defaultCompanyName,
            'tagline' => 'Search, Research Mutual Funds',
            'footer_logo' => $defaultLogo,
        ];

        $user = Auth::user();

        if (!$user || !$user->hasWhiteLabel()) {
            return $branding;
        }

        $settings = $user->whiteLabelSettings();
        $customLogo = !empty($settings['logo']) ? public_path($settings['logo']) : null;
        $companyName = $settings['company_name'] ?: $defaultCompanyName;

        return [
            'company_name' => $companyName,
            'headline' => $companyName,
            'tagline' => 'White Label Report',
            'footer_logo' => $customLogo && file_exists($customLogo) ? $customLogo : $defaultLogo,
        ];
    }

    public function compositionSnapshotPDF($type_id)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        $dataArr['type_data'] = FundType::select(['name','ft_id'])->where('ft_id', $type_id)->first();

        $dataArr['composition_data'] = DB::select('CALL sp_fund_composition_classification('.$type_id.')');
        if (!empty($dataArr['type_data']) && count($dataArr['composition_data'])) {
            $dataArr['type_data'] = json_decode(json_encode($dataArr['type_data']), true);
            $dataArr['composition_data'] = json_decode(json_encode($dataArr['composition_data']), true);
            $branding = $this->brandingData();
            $pdf = PDF::loadView('pdf.composition-snapshot', compact('dataArr', 'branding'));
            return $pdf->stream();
        }
        return abort(404, 'data not found.');
    }
    public function monthlyRankingPDF(Request $request, $type_id)
    {
        $dataArr = $responseArr = $dataArrRatios = [];
        $dataArr['type_data'] = FundType::select(['name','ft_id'])->where('ft_id', $type_id)->first();
        $dataArr['type_data'] = json_decode(json_encode($dataArr['type_data']), true);

        $response = Http::get(url('api/v1/monthly-ranking/'.$type_id));
        // $response = Http::get('https://beta.myplexus.com/api/v1/monthly-ranking/'.$type_id);
        $dataArrRatios = $response->json();

        if (count($dataArrRatios['data']['monthly_ranking'])) {
            $dataArr['monthly_ranking_data'] = $dataArrRatios['data']['monthly_ranking'];
            $dataArr['month'] = date('F', strtotime($dataArr['monthly_ranking_data'][0]['end_date']));
            $dataArr['year'] = date('Y', strtotime($dataArr['monthly_ranking_data'][0]['end_date']));
            $branding = $this->brandingData();
            $pdf = PDF::loadView('pdf.monthly-ranking', compact('dataArr', 'branding'));
            return $pdf->stream();
        }
        return abort(404, 'data not found.');
    }
    public function performanceSnapshotPDF(Request $request)
    {
        $dataArr = $responseArr = $dataArrRatios = [];
        $type_id = isset($request->fund_type_id) ? $request->fund_type_id : '';

        $type = (isset($request->type) && $request->type) ? $request->type : '';
        $report_category = isset($request->report_category) ? $request->report_category : '';
        $date = (isset($request->date) && $request->date) ? urldecode($request->date) : '';


        $dataArr['type_data'] = FundType::select(['name','ft_id'])->where('ft_id', $type_id)->first();
        $dataArr['type_data'] = json_decode(json_encode($dataArr['type_data']), true);
        $dataArr['type_data']['type'] = $type;
        $dataArr['type_data']['report_category'] = $report_category;

        $response = Http::get(url('api/v1/performance-snapshot/'), $request->all());
        $dataArrSn = $response->json();
        if (count($dataArrSn['data']['snapshot_data'])) {
            $dataArr['type_data']['text'] = 'As on '.date('d/m/Y', strtotime($date));

            $dataArr['performance_snapshot_data'] = $dataArrSn['data']['snapshot_data'];
            $branding = $this->brandingData();
            $pdf = PDF::loadView('pdf.performance-snapshot', compact('dataArr', 'branding'));
            return $pdf->stream();
        }
        return abort(404, 'data not found.');
    }
}
