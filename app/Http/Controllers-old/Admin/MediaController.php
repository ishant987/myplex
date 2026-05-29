<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;
use Storage;

use App\Lib\Core\Core;
use App\Lib\Admin\App;

use App\Models\MediaModel;

class MediaController extends BaseController
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
    public function index(Request $request)
    {
        /*$perPage = 2;*/
        $data = $request->all();
        $perPage = Config('commonconstants.pagination_no');
        $sortBy = 'media_id';
        $orderBy = 'DESC';

        $listDataAtrArr = App::getListDataAtr();
        $moduleAtrArr = self::getModuleVars();

        $lstObj = new MediaModel;

        $fltrDataArr = array();

        $fltrDataArr['title'] = $request->has('ftl') ? $request->query('ftl') : '';
        $fltrDataArr['alt'] = $request->has('fat') ? $request->query('fat') : '';
        $fltrDataArr['updated_at'] = $request->has('fud') ? $request->query('fud') : '';
        $fltrDataArr['updated_by_name'] = $request->has('fuu') ? $request->query('fuu') : '';

        if ($request->has('ppage')) { $perPage = $request->query('ppage'); }

        if ($request->has('oby')) { $orderBy = $request->query('oby'); }
        if ($request->has('sby')) { $sortBy = $request->query('sby'); }

        $dataListModel = $lstObj::search($fltrDataArr)->orderBy($sortBy, $orderBy)->paginate($perPage);

        $sortbyArr = ['media_id'=>__('admin.insertion_txt'), 'title'=>__('admin.title_txt'), 'alt'=>__('media.alt_txt'), 'updated_at'=>__('admin.mdfy_date_txt')];
        $orderbyArr = ['asc'=>'ASC', 'desc'=>'DESC'];

        $showEntryArr = ['value'=>__('admin.sw_entry.options.value'), 'text'=>__('admin.sw_entry.options.text')];

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.media.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.media.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.deletemedia')];
        
        return view('themes.backend.pages.media.index', compact('dataListModel', 'data', 'listDataAtrArr', 'moduleAtrArr', 'sortbyArr', 'orderbyArr', 'fltrDataArr', 'perPage', 'sortBy', 'orderBy', 'showEntryArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('themes.backend.pages.media.createform');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = MediaModel::find($id);

        $moduleAtrArr = self::getModuleVars();

        $editDataAtrArr = ["title"=>__('media.edit_txt'), "route"=>'media.edit'];
        
        return view('themes.backend.pages.media.updateform', compact('dataArr', 'editDataAtrArr', 'moduleAtrArr'));
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

        $validator = Validator::make($request->all(), [
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,pdf,ppt,pptx,xlx,xlsx,docx,doc|max:'.Config('commonconstants.media_upld_max_size').''
        ], [
            'file.max' => __('message.error.media_upload_max_sz')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();

        try {
            $store = MediaModel::find($id);

            $exstFile = $store->path;

            $input = $request->except('_method', '_token', 'submit'); 

            foreach ($input as $key => $value) {
                $store->$key = trim($value);
            }

            $upldDirName = Config('commonconstants.media_dir_name');

            if ($request->hasFile('path')) {
                $file      = $request->file('path');
                $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
				$extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $filename  = time().'-'.Core::removeSpecialChars($title).'.'.$extension;

                $path      = $file->storeAs($upldDirName, $filename);
                if($path){
                    $store->path = $filename;                  
                }
                else{
                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.img_upload'))->with('title', __('admin.error_ttl'));
                }
            }
            else{
                $store->path = $exstFile; 
            }

            $store->updated_id = $loginAdminId;

            if($store->save()){
                if($request->hasFile('path') && $exstFile)
                {
                    $oldFilePath = $upldDirName.'/'.$exstFile;
                    $exists = Storage::exists($oldFilePath);
                    if($exists){
                        Storage::delete($oldFilePath);
                    }
                }

                \DB::commit();

                return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl')); 
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if(isset($path) && $path){
                $exists = Storage::exists($path);
                if($exists){
                    Storage::delete($path);
                }
            }

            if($loginAdminId == Config('commonconstants.def_super_admin_id')){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }
    }

    public function deletedata(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        try {
            $checkboxArr = $request->get('checkbox');
            if(count($checkboxArr)>0)
            {
                $dataArr = MediaModel::whereIn('media_id', $checkboxArr)->get();
                
                $delModel = MediaModel::whereIn('media_id', $checkboxArr)->delete();

                if($delModel > 0){
                    $upldDirName = Config('commonconstants.media_dir_name')."/";
                    foreach ($dataArr as $key => $value) {
                        $file = $value->path;
                        if($file){
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
            if($loginAdminId == Config('commonconstants.def_super_admin_id')){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }
        
        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }


    public function getModuleVars(){
        $commonconstants = Config('commonconstants');

        return ["view_txt"=>__('admin.view_txt'), "target"=>$commonconstants['target_opt1'], "media_folder"=>Core::getUploadedURL($commonconstants['media_dir_name']), "img_width"=>Config('adminconstants.image_width')];
    }

    /**
     * Display a listing of the resource in modal.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGallery(Request $request,$typeid)
    {
        $data = $request->all();
        $fltrDataArr = array();
        $searchKey = '';
        $perPage = 35;
        $fltrDataArr = array();
        
        $model = new MediaModel;
        if($request->has('searchKey')){
            $searchKey = $request->query('searchKey');
            $fltrDataArr['search_key'] = $searchKey; 
        }        
        $dataListModel = $model->where('mime_type','LIKE', 'image/%')->search($fltrDataArr)->orderByDesc('media_id')->paginate($perPage);

        $moduleAtrArr = self::getModuleVars();
        $imagesTypeAry = array("image/jpeg", "image/png", "image/svg", "image/bmp", "image/tiff", "image/x-icon");

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.media.create')];

        return view('themes.backend.pages.media.modalgallery',compact('dataListModel','moduleAtrArr','typeid','searchKey','data','imagesTypeAry', 'roleRights'));
    }

    public function getMediainfo($id)
    {
        $model = new MediaModel;       
        $dataModel = $model->where('media_id', '=', $id)->first();

        // echo "<pre>";
        // print_r($dataModel); default-file.jpg
        // die();

        $moduleAtrArr = self::getModuleVars();
        $mediaInfoArr = json_decode($dataModel->media_info);
        $dimension = $altAttr = '';
        $imagesTypeAry = array("image/jpeg", "image/png", "image/svg", "image/bmp", "image/tiff", "image/x-icon");
        if ( in_array($dataModel->mime_type, $imagesTypeAry) )
        {
            $imgSrc = $moduleAtrArr['media_folder'].$dataModel->path;
            $width = $mediaInfoArr->width ?? '';
            $height = $mediaInfoArr->height ?? '';
            $dimension = '';
            if($width && $height){
                $dimension = '<div class="dimensions">' . $width . 'px X ' . $height . 'px</div>';
            }
            $altAttr = '<div class="form-group">
            <label>'.__('media.alt_txt').'</label>
            <input class="form-control" type="text" name="alt" value="'.$dataModel->alt.'">
            </div>';
        } else {
            $imgSrc = asset('themes/backend/images/default-file.jpg');
        }

        $roleRights = ['edit' => App::hasAccessToMethod($this->className, 'admin.media.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.deletemedia')];

        return view('themes.backend.pages.media.mediainfo',compact('dataModel','moduleAtrArr','mediaInfoArr','imgSrc','dimension','altAttr', 'roleRights'));
    }

    public function storeajax(Request $request)
    {        
        $loginAdminId = self::getLoggedInAdminId();
        $validator = Validator::make($request->all(), [
                'files' => 'required',
                'files.*' => 'mimes:jpg,jpeg,png,svg,doc,docx,xlsx,xls,ppt,pptx,pdf|max:10240'
            ]);
        if ($validator->fails()) {
          return response()->json(['msg'=>'error','errors'=>$validator->errors()]);
        }
        $upldDirName = Config('commonconstants.media_dir_name');

        if ($request->hasFile('files')) {
            foreach($request->file('files') as $file)
            {
                $model = new MediaModel;  
                $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
				$extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $filename  = time().'-'.Core::removeSpecialChars($title).'.'.$extension;

                $path      = $file->storeAs($upldDirName, $filename);
                if($path)
                {                    
                    $model->path        = $filename;
                    $model->mime_type   = $file->getMimeType();
                    $model->media_info  = json_encode($model->setMediainfoArr($file));
                    $model->status      = 1;
                    $model->title       = $title;
                    $model->alt         = $title;
                    //$model->updated_by  = $cuBy;
                    $model->updated_id  = $loginAdminId;
                    $model->save();
                    
                    return response()->json(['msg'=>'success','file_name'=>$filename,'media_id'=>$model->media_id,'del_url'=>route('admin.media.ajaxdelete',$model->media_id)]);
                }
                else{
                    return response()->json(['errors'=>'Unable to save file.']);
                }

            }
        }
       return response()->json(['msg'=>'error','errors'=>$validator->errors()]);
    }

    public function updateajax(Request $request)
    {        
        $inputs = $request->all();
        $media_id = $inputs['hidMediaId'];
        if($media_id>0){
            $dataModel = MediaModel::find($media_id);
            $dataModel->title = $inputs['title'];
            $dataModel->alt = $inputs['alt']??'';
            $dataModel->save();
             return '<span class="alert alert-success">Saved Successfully.</span>';
        }
        else{
            return '<span class="alert alert-danger"> Error ! in updating. try again</span>';
        }
    }

    public function destroyajax($id)
    {
        $upldDirName = Config('commonconstants.media_dir_name');

        $model = new MediaModel;
        $fileName = $model->getMediaPath($id);
        if($model->destroy($id))
        {
            $path = $upldDirName.'/'.$fileName;
            if(Storage::exists($path))
            {
                Storage::delete($path);
            }
            return true;
        }
        return false;
    }
}
