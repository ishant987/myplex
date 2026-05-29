<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Admin\App;

use App\Models\TestimonialModel;

class TestimonialController extends BaseController
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
        $dataListModel = TestimonialModel::testimonialList();

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.testimonial.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.testimonial.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.testimonial.delete')];

        return view('themes.backend.pages.testimonial.index', compact('dataListModel', 'listDataAtrArr', 'statusAtrArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusArr = App::getStatusLblTyp2Arr();

        return view('themes.backend.pages.testimonial.createform', compact('statusArr'));
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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit');

            $store = new TestimonialModel($input);

            $media_id = intval($input['media_id']);
            $store->media_id = $media_id > 0 ? $media_id : 0;

            $c_order = intval($input['c_order']);
            $store->c_order = $c_order > 0 ? $c_order : 0;

            $store->updated_id = $loginAdminId;

            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
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
        $dataArr = TestimonialModel::find($id);

        $statusArr = App::getStatusLblTyp2Arr();

        $editDataAtrArr = ["title" => __('testimonial.edit_txt'), "route" => 'testimonial.edit'];

        return view('themes.backend.pages.testimonial.updateform', compact('dataArr', 'statusArr', 'editDataAtrArr'));
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
            'name' => 'required',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_method', '_token', 'submit', 'files');

            $store = TestimonialModel::find($id);

            foreach ($input as $key => $value) {
                if ($key == 'media_id') {
                    $media_id = intval($value);
                    $store->$key = $media_id > 0 ? $media_id : 0;
                } elseif ($key == 'c_order') {
                    $c_order = intval($value);
                    $store->$key = $c_order > 0 ? $c_order : 0;
                } else {
                    $store->$key = trim($value);
                }
            }
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
    }

    public function deleteData(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                TestimonialModel::destroy($checkboxArr);
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }
}
