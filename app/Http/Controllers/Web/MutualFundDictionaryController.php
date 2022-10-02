<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Models\PageModel;
use App\Models\FundDictionary;

class MutualFundDictionaryController extends BaseController
{
    public function __construct()
    {
        $this->defDataArr = self::getDefData();
        $this->page_path =env('PAGE_PATHS','web.pages');
    }

    public function index(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 25;
        }

        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.mutual-fund-dictionary', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    /* Process ajax request */
    public function dataList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = FundDictionary::select('count(*) as allcount')->count();
        $totalRecordswithFilter = FundDictionary::select('count(*) as allcount')->where('title', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = FundDictionary::orderBy($columnName, $columnSortOrder)
            ->where('fund_dictionary.title', 'like', '%' . $searchValue . '%')
            ->orWhere('fund_dictionary.description', 'like', '%' . $searchValue . '%')
            ->select('fund_dictionary.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "title" => $record->title,
                "description" => $record->description,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $data_arr,
        );

        echo json_encode($response);
    }
}
