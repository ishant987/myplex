<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;
use Response;

use App\Lib\Admin\App;
use App\Lib\Core\Core;
use App\Models\FundMaster;
use App\Models\IndicesComposition;
use App\Models\IndicesDetail;
use App\Models\IndicesMaster;
use Illuminate\Support\Facades\DB;

class IndicesMasterController extends BaseController
{
    public $className;

    public function __construct(){
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($time='')
    {
        $dataListModel = IndicesMaster::list();

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.indices.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.indices.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.indices.delete')];
        
        return view('themes.backend.pages.indices.index', compact('dataListModel', 'listDataAtrArr', 'roleRights', 'statusAtrArr', 'time'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusArr = App::getStatusLblTyp2Arr();
        return view('themes.backend.pages.indices.createform', compact('statusArr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'corelation' => 'required',
            'status' => 'required|integer'
        ], [
            'name.required' => __('admin.indices.validation.required.name_txt'),
            'corelation.required' => __('admin.indices.validation.required.corelation_txt')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit'); 

            $store = new IndicesMaster($input);

            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            }
        }
        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['add'])->with('title', $admin['success_ttl']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = IndicesMaster::find($id);
        $statusArr = App::getStatusLblTyp2Arr();
        
        $editDataAtrArr = ["title"=>__('admin.indices.edit_txt'), "route" => 'indices.edit'];
        
        return view('themes.backend.pages.indices.updateform', compact('dataArr', 'editDataAtrArr', 'statusArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'corelation' => 'required',
            'status' => 'required|integer'
        ], [
            'name.required' => __('admin.indices.validation.required.name_txt'),
            'corelation.required' => __('admin.indices.validation.required.corelation_txt')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_method', '_token', 'submit'); 

            $store = IndicesMaster::find($id);

            foreach ($input as $key => $value) 
            {
                $store->$key = trim($value);
            }
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
            }
        }
        return redirect()->route('admin.indices.index')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['update'])->with('title', $admin['success_ttl']);
    }

    public function deleteData(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();
        try {
            $checkboxArr = $request->get('checkbox');
            if(count($checkboxArr)>0)
            {
                DB::beginTransaction();
                $dataArr = IndicesMaster::whereIn('idc_id', $checkboxArr)->get();
                $delModel = IndicesMaster::whereIn('idc_id', $checkboxArr)->delete();
                if($delModel > 0){
                    if($dataArr){
                        $time = time();
                        $upldDirName = $commonconstants['idc_del_dir_name'];
                        $errFileName = 'indices_exist_fund_deleted_' . $time . '.csv';
                        $errFilePath = $upldDirName . '/' . $errFileName;
                        Storage::put($errFilePath, '');
                        $errFileColumns = array('Indices Name', 'Fund Name', 'Fund Code');
                        $errFile = fopen(Core::getUploadedPath($errFilePath), 'w');
                        fputcsv($errFile, $errFileColumns);
                        foreach ($dataArr as $value) {
                            $name = $value->name;
                            if ($name) {
                                IndicesDetail::where('name', $name)->delete();
                                IndicesComposition::where('indices_name', $name)->delete();
                                $FundMdl = FundMaster::where('indices_name', $name)->get();
                                if($FundMdl){
                                    foreach ($FundMdl as $fund) {
                                        fputcsv($errFile, array($name, $fund->fund_name, $fund->fund_code));
                                    }
                                }
                            }
                        }
                        fclose($errFile);
                    }
                    DB::commit();
                    return redirect()->route('admin.indices.index', $time)->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['delete'])->with('title', $admin['success_ttl']);
                }
            }
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['delete'])->with('title', $admin['error_ttl']);
            }
        }
        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['delete'])->with('title', $admin['success_ttl']);
    }

    public function downloaddeleted($time = '')
    {
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();
        try {
            if ($time != '') {
                $upldDirName = $commonconstants['idc_del_dir_name'];
                $errFileName = 'indices_exist_fund_deleted_' . $time . '.csv';
                if (Storage::exists($upldDirName . '/' . $errFileName)) {
                    $file = Core::getUploadedPath($upldDirName) . '/' . $errFileName;

                    $headers = array(
                        'Content-Type: text/csv',
                    );

                    return Response::download($file, $errFileName, $headers)->deleteFileAfterSend(true);
                } else {
                    return redirect()->route('admin.indices.index')->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['dwnld_file_not_exist'])->with('title', $admin['warning_ttl']);
                }
            }
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['delete'])->with('title', $admin['error_ttl']);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexnocor()
    {
        $dataListModel = IndicesMaster::list(['nocor' => 'yes']);

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();

        $roleRights = ['edit' => App::hasAccessToMethod($this->className, 'admin.indices.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.indices.delete')];
        
        return view('themes.backend.pages.indices.indexnocor', compact('dataListModel', 'listDataAtrArr', 'roleRights'));
    }
}
