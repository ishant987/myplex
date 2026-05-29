<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

use App\Lib\Core\UsefulSql;

use App\Models\ModuleClassModel;

class BaseController extends Controller
{
	public $_curController;
	public $_curMethod;
	
    public function changeStatus(Request $request)
    {
		if($input = $request->all()){
			$table = $input['table'];
			$status = $input['status'];
			$newstatus = $status > 1 ? 1 : 2;
			$id = $input['id'];
			$idName = $input['id_name'];
			$msgType = $input['msg_type'];
			$url = $input['url'];
			switch ($msgType) {
				case Config('adminconstants.status_lbl_typ1'):/*Active / Inactive*/
					$statusLblTxt = __('common.status_lbl_typ1_txt');
					break;
				case Config('adminconstants.status_lbl_typ2'):/*Enabled / Disabled*/
					$statusLblTxt = __('common.status_lbl_typ2_txt');
					break;
			}

			$alertCss = Config('adminconstants.alert_css');

			$whereFldArr = array($idName => $id);
			$updFldArr   = array('status' => $newstatus, 'updated_id' => auth()->guard('admin')->user()->admin_id, 'updated_at' => now());
			if($table=='blog'){
				$curTime = new \DateTime();
          		$published_time = $curTime->format("Y-m-d H:i:s");
				if($newstatus==1)
				{
					$blogArray['published_date']=$published_time;
				}
				$blogArray['is_active']=$newstatus;
				$updFldArr=array_merge($updFldArr,$blogArray);
			}
			$res = UsefulSql::updateSingleRecord($table, $whereFldArr, $updFldArr);
			if($res){
				$newbtnClass = $alertCss[$newstatus];
				$newstatusTxt = $statusLblTxt[$newstatus];

				$resArr['msg'] = $alertCss[1];
				$resArr['content']= <<<EOF
				<label id="change_status$id" onclick="return changeStatus('$idName', '$id', '$table', '$newstatus', '$msgType', '$url');" class="label btn-$newbtnClass">$newstatusTxt</label>
				EOF;
			}
			else{
				$newbtnClass = $alertCss[$status];
				$statusTxt = $statusLblTxt[$status];

				$resArr['msg'] = $alertCss[1];
				$resArr['content']= <<<EOF
				<label id="change_status$id" onclick="return changeStatus('$idName', '$id', 'admin', '$status', '$msgType', '$url');" class="label btn-$newbtnClass">$statusTxt</label>
				EOF;
			}
			return json_encode($resArr);
		}
    }    

    public static function getLoggedInAdminId(){
    	return auth()->guard('admin')->user()->admin_id;
    }

    public static function getClassIdByname($class_name){
    	return ModuleClassModel::getClassIdByname($class_name);
    }
}
