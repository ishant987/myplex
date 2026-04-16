<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use App\Lib\Admin\App;
use App\Models\CalculatorRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CalculatorloginController extends BaseController
{
    public function index(Request $request)
    {
        $perPage = Config('commonconstants.pagination_no');
        $data = $request->all();

        $model = new CalculatorRegister();
        $table = $model->getTable();
        $columns = Schema::hasTable($table) ? Schema::getColumnListing($table) : [];

        $sortableColumns = [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'platform' => 'Platform',
            'created_at' => 'Created At',
        ];

        $availableSorts = array_intersect_key($sortableColumns, array_flip($columns));
        $defaultSort = array_key_exists('created_at', $availableSorts)
            ? 'created_at'
            : (array_key_exists('id', $availableSorts) ? 'id' : array_key_first($availableSorts));

        $sortBy = $request->query('sby', $defaultSort);
        if (! array_key_exists($sortBy, $availableSorts)) {
            $sortBy = $defaultSort;
        }

        $orderBy = strtolower($request->query('oby', 'desc')) === 'asc' ? 'ASC' : 'DESC';

        if ($request->has('ppage')) {
            $perPage = $request->query('ppage');
        }

        $query = CalculatorRegister::query();

        $fltrDataArr = [
            'username' => $request->query('fun', ''),
            'email' => $request->query('fel', ''),
            'platform' => $request->query('fpl', ''),
            'created_at' => $request->query('fad', ''),
        ];

        if (in_array('username', $columns, true) && $fltrDataArr['username'] !== '') {
            $query->where('username', 'like', '%' . $fltrDataArr['username'] . '%');
        }

        if (in_array('email', $columns, true) && $fltrDataArr['email'] !== '') {
            $query->where('email', 'like', '%' . $fltrDataArr['email'] . '%');
        }

        if (in_array('platform', $columns, true) && $fltrDataArr['platform'] !== '') {
            $query->where('platform', $fltrDataArr['platform']);
        }

        if (in_array('created_at', $columns, true) && $fltrDataArr['created_at'] !== '') {
            $query->whereDate('created_at', $fltrDataArr['created_at']);
        }

        $dataListModel = empty($columns)
            ? collect()
            : $query->orderBy($sortBy, $orderBy)->paginate($perPage);

        $listDataAtrArr = App::getReportListDataAtr();
        $orderbyArr = ['asc' => 'ASC', 'desc' => 'DESC'];
        $showEntryArr = ['value' => __('admin.sw_entry.options.value'), 'text' => __('admin.sw_entry.options.text')];
        $platformOptions = ['' => 'All', '1' => 'Google', '2' => 'Facebook'];

        return view('themes.backend.pages.calculatorlogin.index', compact(
            'availableSorts',
            'columns',
            'data',
            'dataListModel',
            'fltrDataArr',
            'listDataAtrArr',
            'orderBy',
            'orderbyArr',
            'perPage',
            'platformOptions',
            'showEntryArr',
            'sortBy'
        ));
    }
}
