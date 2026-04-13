<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

use App\Lib\Admin\App;

use App\Models\Newsletter;

class NewsletterExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithMapping
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
        $commonconstants = Config('commonconstants');

        $fltrDataArr     = array();
        $perPage         = $commonconstants['pagination_no'];
        $sortBy         = 'n_id';
        $orderBy         = 'DESC';

        $lstObj = new Newsletter;
        $fltrDataArr['email']         = $this->filter['email'] ?? '';
        $fltrDataArr['created_at']     = $this->filter['created_at'] ?? '';

        $sortBy     = $this->filter['sortBy'] ?? $sortBy;
        $orderBy     = $this->filter['orderBy'] ?? $orderBy;
        $perPage     = $this->filter['perPage'] ?? $perPage;

        return $lstObj::search($fltrDataArr)->orderBy($sortBy, $orderBy)->paginate($perPage);
    }

    public function map($dataModel): array
    {
        return [
            $dataModel->email,
            Date::dateTimeToExcel($dataModel->created_at)
        ];
    }

    public function headings(): array
    {
        return [
            __('common.email_txt'),
            __('admin.added_date_txt')
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => App::getReportListDataAtr()['dt_tm_report_frmt']
        ];
    }
}
