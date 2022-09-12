<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;

use App\Lib\Core\Core;
use App\Lib\Admin\App;

use App\Models\FundWatch;

class FundWatchController extends BaseController
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
    public function index()
    {
        $dataListModel = FundWatch::list();
        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $fldsHide = __('admin.fundwatch.flds_hide');
        $boolFalse = Config('commonconstants.bool_false');

        $moduleAtrArr = FundWatch::getModuleVars();

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.fund-watch.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.fund-watch.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.fund-watch.delete')];
        
        return view('themes.backend.pages.fundwatch.index', compact('dataListModel', 'listDataAtrArr', 'moduleAtrArr', 'statusAtrArr', 'roleRights', 'fldsHide', 'boolFalse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $statusArr = App::getStatusLblTyp2Arr();

        $fldsHide = __('admin.fundwatch.flds_hide');
        $boolFalse = Config('commonconstants.bool_false');

        return view('themes.backend.pages.fundwatch.createform', compact('statusArr', 'fldsHide', 'boolFalse'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'file' => 'required|file|mimes:pdf|max:'.$commonconstants['pdf_upld_max_size'].'',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'file.max' => __('message.error.pdf_upld_max_size'),
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $path = '';

        try {
            $input = $request->except('_token', 'submit'); 

            $store = new FundWatch($input);

            $upldDirName = $commonconstants['pdf_dir_name'];
            if ($request->hasFile('file')) {
                $file      = $request->file('file');
                $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $filename  = 'fw-'.time().'-'.Core::removeSpecialChars($title).'.'.$extension;

                $path      = $file->storeAs($upldDirName, $filename);
                if($path){
                    $store->file = $filename;            
                }
                else{
                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.pdf_upload'))->with('title', __('admin.error_ttl'));
                }
            }
            
            $fldsHide = __('admin.fundwatch.flds_hide');
            $boolFalse = $commonconstants['bool_false'];
            if( $fldsHide['c_order'] == $boolFalse ){
                $c_order = intval($input['c_order']);
                $store->c_order = $c_order > 0 ? $c_order : 0;
            }

            $store->updated_id = $loginAdminId;

            $store->save();
        } catch (QueryException $exception) {
            if(isset($path) && $path){
                $exists = Storage::exists($path);
                if($exists){
                    Storage::delete($path);
                }
            }

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.data_saved'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.add'))->with('title', __('admin.success_ttl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = FundWatch::find($id);

        $moduleAtrArr = FundWatch::getModuleVars();

        $statusArr = App::getStatusLblTyp2Arr();

        $fldsHide = __('admin.fundwatch.flds_hide');
        $boolFalse = Config('commonconstants.bool_false');

        $editDataAtrArr = ["title"=>__('admin.fundwatch.edit_txt'), "route"=>'fundwatch.edit'];
        
        return view('themes.backend.pages.fundwatch.updateform', compact('dataArr', 'moduleAtrArr', 'statusArr', 'editDataAtrArr', 'fldsHide', 'boolFalse'));
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
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'file' => 'nullable|file|mimes:pdf|max:'.$commonconstants['pdf_upld_max_size'].'',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'file.max' => __('message.error.pdf_upld_max_size'),
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $path = '';

        try {
            $store = FundWatch::find($id);

            $exstFile = $store->file;

            $input = $request->except('_method', '_token', 'submit'); 

            foreach ($input as $key => $value) {
                if ($key == 'c_order') {
                    $c_order = intval($input['c_order']);
                    $store->c_order = $c_order > 0 ? $c_order : 0;
                }
                else{
                    $store->$key = trim($value);
                }
            }

            $upldDirName = $commonconstants['pdf_dir_name'];
            if ($request->hasFile('file')) {
                $file      = $request->file('file');
                
                $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $filename  = 'fw-'.time().'-'.Core::removeSpecialChars($title).'.'.$extension;
                
                $path      = $file->storeAs($upldDirName, $filename);
                if($path){
                    $store->file = $filename;                  
                }
                else{
                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.pdf_upload'))->with('title', __('admin.error_ttl'));
                }
            }
            else{
                $store->file = $exstFile; 
            }

            $store->updated_id = $loginAdminId;

            if($store->save()){
                if($request->hasFile('file') && $exstFile){
                    $oldFilePath = $upldDirName.'/'.$exstFile;
                    $oldFileExists = Storage::exists($oldFilePath);
                    if($oldFileExists){
                        Storage::delete($oldFilePath);
                    }
                }
            }
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
    }

    public function deletedata(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        try {
            $checkboxArr = $request->get('checkbox');
            if(count($checkboxArr)>0)
            {
                $dataArr = FundWatch::whereIn('fw_id', $checkboxArr)->get();
                $delModel = FundWatch::whereIn('fw_id', $checkboxArr)->delete();
                if($delModel > 0){
                    if(count($dataArr)){
                        $upldDirName = $commonconstants['pdf_dir_name']."/";
                        foreach ($dataArr as $value) {
                            $file = $value->file;
                            $path = $upldDirName.$file;
                            if(isset($path) && $path){
                                $exists = Storage::exists($path);
                                if($exists){
                                    Storage::delete($path);
                                }
                            }
                        }
                    }
                }
            }
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }
        
        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }
}
