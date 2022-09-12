<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Lib\Core\Useful;

use App\Models\FundDetail;
use App\Models\FundMaster;

class MissingNavExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $filter;

    public function __construct($request)
    {
        $this->filter = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $fltrDataArr = array();

        $fltrDataArr['missing_date'] = $this->filter['missing_date'] ?? '';
        $fltrDataArr['fund_code']  = $this->filter['fund_code'] ?? '';

        return collect(FundDetail::missingList($fltrDataArr));
    }

    public function map($dataModel): array
    {
        $fundName = '';
        if ($this->filter['fund_code'] != '') {
            $dataMdl = FundMaster::getData(['fund_code' => $this->filter['fund_code'], 'status' => Config('commonconstants.status_val.1')], ['fund_name']);
            $fundName = $dataMdl ? $dataMdl->fund_name : '';
        }

        return [
            $dataModel->missing_date,
            $fundName,
            $dataModel->fund_code,
            Useful::isHoliday($dataModel->missing_date)
        ];
    }

    public function headings(): array
    {
        return [
            __('admin.missing_date_txt'),
            __('admin.fund.missing.scheme_txt'),
            __('admin.fund.code_txt'),
            __('admin.holiday_txt'),
            __('admin.value_txt')
        ];
    }
}
