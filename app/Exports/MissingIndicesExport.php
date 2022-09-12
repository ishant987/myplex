<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Lib\Core\Useful;

use App\Models\IndicesDetail;
use App\Models\IndicesMaster;

class MissingIndicesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
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
        $fltrDataArr['indices']  = $this->filter['indices'] ?? '';

        return collect(IndicesDetail::missingList($fltrDataArr));
    }

    public function map($dataModel): array
    {
        $indicesName = '';
        if ($this->filter['indices'] != '') {
            $dataMdl = IndicesMaster::getData(['corelation' => $this->filter['indices'], 'status' => Config('commonconstants.status_val.1')], ['name']);
            $indicesName = $dataMdl ? $dataMdl->name : '';
        }

        return [
            $dataModel->missing_date,
            $indicesName,
            $dataModel->indices,
            Useful::isHoliday($dataModel->missing_date)
        ];
    }

    public function headings(): array
    {
        return [
            __('admin.missing_date_txt'),
            __('admin.indices.name_txt'),
            __('admin.indices.corelation_txt'),
            __('admin.holiday_txt'),
            __('admin.value_txt')
        ];
    }
}
