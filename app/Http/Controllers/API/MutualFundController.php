<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FundDictionary;
class MutualFundController extends BaseController
{
    public function getDirectory(Request $request){
        $searchValue=$request->get('text');
        $records = FundDictionary::orderBy('title', 'asc')
            ->where('fund_dictionary.title', 'like', '%' . $searchValue . '%')
            ->orWhere('fund_dictionary.description', 'like', '%' . $searchValue . '%')
            ->select('fund_dictionary.*')
            // ->skip($start)
            // ->take($rowperpage)
            ->paginate($request->get('limit'));
            $responseArr['table_data'] = $records;
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
    }
}
