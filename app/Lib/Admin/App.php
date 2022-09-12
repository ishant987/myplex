<?php
namespace App\Lib\Admin;

use App\Models\ModuleModel;
use App\Models\ModuleMethodModel;
use App\Models\RoleModuleMethodRightsModel;

class App
{
    public static function getListDataAtr(){
        $dataArr = ["mdfy_dt_frmt"=>Config('commonconstants.dt_tm_frmt2'), "unknown_txt"=>__('common.unknown_txt'), "alert_css"=>Config('adminconstants.alert_css'), "edit_txt"=>__('admin.edit_txt')];
        return $dataArr;
    }

    public static function getStatusLblTyp1Atr(){
        $dataArr = ["status_type"=>Config('adminconstants.status_lbl_typ1'), "label"=>__('common.status_lbl_typ1_txt')];
        return $dataArr;
    }

    public static function getStatusLblTyp2Atr(){
        $dataArr = ["status_type"=>Config('adminconstants.status_lbl_typ2'), "label"=>__('common.status_lbl_typ2_txt')];
        return $dataArr;
    }

    public static function getStatusLblTyp1Arr(){
        $dataArr = array(Config('commonconstants.status_val.1') => __('common.status_lbl_typ1_txt.1'), Config('commonconstants.status_val.2') => __('common.status_lbl_typ1_txt.2'));
        return $dataArr;
    }

    public static function getStatusLblTyp2Arr(){
        $dataArr = array(Config('commonconstants.status_val.1') => __('common.status_lbl_typ2_txt.1'), Config('commonconstants.status_val.2') => __('common.status_lbl_typ2_txt.2'));
        return $dataArr;
    }

    public static function getYesNoArr(){
        $dataArr = array(Config('commonconstants.y_n_val.1') => __('common.yes_no_txt.y'), Config('commonconstants.y_n_val.2') => __('common.yes_no_txt.n'));
        return $dataArr;
    }

    public static function getReportListDataAtr(){
        $dataArr = ["mdfy_dt_frmt"=>Config('commonconstants.dt_tm_frmt2'),"dt_tm_report_frmt"=>Config('commonconstants.dt_tm_report_frmt'), "view_txt"=>__('admin.view_txt'), "edit_txt"=>__('admin.edit_txt'), "target"=>Config('commonconstants.target_opt1'), "unknown_txt"=>__('common.unknown_txt'), "na_txt"=>__('common.na_txt')];
        return $dataArr;
    }

    public static function hasAccessToMethod($controller,$route)
    {
        if(auth()->guard('admin')->user() && $controller && $route)
        {
            $role_id = auth()->guard('admin')->user()->role_id;
            if($role_id>0)
            {
                $moduleModel = ModuleModel::select('module_id')->where(['class_name'=>$controller,'status'=>1])->first();
                if($moduleModel && $moduleModel->module_id>0)
                {
                    $module_id = $moduleModel->module_id;
                    $moduleMethodModel = ModuleMethodModel::select('method_id')->where(['route_link'=>$route,'module_id'=>$module_id])->first();
                    if($moduleMethodModel && $moduleMethodModel->method_id>0)
                    {
                        $method_id = $moduleMethodModel->method_id;
                        $roleModuleMethodRightsModel = RoleModuleMethodRightsModel::where(['module_id'=>$module_id,'method_id'=>$method_id,'role_id'=>$role_id])->first();
                        if($roleModuleMethodRightsModel && $roleModuleMethodRightsModel->role_module_method_right_id>0){
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function linkTargetAtr(){
        $adminLang = __('admin');
        $opt1 = $adminLang['target_optn1_txt'];
        $opt2 = $adminLang['target_optn2_txt'];
        $dataArr = [$opt1, $opt2];
        return $dataArr;
    }

    public static function medium(){
        $medium = Config('commonconstants.medium');
        $value = $medium['value'];
        $text = $medium['text'];

        $opt1 = $value['0'];
        $opt2 = $value['1'];
        $opt3 = $value['2'];
        $dataArr = [$opt1 => $text[$opt1], $opt2 => $text[$opt2], $opt3 => $text[$opt3]];
        return $dataArr;
    }

    public static function getMediumLblTyp2Atr(){
        $medium = Config('commonconstants.medium');
        $value = $medium['value'];
        $text = $medium['text'];

        $opt2 = $value['1'];
        $opt3 = $value['2'];
        $dataArr = [$opt2 => $text[$opt2], $opt3 => $text[$opt3]];
        return $dataArr;
    }

    public static function getMediumLblTyp3Atr(){
        $medium = Config('commonconstants.medium');
        $value = $medium['value'];
        $text = $medium['text'];

        $opt1 = $value['0'];
        $opt2 = $value['1'];
        $opt3 = $value['2'];
        $opt4 = $value['3'];
        $dataArr = [$opt1 => $text[$opt1], $opt2 => $text[$opt2], $opt3 => $text[$opt3], $opt4 => $text[$opt4]];
        return $dataArr;
    }

    public static function getMediumLblTyp4Atr(){
        $medium = Config('commonconstants.medium');
        $value = $medium['value'];
        $text = $medium['text'];

        $opt1 = $value['1'];
        $opt2 = $value['2'];
        $opt3 = $value['3'];
        $dataArr = [$opt1 => $text[$opt1], $opt2 => $text[$opt2], $opt3 => $text[$opt3]];
        return $dataArr;
    }

    public static function getMediumLblTyp5Atr(){
        $medium = Config('commonconstants.medium');
        $value = $medium['value'];
        $text = $medium['text'];

        $opt1 = $value['1'];
        $opt2 = $value['2'];
        $opt3 = $value['3'];
        $opt4 = $value['4'];
        return [$opt1 => $text[$opt1], $opt2 => $text[$opt2], $opt3 => $text[$opt3], $opt4 => $text[$opt4]];
    }

    public static function printR($arr,$exit=true)
    {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
        if($exit)
            die();
    }
}
