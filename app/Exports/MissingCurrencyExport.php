<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Models\CurrencyDetail;
use App\Models\CurrencyMaster;

class MissingCurrencyExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
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
        $fltrDataArr['currency_id']  = $this->filter['currency_id'] ?? 0;

        return collect(CurrencyDetail::missingList($fltrDataArr));
    }

    public function map($dataModel): array
    {
        $currencyName = '';
        if (intval($this->filter['currency_id']) > 0) {
            $dataMdl = CurrencyMaster::getData(['currency_id' => $this->filter['currency_id'], 'status' => Config('commonconstants.status_val.1')], ['name']);
            $currencyName = $dataMdl ? $dataMdl->name : '';
        }

        return [
            $dataModel->missing_date,
            $currencyName,
            $this->filter['currency_id']
        ];
    }

    public function headings(): array
    {
        return [
            __('admin.missing_date_txt'),
            __('admin.currency.name_txt'),
            __('admin.currency.missing.currency_id'),
            __('admin.value_txt')
        ];
    }
}
