<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Lib\Admin\App;

use App\Models\EnquiryModel;

use App\Exports\EnquiryExport;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends BaseController
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
        $exportDataArr = $fltrDataArr = [];
        $perPage    = Config('commonconstants.pagination_no');
        $sortBy     = 'enq_id';
        $orderBy    = 'DESC';
        $data       = $request->all();

        $listDataAtrArr = App::getReportListDataAtr();

        $lstObj = new EnquiryModel;

        $fltrDataArr['name'] = $request->has('ffn') ? $request->query('ffn') : '';
        $fltrDataArr['email'] = $request->has('fel') ? $request->query('fel') : '';
        $fltrDataArr['mobile'] = $request->has('fml') ? $request->query('fml') : '';
        $fltrDataArr['message'] = $request->has('fms') ? $request->query('fms') : '';
        $fltrDataArr['created_at'] = $request->has('fad') ? $request->query('fad') : '';

        if ($request->has('ppage')) {
            $perPage = $request->query('ppage');
            $exportDataArr['perPage'] = $perPage;
        }

        if ($request->has('oby')) {
            $orderBy = $request->query('oby');
            $exportDataArr['orderBy'] = $orderBy;
        }
        if ($request->has('sby')) {
            $sortBy = $request->query('sby');
            $exportDataArr['sortBy'] = $sortBy;
        }
        if ($request->has('page')) {
            $exportDataArr['page'] = $request->query('page');
        }

        $dataListModel = $lstObj::search($fltrDataArr)->orderBy($sortBy, $orderBy)->paginate($perPage);

        $sortbyArr = ['enq_id' => __('admin.insertion_txt'), 'name' => __('contact.name_txt'), 'email' => __('contact.email_txt'), 'mobile' => __('contact.mobile_txt'), 'message' => __('contact.message_txt'), 'created_at' => __('admin.added_date_txt')];
        $orderbyArr = ['asc' => 'ASC', 'desc' => 'DESC'];

        $showEntryArr = ['value' => __('admin.sw_entry.options.value'), 'text' => __('admin.sw_entry.options.text')];

        $exportDataArr = array_merge($exportDataArr, $fltrDataArr);

        $cFilterArr = ['all_txt' => __('admin.def_drop_optn_styl3_txt')];

        $roleRights = ['view' => App::hasAccessToMethod($this->className, 'admin.contact.show'), 'delete' => App::hasAccessToMethod($this->className, 'admin.deletecontact')];

        return view('themes.backend.pages.contact.index', compact('dataListModel', 'listDataAtrArr', 'sortbyArr', 'orderbyArr', 'fltrDataArr', 'perPage', 'sortBy', 'orderBy', 'showEntryArr', 'cFilterArr', 'data', 'exportDataArr', 'roleRights'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commonconstants = Config('commonconstants');

        $dataObj = EnquiryModel::find(['enq_id' => $id]);

        $listDataAtrArr = App::getReportListDataAtr();

        return view('themes.backend.pages.contact.show', compact('dataObj', 'id', 'listDataAtrArr'));
    }

    public function deletedata(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                EnquiryModel::whereIn('enq_id', $checkboxArr)->delete();
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

    /**
     * Export the Gamification responses of all users
     *
     */
    public function export(Request $request)
    {
        return Excel::download(new EnquiryExport($request->all()), 'contact-list_' . date(Config('commonconstants.dt_tm_frmt')) . '.xlsx');
    }
}
