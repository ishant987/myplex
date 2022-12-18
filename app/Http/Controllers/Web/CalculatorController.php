<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageModel;
class CalculatorController extends BaseController
{
    public $className;
    public $class_id;

    public function __construct()
    {
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
        $this->class_id = self::getClassIdByname($this->className);
        $this->page_path =env('PAGE_PATHS','web.pages');
        $this->defDataArr = self::getDefData();
    }
    public function calculatorsPageData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 44;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
            $defDataArr = $this->defDataArr;
            if ($request->isMethod('post')) {
                
            }
            return view($this->page_path.'.calculators', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }
    public function CalualotLogin(Request $request){
        session()->put('useremail', $request->useremail);
        session()->put('username', $request->username);
        return redirect()->back();
    }
    public function ObjectiveCalculator(Request $request, $slug = false){
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 44;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
            $defDataArr = $this->defDataArr;
            return view($this->page_path.'.calulators.objective_calculator', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }
    public function InflationCalculator(Request $request, $slug = false){
        // session()->forget('useremail');
        // session()->forget('username');
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 44;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
            $defDataArr = $this->defDataArr;
            if ($request->isMethod('post')) {
                session()->put('useremail', $request->useremail);
                session()->put('username', $request->username);
            }
            return view($this->page_path.'.calulators.inflation_calculator', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }
    public function RetirementCalculator(Request $request, $slug = false){
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 44;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
            $defDataArr = $this->defDataArr;
           
            return view($this->page_path.'.calulators.retirement_calulator', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }
    public function RiskCalculator(Request $request, $slug = false){
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 44;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
            $defDataArr = $this->defDataArr;
            
            return view($this->page_path.'.calulators.risk_evaluation', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }
}
