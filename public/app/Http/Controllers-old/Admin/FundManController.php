<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\App\Common;
use App\Lib\Admin\App;

use App\Models\FundMan;

class FundManController extends BaseController
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
    public function index()
    {
        $dataListModel = FundMan::list();

        $coreObj = new App();

        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.fund-man.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.fund-man.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.fund-man.delete')];

        return view('themes.backend.pages.fundman.index', compact('dataListModel', 'listDataAtrArr', 'statusAtrArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusArr = App::getStatusLblTyp2Arr();

        return view('themes.backend.pages.fundman.createform', compact('statusArr'));
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
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required|integer'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit');

            $store = new FundMan($input);

            $reqSlug        = isset($input['slug']) ? $input['slug'] : $input['name'];
            $store->slug    = Common::generateSlug($reqSlug, 'fund_man');

            $media_id = intval($input['media_id']);
            $store->media_id = $media_id > 0 ? $media_id : 0;

            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $adminLang['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['data_saved'])->with('title', $adminLang['error_ttl']);
            }
        }

        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['add'])->with('title', $adminLang['success_ttl']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = FundMan::find($id);

        $statusArr = App::getStatusLblTyp2Arr();

        $editDataAtrArr = ["title" => __('admin.fundman.edit_txt'), "route" => 'fundman.edit'];

        return view('themes.backend.pages.fundman.updateform', compact('dataArr', 'statusArr', 'editDataAtrArr'));
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
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required|integer'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_method', '_token', 'submit', 'files');

            $store = FundMan::find($id);

            foreach ($input as $key => $value) {
                if ($key == 'media_id') {
                    $media_id = intval($value);
                    $store->$key = $media_id > 0 ? $media_id : 0;
                } else {
                    $store->$key = trim($value);
                }
            }

            $reqSlug = (isset($store->slug) && $store->slug) ? $store->slug : $store->name;
            $store->slug = Common::generateSlug($reqSlug, 'fund_man', '', 'fm_id !=' . $id);

            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $adminLang['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['update'])->with('title', $adminLang['error_ttl']);
            }
        }

        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['update'])->with('title', $adminLang['success_ttl']);
    }

    public function deleteData(Request $request)
    {
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $loginAdminId = self::getLoggedInAdminId();
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                FundMan::whereIn('fm_id', $checkboxArr)->delete();
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $adminLang['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['delete'])->with('title', $adminLang['error_ttl']);
            }
        }

        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['delete'])->with('title', $adminLang['success_ttl']);
    }
}
