<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use Validator;
use Storage;

use App\Lib\App\Common;
use App\Lib\Core\Core;
use App\Lib\Admin\App;

use App\Models\News;

class NewsController extends BaseController
{
    public $className;

    public function __construct()
    {
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
        $dataListModel = News::list();

        $coreObj = new App();

        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $moduleAtrArr = News::getModuleVars();

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.news.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.news.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.news.delete')];

        return view('themes.backend.pages.news.index', compact('dataListModel', 'listDataAtrArr', 'moduleAtrArr', 'statusAtrArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $moduleAtrArr = Arr::except(News::getModuleVars(), ['view_txt', 'target', 'media_folder', 'img_width']);

        $statusArr = App::getStatusLblTyp2Arr();

        return view('themes.backend.pages.news.createform', compact('statusArr', 'moduleAtrArr'));
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
            'image' => 'nullable|file|image|mimes:jpeg,jpg,png|max:' . $commonconstants['img_upld_max_size'] . '',
            'video_file' => 'nullable|file|mimes:mp4|max:' . $commonconstants['vdo_upld_max_size'] . '',
            'youtube_code' => 'nullable|url',
            'video_image' => 'nullable|file|image|mimes:jpeg,jpg,png|max:' . $commonconstants['img_upld_max_size'] . '',
            'source_link' => 'nullable|url',
            'status' => 'required|integer'
        ], [
            'image.max' => __('message.error.img_upload_max_sz'),
            'video_file.max' => __('message.error.vdo_upload_max_sz'),
            'youtube_code.url' => __('news.validation.required.youtube_code'),
            'video_image.max' => __('message.error.img_upload_max_sz'),
            'source_link.url' => __('message.error.valid_url')
        ]);

        $mediaTypeImage = $commonconstants['media_type']['value']['0'];
        $mediaTypeVideo = $commonconstants['media_type']['value']['1'];

        $videoTypeLocal = $commonconstants['video_type']['value']['0'];
        $videoTypeYtube = $commonconstants['video_type']['value']['1'];

        $validator->after(function () use ($request, $validator) {
            $mediaType = $request->input('media_type');
            if ($mediaType) {
                switch ($mediaType) {
                    case Config('commonconstants.media_type.value.0'):
                        if (!$request->hasFile('image')) {
                            $validator->errors()->add('image', __('admin.validation.required.featured_img'));
                        }
                        break;
                    case Config('commonconstants.media_type.value.1'):
                        $videoFrom = $request->input('video_from');
                        if (!$videoFrom) {
                            $validator->errors()->add('video_from', __('news.validation.required.video_from'));
                        } else {
                            switch ($videoFrom) {
                                case Config('commonconstants.video_type.value.0'):
                                    if (!$request->hasFile('video_file')) {
                                        $validator->errors()->add('video_file', __('news.validation.required.video_file'));
                                    }
                                    break;
                                case Config('commonconstants.video_type.value.1'):
                                    if (!$request->input('youtube_code')) {
                                        $validator->errors()->add('youtube_code', __('news.validation.required.youtube_code'));
                                    }
                                    break;
                            }
                        }
                        break;
                }
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $path = '';
        $path2 = '';
        $path3 = '';
        $videoImageName = '';

        try {
            $store = new News;

            $input = $request->except('_token', 'submit', 'image', 'video_file', 'youtube_code');

            foreach ($input as $key => $value) {
                $store->$key = trim($value);
            }

            $mediaType = $request->input('media_type');
            if ($mediaType) {
                $upldDirName = $commonconstants['news_dir_name'];

                switch ($mediaType) {
                    case $mediaTypeImage:
                        if ($request->hasFile('image')) {
                            $file      = $request->file('image');
                            $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                            $filename  = 'nws-' . time() . '-' . Core::removeSpecialChars($title) . '.' . $extension;

                            $path      = $file->storeAs($upldDirName, $filename);
                            if ($path) {
                                $store->image = $filename;
                            } else {
                                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.img_upload'))->with('title', __('admin.error_ttl'));
                            }
                        }
                        break;
                    case $mediaTypeVideo:
                        $videoFrom = $request->input('video_from');
                        if ($videoFrom) {
                            switch ($videoFrom) {
                                case $videoTypeLocal:/*Local*/
                                    if ($request->hasFile('video_file')) {
                                        $file2      = $request->file('video_file');
                                        $title2     = pathinfo($file2->getClientOriginalName(), PATHINFO_FILENAME);
                                        $extension2 = pathinfo($file2->getClientOriginalName(), PATHINFO_EXTENSION);
                                        $filename2  = 'nws-' . time() . '-' . Core::removeSpecialChars($title2) . '.' . $extension2;

                                        $path2      = $file2->storeAs($upldDirName, $filename2);
                                        if ($path2) {
                                            $store->video_data = $filename2;
                                        } else {
                                            return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.vdo_upload'))->with('title', __('admin.error_ttl'));
                                        }
                                    }
                                    break;
                                case $videoTypeYtube:/*Youtube*/
                                    $youtubeCode = $request->input('youtube_code');
                                    if ($youtubeCode != "") {
                                        $store->video_data = $youtubeCode;
                                    }
                                    break;
                            }
                            /**/
                            if ($request->hasFile('video_image')) {
                                $file3      = $request->file('video_image');
                                $title3     = pathinfo($file3->getClientOriginalName(), PATHINFO_FILENAME);
                                $extension3 = pathinfo($file3->getClientOriginalName(), PATHINFO_EXTENSION);
                                $filename3  = 'nws-' . time() . '-' . Core::removeSpecialChars($title3) . '.' . $extension3;

                                $path3      = $file3->storeAs($upldDirName, $filename3);
                                if ($path3) {
                                    $store->video_image = $filename3;
                                } else {
                                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.img_upload'))->with('title', __('admin.error_ttl'));
                                }
                            } else {
                                $coreObj = new Core;
                                switch ($videoFrom) {
                                    case $videoTypeYtube:
                                        if ($youtubeCode != "") {
                                            /*Download file and save locally*/
                                            $yImgArr = $coreObj->getYtubeImage($youtubeCode, 'maxresdefault');
                                            if (!empty($yImgArr)) {
                                                $yImgUrl = $yImgArr['thumb_link'];
                                                if ($yImgUrl != '') {
                                                    $downloadedFileContents = file_get_contents($yImgUrl);
                                                    if ($downloadedFileContents) {
                                                        $videoId = $yImgArr['video_id'];
                                                        $videoImageName = 'nws-' . time() . '-' . $videoId . ".jpg";
                                                        Storage::put($videoImageName, $downloadedFileContents, 'public');
                                                        Storage::move($videoImageName, $upldDirName . '/' . $videoImageName);
                                                        $store->video_image = $videoImageName;
                                                    }
                                                }
                                            }
                                        }
                                        break;
                                }
                            }
                        }
                        break;
                }
            }

            $reqSlug        = isset($input['slug']) ? $input['slug'] : $input['title'];
            $store->slug    = Common::generateSlug($reqSlug, 'news');
            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if (isset($path) && $path) {
                $exists = Storage::exists($path);
                if ($exists) {
                    Storage::delete($path);
                }
            }

            if (isset($path2) && $path2) {
                $exists2 = Storage::exists($path2);
                if ($exists2) {
                    Storage::delete($path2);
                }
            }

            if (isset($path3) && $path3) {
                $exists3 = Storage::exists($path3);
                if ($exists3) {
                    Storage::delete($path3);
                }
            }

            if (isset($videoImageName) && $videoImageName) {
                $exists4 = Storage::exists($videoImageName);
                if ($exists4) {
                    Storage::delete($videoImageName);
                }
            }

            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
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
        $nmObj = new News;

        $dataArr = $nmObj->find($id);

        $moduleAtrArr = $nmObj->getModuleVars();

        $statusArr = App::getStatusLblTyp2Arr();

        $editDataAtrArr = ["title" => __('news.edit_txt'), "route" => 'news.edit'];

        return view('themes.backend.pages.news.updateform', compact('dataArr', 'moduleAtrArr', 'statusArr', 'editDataAtrArr'));
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
            'image' => 'nullable|file|image|mimes:jpeg,jpg,png|max:' . $commonconstants['img_upld_max_size'] . '',
            'video_file' => 'nullable|file|mimes:mp4,mov,qt,ogx,oga,ogv,ogg,webm|max:' . $commonconstants['vdo_upld_max_size'] . '',
            'youtube_code' => 'nullable|url',
            'video_image' => 'nullable|file|image|mimes:jpeg,jpg,png|max:' . $commonconstants['img_upld_max_size'] . '',
            'source_link' => 'nullable|url',
            'status' => 'required|integer'
        ], [
            'image.max' => __('message.error.img_upload_max_sz'),
            'video_file.max' => __('message.error.vdo_upload_max_sz'),
            'youtube_code.url' => __('news.validation.required.youtube_code'),
            'video_image.max' => __('message.error.img_upload_max_sz'),
            'source_link.url' => __('message.error.valid_url')
        ]);

        $mediaTypeImage = $commonconstants['media_type']['value']['0'];
        $mediaTypeVideo = $commonconstants['media_type']['value']['1'];

        $videoTypeLocal = $commonconstants['video_type']['value']['0'];
        $videoTypeYtube = $commonconstants['video_type']['value']['1'];

        $validator->after(function () use ($request, $validator) {
            $mediaType = $request->input('media_type');
            if ($mediaType) {
                switch ($mediaType) {
                    case Config('commonconstants.media_type.value.0'):
                        if ($request->hasFile('image')) {
                            if (!$request->file('image')) {
                                $validator->errors()->add('image', __('admin.validation.required.featured_img'));
                            }
                        }
                        break;
                    case Config('commonconstants.media_type.value.1'):
                        $videoFrom = $request->input('video_from');
                        if (!$videoFrom) {
                            $validator->errors()->add('video_from', __('news.validation.required.video_from'));
                        } else {
                            switch ($videoFrom) {
                                case Config('commonconstants.video_type.value.0'):
                                    if ($request->hasFile('video_file')) {
                                        if (!$request->file('video_file')) {
                                            $validator->errors()->add('video_file', __('news.validation.required.video_file'));
                                        }
                                    }
                                    break;
                                case Config('commonconstants.video_type.value.1'):
                                    if (!$request->input('youtube_code')) {
                                        $validator->errors()->add('youtube_code', __('news.validation.required.youtube_code'));
                                    }
                                    break;
                            }
                        }
                        break;
                }
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $path = '';
        $path2 = '';
        $path3 = '';
        $videoImageName = '';

        try {
            $store = News::find($id);

            $exstImage = $store->image;
            $exstVideoFile = $store->video_data;
            $exstVideoImage = $store->video_image;

            $input = $request->except('_method', '_token', 'submit', 'image', 'video_file', 'youtube_code');

            foreach ($input as $key => $value) {
                $store->$key = trim($value);
            }

            $youtubeCode = "";
            $mediaType = $request->input('media_type');
            if ($mediaType) {
                $upldDirName = $commonconstants['news_dir_name'];

                switch ($mediaType) {
                    case $mediaTypeImage:
                        if ($request->hasFile('image')) {
                            $file      = $request->file('image');
                            $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                            $filename  = 'nws-' . time() . '-' . Core::removeSpecialChars($title) . '.' . $extension;

                            $path      = $file->storeAs($upldDirName, $filename);
                            if ($path) {
                                $store->image = $filename;
                                $store->video_from = '';
                                $store->video_data = '';
                                $store->video_image = '';
                            } else {
                                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.img_upload'))->with('title', __('admin.error_ttl'));
                            }
                        } else {
                            $store->image = $exstImage;
                            $store->video_from = '';
                            $store->video_data = '';
                            $store->video_image = '';
                        }
                        break;
                    case $mediaTypeVideo:
                        $videoFrom = $request->input('video_from');
                        if ($videoFrom) {
                            $coreObj = new Core;
                            switch ($videoFrom) {
                                case $videoTypeLocal:
                                    if ($request->hasFile('video_file')) {
                                        $file2      = $request->file('video_file');
                                        $title2     = pathinfo($file2->getClientOriginalName(), PATHINFO_FILENAME);
                                        $extension2 = pathinfo($file2->getClientOriginalName(), PATHINFO_EXTENSION);
                                        $filename2  = 'nws-' . time() . '-' . Core::removeSpecialChars($title2) . '.' . $extension2;

                                        $path2      = $file2->storeAs($upldDirName, $filename2);
                                        if ($path2) {
                                            $store->video_data = $filename2;
                                            $store->image = '';
                                        } else {
                                            return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.vdo_upload'))->with('title', __('admin.error_ttl'));
                                        }
                                    } else {
                                        $store->video_data = $exstVideoFile;
                                    }
                                    break;
                                case $videoTypeYtube:
                                    $youtubeCode = $request->input('youtube_code');
                                    if ($youtubeCode != "") {
                                        $store->video_data = $youtubeCode;
                                        $store->image = '';
                                    }
                                    break;
                            }
                            
                            if ($request->hasFile('video_image')) {
                                $file3      = $request->file('video_image');
                                $title3     = pathinfo($file3->getClientOriginalName(), PATHINFO_FILENAME);
                                $extension3 = pathinfo($file3->getClientOriginalName(), PATHINFO_EXTENSION);
                                $filename3  = 'nws-' . time() . '-' . Core::removeSpecialChars($title3) . '.' . $extension3;

                                $path3      = $file3->storeAs($upldDirName, $filename3);
                                if ($path3) {
                                    $store->video_image = $filename3;
                                } else {
                                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.img_upload'))->with('title', __('admin.error_ttl'));
                                }
                            } else {
                                if ($exstVideoImage == '') {
                                    switch ($videoFrom) {
                                        case $videoTypeLocal:
                                            if ($path2) {
                                            }
                                            break;
                                        case $videoTypeYtube:
                                            if ($youtubeCode != "") {
                                                /*Download file and save locally*/
                                                $yImgArr = $coreObj->getYtubeImage($youtubeCode, 'maxresdefault');
                                                if (!empty($yImgArr)) {
                                                    $yImgUrl = $yImgArr['thumb_link'];
                                                    if ($yImgUrl != '') {
                                                        $downloadedFileContents = file_get_contents($yImgUrl);
                                                        if ($downloadedFileContents) {
                                                            $videoId = $yImgArr['video_id'];
                                                            $videoImageName = 'nws-' . time() . '-' . $videoId . ".jpg";
                                                            Storage::put($videoImageName, $downloadedFileContents, 'public');
                                                            Storage::move($videoImageName, $upldDirName . '/' . $videoImageName);
                                                            $store->video_image = $videoImageName;
                                                        }
                                                    }
                                                }
                                            }
                                            break;
                                    }
                                }
                            }
                        }
                        break;
                }
            }

            $reqSlug = (isset($store->slug) && $store->slug) ? $store->slug : $store->title;
            $store->slug = Common::generateSlug($reqSlug, 'news', '', 'n_id !=' . $id);
            $store->updated_id = $loginAdminId;
            if ($store->save()) {
                if ($request->hasFile('image')) {
                    if ($exstImage) {
                        $oldFilePath = $upldDirName . '/' . $exstImage;
                        $exists = Storage::exists($oldFilePath);
                        if ($exists) {
                            Storage::delete($oldFilePath);
                        }
                    }
                    /**/
                    if ($exstVideoFile) {
                        $oldFilePath2 = $upldDirName . '/' . $exstVideoFile;
                        $exists2 = Storage::exists($oldFilePath2);
                        if ($exists2) {
                            Storage::delete($oldFilePath2);
                        }
                    }
                    /**/
                    if ($exstVideoImage) {
                        $oldFilePath3 = $upldDirName . '/' . $exstVideoImage;
                        $exists3 = Storage::exists($oldFilePath3);
                        if ($exists3) {
                            Storage::delete($oldFilePath3);
                        }
                    }
                }

                if ($request->hasFile('video_file') && $exstVideoFile) {
                    $oldFilePath2 = $upldDirName . '/' . $exstVideoFile;
                    $exists2 = Storage::exists($oldFilePath2);
                    if ($exists2) {
                        Storage::delete($oldFilePath2);
                    }
                    /**/
                    if ($exstImage) {
                        $oldFilePath = $upldDirName . '/' . $exstImage;
                        $exists = Storage::exists($oldFilePath);
                        if ($exists) {
                            Storage::delete($oldFilePath);
                        }
                    }
                } else {
                    if ($youtubeCode != "") {
                        $oldFilePath2 = $upldDirName . '/' . $exstVideoFile;
                        $exists2 = Storage::exists($oldFilePath2);
                        if ($exists2) {
                            Storage::delete($oldFilePath2);
                        }
                        /**/
                        if ($exstImage) {
                            $oldFilePath = $upldDirName . '/' . $exstImage;
                            $exists = Storage::exists($oldFilePath);
                            if ($exists) {
                                Storage::delete($oldFilePath);
                            }
                        }
                    }
                }

                if (($request->hasFile('video_image') && $exstVideoImage) || ($videoImageName && $exstVideoImage)) {
                    $oldFilePath3 = $upldDirName . '/' . $exstVideoImage;
                    $exists3 = Storage::exists($oldFilePath3);
                    if ($exists3) {
                        Storage::delete($oldFilePath3);
                    }
                }

                return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
            }
        } catch (QueryException $exception) {
            if (isset($path) && $path) {
                $exists = Storage::exists($path);
                if ($exists) {
                    Storage::delete($path);
                }
            }

            if (isset($path2) && $path2) {
                $exists2 = Storage::exists($path2);
                if ($exists2) {
                    Storage::delete($path2);
                }
            }

            if (isset($path3) && $path3) {
                $exists3 = Storage::exists($path3);
                if ($exists3) {
                    Storage::delete($path3);
                }
            }

            if (isset($videoImageName) && $videoImageName) {
                $exists4 = Storage::exists($videoImageName);
                if ($exists4) {
                    Storage::delete($videoImageName);
                }
            }

            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }
    }

    public function deletedata(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                $dataArr = News::whereIn('n_id', $checkboxArr)->get();
                $delModel = News::whereIn('n_id', $checkboxArr)->delete();
                if ($delModel > 0) {
                    $upldDirName = $commonconstants['news_dir_name'] . "/";

                    $mediaTypeImage = $commonconstants['media_type']['value']['0'];
                    $mediaTypeVideo = $commonconstants['media_type']['value']['1'];

                    $videoTypeLocal = $commonconstants['video_type']['value']['0'];
                    foreach ($dataArr as $value) {
                        $mediaType = $value->media_type;

                        switch ($mediaType) {
                            case $mediaTypeImage:
                                $image = $value->image;
                                $path = $upldDirName . $image;
                                if (isset($path) && $path) {
                                    $exists = Storage::exists($path);
                                    if ($exists) {
                                        Storage::delete($path);
                                    }
                                }
                                break;
                            case $mediaTypeVideo:
                                $videoFrom = $value->video_from;
                                if ($videoFrom) {
                                    switch ($videoFrom) {
                                        case $videoTypeLocal:
                                            $videoData = $value->video_data;
                                            $path2 = $upldDirName . $videoData;
                                            if (isset($path2) && $path2) {
                                                $exists2 = Storage::exists($path2);
                                                if ($exists2) {
                                                    Storage::delete($path2);
                                                }
                                            }
                                            break;
                                    }
                                    
                                    $video_image = $value->video_image;
                                    $path3 = $upldDirName . $video_image;
                                    if (isset($path3) && $path3) {
                                        $exists3 = Storage::exists($path3);
                                        if ($exists3) {
                                            Storage::delete($path3);
                                        }
                                    }
                                }
                                break;
                        }
                    }
                }
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }

    public function deletefile($id, $fileName, $field)
    {
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        $alertCss2 = Config('adminconstants.alert_css.2');
        $delErrMsg = __('message.error.delete');
        $errTtl = __('admin.error_ttl');
        try {
            \DB::beginTransaction();

            $store = News::find($id);
            if ($store) {
                $store->$field = '';
                $store->updated_id = $loginAdminId;
                if ($store->save()) {
                    if ($fileName) {
                        $upldDirName = $commonconstants['news_dir_name'] . "/";
                        $path = $upldDirName . $fileName;
                        if (isset($path) && $path) {
                            $exists = Storage::exists($path);
                            if ($exists) {
                                Storage::delete($path);
                                \DB::commit();
                            } else {
                                \DB::rollBack();
                                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
                            }
                        }
                    }
                } else {
                    return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
                }
            } else {
                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $alertCss2)->with('message', $exception->getMessage())->with('title', $errTtl)->withInput();
            } else {
                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }
}
